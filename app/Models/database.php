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
            ///echo "Các bảng trong cơ sở dữ liệu:<br>";
            //oreach ($tables as $table) {
            //   echo $table . "<br>";
            //  }
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


        //$this->db->bind(':id', $idBrand);


        if (is_null($type)) {
            switch (true) {
                    //hàm sẽ tự động xác định loại dữ liệu của $value dựa trên giá trị của nó.
                    //is_int trong PHP được sử dụng để kiểm tra xem một biến có phải là số nguyên hay khôn
                    //nếu là số nguyên thì gán kiểu dữ liệu cho nó tiếp tục tới hết
                case is_int($value):

                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default: //  còn lại thì cho là string
                    $type = PDO::PARAM_STR; // PDO::PARAM_STR là một hằng số trong PHP Data Objects (PDO) mà đại diện cho kiểu dữ liệu chuỗi (string)
            }
        }

        // ràng buộc $value với $param với loại dữ liệu được xác định bởi $type.
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
