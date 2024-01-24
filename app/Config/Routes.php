<?php

use App\Controllers\Articulos;
use App\Controllers\Usuarios;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Articulos::class, 'index'], ['as' => 'inicio']);
$routes->get('/articulo/(:segment)', [Articulos::class, 'verArticulo']);
$routes->get('/admin', [Articulos::class, 'admin'], ['as' => 'dashboard']);
$routes->get('/listaArticulos', [Articulos::class, 'listaArticulos']);
$routes->get('/listaArticulosPortada', [Articulos::class, 'listaArticulosPortada']);

$routes->get('/login', [Usuarios::class, 'loginForm'], ['as' => 'loginForm']);
$routes->post('/login', [Usuarios::class, 'login']);
$routes->get('/logout', [Usuarios::class, 'logout'], ['as' => 'logout']);
