<?php

//namespace App\Router;

namespace App\Routing;
// config router
class Route
{
    private static $routes = [];

    public static function showroutes()
    {
        return self::$routes;
        // 1 mãng này chứa các 1 object {uri :value , controller :value }
        // Hàm preg_match sẽ thực hiện so khớp biểu thức chính quy (được cung cấp bởi $route['uri']) với chuỗi $uri.
        // Nếu có sự khớp, preg_match sẽ gán các phần khớp vào mảng $matches và trả về số lượng các phần khớp
        //
        //
        //php -S localhost:8000  

    }
    public static function add($uri, $controller)
    {
        $uri = "#^" . $uri . "$#";
        self::$routes[] = ['uri' => $uri, 'controller' => $controller];
    }

    public static function dispatch($uri)
    {
        foreach (self::$routes as $route) {
            //echo $route['uri'] . " <> " . $uri . "</br>";
            if (preg_match($route['uri'], $uri, $matches)) {
                if (count($matches) > 0) {
                    //echo $route['controller'] đáp án là HomeController@index
                    list($controller, $method) = explode('@', $route['controller']);
                    //echo $method; -> lưu cái method-> là index
                    //echo $controller; đầu ra là HomeController
                    $controllerClass = 'App\Controllers\\' . $controller;
                    $controllerInstance = new $controllerClass();
                    $controllerInstance->$method();

                    return;
                }
            }
        }
        echo '404 Not Found';
    }
}
