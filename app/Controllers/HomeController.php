<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        // echo "hello";

        // $data = compact('products');

        require_once '../app/Views/home.php';
    }
}
