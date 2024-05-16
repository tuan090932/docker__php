<?php

namespace App\Models;

use Exception;

class BrandModel extends BaseModel
{
    public function getAllBrand()
    {
        try {
            $this->db->query("SELECT * FROM brand");
            return $this->db->resultSet();
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

    public function deleteBrandById($idBrand)
    {
        try {
            $this->db->query("SELECT * FROM product WHERE brand_id = :id");
            $this->db->bind(':id', $idBrand);
            $result = $this->db->resultSet();
            if ($result) {
                $_SESSION['errorDeleteBrand'] = "không thể xóa thương hiệu này vì có sản phẩm thuộc thương hiệu này đang trong giỏ hàng";
                throw new Exception("không thể xóa thương hiệu này vì có sản phẩm thuộc thương hiệu này");
            }
            if ($result == false) {
                $this->db->query("DELETE FROM brand WHERE id = :id");
                $this->db->bind(':id', $idBrand);
                if ($this->db->execute()) {
                    $_SESSION['sucesssfullDeleteBrand'] = "xóa thành công thương hiệu có id $idBrand";
                    // echo $idBrand;
                }
            }
            header("Location: /editPhone");
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            header("Location: /editPhone");
        }
    }

    public function createBrand($nameBrand)
    {
        try {
            $this->db->query("SELECT * FROM brand WHERE name = :name");
            $this->db->bind(':name', $nameBrand);
            $result = $this->db->single();

            if ($result) {

                $_SESSION['errorBrand'] = "vui lòng nhập lại vì tên thương hiệu này đả tồn tại trong hệ thống";
                throw new Exception("Brand with name {$nameBrand} already exists.");
            }
            if ($result == false) {
                $_SESSION['successfullBrand'] = "thêm thành công thương hiệu $nameBrand thành công";
                $this->db->query("INSERT INTO brand (name) VALUES (:name)");
                $this->db->bind(':name', $nameBrand);
                $this->db->execute();
            }

            header("Location: /editPhone");
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            header("Location: /editPhone");
        }
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
