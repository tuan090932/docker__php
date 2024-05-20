<?php

namespace App\Models;

use Exception;

class UserModel extends BaseModel
{
    public function createUser($user)
    {
        $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
        // Khi bạn sử dụng PASSWORD_DEFAULT, PHP sẽ chọn thuật toán băm mật khẩu mạnh nhất có thể sử dụng. Hiện tại, nó là BCRYPT
        $this->db->query("INSERT INTO user_info (username, password, email_address, phone_number, address) VALUES(:username, :password, :email_address, :phone_number, :address)");
        $this->db->bind(':username', $user['name']);
        $this->db->bind(':password', $hashedPassword);
        $this->db->bind(':email_address', $user['email']);
        $this->db->bind(':phone_number', $user['contact']);
        $this->db->bind(':address', $user['Address']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function CheckDuplicateEmail($email)
    {


        // pre

        $this->db->query("SELECT *FROM user_info where email_address=:email");
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        if ($row) {
            return true;
        } else {
            return false;
        }
    }

    public function insertSession($sessionId, $username)
    {


        //$name = $_COOKIE['username'] ?? null;

        $this->db->query("SELECT * FROM session WHERE session_id = :session_id");
        $this->db->bind(':session_id', $sessionId);
        $row = $this->db->single();

        if ($row) {
            $this->db->query("UPDATE session SET username = :username WHERE session_id = :session_id");
        } else {
            $this->db->query("INSERT INTO session (session_id, username) VALUES (:session_id, :username)");
        }
        $this->db->bind(':session_id', $sessionId);
        $this->db->bind(':username', $username);
        $this->db->execute();
    }
}
