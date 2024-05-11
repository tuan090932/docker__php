<?php

namespace App\Services;

use App\Models\ProductModel;
use App\Models\UserModel;
use App\Models\BaseModel;
use App\Models\Database; // Import the Database class

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
        // Prepare a select statement
        // Prepare a select statement
        $this->db->query("SELECT * FROM user_info WHERE email_address = :email");
        // Bind the email to the prepared statement
        $this->db->bind(':email', $User['email']);
        // Execute the statement
        $row = $this->db->single();

        // Check if the email exists in the database
        if ($row) {
            // Verify the password
            if (password_verify($User['password'], $row['password'])) {
                // Password is correct, so start a new session
                session_start();

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
                    $cookieExpiration = time() + (1000); // 86400 = 1 day
                    setcookie("password_hash", $User['password'], $cookieExpiration, "/");
                    setcookie("email",  $row['email_address'], $cookieExpiration, "/");
                    setcookie("username", $row['username'], $cookieExpiration, "/");
                    setcookie("remember", $remember, $cookieExpiration, "/");
                    setcookie("session_Id", $randomNumber, $cookieExpiration, "/");
                    // echo $randomNumber;
                    // exit;
                    // tạo 1 biến show thời hạn của của cookie  này
                    // $date = date('Y-m-d H:i:s', $cookieExpiration);
                    //   $decodedString = urldecode($date);
                    //echo "ham nay run chua";
                    //exit;
                    setcookie("address", $row['address'], $cookieExpiration, "/");
                    setcookie("phone_number", $row['phone_number'], $cookieExpiration, "/");
                }
                // If remember me is not checked, delete cookies

                $cookieExpiration = time() + (1000); // 86400 = 1 day
                setcookie("session_Id", $randomNumber, $cookieExpiration, "/");
                setcookie("username", $row['username'], $cookieExpiration, "/");
                setcookie("address", $row['address'], $cookieExpiration, "/");
                setcookie("phone_number", $row['phone_number'], $cookieExpiration, "/");
                // Redirect user to home page
                //  echo "ham nay run chua";
                // exit;
                header("location: /product/list");
            } else {
                // Display an error message if password is not valid
                $_SESSION["message"] = "login fail";
                header("location: /login_get");

                //  echo "The password you entered was not valid.";
            }
        } else {
            $_SESSION["message"] = "login fail";
            header('Location:/login_get');
            // Display an error message if email doesn't exist
            echo "No account found with that email.";
        }


        // ajax show 
    }

    public function getProductById($id)
    {
        //  return $this->productModel->getProductById($id);
    }
    // Add more methods as needed for other product-related logic
}
