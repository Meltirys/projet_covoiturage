<?php

namespace App\Controllers;

use App\Helpers\EmailTemplates;
use App\Services\MailService;

class ContactController extends BaseController
{
    public function send()
    {
        $post = $this->request->getPost();

        // Validation...

        $html = EmailTemplates::contactFormReceived(
            $post['first_name'],
            $post['last_name'],
            $post['email'],
            $post['motif'],
            $post['message']
        );

        try {
            $mailService = new MailService();
            $mailService->send('adresse.admin@greta.fr', 'Nouveau message de contact - PennRide', $html);
        } catch (\Exception $e) {
            log_message('ContactController->send', 'Erreur lors de l\'envoie du mail');
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'envoie du message');
        }


        return redirect()->back()->with('success', 'Ton message a bien été envoyé !');
    }
}
