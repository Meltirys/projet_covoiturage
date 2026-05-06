<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'PennRide',
        ];

        return view('templates/header', $data)
            . view('welcome_message')
            . view('templates/footer');
    }
}
