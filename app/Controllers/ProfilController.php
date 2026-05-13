<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;


class ProfilController extends BaseController
{
    public function index()
    {
        helper('form');

        //Loading the cars of the user
        $carModel = new CarModel();
        $cars = $carModel->getCarsByUser(session()->user_id);

        return view('profil/index',[
            'cars' => $cars,
            'errors' => session('errors') ?? null  //Intercepting the errors of the add car form to prepare them for the view
        ]);
    }

    public function modify(){

    }

    public function update() {
        
    }
}