<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PagesController extends BaseController
{
    public function index()
    {
        return view('HomeView');
    }

    public function login()
    {
        return view('AuthView');
    }

    public function itinerary()
    {
        return view('RouteView');
    }
}
