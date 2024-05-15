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

        // VarDumper::dump("helo");
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $url = "https://";
        else
            $url = "http://";
        // Append the host(domain name, ip) to the URL.   
        $url .= $_SERVER['HTTP_HOST'];
        //  echo $url;
        // Append the requested resource location to the URL   
        $url .= $_SERVER['REQUEST_URI'];
        // Phân tích URL
        $urlParts = parse_url($url);
        //echo $urlParts;
        //  echo $urlParts;
        // echo $urlParts['path'];

        $url = $urlParts;

        // Split the path by '/'
        $pathParts = explode('/', $url['path']);

        // Get the last part of the path, which should be the final value
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
                $this->UserModel->insertSession($randomNumber);
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
                    $cookieExpiration = time() + (10); //là số giây là 10 giây // 86400 = 1 day
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
                // Display an error message if password is not valid
                if (isset($_SESSION['password_error'])) {
                    //không làm gì cả
                } else {
                    $_SESSION['password_error'] = 'bạn nhập sai password mất rồi';
                    $_SESSION["message"] = "sai password mất rồi";
                }

                header("location: /login");

                //  echo "The password you entered was not valid.";
            }
        } else {



            if (isset($_SESSION['email_error'])) {
                //không làm gì cả
            } else {

                $_SESSION['email_error'] = 'bạn nhập sai email mất rồi';
                $_SESSION["message"] = "sai email mất rồi";
            }


            header('Location:/login_get');
            // Display an error message if email doesn't exist
            echo "No account found with that email.";
        }
    }



    public function handleDataLogin($user)
    {
        session_start();
        try {
            if (!isset($user['email']) || empty($user['email'])) {
                $_SESSION['email_error'] = 'email trống.';

                throw new Exception(' Bad Request: email trống.');
            }

            if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['email_error'] = 'Bad Request: đây không phải là email.';

                throw new Exception(' Bad Request: đây không phải là email.');
            }
            if (!array_key_exists('password', $user) || empty($user['password'])) {

                $_SESSION['password_error'] = 'Mậc khẩu trống.';

                throw new Exception(' Bad Request: Mậc khẩu trống.');
            }
            if (strlen($user['password']) > 20) {

                $_SESSION['password_error'] = 'Mật khẩu không được quá 20 ký tự.';

                throw new Exception(' Bad Request: Mật khẩu không được quá 20 ký tự.');
            }
            // Rest of your code...
        } catch (Exception $ex) {

            //exceoption được run hoặc là dính lỗi hàm không tồn tại ,cú pháp thì nó vẩn chyaj exception
            echo $ex->getMessage(); // lấy thông tin từ exceptio("chuổi abc") -> ném chuổi này ra
            //  echo $ex->getFile();
            // echo $ex->getLine();
            http_response_code(400);
            // echo '<script>alert("' . $ex->getMessage() . '");</script>';
            // echo '<script>window.location.replace("login_get");</script>'; // Chuyển hướng đến trang khác nếu cần
            // echo "co loi";
            //exit(); // Dừng việc thực thi tiếp theo

        }
    }


    // Add more methods as needed for other product-related logic
}
