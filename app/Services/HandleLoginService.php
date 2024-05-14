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


    public function handle_login($User, $remember)
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
                // Password is correct, so start a new session

                // Store data in session variables
                // $session_Id = session_id(); // để sau này check mỗi lần request


                $randomNumber = rand();
                // dd($randomNumber);
                // echo $randomNumber;
                // exit;

                // Insert session_id into session table
                $this->UserModel->InsertSession($randomNumber);
                $_SESSION["address"] = $row['address'];
                $_SESSION["phone_number"] = $row['phone_number'];

                // If remember me is checked, set cookies
                if ($remember) {
                    $cookieExpiration = time() + (86400); // 86400 = 1 day

                    setcookie("email",  $row['email_address'], $cookieExpiration, "/");
                    setcookie("username", $row['username'], $cookieExpiration, "/");
                    setcookie("remember", $remember, $cookieExpiration, "/");
                    setcookie("session_Id", $randomNumber, $cookieExpiration, "/");
                    setcookie("address", $row['address'], $cookieExpiration, "/");
                    setcookie("phone_number", $row['phone_number'], $cookieExpiration, "/");
                    $remainingTime = $cookieExpiration - time();
                    // Store the remaining time in a cookie
                    setcookie("remaining_time", $remainingTime, $cookieExpiration, "/");
                    header("location: /product/list");
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


                    header("location: /product/list");
                }
            } else {
                // Display an error message if password is not valid
                if (isset($_SESSION['password_error'])) {
                    //không làm gì cả
                } else {
                    $_SESSION['password_error'] = 'bạn nhập sai password mất rồi';
                    $_SESSION["message"] = "sai password mất rồi";
                }

                header("location: /login_get");

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



    public function handle_data_login($user)
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

    public function getProductById($id)
    {
        //  return $this->productModel->getProductById($id);
    }
    // Add more methods as needed for other product-related logic
}
