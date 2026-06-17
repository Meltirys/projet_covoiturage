<?php

use App\Controllers\Backoffice\DashboardController;
use App\Controllers\Backoffice\SearchController;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\CarController;
use App\Controllers\UserController;
use App\Controllers\Backoffice\UserValidationController;
use App\Controllers\Backoffice\UserRoleController;
use App\Controllers\ProfilController;
use App\Controllers\Debug;
use App\Controllers\ReportController;

/**
 * @var RouteCollection $routes
 */

// C'est ici que l'on défini les chemins des pages
// Pour en définir une nouvelle il suffit d'écrire comme ceci :
// $routes->méthodehttp(get ou post)('url que l'on souhaite afficher', 'nomducontrolleur::méthode)
// => $route->get('url', 'controller::méthode')

$routes->get('/', 'PagesController::home'); // index
$routes->get('/mentions-legales', 'PagesController::mentionsLegales'); // mentions légales
$routes->get('/cgu', 'PagesController::cgu'); // conditions générales d'utilisation
$routes->get('/comment-ca-marche', 'PagesController::howItWorks'); // conseils d'utilisation
$routes->get('/contact-page', 'PagesController::contactPage'); // page de contact

if (ENVIRONMENT === 'production') {
    $routes->set404Override(function () {
        return view('errors/custom_404'); // page 404 custom
    });
}

// Authentification
$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('authentification', 'PagesController::login');
    $routes->post('authentification', 'AuthController::authenticate');
    $routes->post('signup', 'UserController::saveUser');
});

// Section Utilisateur authentifié
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
    $routes->post('user/avatar/update', [UserController::class, 'updateAvatar']);
    $routes->post('user/avatar/delete', [UserController::class, 'deleteAvatar']);

    //User form routes
    $routes->post('user/update', [UserController::class, 'update']);
    $routes->post('user/updatePassword', [UserController::class, 'updatePassword']);
    $routes->post('user/delete', [UserController::class, 'delete']);


    // Création de trajets
    $routes->get('nouveau-trajet', 'PagesController::createJourney');
    $routes->post('drive/save', 'Journey\JourneyDriveController::save'); // conduite
    $routes->post('request/save', 'Journey\JourneyRequestController::save'); // requête
    $routes->get('request/list', 'Journey\JourneyRequestController::index');

    // Modification de trajet conducteur
    $routes->get('trajet/modification/(:num)', 'PagesController::editJourneyDrive/$1');
    $routes->post('drive/edit/(:num)', 'Journey\JourneyDriveController::update/$1');

    // Modification de demande de trajet
    $routes->get('request/edit/(:num)', 'Journey\JourneyRequestController::edit/$1');
    $routes->post('request/update/(:num)', 'Journey\JourneyRequestController::update/$1');
    $routes->post('request/delete/(:num)', 'Journey\JourneyRequestController::delete/$1');

    // Recherche de trajets
    $routes->get('trajet', 'Journey\JourneyDriveController::search'); // conduite
    $routes->get('request/search', 'Journey\JourneyRequestController::search'); // requête

    // Affichage de trajet individuel
    $routes->get('drive/show/(:num)', 'Journey\JourneyDriveController::show/$1'); // conduite
    $routes->get('request/show/(:num)', 'Journey\JourneyRequestController::show/$1'); // requête

    // Réservation
    $routes->get('reservation/(:num)',           'Journey\BookingController::show/$1');
    $routes->post('reservation',                 'Journey\BookingController::save');
    $routes->post('reservation/annuler/(:num)',  'Journey\BookingController::cancel/$1');
    $routes->post('reservation/accepter/(:num)', 'Journey\BookingController::accept/$1');
    $routes->post('reservation/refuser/(:num)',  'Journey\BookingController::refuse/$1');
    $routes->post('reservation/trajet/annuler/(:num)', 'Journey\BookingController::cancelJourney/$1');

    //Report
    $routes->get('report', [ReportController::class, 'showReportView']);
    $routes->post('user/report/(:num)', [ReportController::class, 'report']);
});


// Section Admin
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

// Section Super-Admin
$routes->group('', ['filter' => 'authsuper'], function ($routes) {

    $routes->get('backoffice', [DashboardController::class, 'index']); //Show dashboard

    $routes->get('userRole', [UserRoleController::class, 'index']);
    $routes->get('searchUserWP/(:any)', [SearchController::class, 'searchUserWithPerm']);
    $routes->get('getAllPermissions', [UserRoleController::class, 'getAllPermissions']);

    $routes->post('user/updateRole/(:num)', [UserRoleController::class, 'updateUserRole']);
});
