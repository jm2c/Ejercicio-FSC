<?php

use App\Controllers\Articulos;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Articulos::class, 'index']);
$routes->get('/articulo/(:segment)', [Articulos::class, 'verArticulo']);
$routes->get('/listaArticulosPortada', [Articulos::class, 'listaArticulosPortada']);
