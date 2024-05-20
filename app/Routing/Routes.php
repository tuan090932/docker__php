<?php
require_once '../vendor/autoload.php';

require_once '../config/config.php';

use App\Routing\Route;

//include_once '../app/Routing/Routes.php';
//include './app/Routing/Routes.php';
//
//require_once là một hàm PHP được sử dụng để tải một file PHP. Nếu file đã được tải trước đó, nó sẽ không tải lại.
//
//echo "ss";

// Define routes
//Route::add('/', 'HomeController@index');
//echo "<pre>" . print_r(Route::showroutes()) . "</pre>";

//Route::add('/index', 'HomeController@index');
//echo "<pre>" . print_r(Route::showroutes()) . "</pre>";
//Route::add('/product/list', 'ProductController@productList');

Route::add('/', 'ProductController@productList');
Route::add('/view/(\d+)', 'ProductController@productListByIdGet');
Route::add('/cart', 'CartController@getAllCart');




Route::add('/view/post_cart', 'CartController@handlePostCart');
Route::add('/editPhone', 'ProductController@getAllBrand');
Route::add('/addBrand', 'ProductController@getAllBrand');
Route::add('/deleteBrandByID/(\d+)', 'ProductController@handleDeleteBrandByID');
Route::add('/postBrand', 'ProductController@handlePostBrand');


//Route::add('/product/create', 'ProductController@createProduct');
//Route::add('/product/handle_create', 'ProductController@handle_createProduct');
//Route::add('/handleLogin', 'ProductController@handleLogin');

Route::add('/home', 'HomeController@index');


Route::add('/createProduct', 'ProductController@createProduct');
Route::add('/handleCreateProduct', 'ProductController@handleCreateProduct');
Route::add('/brand/(\d+)', 'ProductController@handleFilterByBrand');
Route::add('/product/list/view/(\d+)', 'ProductController@handleViewProduct');
Route::add('/delete/(\d+)', 'ProductController@handleDeleteProduct');
Route::add('/form_editProduct/(\d+)', 'ProductController@formEditProduct');

Route::add('/product/edit', 'ProductController@handleEdit');

Route::add('/search', 'ProductController@productSearch');


//Route::add('/check_login_ajax', 'AuthController@check_login_ajax');
//Route::add('/product/search', 'ProductController@productSearch');

Route::add('/login', 'AuthController@getLogin');
Route::add('/login_post', 'AuthController@postLogin');
Route::add('/register', 'AuthController@getRegister');
Route::add('/register_post', 'AuthController@postRegister');
Route::add('/logout_post', 'AuthController@postLogout');


//Route::add('/product/detail/(\d+)', 'ProductController@productdetail');
//$router->add('/product/list', ['controller' => 'ProductController', 'action' => 'productList']);
//echo "<pre>" . print_r(Route::showroutes()) . "</pre>";
//echo $_GET['url'];
//$uri = isset($_GET['url']) ? "/" . rtrim($_GET['url'], '/') : '/';

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https://";
else
    $url = "http://";
// Append the host(domain name, ip) to the URL.   
$url .= $_SERVER['HTTP_HOST'];
// Append the requested resource location to the URL   
$url .= $_SERVER['REQUEST_URI'];
// Phân tích URL
$urlParts = parse_url($url);


//echo end($urlParts);
//echo $urlParts['path'];
//sử dụng convert ví dụ input là "  http://localhost:8000/product/list " output là "/product/list" 1 string
$uri = isset($_GET['url']) ? "/" . rtrim($_GET['url'], '/') : $urlParts['path'];


Route::dispatch($uri);
