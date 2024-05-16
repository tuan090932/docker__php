<?php

namespace App\Models;

use Exception;

class CartModel extends BaseModel
{
    public function getAllCart($userId)
    {

        // cart và product dựa trên điều kiện cart.product_id = product.id
        //Đoạn truy vấn SQL này được sử dụng để lấy tất cả các thông tin về sản phẩm từ bảng product
        // mà người dùng đã thêm vào giỏ hàng.
        //cart.user_info_id = :userId điều kiện
        //phép hết product với cart product để có thêm colum
        try {
            $this->db->query("SELECT product.* FROM cart JOIN product ON cart.product_id = product.id WHERE cart.user_info_id = :userId");
            $this->db->bind(':userId', $userId);
            return $this->db->resultSet();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function insertCart($idUser, $idProduct)
    {
        try {
            $this->db->query("INSERT INTO cart (user_info_id, product_id, quantity) VALUES (:user_info_id, :product_id, :quantity)");
            $this->db->bind(':user_info_id', $idUser);
            $this->db->bind(':product_id', $idProduct);
            $this->db->bind(':quantity', 1); // assuming quantity is 1
            $this->db->execute();
            return true;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function deleteCartById($id)
    {

        try {
            $this->db->query("DELETE FROM cart WHERE product_id = :id");
            $this->db->bind(':id', $id);
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function getBrandById($id)
    {
        $this->db->query("SELECT * FROM brand WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getBrandByName($name)
    {
        $this->db->query("SELECT * FROM brand WHERE name = :name");
        $this->db->bind(':name', $name);
        return $this->db->single();
    }

    public function getProductById($id)
    {
        $this->db->query("SELECT * FROM product WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function createProduct($productData)
    {
        $this->db->query("INSERT INTO book (bookname, mota) VALUES(:bookname, :mota)");
        $this->db->bind(':bookname', $productData['bookname']);
        $this->db->bind(':mota', $productData['mota']);

        if ($this->db->execute()) {
            echo "<script>alert('create thành công');</script>";
            return true;
        } else {
            return false;
        }
    }
}
