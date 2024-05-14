<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Services\HandleLoginService;

use App\Models\UserModel;
use Exception;

class AuthController extends BaseController
{
    private $productModel;
    public $HandleLoginService;

    private $UserModel;
    public function __construct()
    {
        parent::__construct();
        $this->HandleLoginService = new HandleLoginService();
        $this->productModel = new ProductModel();
        $this->UserModel = new UserModel();
    }






    public function login_get()
    {
        require_once '../app/Views/auth/login_get.php';
    }


    public function login_post()
    {

        //con lạc đà

        //gặp lỗi như vẩn chay được thì dùng try catch 
        // nếu muốn gặp lỗi dừng lại thì dùng exit
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = [
            'email' => $email,
            'password' => $password,
        ];
        $this->HandleLoginService->handle_data_login($user);


        if (isset($_POST['login'])) {


            if (isset($_POST['remember'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];
                $_POST['remember'] = true;
                $user = [
                    'email' => $email,
                    'password' => $password,
                ];
                $this->HandleLoginService->handle_login($user, $_POST['remember']);
            }

            if (!isset($_POST['remember'])) {
                $_POST['remember'] = false;
                $email = $_POST['email'];
                $password = $_POST['password'];
                $user = [
                    'email' => $email,
                    'password' => $password,
                ];
                // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                //     http_response_code(400);
                //     echo '400 Bad Request: Yêu cầu không hợp lệ hoặc không thể hiểu.';
                //     exit;
                // }
                $this->HandleLoginService->handle_login($user, $_POST['remember']);
            }
        }
    }



    // if (isset($_POST['login']) && isset($_POST['remember'])) {

    //     if (!empty($_POST['email']) && !empty($_POST['password'])) {
    //         $email = $_POST['email'];
    //         $password = $_POST['password'];
    //         $_POST['remember'] = true;
    //         $user = [
    //             'email' => $email,
    //             'password' => $password,
    //         ];
    //         // echo $email;
    //         //echo $password;
    //         //  exit;
    //         $this->HandleLoginService->handle_login($user, $_POST['remember']);
    //     }
    // }
    // if (isset($_POST['login'])) {
    // }



    function register_get()
    {
        require_once '../app/Views/auth/register_get.php';
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

    public function logout_post()
    {
        // Unset all of the session variables
        setcookie("session_Id", "", time() - 3600, "/");

        setcookie("address", "", time() - 3600, "/");

        setcookie("email", "", time() - 3600, "/");

        setcookie("password_hash", "", time() - 3600, "/");

        setcookie("phone_number", "", time() - 3600, "/");

        setcookie("remember", "", time() - 3600, "/");

        setcookie("username", "", time() - 3600, "/");


        header('Location:/login_get');


        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        // Finally, destroy the session.
        //session_destroy();
        // Redirect to homepage
        // header("location: /");
    }
}
