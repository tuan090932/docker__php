<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Validators\FormValidator;
use Symfony\Component\VarDumper\VarDumper;
use function App\Controllers\view;
use Exception;



namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\BrandModel;
use App\Models\CartModel;

use App\Services\HandleLoginService;

use App\Models\UserModel;






class CartController extends BaseController
{
    private $productModel;
    private $HandleLoginService;
    private $CartModel;


    private $UserModel;
    private $BrandModel;
    public function __construct()
    {
        parent::__construct();
        $this->HandleLoginService = new HandleLoginService();
        $this->productModel = new ProductModel();
        $this->UserModel = new UserModel();
        $this->BrandModel = new BrandModel();
        $this->CartModel = new CartModel();
    }
















    public function handlePostCart()
    {

        // thêm sản phẩm vô giỏ hàng
        $user_id = $_POST['user_id'];
        $product_id = $_POST['product_id'];
        //echo $this->CartModel->getAllCart();
        if ($this->CartModel->insertCart($user_id, $product_id)) {
            session_start();
            $_SESSION['statusInsertCart'] = "thêm vào giỏ hàng thành công";
            header("Location:/");
        }
        //echo "thanh còng";

    }

    public function getAllCart()
    {

        //echo $this->CartModel->getAllCart();
        $products = $this->CartModel->getAllCart(
            $_COOKIE['user_id']
        );
        require_once '../app/Views/cart/showCart.php';

        //echo "thanh còng";

    }
}
