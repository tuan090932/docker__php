<?php

namespace App\Models;

use PDO;
use PDOException;

class Database
{
    private $host = 'mysql';
    private $port = '3306';
    private $user = 'root';
    private $password = 'root';
    private $dbname = 'tranining_php';
    private $dbh;
    private $stmt;
    public function __construct()
    {
        try {
            // Thiết lập kết nối PDO
            $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            $this->dbh = new PDO($dsn, $this->user, $this->password, $options);

            // Truy vấn để lấy tên của tất cả các bảng trong cơ sở dữ liệu
            $stmt = $this->dbh->query("SHOW TABLES");

            // Fetch tất cả các tên bảng vào một mảng
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Hiển thị tất cả các bảng
            echo "Các bảng trong cơ sở dữ liệu:<br>";
            foreach ($tables as $table) {
                echo $table . "<br>";
            }
        } catch (PDOException $e) {
            // Xử lý lỗi nếu kết nối không thành công
            die("Connection failed: " . $e->getMessage());
        }
    }
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    public function execute()
    {
        return $this->stmt->execute();
    }
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
