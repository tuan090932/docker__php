<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Services\HandleLoginService;
use App\Models\UserModel;

class AuthController extends BaseController
{
    private $productModel;
    private $handleLoginService;
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->handleLoginService = new HandleLoginService();
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
    }

    public function getLogin()
    {
        require_once '../app/Views/auth/login_get.php';
    }



    public function postLogin()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = [
            'email' => $email,
            'password' => $password,
        ];
        $this->handleLoginService->handleDataLogin($user);

        if (isset($_POST['login'])) {
            if (isset($_POST['remember'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $_POST['remember'] = true;
                $user = [
                    'email' => $email,
                    'password' => $password,
                ];
                $this->handleLoginService->handleLogin($user, $_POST['remember']);
            }

            if (!isset($_POST['remember'])) {
                $_POST['remember'] = false;
                $email = $_POST['email'];
                $password = $_POST['password'];
                $user = [
                    'email' => $email,
                    'password' => $password,
                ];
                $this->handleLoginService->handleLogin($user, $_POST['remember']);
            }
        }
    }

    public function getRegister()
    {
        require_once '../app/Views/auth/register_get.php';
    }

    public function postRegister()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        $address = $_POST['Address'];
        if ($password == $confirmPassword) {
            $user = [
                'name' => $name,
                'email' => $email,
                'contact' => $contact,
                'password' => $password,
                'Address' => $address,
            ];
            $this->userModel->createUser($user);
        } else {
            echo "Passwords do not match.";
        }
    }

    public function postLogout()
    {
        setcookie("session_Id", "", time() - 3600, "/");
        setcookie("address", "", time() - 3600, "/");
        setcookie("email", "", time() - 3600, "/");
        setcookie("password_hash", "", time() - 3600, "/");
        setcookie("phone_number", "", time() - 3600, "/");
        setcookie("remember", "", time() - 3600, "/");
        setcookie("username", "", time() - 3600, "/");
        header('Location:/login');
    }
}
