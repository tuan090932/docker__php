<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\UserModel;


class AuthController extends BaseController
{

    private $productModel;
    private $UserModel;


    public function __construct()
    {
        parent::__construct();
        $this->productModel = new ProductModel();
        $this->UserModel = new UserModel();
    }

    public function login_get()
    {
        //echo "hello";

        // $data = compact('products');

        require_once '../app/Views/login_get.php';
    }


    public function login_post()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        //$user = $this->UserModel->handle_login($email);
        $user = [
            'email' => $email,
            'password' => $password,
        ];
        $this->UserModel->handle_login($user);
    }

    public function register_get()
    {

        require_once '../app/Views/register_get.php';
    }

    public function register_post()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $Address = $_POST['Address'];
        if ($password == $confirm_password) {
            $user = [
                'name' => $name,
                'email' => $email,
                'contact' => $contact,
                'password' => $password,
                'Address' => $Address,
            ];
            $this->UserModel->CreateUser($user);
        } else {
            echo "Passwords do not match.";
        }
    }
}
