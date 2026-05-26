<?php

namespace App\Controllers\Backoffice;

use App\Controllers\BaseController;

class UserValidationController extends BaseController
{
    public function index()
    {
        helper('form');
        $dbUser = model('UserModel');
        $data['users'] = $dbUser->getNonValidatedUsers();
        return view('backoffice/userValidation', $data);
    }

    /**
     * Grant a user the access to the application. Access route /userValidation/accept/{idUser}.
     * @param int $idUser The id of the user whom we want to grant access
     * 
     */
    public function acceptUser(int $idUser)
    {
        $dbUser = model('UserModel');

        if (!$dbUser->update($idUser, [
            'is_validated' => true
        ])) {
            return redirect()->back()
                ->with('user_validation_error', "Une erreur est survenue lors de l'acceptation de l'utilisateur, veuillez réessayer.");
        }

        return redirect()->back()
            ->with('user_validation_success', $dbUser->getUserName($idUser) . " a bien été accepté.");;
    }

    /**
     * Refuses a user the access to the application. Access route /userValidation/refuse/{idUser}.
     * @param int $idUser The id of the user whom we want to restrain access
     * 
     */
    public function refuseUser(int $idUser)
    {
        $dbUser = model('UserModel');

        if (!$dbUser->update($idUser, [
            'is_validated' => false
        ])) {
            return redirect()->back()
            ->with('user_validation_error', "Une erreur est survenue lors du refus de l'utilisateur, veuillez réessayer.");
        }
        return redirect()->back()
            ->with('user_validation_success', "Le refus de " . $dbUser->getUserName($idUser) . " a bien été pris en compte.");
    }
}
