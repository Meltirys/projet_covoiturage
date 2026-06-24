<?php

namespace App\Controllers;

use App\Helpers\EmailTemplates;
use App\Services\MailService;
use App\Validators\ContactFormValidator;

class ContactController extends BaseController
{
    /**
     * Sends a mail filled with the informations of the contact form to the default mail address
     */
    public function send()
    {
        helper('form');
        helper('mail_helper');

        $post = $this->request->getPost();

        //Validation
        $contactValidator = new ContactFormValidator();

        if (!$contactValidator->validate($post)) {
            return redirect()->back()
                ->with('errors', $contactValidator->getErrors())
                ->withInput()
                ->with('contact_error', true);
        }

        //Creating the template
        $html = EmailTemplates::contactFormReceived(
            $post['first_name_contact'],
            $post['last_name_contact'],
            $post['email_contact'],
            $post['motif'],
            $post['message']
        );

        //Send the mail
        try {
            $mailService = new MailService();
            $mailService->send($mailService->getMailer()->Username, 'Nouveau message de contact - PennRide', $html);
        } catch (\Exception $e) {
            log_message('ContactController->send', 'Erreur lors de l\'envoie du mail');
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'envoie du message');
        }

        return redirect()->back()->with('success', 'Ton message a bien été envoyé !');
    }
}
