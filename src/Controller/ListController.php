<?php

namespace App\Controller;
use App\Manager\ShoppingAiManager;
use App\Model\ListItem;
use App\Repo\ListItemRepo;
use App\Repo\ShoppingListRepo;
use App\Model\ShoppingList;
use App\Repo\UserRepo;

class ListController extends BaseController
{
    private ShoppingListRepo $shoppingListRepo;
    private ListItemRepo $itemRepo;

    private ShoppingAiManager $shoppingAiManager;

    public function __construct(
        UserRepo $userRepo,
        array $strings,
        ShoppingListRepo $shoppingListRepo,
        ListItemRepo $itemRepo,
        ShoppingAiManager $shoppingAiManager
    )
    {
        parent::__construct($userRepo, $strings);
        $this->shoppingListRepo = $shoppingListRepo;
        $this->itemRepo = $itemRepo;
        $this->strings = $strings;
        $this->shoppingAiManager = $shoppingAiManager;
    }

    public function template(): void {
        $action = $this->getRequestedAction();
        if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'GET') {
            include __DIR__ . '/../Templates/new_list.php';
        } elseif ($action === 'detail' && $_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->detail();
        } elseif ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->edit();
        } elseif ($action === 'join' && $_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->join();
        } else {
            $this->index();
        }
    }
    
    public function index(): void {
        $lists = $this->shoppingListRepo->getAllForUser($this->getCurrentUser()->getId());
        include __DIR__ . '/../Templates/list_overview.php';
    }

    public function create(): void
    {
        $name = trim($_POST['name'] ?? '');
        $userId = $this->getCurrentUser()->getId();

        if (!$name && !$userId) {
            $errorMsg = $this->strings['missing_list_name_or_user'];
            echo "<p class='error'>" . htmlspecialchars($errorMsg) . "</p>";
            return;
        }
            try {
                $this->shoppingListRepo->create(new ShoppingList($name, (int) $userId));
                header("Location: index.php?controller=list&action=template");
                exit;
            } catch (\PDOException $e) {
                echo "<p class='error'>Fehler: " . htmlspecialchars($e->getMessage()) . "</p>";
            }

    }

    public function addItem(): void
    {
        $listId = $_POST['list_id'] ?? null;
        $name = trim($_POST['name'] ?? '');
        $amount = trim($_POST['amount'] ?? '');
        $unit = trim($_POST['unit'] ?? '');
        $comment = trim($_POST['comment'] ?? '');

        if (!$listId || $name === '') {
            $errorMsg = $this->strings['missing_item_name_or_list'] ?? 'Fehlender Eintrag oder Liste.';
            echo "<p class='error'>" . htmlspecialchars($errorMsg) . "</p>";
            return;
        }

        $allowedUnits = ['stück', 'kg', 'gramm', 'ml', 'liter', 'cm', 'meter'];
        $unit = $unit === '' ? 'stück' : strtolower($unit);
        if (!in_array($unit, $allowedUnits, true)) {
            $unit = 'stück';
        }

        $amount = $amount === '' ? 0 : (int)$amount;

        try {
            $item = new ListItem((int)$listId, $name, $amount, $unit, $comment);
            $this->itemRepo->create($item);
            header("Location: index.php?controller=list&action=detail&id=" . urlencode($listId));
            exit;
        } catch (\PDOException $e) {
            echo "<p class='error'>Fehler: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }

    public function checkItem(): void
    {
        $itemId = $_POST['item_id'] ?? null;
        $listId = $_POST['list_id'] ?? null;

        if (!$itemId || !$listId) {
            echo "<p class='error'>Ungültige Anfrage.</p>";
            return;
        }

        try {
            $this->itemRepo->markChecked((int)$itemId, true);
            header("Location: index.php?controller=list&action=detail&id=" . (int)$listId);
            exit;
        } catch (\Exception $e) {
            echo "<p class='error'>Fehler beim Abhaken: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if (!$id) { $this->redirect('?controller=list&action=index'); }

        $list = $this->shoppingListRepo->getListById($id);
        if (!$list) {
            $this->renderError('Liste nicht gefunden.');
            return;
        }

        include __DIR__ . '/../Templates/list_edit.php';
    }

    public function update(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        if (!$id || $name === '') {
            $this->renderError('Ungültige Eingabe.');
            return;
        }

        try {
            $list = $this->shoppingListRepo->getListById($id);
            $list->setName($name);
            $this->shoppingListRepo->update($list);
            $this->redirect('?controller=list&action=index');
        } catch (\Throwable $e) {
            $this->renderError('Konnte Liste nicht umbenennen: ' . htmlspecialchars($e->getMessage()));
        }
    }

    public function delete(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        if (!$id) {
            $this->renderError('Ungültige Anfrage.');
            return;
        }

        try {
            $this->shoppingListRepo->delete($id);
            $this->redirect('?controller=list&action=index');
        } catch (\Throwable $e) {
            $this->renderError('Konnte Liste nicht löschen: ' . htmlspecialchars($e->getMessage()));
        }
    }


    public function detail(): void {
        $listId = $_GET['id'] ?? null;
        if (!$listId) {
            $errorMsg = $this->translate('no_list_error');
            echo "<p class='error'>" . htmlspecialchars($errorMsg) . "</p>";
            return;
        }

        $list = $this->shoppingListRepo->getListById((int) $listId);
        $items = $this->itemRepo->getItemsByListId((int) $listId);

        include __DIR__ . '/../Templates/list_detail.php';
    }

    public function join(): void
    {
        $user = $this->getCurrentUser();
        if (!$user) {
            $this->redirect('?controller=auth&action=login');
            return;
        }

        $listId = (int)($_GET['list_id'] ?? 0);
        if ($listId <= 0) {
            $this->renderError('Ungültige Listen-ID.');
            return;
        }

        try {
            $list = $this->shoppingListRepo->getListById($listId);
            if (!$list) {
                $this->renderError('Liste nicht gefunden.');
                return;
            }

            $this->shoppingListRepo->addMember($listId, $user->getId());
            $this->redirect('?controller=list&action=detail&id=' . $listId);
        } catch (\Throwable $e) {
            $this->renderError('Beitritt fehlgeschlagen: ' . htmlspecialchars($e->getMessage()));
        }
    }

    public function aiGenerate(): void
    {
        $persons     = max(1, (int)($_POST['persons'] ?? 2));
        $meals       = max(1, (int)($_POST['meals'] ?? 5));
        $cuisine     = trim((string)($_POST['cuisine'] ?? ''));
        $budget      = trim((string)($_POST['budget'] ?? ''));
        $vegetarian  = isset($_POST['vegetarian']);
        $vegan       = isset($_POST['vegan']);
        $allergies   = trim((string)($_POST['allergies'] ?? ''));
        $dislikes    = trim((string)($_POST['dislikes'] ?? ''));
        $notes       = trim((string)($_POST['notes'] ?? ''));
        $baseListId  = (int)($_POST['base_list_id'] ?? 0);

        $parts = [];
        $parts[] = "{$persons} Personen";
        $parts[] = "{$meals} Mahlzeiten";
        if ($vegan) {
            $parts[] = "vegan";
        } elseif ($vegetarian) {
            $parts[] = "vegetarisch";
        }
        if ($cuisine !== '') {
            $parts[] = "Küche: {$cuisine}";
        }
        if ($budget !== '') {
            $parts[] = "Budget ca. CHF {$budget}";
        }
        if ($allergies !== '') {
            $parts[] = "Allergien/Unverträglichkeiten: {$allergies}";
        }
        if ($dislikes !== '') {
            $parts[] = "Ausschlüsse: {$dislikes}";
        }
        if ($notes !== '') {
            $parts[] = "Zusatzwünsche: {$notes}";
        }

        $prompt = "Erstelle eine Einkaufs- und Menüplanung basierend auf:\n- " . implode("\n- ", $parts) .
            "\n\nLiefere nur die finalen Einkaufspositionen (keine Rezepte), " .
            "mit sinnvollen Mengen pro Artikel. Nutze Einheiten nur aus: stück, kg, gramm, ml, liter, cm, meter. " .
            "Wenn Mengen unsicher sind, setze amount=null.";

        try {
            $newListId = $this->shoppingAiManager->generateMenuAndCreateList($prompt, $this->getCurrentUser()->getId());
            header('Location: index.php?controller=list&action=detail&id=' . $newListId);
            exit;
        } catch (\Throwable $e) {
            http_response_code(500);
            echo "<p class='error'>Fehler beim Generieren der Liste: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }

}