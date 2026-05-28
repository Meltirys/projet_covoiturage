<?php

namespace App\Controllers\Backoffice;

use App\Controllers\BaseController;
use App\Validators\BanUserValidator;

class UserBanController extends BaseController
{

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
            return redirect()->to('/backoffice')
                ->with('ban_error', $validator->getError('id_user'));
        }

        //Checking if an error happens when banning the user
        if (!$userModel->update($idUser, [
            'is_validated' => 0
        ])) {
            return redirect()->to('/backoffice')
                ->with('ban_error', 'Une erreur est survenue lors du banissement de l\'utilisateur, veuillez réessayer');
        }

        //If no errors
        return redirect()->to('/backoffice')
            ->with('ban_success', "L'utilisateur " . $userModel->getUserName($idUser) . " a été bannis avec succès");
    }
}
