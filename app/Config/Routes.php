<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// C'est ici que l'on défini les chemins des pages
// Pour en définir une nouvelle il suffit d'écrire comme ceci :
// $routes->méthodehttp(get ou post)('url que l'on souhaite afficher', 'nomducontrolleur::méthode)
// => $route->get('url', 'controller::méthode')

$routes->get('/', 'PagesController::home');

// Authentification
$routes->get('authentification', 'PagesController::login');
$routes->post('logout', 'AuthController::logout');
$routes->post('authentification', 'AuthController::authenticate');
$routes->post('signup', 'AuthController::saveUser');

// Itinéraire
$routes->get('trajet', 'PagesController::itineraries');
$routes->post('trajet-recherche', 'ItineraryController::search');
$routes->get('nouveau-trajet', 'PagesController::newItinerary');
