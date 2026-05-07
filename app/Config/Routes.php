<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// C'est ici que l'on défini les chemins des pages
// Pour en définir une nouvelle il suffit d'écrire comme ceci :
// $routes->méthodehttp(get ou post)('url que l'on souhaite afficher', 'nomducontrolleur::méthode)
// => $route->get('url', 'controller::méthode')

$routes->get('/', 'HomeController::index');

$routes->get('/authentification', 'AuthController::index');

$routes->get('/trajet', 'ItineraryController::index');

$routes->post('/auth/connexion', 'AuthController::login');

$routes->post('/auth/inscription', 'AuthController::register');
