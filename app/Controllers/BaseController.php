<?php

namespace App\Controllers;

class BaseController
{
    protected $viewPath = '../app/views/';
    //  protected $layout = 'app/views/layout/default.php';
    public function __construct()
    {
    }
    protected function  convertDotToSlash($string)
    {
        return str_replace('.', '/', $string);
        //Hàm này thay thế tất cả các dấu chấm trong chuỗi $string bằng dấu gạch chéo.
        //str_replace(search, replace, subject);
        //search: Chuỗi con cần tìm để thay thế.
        //replace: Chuỗi con sẽ thay thế chuỗi con search.
        //subject: Chuỗi gốc mà bạn muốn thực hiện việc thay thế.

    }

    protected function view($view, $data = [])
    {
        extract($data);
        $view = self::convertDotToSlash($view);
        //input hiện tại là home.php
        //input mong muốn là nếu là : product.viewController

        $viewFile = $this->viewPath . $view . '.php';
        //../app/views/home.php.php
        if (file_exists($viewFile)) {
            // ob_start();
            include $viewFile;
            // ĐÂY LÀ ĐẦU RA../app/views/home.php.php
        } else {
            die("View file not found: $viewFile");
        }
    }
}
