<?php

namespace App\Models;

use App\Models\BrandModel;
use Exception;

class ProductModel extends BaseModel
{
    private $brandModel;

    public function __construct()
    {
        parent::__construct();
        $this->brandModel = new BrandModel();
    }

    public function getAllProducts()
    {
        try {
            $this->db->query("SELECT product.*, brand.name as brand_name FROM product JOIN brand ON product.brand_id = brand.id");
            return $this->db->resultSet();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function getProductById($id)
    {
        $this->db->query("SELECT * FROM product WHERE id = :id");
        $this->db->bind(':id', $id);
        $product = $this->db->single();

        if (!$product) {
            $_SESSION['errorMessage'] = 'Sản phẩm đã bị xóa';
            header('Location: /');
            exit();
        }

        return $product;
    }

    public function getProductByBrand($brandId)
    {
        $this->db->query("SELECT * FROM product WHERE brand_id = :brand_id");
        $this->db->bind(':brand_id', $brandId);
        return $this->db->resultSet();
    }

    public function createProduct($productData)
    {
        $this->db->query("INSERT INTO book (bookname, mota) VALUES(:bookname, :mota)");
        $this->db->bind(':bookname', $productData['bookname']);
        $this->db->bind(':mota', $productData['mota']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteProduct($id)
    {
        $this->db->query("DELETE FROM product WHERE id = :id");
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function productSearch($query)
    {
        $this->db->query("SELECT * FROM book WHERE bookname LIKE :query");
        $this->db->bind(':query', '%' . $query . '%');
        $results = $this->db->resultSet();
        return $results;
    }

    public function createProductImage($productData)
    {
        $brandId = $this->brandModel->getBrandByName($productData['brand_name']);

        $this->db->query("INSERT INTO product (name, price, image, brand_id) VALUES(:name, :price, :image, :brand_id)");
        $this->db->bind(':name', $productData['name']);
        $this->db->bind(':price', $productData['price']);
        $this->db->bind(':image', $productData['image']);
        $this->db->bind(':brand_id', $brandId['id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function editProduct($id, $productData)
    {
        $brandId = $this->brandModel->getBrandByName($productData['brand_name']);

        $this->db->query("UPDATE product SET name = :name, price = :price, image = :image, brand_id = :brand_id WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->bind(':name', $productData['name']);
        $this->db->bind(':price', $productData['price']);
        $this->db->bind(':image', $productData['image']);
        $this->db->bind(':brand_id', $brandId['id']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
