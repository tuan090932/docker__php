<?php

namespace App\Models;


use Exception;
// tự hiểu auto_load sẽ add vào
class UserModel extends BaseModel
{





    public function CreateUser($User)
    {

        // Hash the password
        $hashedPassword = password_hash($User['password'], PASSWORD_DEFAULT);
        //dung ham password_hash

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

    public function InsertSession($session_Id)
    {
        $this->db->query("SELECT * FROM session WHERE session_id = :session_id");
        $this->db->bind(':session_id', $session_Id);
        $row = $this->db->single();

        if ($row) {
            // Update existing record
            $this->db->query("UPDATE session SET username = :username WHERE session_id = :session_id");
        } else {
            // Insert new record
            $this->db->query("INSERT INTO session (session_id, username) VALUES (:session_id, :username)");
        }

        $this->db->bind(':session_id', $session_Id);
        $this->db->bind(':username', 'tuan');
        $this->db->execute();
    }
}
