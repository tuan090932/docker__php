<?php

namespace App\Models;

use App\Traits\Loggable;

use Exception;
// tự hiểu auto_load sẽ add vào
class UserModel extends BaseModel
{
    use Loggable;



    public function handle_login($User)
    {
        // Prepare a select statement
        $this->db->query("SELECT * FROM user_info WHERE email_address = :email");

        // Bind the email to the prepared statement
        $this->db->bind(':email', $User['email']);

        // Execute the statement
        $row = $this->db->single();
        echo  $row['password'];
        // Check if the email exists in the database
        if ($row) {
            // Verify the password
            if (password_verify($User['password'], $row['password'])) {
                // Password is correct, so start a new session
                session_start();

                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $row['id'];
                $_SESSION["username"] = $row['username'];
                $_SESSION["email_address"] = $row['email_address'];
                $_SESSION["address"] = $row['address'];
                $_SESSION["phone_number"] = $row['phone_number'];

                // tạo 1 biến show thời hạn của của cookie  này
                $cookieExpiration = time() + (60); // 86400 = 1 day
                $date = date('Y-m-d H:i:s', $cookieExpiration);

                //     $encodedString = "2024-05-09%2002%3A13%3A25";
                $decodedString = urldecode($date);
                // echo $decodedString; // Outputs: 2024-05-09 02:13:25


                setcookie("cookieExpiration", $decodedString, $cookieExpiration, "/");

                setcookie("loggedin", true, $cookieExpiration, "/");

                setcookie("id", $row['id'], $cookieExpiration, "/");
                setcookie("username", $row['username'], $cookieExpiration, "/");
                setcookie("email_address",  $row['email_address'], $cookieExpiration, "/");
                setcookie("address", $row['address'], $cookieExpiration, "/");
                setcookie("phone_number", $row['phone_number'], $cookieExpiration, "/");

                // Check if a session with the same ID already exists
                $this->db->query("SELECT * FROM session WHERE session_id = :session_id");
                $this->db->bind(':session_id', session_id());

                $existingSession = $this->db->single();

                // If a session with the same ID does not exist, insert a new one
                if (!$existingSession) {
                    $this->db->query("INSERT INTO session (session_id, username, last_access) VALUES(:session_id, :username, :last_access)");
                    $this->db->bind(':session_id', session_id()); // bì trùng khi cùng 1 tài khoản google -> đăng nhập nhiều  tài khoản khác nhau nó vẩn sinh ra chỉ 1 session id
                    $this->db->bind(':username', $row['username']);
                    $this->db->bind(':last_access', date('Y-m-d H:i:s', time()));
                    $this->db->execute();
                }



                // Redirect user to home page
                header("location: /product/list");
            } else {
                // Display an error message if password is not valid
                echo "The password you entered was not valid.";
            }
        } else {
            // Display an error message if email doesn't exist
            echo "No account found with that email.";
        }
    }


    public function CreateUser($User)
    {
        // Hash the password
        $hashedPassword = password_hash($User['password'], PASSWORD_DEFAULT);

        $this->db->query("INSERT INTO user_info (username, password, email_address, phone_number, address) VALUES(:username, :password, :email_address, :phone_number, :address)");
        // Bind values
        $this->db->bind(':username', $User['name']);
        $this->db->bind(':password', $hashedPassword); // Store the hashed password
        $this->db->bind(':email_address', $User['email']);
        $this->db->bind(':phone_number', $User['contact']);
        $this->db->bind(':address', $User['Address']);
        // Execute
        if ($this->db->execute()) {
            echo "<script>alert('create thành công');</script>";
            return true;
        } else {
            return false;
        }
    }
}
