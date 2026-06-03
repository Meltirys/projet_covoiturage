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
use App\Controllers\Debug;
use App\Controllers\ReportController;
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
    $routes->get('request/list', 'Journey\RequestController::index');

    // Modification de demande de trajet
    $routes->get('request/edit/(:num)', 'Journey\RequestController::edit/$1');
    $routes->post('request/update/(:num)', 'Journey\RequestController::update/$1');
    $routes->post('request/delete/(:num)', 'Journey\RequestController::delete/$1');

    // Recherche de trajets
    $routes->get('trajet', 'PagesController::searchJourney');
    $routes->get('drive/search', 'Journey\DriveController::search'); // conduite
    $routes->get('request/search', 'Journey\RequestController::search'); // requête

    // Affichage de trajet individuel
    $routes->get('drive/show/(:num)', 'Journey\DriveController::show/$1'); // conduite
    $routes->get('request/show/(:num)', 'Journey\RequestController::show/$1'); // requête

    // Réservation
    $routes->get('reservation/(:num)',           'Journey\BookingController::show/$1');
    $routes->post('reservation',                 'Journey\BookingController::save');
    $routes->get('mes-reservations',             'Journey\BookingController::index');
    $routes->post('reservation/annuler/(:num)',  'Journey\BookingController::cancel/$1');
    $routes->post('reservation/accepter/(:num)', 'Journey\BookingController::accept/$1');
    $routes->post('reservation/refuser/(:num)',  'Journey\BookingController::refuse/$1');
    $routes->post('reservation/trajet/annuler/(:num)', 'Journey\BookingController::cancelJourney/$1');

    //Report
    $routes->get('report', [ReportController::class, 'showReportView']);
    $routes->post('user/report/(:num)', [ReportController::class, 'report']);
});


//Admin part
$routes->group('', ['filter' => 'authadmin'], function ($routes) {

    $routes->get('backoffice', [DashboardController::class, 'index']); //Show dashboard

    $routes->post('userValidation/accept/(:num)', [UserValidationController::class, 'acceptUser']); //Accept an user
    $routes->post('userValidation/refuse/(:num)', [UserValidationController::class, 'refuseUser']); //Refuse an user

    $routes->post('user/delete/(:num)', [UserController::class, 'delete']); //Deleting an user
    $routes->post('user/ban/(:num)', [UserController::class, 'ban']); //Banning an user

    $routes->post('report/solve/(:num)', [ReportController::class, 'solve']);

    $routes->get('searchUser/(:any)', [SearchController::class, 'searchUser']);
    $routes->get('debug', [Debug::class, 'debug']);
});

//Super-admin part
$routes->group('', ['filter' => 'authsuper'], function ($routes) {

    $routes->get('backoffice', [DashboardController::class, 'index']); //Show dashboard

    $routes->get('userRole', [UserRoleController::class, 'index']);
    $routes->get('searchUserWP/(:any)', [SearchController::class, 'searchUserWithPerm']);
    $routes->get('getAllPermissions', [UserRoleController::class, 'getAllPermissions']);

    $routes->post('user/updateRole/(:num)', [UserRoleController::class, 'updateUserRole']);
});
