<?php

namespace App\Controllers\Backoffice;

use App\Controllers\BaseController;
use App\Validators\BanUserValidator;

class UserBanController extends BaseController
{
    public function index()
    {
        return view('backoffice/UserBan');
    }

    /**
     * Ban the given user. Access route is /user/ban/{idUser}
     * @param int $idUser The id of the user we want to ban
     */
    public function ban(int $idUser)
    {
        $userModel = model('UserModel');

        $datas['id_user'] = $idUser; //Preparing the datas for the validator
        $validator = new BanUserValidator();

        if (!$validator->validate($datas)) {
            return redirect()->to('banUser')
                ->with('error', $validator->getError('id_user'));
        }

        //Checking if an error happens when banning the user
        if (!$userModel->update(session()->get('user_id'), [
            'is_validated' => false
        ])) {
            return redirect()->to('banUser')
                ->with('error', 'Une erreur est survenue lors du banissement de l\'utilisateur, veuillez réessayer');
        }

        //If no errors
        return redirect()->to('banUser')
            ->with('success', "L'utilisateur " . $userModel->getUserName($idUser) . " a été bannis avec succès");
    }
}
