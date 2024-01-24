<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ArticuloModel;

class Articulos extends BaseController
{
    public function index()
    {
        return view('layout/header')
             . view('inicio')
             . view('layout/footer');
    }

    public function listaArticulosPortada()
    {
        $articulo = new ArticuloModel();

        $articulosPortada = $articulo->select(['id', 'titulo', 'imagen_previa', 'sintesis'])
                          ->orderBy('fecha_de_creacion', 'desc')->limit(6)->find();

        return json_encode($articulosPortada);
    }
}
