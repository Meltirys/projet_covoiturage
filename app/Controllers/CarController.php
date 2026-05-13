<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Validators\CarValidator;


class CarController extends BaseController
{

    public function add() {
        helper('form');
        $car = [
            'brand'   => $this->request->getPost('brand'),
            'model'    => $this->request->getPost('model'),
            'color'        => $this->request->getPost('color'),
            'year'     => $this->request->getPost('year'),
            'number_of_seat' => $this->request->getPost('places'),
        ];

        $validator = new CarValidator();

        if(!$validator->validate($car)){
            return redirect()->to('/myprofil')
                 ->with('error_in_car_form', true)
                 ->withInput()
                 ->with('errors', $validator->getErrors());
        }

        echo 'test';
    }

    public function update() {}
}
