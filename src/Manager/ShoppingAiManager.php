<?php

namespace App\Manager;


use App\Model\ListItem;
use App\Model\ShoppingList;
use App\Repo\ListItemRepo;
use App\Repo\ShoppingListRepo;

class ShoppingAiManager
{
    public function __construct(
        private  ShoppingListRepo $shoppingListRepo,
        private  ListItemRepo $itemRepo,
        private  ?string $openAiApiKey = null,
        private  ?string $openAiModel = 'gpt-4o-mini'
    ) {}

    public function generateMenuAndCreateList(string $prompt, int $userId): int
    {
        $apiKey = $this->openAiApiKey ?? getenv('OPENAI_API_KEY');
        if (!$apiKey) {
            throw new \RuntimeException('Missing OPENAI_API_KEY.');
        }

        $assistantJson = $this->callOpenAi($apiKey, $this->openAiModel, $prompt);

        $payload = $this->parseAssistantJson($assistantJson);

        $title  = $payload['title'] ?? ('AI-Menü ' . date('Y-m-d'));
        $newList = new ShoppingList($title, $userId);
        $newListId = $this->shoppingListRepo->create($newList);

        foreach ($payload['items'] as $it) {
            $name    = trim((string)($it['name'] ?? ''));
            if ($name === '') {
                continue;
            }
            $amount  = $this->toIntOrNull($it['amount'] ?? null);
            $unit    = $this->normalizeUnit((string)($it['unit'] ?? 'stück'));
            $comment = trim((string)($it['comment'] ?? ''));
            $item = new ListItem($newListId, $name, (int)($amount ?? 1), $unit, $comment);
            $this->itemRepo->create($item);
        }

        return $newListId;
    }

    private function callOpenAi(string $apiKey, ?string $model, string $userPrompt): string
    {
        $system = <<<SYS
You are a menu & shopping planner.
Return ONLY strict JSON (no explanations, no markdown fences).
Schema:
{
  "title": "string (dish name and amount of persons, e.g. 'Vegane Burrito - 2 Personen', 'Spaghetti Bolognese - 1 Person')",
  "items": [
    {
      "name": "string",
      "amount": "integer or null if not applicable",
      "unit": "stück|kg|gramm|ml|liter|cm|meter",
      "comment": "string (can be empty)"
    }
  ]
}
Rules:
- The "title" must be a catchy name derived from the planned dishes, not just a restatement of the user prompt.
- Units must be one of: stück, kg, gramm, ml, liter, cm, meter.
- If an exact quantity isn't obvious, set amount to null (we'll default to 1).
- Keep "name" concise (e.g., "Tomaten", "Spaghetti").
- The JSON must be valid and parseable.
SYS;


        $body = json_encode([
            'model' => $model ?? 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => $system],
                ['role' => 'user',   'content' => $userPrompt],
            ],
            'temperature' => 0.4,
        ], JSON_UNESCAPED_UNICODE);

        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey,
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_TIMEOUT => 45,
        ]);

        $raw = curl_exec($ch);
        if ($raw === false) {
            $err = curl_error($ch);
            curl_close($ch);
            throw new \RuntimeException('OpenAI request failed: ' . $err);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode < 200 || $httpCode >= 300) {
            throw new \RuntimeException('OpenAI HTTP ' . $httpCode . ': ' . $raw);
        }

        $json = json_decode($raw, true);
        $assistant = $json['choices'][0]['message']['content'] ?? null;
        if (!is_string($assistant) || $assistant === '') {
            throw new \RuntimeException('OpenAI returned empty content.');
        }
        return $assistant;
    }

    private function parseAssistantJson(string $assistantJson): array
    {
        if (preg_match('/```json\s*(.*?)\s*```/is', $assistantJson, $m)) {
            $assistantJson = $m[1];
        }

        $data = json_decode($assistantJson, true);
        if (!is_array($data)) {
            throw new \RuntimeException('Failed to parse JSON from assistant.');
        }

        if (!isset($data['items']) || !is_array($data['items'])) {
            throw new \RuntimeException('Assistant JSON missing "items" array.');
        }

        $normItems = [];
        foreach ($data['items'] as $row) {
            if (!is_array($row)) { continue; }
            $normItems[] = [
                'name'    => isset($row['name']) ? (string)$row['name'] : '',
                'amount'  => $this->toIntOrNull($row['amount'] ?? null),
                'unit'    => $this->normalizeUnit((string)($row['unit'] ?? 'stück')),
                'comment' => isset($row['comment']) ? (string)$row['comment'] : '',
            ];
        }

        if (empty($normItems)) {
            throw new \RuntimeException('Assistant JSON contained zero valid items.');
        }

        $data['title'] = isset($data['title']) ? (string)$data['title'] : 'AI-Menü';
        $data['items'] = $normItems;

        return $data;
    }

    private function toIntOrNull($v): ?int
    {
        if ($v === null || $v === '' || $v === 'null') {
            return null;
        }
        if (is_numeric($v)) {
            return (int)floor((float)$v);
        }
        return null;
    }

    private function normalizeUnit(string $u): string
    {
        $u = mb_strtolower(trim($u));
        $map = [
            'stk' => 'stück',
            'stück' => 'stück',
            'stueck' => 'stück',
            'pcs' => 'stück',
            'kg' => 'kg',
            'g' => 'gramm',
            'gramm' => 'gramm',
            'gr' => 'gramm',
            'ml' => 'ml',
            'l' => 'liter',
            'liter' => 'liter',
            'cm' => 'cm',
            'm' => 'meter',
            'meter' => 'meter',
        ];
        return $map[$u] ?? 'stück';
    }
}
