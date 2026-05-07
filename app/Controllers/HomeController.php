<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        helper('form');
        return view('HomeView');
    }

}
