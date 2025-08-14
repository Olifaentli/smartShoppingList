<?php

namespace App\Controller;

class ListController
{
    public function template(): void
    {
        $this->detail();
    }

    public function detail(): void
    {
        $list = [
            'title' => '🎉 Party Einkaufsliste',
            'items' => [
                ['name' => 'Chips', 'quantity' => '3 Packungen'],
                ['name' => 'Cola', 'quantity' => '2 Flaschen'],
                ['name' => 'Bier', 'quantity' => '1 Kiste'],
                ['name' => 'Plastikbecher', 'quantity' => '20 Stück'],
            ]
        ];

        // ⬅️ Die $list-Variable wird vor dem include deklariert
        include __DIR__ . '/../Templates/list_detail.php';
    }
}
