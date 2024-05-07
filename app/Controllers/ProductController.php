<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Validators\FormValidator;
use Symfony\Component\VarDumper\VarDumper;
use function App\Controllers\view;
use Exception;

class ProductController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new ProductModel();
    }

    public function productList()
    {
        //VarDumper::dump("helo");

        $products = $this->productModel->getAllProducts();
        $data = compact('products');
        require_once '../app/Views/product_list.php';
    }

    public function createProduct()
    {
        require_once '../app/Views/create_product.php';
    }


    public function handle_createProduct()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $validator = new FormValidator($_POST);
            try {
                // $validator->validate();
                //echo $_POST['title'];
                // exit();

                $productData = [
                    'bookname' => $_POST['bookname'],
                    'mota' => $_POST['mota'],
                ];


                $this->productModel->createProduct($productData);
                header('Location: /product/list');
                exit();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public function form_editProduct()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $url = "https://";
        else
            $url = "http://";
        $url .= $_SERVER['HTTP_HOST'];
        $url .= $_SERVER['REQUEST_URI'];
        $urlParts = parse_url($url);
        $url = $urlParts;

        // Split the path by '/'
        $pathParts = explode('/', $url['path']);

        // Get the last part of the path, which should be the final value
        $finalValue = end($pathParts);

        echo $finalValue;

        //compact($finalValue);

        require_once '../app/Views/editProduct.php';
    }


    public function handle_deleteProduct()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $url = "https://";
        else
            $url = "http://";
        $url .= $_SERVER['HTTP_HOST'];
        $url .= $_SERVER['REQUEST_URI'];
        $urlParts = parse_url($url);
        $url = $urlParts;

        // Split the path by '/'
        $pathParts = explode('/', $url['path']);

        // Get the last part of the path, which should be the final value
        $finalValue = end($pathParts);

        echo $finalValue;

        $product = $this->productModel->deleteProduct($finalValue);
    }


    public function handle_edit()
    {

        if (isset($_POST['id'])) {
            $bookname = $_POST['bookname'];
            $mota = $_POST['mota'];
            $product = [
                'bookname' => $bookname,
                'mota' => $mota,
            ];

            $this->productModel->editProduct($_POST['id'], $product);
        }
    }




    public function handleLogin()
    {
        // ... authentication logic ...
        session_start();

        // Set cookies for username and address
        setcookie("username", "tuan ne", time() + (86400 * 30), "/"); // 86400 = 1 day
        setcookie("address", "ktx khu a", time() + (86400 * 30), "/");
        echo "<script>alert('setcookie thanh cong ');</script>";

        //lay gia tri tu cookie -> show ra
        echo "<script>alert('Title: " . $_COOKIE['username'] . "\\nBody: " . $_COOKIE['address'] . "');</script>";


        // ... rest of the method ...
    }

    public function handle_viewProduct()
    {








        // VarDumper::dump("helo");
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $url = "https://";
        else
            $url = "http://";
        // Append the host(domain name, ip) to the URL.   
        $url .= $_SERVER['HTTP_HOST'];
        echo $url;
        // Append the requested resource location to the URL   
        $url .= $_SERVER['REQUEST_URI'];
        // Phân tích URL
        $urlParts = parse_url($url);
        //echo $urlParts;
        //  echo $urlParts;
        // echo $urlParts['path'];

        $url = $urlParts;

        // Split the path by '/'
        $pathParts = explode('/', $url['path']);

        // Get the last part of the path, which should be the final value
        $finalValue = end($pathParts);

        echo $finalValue;


        $product = $this->productModel->getProductById($finalValue);
        echo "<script>alert('Title: " . $product['bookname'] . "\\nBody: " . $product['author'] . "');</script>";

        //require_once 'app/Views/product_detail.php';
    }
}
