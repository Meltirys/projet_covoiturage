<?php

namespace App\Controllers;

use App\Controllers\BaseController;


class ProfilController extends BaseController
{
    public function index()
    {
        helper('form');
        return view('profil/index');
    }

    public function modify(){

    }

    public function update() {
        
    }
}