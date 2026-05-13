<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\CarController;

/**
 * @var RouteCollection $routes
 */

// C'est ici que l'on défini les chemins des pages
// Pour en définir une nouvelle il suffit d'écrire comme ceci :
// $routes->méthodehttp(get ou post)('url que l'on souhaite afficher', 'nomducontrolleur::méthode)
// => $route->get('url', 'controller::méthode')

$routes->get('/', 'PagesController::home');

// Authentification
$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('authentification', 'PagesController::login');
    $routes->post('authentification', 'AuthController::authenticate');
    $routes->post('signup', 'AuthController::saveUser');
});

$routes->group('', ['filter' => 'auth'], function($routes){
    $routes->get('logout', 'AuthController::logout');

    //Profil
    $routes->get('myprofil', 'ProfilController::index');
    $routes->post('car/add', 'CarController::add');
    $routes->post('car/delete/(:num)', [CarController::class, 'delete']);
});





// Itinéraire
$routes->get('trajet', 'PagesController::itineraries');
$routes->post('trajet-recherche', 'ItineraryController::search');
$routes->get('nouveau-trajet', 'PagesController::newItinerary');
