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

    public function itineraries()
    {
        helper('form');
        return view('commons/header')
            . view('itinerary/search/SearchView')
            . view('commons/footer');
    }

    public function newItinerary()
    {
        helper('form');
        return view('commons/header')
            . view('itinerary/create/CreateView')
            . view('commons/footer');
    }
}
