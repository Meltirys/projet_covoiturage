<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// C'est ici que l'on défini les chemins des pages
// Pour en définir une nouvelle il suffit d'écrire comme ceci :
// $routes->méthodehttp(get ou post)('url que l'on souhaite afficher', 'nomducontrolleur::méthode)
// => $route->get('url', 'controller::méthode')

$routes->get('/', 'PagesController::index');

// Authentification
$routes->get('authentification', 'PagesController::login');
$routes->post('connexion', 'AuthController::loginAttempt');
$routes->post('inscription', 'AuthController::registerAttempt');

// Itinéraire
$routes->get('trajet', 'PagesController::itinerary');
$routes->post('trajet-recherche', 'ItineraryController::search');
