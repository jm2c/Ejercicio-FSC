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

    public function admin()
    {
        return view('layout/header')
             . view('adminView')
             . view('layout/footer');
    }

    public function listaArticulos()
    {
        $articulos = $this->articulo->select(['id', 'titulo'])->findAll();
        return json_encode($articulos);
    }

    public function listaArticulosPortada()
    {
        $articulosPortada = $this->articulo->select(['id', 'titulo', 'imagen_previa', 'sintesis'])
                          ->orderBy('fecha_de_creacion', 'desc')->findAll(6);

        return json_encode($articulosPortada);
    }
}
