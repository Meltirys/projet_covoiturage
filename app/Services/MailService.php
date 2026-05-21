<?php

namespace App\Services;

use Config\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    private PHPMailer $mailer;

    public function __construct()
    {
        $config = config(Mail::class);

        $this->mailer = new PHPMailer(true);

        // Configuration SMTP
        $this->mailer->isSMTP();
        $this->mailer->Host       = $config->host;
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = $config->username;
        $this->mailer->Password   = $config->password;
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port       = $config->port;

        // Expéditeur par défaut
        $this->mailer->setFrom($config->from, $config->fromName);

        // Encodage
        $this->mailer->CharSet = 'UTF-8';
    }

    /**
     * @param string $to The email address that the message will be sent to
     * @param string $subject The subject of the mail
     * @param string $body What the email contains, can be html or plain text
     * 
     * @return bool True if the mail is sent, false otherwise.
     */
    public function send(string $to, string $subject, string $body): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->isHTML(true);
            $this->mailer->Body = $body;

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            log_message('error', 'Erreur envoi mail : ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send a welcome message to a user.
     * @param string $to The email address that the message will be sent to
     * @param string $first_name The first name of the user the mail will be sent
     * 
     * @return bool True if the mail is sent, false otherwise.
     */
    public function sendWelcome(string $to, string $first_name): bool
    {
        $body = view('emails/welcome', [
            'first_name' => $first_name
        ]);

        return $this->send($to, 'Bienvenue sur notre application !', $body);
    }

    /**
     * Send a message that a booking request has been made
     * @param string $to The email address that the message will be sent to
     * @param array $data The informations needed for the mail
     * 
     * @return bool True if the mail is sent, false otherwise.
     */
    public function sendBookingRequest(string $to, array $data): bool
    {
        $body = view('emails/BookingRequest', $data);
        return $this->send($to, 'Nouvelle demande de réservation', $body);
    }

    /**
     * Send a message that a booking request has been refused
     * @param string $to The email address that the message will be sent to
     * @param array $data The informations needed for the mail
     * 
     * @return bool True if the mail is sent, false otherwise.
     */
    public function sendBookingRefused(string $to, array $data): bool
    {
        $body = view('emails/BookingRefused', $data);
        return $this->send($to, 'Votre réservation a été refusée', $body);
    }

    /**
     * Send a message that a booking request has been accepted
     * @param string $to The email address that the message will be sent to
     * @param array $data The informations needed for the mail
     * 
     * @return bool True if the mail is sent, false otherwise.
     */
    public function sendBookingAccepted(string $to, array $data): bool
    {
        $body = view('emails/BookingAccepted', $data);
        return $this->send($to, 'Votre réservation a été acceptée !', $body);
    }
}
