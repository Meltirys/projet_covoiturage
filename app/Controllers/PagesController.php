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

    public function itinerary()
    {
        helper('form');
        return view('commons/header')
            . view('itinerary/RouteView')
            . view('commons/footer');
    }
}
