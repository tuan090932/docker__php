<?php

namespace App\Models;

interface IProductModel
{
    public function getAllProducts();

    public function getProductById($id);

    public function createProduct($productData);

    public function deleteProduct($id);
}
