<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class JuegoController extends BaseController
{
    public function index()
    {
        return view('juego');
    }
}
