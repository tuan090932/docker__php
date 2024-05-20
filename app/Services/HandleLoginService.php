<?php

namespace App\Services;

use App\Models\ProductModel;
use App\Models\UserModel;
use App\Models\BaseModel;
use App\Models\Database; // Import the Database class
use Exception;

class HandleLoginService extends BaseModel
{
    protected $productModel;
    private $UserModel;
    protected $db; // Declare the $db property

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->UserModel = new UserModel(); // Initialize the $db property


        $this->db = new Database(); // Initialize the $db property


    }

    public function convertURLToFinalValue()
    {


        $url = '';
        $url .= $_SERVER['HTTP_HOST'];
        //input url
        //http://localhost/form_editProduct/40
        //echo $_SERVER['HTTP_HOST'];
        //ouput sẽ là localhost
        //echo "<br>";
        // Append the requested resource location to the URL   
        $url .= $_SERVER['REQUEST_URI'];
        //echo "<br>";
        //echo $_SERVER['REQUEST_URI'];
        //output sẽ là      /form_editProduct/40
        // Phân tích URL
        $urlParts = parse_url($url);
        echo "<br>";
        echo $urlParts['path'];
        // echo     localhost/form_editProduct/40
        //exit;
        //$url = $urlParts;

        // tách chưởi bởi dấu / ->localhost/form_editProduct/40->
        // a[0],localhost,a[1],là form_editProduct, a[2] và 40 
        $pathParts = explode('/', $urlParts['path']);

        //echo "<br>";
        //echo $pathParts[0]; // or another index depending on what you want to access
        //echo $pathParts[1];
        //echo $pathParts[2];

        //exit;
        // lấy giá trị cuối cùng của mảng
        $finalValue = end($pathParts);

        return $finalValue;
    }

    public function checkSession()
    {
        $sessionId = $_COOKIE['session_Id'] ?? null;




        if ($sessionId) {
            $this->db->query("SELECT * FROM session WHERE session_id = :session_id");
            $this->db->bind(':session_id', $sessionId);
            $row = $this->db->single();
            if ($row && $sessionId == $row['session_id']) {
                return true;
            }
        }
        return false;
    }


    public function handleLogin($User, $remember)
    {




        //session_start();

        // Prepare a select statement
        // Prepare a select statement

        $this->db->query("SELECT * FROM user_info WHERE email_address = :email");
        $this->db->bind(':email', $User['email']);
        $row = $this->db->single();

        // Check if the email exists in the database

        if ($row) {
            // Verify the password
            if (password_verify($User['password'], $row['password'])) {

                if ($row['role'] == 1) {
                    $_SESSION['admin'] = true;
                } else {
                    $_SESSION['admin'] = false;
                }


                // Password is correct, so start a new session

                // Store data in session variables
                // $session_Id = session_id(); // để sau này check mỗi lần request

                $randomNumber = rand();
                // dd($randomNumber);
                // echo $randomNumber;
                // exit;

                // Insert session_id into session table
                $this->UserModel->insertSession($randomNumber, $row['username']);
                $_SESSION["address"] = $row['address'];
                $_SESSION["phone_number"] = $row['phone_number'];

                // If remember me is checked, set cookies
                if ($remember) {

                    //if()

                    $cookieExpiration = time() + (86400); // 86400 = 1 day
                    setcookie("user_id",  $row['id'], $cookieExpiration, "/");
                    setcookie("email",  $row['email_address'], $cookieExpiration, "/");
                    setcookie("username", $row['username'], $cookieExpiration, "/");
                    setcookie("remember", $remember, $cookieExpiration, "/");
                    setcookie("session_Id", $randomNumber, $cookieExpiration, "/");
                    setcookie("address", $row['address'], $cookieExpiration, "/");
                    setcookie("phone_number", $row['phone_number'], $cookieExpiration, "/");
                    $remainingTime = $cookieExpiration - time();
                    // Store the remaining time in a cookie
                    setcookie("remaining_time", $remainingTime, $cookieExpiration, "/");
                    header("location: /");
                }
                // If remember me is not checked, dele  te cookies

                if ($remember == false) {
                    $cookieExpiration = time() + (2 * 3600); // 2 hours                    setcookie("email",  $row['email_address'], $cookieExpiration, "/");

                    setcookie("user_id",  $row['id'], $cookieExpiration, "/");
                    setcookie("email",  $row['email_address'], $cookieExpiration, "/");
                    setcookie("username", $row['username'], $cookieExpiration, "/");
                    setcookie("remember", '0', $cookieExpiration, "/");
                    setcookie("session_Id", $randomNumber, $cookieExpiration, "/");
                    setcookie("address", $row['address'], $cookieExpiration, "/");
                    setcookie("phone_number", $row['phone_number'], $cookieExpiration, "/");
                    // Calculate the remaining time for the cookie to expire
                    $remainingTime = $cookieExpiration - time();
                    // Store the remaining time in a cookie
                    setcookie("remaining_time", $remainingTime, $cookieExpiration, "/");
                    header("location: /");
                }
            } else {
                $_SESSION['password_error'] = 'bạn nhập sai password mất rồi';
                throw new Exception(' bạn nhập sai password mất rồi ');
                // Display an error message if password is not valid
                //  echo "The password you entered was not valid.";
            }
        } else {
            $_SESSION['email_error'] = 'bạn nhập sai email mất rồi';
            throw new Exception(' bạn nhập sai email mất rồi ');
            // Display an error message if email doesn't exist
        }
    }



    public function handleDataLogin($user)
    {
        //session_start();
        if (!isset($user['email']) || empty($user['email'])) {
            $_SESSION['email_error'] = 'email trống.';
            //http_response_code(400);
            throw new Exception(' Bad Request: email trống.');
        }

        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['email_error'] = 'đây không phải là email.';
            // http_response_code(400);
            throw new Exception(' Bad Request: đây không phải là email.');
        }
        if (empty($user['password'])) {

            $_SESSION['password_error'] = 'Mậc khẩu trống.';
            // http_response_code(400);
            throw new Exception(' Bad Request: Mậc khẩu trống.');
        }
        if (strlen($user['password']) > 20) {
            $_SESSION['password_error'] = 'Mật khẩu không được quá 20 ký tự.';
            // http_response_code(400);
            throw new Exception(' Bad Request: Mật khẩu không được quá 20 ký tự.');
        }
    }


    // Add more methods as needed for other product-related logic
}
