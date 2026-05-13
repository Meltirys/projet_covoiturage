<?php

namespace App\Controllers;

use App\Controllers\BaseController;


class ProfilController extends BaseController
{
    public function index()
    {
        helper('form');
        return view('profil/index',[
            'errors' => session('errors') ?? null  //Intercepting the errors of the add car form to prepare them for the view
        ]);
    }

    public function modify(){

    }

    public function update() {
        
    }
}