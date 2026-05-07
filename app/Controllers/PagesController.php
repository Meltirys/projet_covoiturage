<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PagesController extends BaseController
{
    public function index()
    {
        helper('form');
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
