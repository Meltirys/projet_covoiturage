<?php

use App\Controllers\Backoffice\DashboardController;
use App\Controllers\Backoffice\SearchController;
use App\Controllers\Backoffice\UserManagementController;
use App\Controllers\Backoffice\UserSuppressionController;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\CarController;
use App\Controllers\UserController;
use App\Controllers\Backoffice\UserValidationController;
use App\Controllers\Backoffice\UserBanController;
use App\Controllers\Backoffice\UserRoleController;
use App\Controllers\Journey\DriveController;

use App\Controllers\Journey\RequestController;
use App\Controllers\ProfilController;
use App\Services\AjaxRequests;

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
    $routes->get('profil/show/(:num)', [ProfilController::class, 'show']);

    //Car
    $routes->post('car/add', 'CarController::add');
    $routes->post('car/delete/(:num)', [CarController::class, 'delete']);
    $routes->post('car/modify/(:num)', [CarController::class, 'modify']);

    //Profil
    $routes->get('profil/modify', [ProfilController::class, 'modify']);
    $routes->get('profil/changePassword', [ProfilController::class, 'showPasswordChange']);

    //User form routes
    $routes->post('user/update', [UserController::class, 'update']);
    $routes->post('user/updatePassword', [UserController::class, 'updatePassword']);
    $routes->post('user/delete', [UserController::class, 'delete']);


    // Création de trajets
    $routes->get('nouveau-trajet', 'PagesController::createJourney');
    $routes->post('drive/save', 'Journey\DriveController::save'); // conduite
    $routes->post('request/save', 'Journey\RequestController::save'); // requête

    // Recherche de trajets
    $routes->get('trajet', 'PagesController::searchJourney');
    $routes->get('drive/search', 'Journey\DriveController::search'); // conduite
    $routes->get('request/search', 'Journey\RequestController::search'); // requête

    // Affichage de trajet individuel
    $routes->get('drive/show', 'Journey\DriveController::show'); // conduite
    $routes->get('request/show', 'Journey\RequestController::show'); // requête

    // Réservation
    $routes->get('reservation/(:num)',           'Journey\BookingController::show/$1');
    $routes->post('reservation',                 'Journey\BookingController::save');
    $routes->get('mes-reservations',             'Journey\BookingController::index');
    $routes->post('reservation/annuler/(:num)',  'Journey\BookingController::cancel/$1');
    $routes->post('reservation/accepter/(:num)', 'Journey\BookingController::accept/$1');
    $routes->post('reservation/refuser/(:num)',  'Journey\BookingController::refuse/$1');
    $routes->post('reservation/trajet/annuler/(:num)', 'Journey\BookingController::cancelJourney/$1');
});


//Admin part
$routes->group('', ['filter' => 'authadmin'], function ($routes) {

    $routes->get('backoffice', [DashboardController::class, 'index']); //Show dashboard

    $routes->post('userValidation/accept/(:num)', [UserValidationController::class, 'acceptUser']); //Accept an user
    $routes->post('userValidation/refuse/(:num)', [UserValidationController::class, 'refuseUser']); //Refuse an user

    $routes->post('user/delete/(:num)', [UserController::class, 'delete']); //Deleting an user
    $routes->post('user/ban/(:num)', [UserController::class, 'ban']); //Banning an user

    $routes->get('searchUser/(:alpha)', [SearchController::class, 'searchUser']);
});

//Super-admin part
$routes->group('', ['filter' => 'authsuper'], function ($routes) {
    $routes->get('userRole', [UserRoleController::class, 'index']);
    $routes->get('searchUserWP/(:alpha)', [SearchController::class, 'searchUserWithPerm']);
    $routes->get('getAllPermissions', [UserRoleController::class, 'getAllPermissions']);

    $routes->post('user/updateRole/(:num)', [UserRoleController::class, 'updateUserRole']);
});
