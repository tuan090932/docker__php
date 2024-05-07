<?php

namespace App\Controllers;

class BaseController
{
    protected $viewPath = 'app/views/';
    protected $layout = 'app/views/layout/default.php';

    public function __construct()
    {
        // Bạn có thể thêm các logic chung cho tất cả các controllers ở đây
    }

    protected function view($view, $data = [])
    {
        extract($data);
        $viewFile = $this->viewPath . $view . '.php';

        if (file_exists($viewFile)) {
            ob_start();
            include $viewFile;
            $content = ob_get_clean();
            include $this->layout;
        } else {
            die("View file not found: $viewFile");
        }
    }
}
