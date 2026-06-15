<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;
use App\Validators\CarValidator;
use CodeIgniter\Exceptions\PageNotFoundException;

class CarController extends BaseController
{

    /**
     * Adds a car in the database, based on the post values. Access route is /car/add
     */
    public function add()
    {
        helper('form');
        $car = [
            'brand'          => $this->request->getPost('brand'),
            'model'          => $this->request->getPost('model'),
            'color'          => $this->request->getPost('color'),
            'year'           => $this->request->getPost('year'),
            'number_of_seat' => $this->request->getPost('places'),
        ];

        //Calling the specific validator
        $validator = new CarValidator();

        //If an error is detected, we redirect the errors to the profil controller
        if (!$validator->validate($car)) {
            return redirect()->to('/myprofil')
                ->with('error_in_add_car_form', true) //This variable is meant to tell the view that it needs to show the form to add a car on load
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
        if (!$carModel->save($car)) {
            $errors = $carModel->errors();

            return redirect()->to('/myprofil')
                ->with('errors', $errors)
                ->withInput()
                ->with('car_error', 'Une erreur est survenue lors de l\'ajout du véhicule');
        }

        return redirect()->to('/myprofil')
            ->with('car_success', 'Votre véhicule à bien été ajouté');
    }

    public function update() {}

    /**
     * Delete the given car from the database. Access route is /car/delete/{id}
     * @param int $idCar The id of the car we want to delete
     */
    public function delete(int $idCar)
    {

        $carModel = new CarModel();
        $isOwner = session()->user_id == $carModel->find($idCar)['id_user']; //Check if the user is the owner


        //If the user is not the owner, we redirect him
        if (!$isOwner) {
            throw PageNotFoundException::forPageNotFound();
        }

        //Chcking if the car is used on future journey
        $journeyDriveModel = model('JourneyDriveModel');

        if ($journeyDriveModel->futureJourneyByCar($idCar)) {
            return redirect()->to('/myprofil')
                ->with('car_error', 'Impossible de supprimer une voiture si elle est utilisé dans un futur trajet. Veuillez modifier ou supprimer les trajets avant de supprimer la voiture');
        }

        if (! $carModel->delete($idCar)) {
            $errors = $carModel->errors();

            return redirect()->to('/myprofil')
                ->with('errors', $errors)
                ->withInput()
                ->with('car_error', 'Une erreur est survenue lors de la suppression du véhicule');
        }

        return redirect()->to('/myprofil')
            ->with('car_success', 'Votre véhicule à bien été supprimé');
    }

    public function modify(int $idCar)
    {

        $carModel = new CarModel();
        $isOwner = session()->user_id == $carModel->find($idCar)['id_user']; //Check if the user is the owner

        //If the user is not the owner, we redirect him
        if (!$isOwner) {
            throw PageNotFoundException::forPageNotFound();
        }

        $car = [
            'id_car'         => $idCar,
            'brand'          => $this->request->getPost('brand'),
            'model'          => $this->request->getPost('model'),
            'color'          => $this->request->getPost('color'),
            'year'           => $this->request->getPost('year'),
            'number_of_seat' => $this->request->getPost('places'),
        ];

        //Calling the specific validator
        $validator = new CarValidator($idCar);

        //If an error is detected, we redirect the errors to the profil controller
        if (!$validator->validate($car)) {
            return redirect()->to('/myprofil')
                ->with('error_in_modify_car_form', true) //This variable is meant to tell the view that it needs to show the form to modify a car on load
                ->withInput()
                ->with('errors', $validator->getErrors()) //We transfer the errors so the view can display it
                ->with('idCar', $idCar); //Transfering the id of the car so the form can point to the correct car
        }

        //Adding the user id for the database request
        $car['id_user'] = session()->user_id;

        if (! $carModel->update($idCar,  $car)) {
            $errors = $carModel->errors();

            return redirect()->to('/myprofil')
                ->with('errors', $errors)
                ->withInput()
                ->with('car_error', 'Une erreur est survenue lors de la modification du véhicule');
        }

        return redirect()->to('/myprofil')
            ->with('car_success', 'Votre véhicule à bien été modifié');
    }
}
