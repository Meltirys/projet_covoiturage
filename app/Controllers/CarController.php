<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;
use App\Validators\CarValidator;


class CarController extends BaseController
{

    public function add()
    {
        helper('form');
        $car = [
            'brand'   => $this->request->getPost('brand'),
            'model'    => $this->request->getPost('model'),
            'color'        => $this->request->getPost('color'),
            'year'     => $this->request->getPost('year'),
            'number_of_seat' => $this->request->getPost('places'),
        ];

        //Calling the specific validator
        $validator = new CarValidator();

        //If an error is detected, we redirect the errors to the profil controller
        if (!$validator->validate($car)) {
            return redirect()->to('/myprofil')
                ->with('error_in_car_form', true) //This variable is meant to tell the view that it needs to show the form to add a car on load
                ->withInput()
                ->with('errors', $validator->getErrors()); //We transfer the errors so the view can display it
        }

        $carModel = new CarModel();
        
        //Adding the user id for the database request
        $car['id_user'] = session()->user_id;

        /* 
         * Tries to save a new car. 
         * If there were errors, returns to view with them in the following format :
         * [ 'field1' => 'error message', 'field2' => 'error message', ]
         */
        if (! $carModel->save($car)) {
            $errors = $carModel->errors();

            return redirect()->to('/myprofil')
                ->with('errors', $errors)
                ->withInput()
                ->with('car_not_added', 'Une erreur est survenue lors de l\'ajout du véhicule');
        }

        return redirect()->to('/myprofil')
            ->with('car_added', 'Votre véhicule à bien été ajouté');
    }

    public function update() {}
}
