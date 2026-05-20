<?php

namespace App\Controllers;

class BackOfficeController extends BaseController
{
    public function validateUser()
    {
        helper('form');
        $dbUser = model('UserModel');
        $data['users'] = $dbUser->getNonValidatedUsers();
        return view('backoffice/userValidation', $data);
    }

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

    public function refuseUser(int $idUser)
    {
        $dbUser = model('UserModel');

        if (!$dbUser->update($idUser, [
            'is_validated' => false
        ])) {
            return redirect()->back()->with('user_validation_error', "Une erreur est survenue lors du refus de l'utilisateur, veuillez réessayer.");
        }
        return redirect()->back()
            ->with('user_validation_success', $dbUser->getUserName($idUser) . " a bien été refusé.");
    }
}
