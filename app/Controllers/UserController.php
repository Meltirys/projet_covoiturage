<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;
use App\Validators\ChangePasswordValidator;

class UserController extends BaseController
{
    public function index() {}

    /**
     * Delete the user from the data base. Access route is /user/delete
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

    public function modify()
    {
        helper('form');

        $dbUser = model('UserModel');
        $data['user'] = $dbUser->find(session()->user_id);
        return view('profil/modify', $data);
    }

    /*
    * Shows the page where the password can be changed. Access route is /user/changePassword
    */
    public function showPasswordChange()
    {
        helper('form');

        return view('profil/changePassword');
    }

    /**
     * Update the password of the connected user. Access route is /user/updatePassword
     */
    public function updatePassword()
    {
        helper('form');

        $password = [
            'old_password' => $this->request->getPost('old_password'),
            'password' => $this->request->getPost('password'),
            'password_conf' => $this->request->getPost('password_conf')
        ];

        $validator = new ChangePasswordValidator();

        if (!$validator->validate($password)) {
            return view('profil/changePassword', [
                'errors' => $validator->getErrors()
            ]);
        }

        $userModel = new UserModel();

        //Checking if an error happens when saving the new password
        if(!$userModel->update(session()->get('user_id'), [
            'password' => $password['password']
        ])){
            return redirect()->to('profil/changePassword')
                    ->with('password_error', 'Une erreur est survenue lors de la modification, veuillez réessayer');
        }

        //If no errors
        return redirect()->to('profil/changePassword')
                     ->with('password_success', 'Mot de passe modifié avec succès.');
    }
}
