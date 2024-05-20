<?php

//namespace App\Router;

namespace App\Routing;
// config router
class Route
{
    private static $routes = [];
    //Biến static có phạm vi toàn cục trong lớp
    public static function showroutes()
    {
        return self::$routes;
        // 1 mãng này chứa các 1 object {uri :value , controller :value }
        // Hàm preg_match sẽ thực hiện so khớp biểu thức chính quy (được cung cấp bởi $route['uri']) với chuỗi $uri.
        // Nếu có sự khớp, preg_match sẽ gán các phần khớp vào mảng $matches và trả về số lượng các phần khớp
        //php -S localhost:8000  

    }
    public static function add($uri, $controller)
    {
        $uri = "#^" . $uri . "$#";
        self::$routes[] = ['uri' => $uri, 'controller' => $controller];
    }

    public static function dispatch($uri)
    {

        // ví dụ input tại url là :http://localhost/home
        // output sẽ là home -> do xử lý trước khi đi vô function dispatch


        // nhận vào 1 url từ client  request tới 
        //var_dump($uri);
        //exit;

        echo "<pre>";
        var_dump(self::$routes);
        exit;
        // print_r(self::$routes);
        // exit;

        foreach (self::$routes as $route) {
            //echo $route['uri'] . " <> " . $uri . "</br>";
            if (preg_match($route['uri'], $uri, $matches)) {
                if (count($matches) > 0) {
                    //echo $route['controller'] đáp án là HomeController@index
                    list($controller, $method) = explode('@', $route['controller']);
                    //echo $method; -> lưu cái method-> là index
                    //echo $controller; đầu ra là HomeController
                    $controllerClass = 'App\Controllers\\' . $controller; // dấu \\ chỉ ra phạm vi của namespace
                    $controllerInstance = new $controllerClass();
                    $controllerInstance->$method();



                    // method là tên hàm


                    //giả sử 
                    // Giả sử $controller = 'HomeController' và $method = 'index'.
                    // Dòng code $controllerClass = 'App\Controllers\\' . $controller; sẽ tạo ra chuỗi 'App\Controllers\HomeController'.
                    // Dòng $controllerInstance = new $controllerClass(); sẽ tạo một đối tượng của lớp App\Controllers\HomeController.
                    // method()= index()
                    // Dòng $controllerInstance->$method(); sẽ gọi phương thức index trên đối tượng của lớp HomeController.



                    //input:http://localhost/home
                    //output object(App\Controllers\HomeController)#2 (1) { ["viewPath":protected]=> string(13) "../app/views/" }
                    //var_dump($controllerInstance);
                    // exit;

                    return;
                }
            }
        }
        echo '404 Not Found';
    }
}
