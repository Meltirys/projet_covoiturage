<?php 

namespace App\Controllers;

class AuthController extends BaseController {

    public function index()
    {
        $data = [
            'activeTab' => session()->getFlashdata('activeTab') ?? 'login',
        ];

        return view('AuthView');
    }

    // Pour la connexion et l'inscription futures

    public function login()
    {

    }

    public function register()
    {

    }

}

?>