<?php

namespace App\Controllers\Backoffice;

use App\Controllers\BaseController;
use App\Helpers\EmailTemplates;
use App\Services\MailService;


class UserValidationController extends BaseController
{

    /**
     * Grant a user the access to the application. Access route /userValidation/accept/{idUser}.
     * @param int $idUser The id of the user whom we want to grant access
     * 
     */
    public function acceptUser(int $idUser)
    {
        $dbUser = model('UserModel');
        $userInfos = $dbUser->find($idUser);

        if (!$dbUser->update($idUser, [
            'is_validated' => true
        ])) {
            return redirect()->to('/backoffice')
                ->with('user_validation_error', "Une erreur est survenue lors de l'acceptation de l'utilisateur, veuillez réessayer.")
                ->with('active_subtab', 'subtab-validation')
                ->with('active_tab', 'tab-utilisateurs');
        }

        //Sending the mail
        try {
            //Creating MailService object to be able to send the mail
            $mailService = new MailService();
            helper('mail_helper');

            //Sending the welcome mail
            $mailService->send(
                $userInfos['email'],
                'Votre compte à été accepté chez les PennRiders',
                EmailTemplates::accountValidated($userInfos['first_name'])
            );
        } catch (\Exception $e) {
            log_message('error', 'Email de bienvenue non envoyé pour : ' . $userInfos['email'] . '. ' . $e->getMessage());
        }

        return redirect()->to('/backoffice')
            ->with('active_tab', 'tab-utilisateurs')
            ->with('active_subtab', 'subtab-validation')
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
            return redirect()->to('/backoffice')
                ->with('active_tab', 'tab-utilisateurs')
                ->with('active_subtab', 'subtab-validation')
                ->with('user_validation_error', "Une erreur est survenue lors du refus de l'utilisateur, veuillez réessayer.");
        }
        return redirect()->to('/backoffice')
            ->with('active_tab', 'tab-utilisateurs')
            ->with('active_subtab', 'subtab-validation')
            ->with('user_validation_success', "Le refus de " . $dbUser->getUserName($idUser) . " a bien été pris en compte.");
    }
}
