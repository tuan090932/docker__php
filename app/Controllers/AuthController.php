<?php

namespace App\Controllers;

use Exception;

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

        try {
            //throw new Exception(' Bad Request: email trống.');
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
        } catch (exception $e) {
            $errorMessage = $e->getMessage();
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'Postman') !== false) {
                // Nếu request đến từ Postman
                echo $errorMessage; //echo này nó giúp postman tại login_post nhìn thấy
                http_response_code(400); // Đặt mã phản hồi HTTP thành 500
                exit(); // Đảm bảo không thực hiện xử lý tiếp theo
            } else {
                // Nếu request đến từ trình duyệt
                header('Location: /login');
                exit(); // Đảm bảo không thực hiện xử lý tiếp theo
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

            header('Location:/login');
            $_SESSION['sussessfulCreateAccout'] = 'Bạn đã tạo tài khoản thành công';
        } else {

            $_SESSION['error_password'] = 'vui lòng nhập lại mậc khẩu vì không khớp';
            //header('Location:/register');
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
