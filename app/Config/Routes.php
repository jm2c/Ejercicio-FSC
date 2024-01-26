<?php

use App\Controllers\Articulos;
use App\Controllers\Usuarios;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Articulos::class, 'index'], ['as' => 'inicio']);
$routes->get('/admin', [Articulos::class, 'admin'], ['as' => 'dashboard']);
$routes->get('/articulo/editar/(:segment)', [Articulos::class, 'editarArticulo']);
$routes->get('/articulo/(:segment)', [Articulos::class, 'verArticulo']);
$routes->get('/articulo/borrar/(:segment)', [Articulos::class, 'borrarArticulo']);

$routes->get('/listaArticulos', [Articulos::class, 'listaArticulos']);
$routes->get('/listaArticulosPortada', [Articulos::class, 'listaArticulosPortada']);
$routes->post('/articulo/editar/(:segment)', [Articulos::class, 'nuevoArticulo']);
$routes->put('/articulo/editar/(:segment)', [Articulos::class, 'actualizarArticulo']);

$routes->get('/login', [Usuarios::class, 'loginForm'], ['as' => 'loginForm']);
$routes->post('/login', [Usuarios::class, 'login']);
$routes->get('/logout', [Usuarios::class, 'logout'], ['as' => 'logout']);
