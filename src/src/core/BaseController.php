<?php

namespace App\core;

class BaseController
{
    public function __construct()
    {
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Origin: " . base_url());
        header("Access-Control-Allow-Methods: " . request_method());
        header("Access-Control-Allow-Headers: Access");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }
}



