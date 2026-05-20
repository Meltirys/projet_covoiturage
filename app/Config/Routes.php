<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\CarController;
use App\Controllers\UserController;
use App\Controllers\Backoffice\UserValidationController;
use App\Controllers\Journey\DriveController;

use App\Controllers\Journey\RequestController;


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
    $routes->post('signup', 'UserController::saveUser');
});

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('logout', 'AuthController::logout');

    //Profil
    $routes->get('myprofil', 'ProfilController::index');

    //Car
    $routes->post('car/add', 'CarController::add');
    $routes->post('car/delete/(:num)', [CarController::class, 'delete']);
    $routes->post('car/modify/(:num)', [CarController::class, 'modify']);

    //User
    $routes->get('user/modify', [UserController::class, 'modify']);
    $routes->get('user/changePassword', [UserController::class, 'showPasswordChange']);
    $routes->post('user/update', [UserController::class, 'update']);
    $routes->post('user/updatePassword', [UserController::class, 'updatePassword']);
    $routes->post('user/delete', [UserController::class, 'delete']);
});

// Itinéraire (conducteur)
$routes->get('drive/search', 'Journey\DriveController::search');
$routes->get('drive/show', 'Journey\DriveController::show');
$routes->get('drive/create', 'Journey\DriveController::create');
$routes->post('drive/save', 'Journey\DriveController::save');

// Itinéraire (requête)
$routes->get('request/search', 'Journey\RequestController::search');
$routes->get('request/show', 'Journey\RequestController::show');
$routes->get('request/create', 'Journey\RequestController::create');
$routes->post('request/save', 'Journey\RequestController::save');

// Réservation
$routes->get('reservation/(:num)',           'Journey\BookingController::show/$1');
$routes->post('reservation',                 'Journey\BookingController::save');
$routes->get('mes-reservations',             'Journey\BookingController::index');
$routes->post('reservation/annuler/(:num)',  'Journey\BookingController::cancel/$1');
$routes->post('reservation/accepter/(:num)', 'Journey\BookingController::accept/$1');
$routes->post('reservation/refuser/(:num)',  'Journey\BookingController::refuse/$1');


$routes->group('', ['filter' => 'authadmin'], function ($routes) {
    $routes->get('userValidation', [UserValidationController::class, 'validateUser']);
    $routes->post('userValidation/accept/(:num)', [UserValidationController::class, 'acceptUser']);
    $routes->post('userValidation/refuse/(:num)', [UserValidationController::class, 'refuseUser']);
});
