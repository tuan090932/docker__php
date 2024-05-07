<?php
require_once '../vendor/autoload.php';

require_once '../config/config.php';

//include_once '../app/Routing/Routes.php';


//include './app/Routing/Routes.php';
//
//require_once là một hàm PHP được sử dụng để tải một file PHP. Nếu file đã được tải trước đó, nó sẽ không tải lại.
//
//echo "ss";

use App\Routing\Route;
// Define routes
//Route::add('/', 'HomeController@index');
//echo "<pre>" . print_r(Route::showroutes()) . "</pre>";

//Route::add('/index', 'HomeController@index');
//echo "<pre>" . print_r(Route::showroutes()) . "</pre>";

Route::add('/product/list', 'ProductController@productList');

Route::add('/product/create', 'ProductController@createProduct');

//Route::add('/product/handle_create', 'ProductController@handle_createProduct');


//Route::add('/handleLogin', 'ProductController@handleLogin');


// i want add edit -> give me route edit
Route::add('/product/view/(\d+)', 'ProductController@handle_viewProduct');
Route::add('/product/delete/(\d+)', 'ProductController@handle_deleteProduct');
Route::add('/product/form_editProduct/(\d+)', 'ProductController@form_editProduct');

Route::add('/product/edit', 'ProductController@handle_edit');




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
// sử dụng convert ví dụ input là "  http://localhost:8000/product/list " output là "/product/list" 1 string


$uri = isset($_GET['url']) ? "/" . rtrim($_GET['url'], '/') : $urlParts['path'];





Route::dispatch($uri);
