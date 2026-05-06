<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\News;
use App\Controllers\Pages;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
