<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Articulos extends BaseController
{
    public function index()
    {
        return view('layout/header')
             . view('inicio')
             . view('layout/footer');
    }
}
