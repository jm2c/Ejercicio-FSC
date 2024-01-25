<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ArticuloModel;

class Articulos extends BaseController
{
    private $articulo;
    private $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->articulo = new ArticuloModel();
    }

    private function isLogged() {
        return isset($this->session->logged);
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
        if(!$this->isLogged())
            return redirect('loginForm');

        return view('layout/header')
             . view('adminView')
             . view('layout/footer');
    }

    public function editarArticulo($segmento = '') {
        if(!$this->isLogged())
            return redirect('loginForm');

        helper('form');
        $articulo = $this->articulo->find($segmento);
        $data = [];

        if(!is_null($articulo))
        {
            // El articulo existe y se va a actualizar
            $data = $articulo;
            $data['nuevo'] = false;
        }
        else
        {
            // El articulo es nuevo
            $data['nuevo'] = true;
        }
        return view('layout/header', $data)
             . view('editarArticuloForm')
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

    public function nuevoArticulo($json) {
        if(!$this->isLogged())
            return redirect('loginForm');

        $request = \Config\Services::request();
        $post = $request->getPost();
        $nuevo = [
            'titulo'         => $post['titulo'],
            'palabras_clave' => $post['palabrasClave'],
            'edad_minima'    => $post['edadMinima'],
            'edad_maxima'    => $post['edadMaxima'],
            'imagen_portada' => 'https://picsum.photos/800/100',
            'imagen_previa'  => 'https://picsum.photos/150',
            'sintesis'       => $post['sintesis'],
            'contenido'      => $post['contenido']
        ];
        $this->articulo->table('articulos')->insert($nuevo);
    }

    public function actualizarArticulo($json) {

    }

    public function borrarArticulo($id)
    {
        if(!$this->isLogged())
            return "Not allowed";

        $this->articulo->delete($id);
        return redirect('dashboard');
    }
}
