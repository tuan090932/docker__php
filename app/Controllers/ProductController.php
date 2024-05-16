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
            header('Location:/login');
            exit();
        }
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


        if ($_SESSION['admin'] == true) {


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
                session_start();
                $_SESSION['statusCreateProduct'] = "Tạo sản phẩm thành công";
                header('Location:/createProduct');
            }
        } else {
            $_SESSION['warning'] = "bạn không có quyền truy cập vào trang này ";
            header('Location:/');
        }
    }

    public function handleFilterByBrand()
    {
        //output tất cả product với brand_id

        if ($this->handleLoginService->checkSession()) {


            $finalValue = $this->handleLoginService->convertURLToFinalValue();
            $products = $this->productModel->getProductByBrand($finalValue);
            //$products = $this->productModel->getProductByBrand()
            require_once '../app/Views/product/showProductByBrand.php';
        } else {
            header('Location:/login');
        }


        // $Brand = $this->BrandModel->getAllBrand();
        //  exit;
        // Render view with the filtered products
    }



    public function productListByIdGet()
    {



        if ($this->handleLoginService->checkSession()) {

            $finalValue = $this->handleLoginService->convertURLToFinalValue();
            $product = $this->productModel->getProductById($finalValue);
            require_once '../app/Views/product/view_Product.php';
        } else {
            header('Location:/login');
        }




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

            // Redirect to the product list page
            session_start();
            $_SESSION['statusDeleteProduct'] = "delete thành công";
            header('Location:/');
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
            require_once '../app/Views/product/showBrand.php';
        } else {
            $_SESSION['warning'] = "bạn không có quyền truy cập vào trang này ";
            header('Location:/');
        }

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






        //  1 if (isset($_FILES['image'])) {: Kiểm tra xem có file hình ảnh được tải lên thông qua form không.
        //  2   $target_dir = "./image/";: Đặt thư mục mục tiêu để lưu trữ hình ảnh được tải lên.
        //   3  if (!is_dir($target_dir)) {: Kiểm tra xem thư mục mục tiêu có tồn tại không.         
        //    4  echo "Directory does not exist: $target_dir";: Nếu thư mục không tồn tại, in ra thông báo.         
        //    5  } elseif (!is_writable($target_dir)) {: Nếu thư mục tồn tại, kiểm tra xem nó có thể ghi được không.        
        //    6  echo "Directory is not writable: $target_dir";: Nếu thư mục không thể ghi, in ra thông báo.     
        //    7  } else {: Nếu thư mục tồn tại và có thể ghi, tiếp tục xử lý.       
        //    8  $target_file = $target_dir . basename($_FILES["image"]["name"]);: Tạo đường dẫn tệp mục tiêu bằng cách nối thư mục mục tiêu với tên của tệp hình ảnh.  
        //   9  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {: Di chuyển tệp đã tải lên từ vị trí tạm thời đến vị trí mục tiêu.      
        //   10  $image = $target_file;: Nếu việc di chuyển tệp thành công, đặt biến $image bằng đường dẫn tệp mục tiêu.
        //   11echo "Upload successful";: In ra thông báo tải lên thành công.

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
                    //folder
                } elseif (!is_writable($target_dir)) {
                    echo "Directory is not writable: $target_dir";
                } else {
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $image = $target_file;
                        echo "Upload successful";
                        //          ./image/xiaomi-11-pro.png
                        // basename=xiaomi-11-pro.png
                        //$target_file là folder muốn dy chuyển tới
                        //$_FILES["image"]["tmp_name"]: Đây là đường dẫn tới tệp tạm thời trên máy chủ nơi tệp đã tải lên được
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

            if ($this->productModel->editProduct($_POST['id'], $product)) {
                session_start();
                $_SESSION['statusEditProduct'] = "Sửa sản phẩm thành công";
                header('Location:/');
            }
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
