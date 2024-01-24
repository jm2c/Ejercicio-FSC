<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ArticuloModel;

class Articulos extends BaseController
{
    private $articulo;

    public function __construct()
    {
        $this->articulo = new ArticuloModel();
    }

    public function index()
    {
        return view('layout/header')
             . view('inicio')
             . view('layout/footer');
    }

    public function verArticulo($id)
    {
        $data = $this->articulo->find($id);
        return view('layout/header', $data)
             . view('articulo')
             . view('layout/footer');
    }

    public function listaArticulosPortada()
    {
        $articulosPortada = $this->articulo->select(['id', 'titulo', 'imagen_previa', 'sintesis'])
                          ->orderBy('fecha_de_creacion', 'desc')->limit(6)->find();

        return json_encode($articulosPortada);
    }
}
