<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\BrandModel;
use App\Models\UserModel;
use App\Models\CartModel;
use App\Services\HandleLoginService;
use Symfony\Component\VarDumper\VarDumper;
use Exception;

class ProductController extends BaseController
{
    private $productModel;
    private $cartModel;


    private $handleLoginService;
    private $userModel;
    private $brandModel;

    public function __construct()
    {
        parent::__construct();
        $this->handleLoginService = new HandleLoginService();
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
        $this->brandModel = new BrandModel();
        $this->cartModel = new CartModel();
    }

    public function productList()
    {

        if ($this->handleLoginService->checkSession()) {
            $products = $this->productModel->getAllProducts();
            $brands = $this->brandModel->getAllBrand();
            // require_once '../app/Views/product/product_list.php';
            require_once '../app/Views/product/product_list.php';
        } else {
            header('Location:/login_get');
            exit();
        }


        //    try {
        //       if (isset($_COOKIE['username'])) {
        //         } else {
        //             throw new Exception("Cookie 'loggedin' is not set or false");
        //         }
        //     } catch (Exception $e) {
        //         error_log($e->getMessage());
        //         header('Location:/login_get');
        //         exit();
        //     }
    }

    public function createProduct()
    {

        //session_start();
        if ($_SESSION['admin'] == true) {
            $Brand = $this->brandModel->getAllBrand();
            require_once '../app/Views/product/create_product.php';
        } else {
            $_SESSION['warning'] = "bạn không có quyền truy cập vào trang này ";
            header('Location:/');
        }
    }
    public function handleCreateProduct()
    {




        if (isset($_POST['id'])) {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $brand_name = $_POST['brand_name'];

            // Handle file upload
            $image = null;
            if (isset($_FILES['image'])) {
                $target_dir = "./image/";
                if (!is_dir($target_dir)) {
                    echo "Directory does not exist: $target_dir";
                } elseif (!is_writable($target_dir)) {
                    echo "Directory is not writable: $target_dir";
                } else {
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $image = $target_file;
                        echo "Upload successful";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
            $product = [
                'name' => $name,
                'price' => $price,
                'image' => $image,
                'brand_name' => $brand_name,
            ];

            $this->productModel->createProductImage($product);
        }
    }

    public function handleFilterByBrand()
    {
        //output tất cả product với brand_id

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
        //echo $finalValue;
        $products = $this->productModel->getProductByBrand($finalValue);
        //$products = $this->productModel->getProductByBrand()

        require_once '../app/Views/product/showProduct.php';

        // $Brand = $this->BrandModel->getAllBrand();
        //  exit;
        // Render view with the filtered products
    }



    public function productListByIdGet()
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

        $product = $this->productModel->getProductById($finalValue);
        require_once '../app/Views/product/view_Product.php';

        //input id-> output 1 product
    }

    public function formEditProduct()
    {



        session_start();
        // Tách tên tệp từ đường dẫn đến tệp
        if ($_SESSION['admin'] == true) {

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
            $Brand = $this->brandModel->getAllBrand();
            //$products = $this->productModel->getAllProducts();

            // echo $finalValue;
            //compact($finalValue);
            //require_once, các biến hiện tại được sử dụng trong phạm vi hàm gọi đó sẽ có thể truy cập được trong tệp tin được gọi
            // -> finalValue được gọi vì dùng require_onmce
            require_once '../app/Views/product/editProduct.php';
        } else {
            $_SESSION['warning'] = "bạn không có quyền truy cập vào trang này ";
            header('Location:/');
        }
    }

    public function productSearch()
    {
        if (isset($_GET['query'])) {
            echo $_GET['query'];
            //  $products = $this->productModel->searchProduct($_GET['query']);
            $products = $this->productModel->productSearch($_GET['query']);
            //echo $products;
            // $data = compact('products');

            require_once '../app/Views/product/showProduct.php';
            // $data = compact('products');
            // require_once '../app/Views/product_list.php';
        }
    }

    public function handleDeleteProduct()
    {
        // Tách tên tệp từ đường dẫn đến tệp
        if ($_SESSION['admin'] == true) {


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


            // Delete or update rows in the cart table that reference the product

            // Now you can delete the product
            //$this->productModel->deleteProduct($id);

            $this->cartModel->deleteCartById($finalValue);


            $product = $this->productModel->deleteProduct($finalValue);
        } else {
            $_SESSION['warning'] = "bạn không có quyền truy cập vào trang này ";
            header('Location:/');
        }
    }

    function extractFileName($path)
    {
        // Tách tên tệp từ đường dẫn đến tệp
        $filename = basename($path);

        // Trả về tên tệp đã xử lý
        return $filename;
    }

    function getAllBrand()
    {

        session_start();
        // Tách tên tệp từ đường dẫn đến tệp
        if ($_SESSION['admin'] == true) {
            $brand =  $this->brandModel->getAllBrand();
            echo "hello";
            require_once '../app/Views/product/showBrand.php';
        } else {
            $_SESSION['warning'] = "bạn không có quyền truy cập vào trang này ";
            header('Location:/');
        }

        // Trả về tên tệp đã xử lý
    }

    function getAddBrand($id_brand)
    {
        // Tách tên tệp từ đường dẫn đến tệp
        $brand =  $this->brandModel->getAllBrand();
        require_once '../app/Views/product/showBrand.php';

        // Trả về tên tệp đã xử lý
    }

    function postAddBrand($id_brand)
    {
        // Tách tên tệp từ đường dẫn đến tệp
        $brand =  $this->brandModel->getAllBrand();
        require_once '../app/Views/product/showBrand.php';

        // Trả về tên tệp đã xử lý
    }

    public function handleEdit()
    {
        if (isset($_POST['id'])) {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $brand_name = $_POST['brand_name'];

            // Handle file upload
            $image = null;
            if (isset($_FILES['image'])) {
                $target_dir = "./image/";
                if (!is_dir($target_dir)) {
                    echo "Directory does not exist: $target_dir";
                } elseif (!is_writable($target_dir)) {
                    echo "Directory is not writable: $target_dir";
                } else {
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $image = $target_file;
                        echo "Upload successful";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }

            $product = [
                'name' => $name,
                'price' => $price,
                'image' => $image,
                'brand_name' => $brand_name,
            ];

            $this->productModel->editProduct($_POST['id'], $product);
        }
    }

    public function handlePostBrand()
    {
        session_start(); // PHẢI KHAI BÁO NÓ TRƯỚC KHI SỬ DỤNG

        if (isset($_POST['nameBrand'])) {
            $this->brandModel->createBrand($_POST['nameBrand']);
        }
    }


    public function handleDeleteBrandByID()
    {

        session_start();

        $idBrand = $this->handleLoginService->convertURLToFinalValue();
        // exit;
        //session_start(); // PHẢI KHAI BÁO NÓ TRƯỚC KHI SỬ DỤNG

        $this->brandModel->deleteBrandById($idBrand);
    }


    public function handleViewProduct()
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
