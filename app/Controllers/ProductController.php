<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Validators\FormValidator;
use Symfony\Component\VarDumper\VarDumper;
use function App\Controllers\view;
use Exception;



namespace App\Controllers;

use App\Models\ProductModel;
use App\Services\HandleLoginService;

use App\Models\UserModel;





class ProductController extends BaseController
{
    private $productModel;
    private $HandleLoginService;

    private $UserModel;
    public function __construct()
    {
        parent::__construct();
        $this->HandleLoginService = new HandleLoginService();
        $this->productModel = new ProductModel();
        $this->UserModel = new UserModel();
    }

    public function productList()
    {
        //VarDumper::dump("helo");






        if ($this->HandleLoginService->checkSession()) {
            $products = $this->productModel->getAllProducts();
            //$data = compact('products');
            require_once '../app/Views/product_list.php';
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


        //$finalValue = end($pathParts);

        // echo $finalValue;

        //compact($finalValue);

        require_once '../app/Views/editProduct.php';
    }

    public function productSearch()
    {
        if (isset($_GET['query'])) {
            echo $_GET['query'];
            $products = $this->productModel->searchProduct($_GET['query']);
            //echo $products;

            // $data = compact('products');
            require_once '../app/Views/showProduct.php';
            // $data = compact('products');
            // require_once '../app/Views/product_list.php';
        }
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

    function extractFileName($path)
    {
        // Tách tên tệp từ đường dẫn đến tệp
        $filename = basename($path);

        // Trả về tên tệp đã xử lý
        return $filename;
    }
    public function handle_edit()
    {
        if (isset($_POST['id'])) {
            $bookname = $_POST['bookname'];
            $mota = $_POST['mota'];
            $rating = $_POST['Rating'];

            $nxb = $_POST['Publisher'];

            $author = $_POST['Author'];

            $id_danhmuc = $_POST['Category_Id'];

            $price = $_POST['Price'];
            //tiếp tục code lấy giá trị từ sau khi upload xuống 
            // Check if file was uploaded
            //$_POST['hinh'] = $_FILES['hinh']['name'];
            if (isset($_FILES['hinh'])) {
                $target_dir = "./image/";
                if (!is_dir($target_dir)) {
                    echo "Directory does not exist: $target_dir";
                } elseif (!is_writable($target_dir)) {
                    echo "Directory is not writable: $target_dir";
                } else {
                    $target_file = $target_dir . basename($_FILES["hinh"]["name"]);
                    if (move_uploaded_file($_FILES["hinh"]["tmp_name"], $target_file)) {
                        $hinh = $target_file;
                        echo $hinh;
                        // chèn cái này = cái lúc đầu ->output nó là  ./image/Screenshot 2024-03-06 232352.png
                        echo "thanh công";
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }

            echo $hinh;

            $hinh = $this->extractFileName($hinh);
            // echo $hinh;

            $product = [
                'bookname' => $bookname,
                'mota' => $mota,
                'hinh' => $hinh,
                'rating' => $rating,
                'nxb' => $nxb,
                'author' => $author,
                'price' => $price,
                'id_danhmuc' => $id_danhmuc
            ];
            $this->productModel->editProduct($_POST['id'], $product);
        }
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
