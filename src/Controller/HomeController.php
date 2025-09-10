<?php

namespace App\Controller;

class HomeController extends BaseController
{
    public function template(): void
    {
        include __DIR__ . '/../Templates/home.php';
    }

}
