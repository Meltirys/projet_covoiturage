<?php

namespace App\Controllers;

use App\Helpers\EmailTemplates;
use App\Services\MailService;
use App\Validators\ContactFormValidator;

class ContactController extends BaseController
{
    public function send()
    {
        helper('form');
        helper('mail_helper');

        $post = $this->request->getPost();

        $contactValidator = new ContactFormValidator();

        if (!$contactValidator->validate($post)) {
            return redirect()->back()
                ->with('errors', $contactValidator->getErrors())
                ->withInput()
                ->with('contact_error', true);
        }

        $html = EmailTemplates::contactFormReceived(
            $post['first_name_contact'],
            $post['last_name_contact'],
            $post['email_contact'],
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
