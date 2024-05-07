<?php

namespace App\Traits;

trait Loggable
{
    public function log($message)
    {
        // Logic to write log
        echo "Log: " . $message;
    }
}
