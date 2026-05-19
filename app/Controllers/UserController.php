<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function index() {}

    /**
     * Delete the user from the data base
     */
    public function delete()
    {
        $idUser = session()->user_id;

        //We delete the car of the user
        $carModel = new CarModel();
        $carModel->where('id_user', $idUser)->delete();

        $userModel = new UserModel();

        if (! $userModel->delete($idUser)) {
            $errors = $userModel->errors();

            return redirect()->to('/myprofil')
                ->with('errors', $errors)
                ->withInput()
                ->with('user_error', 'Une erreur est survenue lors de la suppression du compte');
        }

        //Logging the user out
        $authController = new AuthController();
        $authController->logout();
    }

    public function modify(){
        helper('form');

        $dbUser = model('UserModel');
        $data['user'] = $dbUser->find(session()->user_id);
        return view('profil/modify', $data);
    }
}
