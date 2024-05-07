<?php

namespace App\Models;

use App\Traits\Loggable;

use Exception;
// tự hiểu auto_load sẽ add vào
class ProductModel extends BaseModel implements IProductModel
{
    use Loggable;

    public function getAllProducts()
    {
        try {

            //  $this->query("SHOW TABLES");
            // return $this->resultSet();

            //$this->db->query("SHOW TABLES");

            $this->db->query("SELECT * FROM book");
            $this->log("Getting all products from " . __FILE__);
            //-> output là  file này "C:\xampp\htdocs\PHP_MVC\app\Models\ProductModel.php"

            return $this->db->resultSet();
        } catch (Exception $e) {
            // Xử lý lỗi ở đây
            $this->log("Caught exception: " . $e->getMessage());
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
    public function getProductById($id)
    {
        $this->db->query("SELECT * FROM book WHERE id_book = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }


    public function createProduct($productData)
    {
        $this->db->query("INSERT INTO book (bookname, mota) VALUES(:bookname, :mota)");
        // Bind values
        $this->db->bind(':bookname', $productData['bookname']);
        $this->db->bind(':mota', $productData['mota']);
        // Get current date and time
        // $now = new \DateTime();
        // $this->db->bind(':created_at', $now->format('Y-m-d H:i:s'));
        // $this->db->bind(':updated_at', $now->format('Y-m-d H:i:s'));
        // Execute
        if ($this->db->execute()) {
            echo "<script>alert('create thành công');</script>";

            return true;
        } else {
            return false;
        }
    }
    public function deleteProduct($id)
    {
        $this->db->query("DELETE FROM book WHERE id_book = :id");
        // Bind values
        $this->db->bind(':id', $id);
        // Execute  
        if ($this->db->execute()) {
            echo "<script>alert('delete thành công');</script>";

            return true;
        } else {
            return false;
        }
    }




    public function editProduct($id, $productData)
    {
        $this->db->query("UPDATE book SET bookname = :bookname, mota = :mota WHERE id_book = :id");        // Bind values
        $this->db->bind(':id', $id);
        $this->db->bind(':bookname', $productData['bookname']);
        $this->db->bind(':mota', $productData['mota']);
        // Get current date and time
        // $now = new \DateTime();
        // $this->db->bind(':updated_at', $now->format('Y-m-d H:i:s'));
        // Execute
        if ($this->db->execute()) {
            echo "<script>alert('update thành công');</script>";

            return true;
        } else {
            return false;
        }
    }
}
