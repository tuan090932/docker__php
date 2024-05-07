<?php

namespace App\Services;

use App\Models\ProductModel;

class ProductService
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function getAllProducts()
    {
        // return $this->productModel->getAllProducts();
    }

    public function getProductById($id)
    {
        //  return $this->productModel->getProductById($id);
    }
    // Add more methods as needed for other product-related logic
}
