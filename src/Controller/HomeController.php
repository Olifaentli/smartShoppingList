<?php

namespace App\Controller;

class HomeController
{
    public function template()
    {
        $this->index();
    }

    public function index()
    {
        include __DIR__ . '/../Templates/home.php';
    }
}
