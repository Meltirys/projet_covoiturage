<?php

namespace App\Helpers;

/**
 * Générateur de templates HTML pour les emails PennRide (PHPMailer)
 *
 * Usage :
 *   $html = EmailTemplates::accountCreated($firstName);
 *   $mail->isHTML(true);
 *   $mail->Body = $html;
 */
class EmailTemplates
{
    // ===== Couleurs (cohérentes avec la palette PennRide) =====
    private const OCEAN      = '#0D3B5E';
    private const OCEAN_MID  = '#123E63';
    private const GOLD       = '#DAAF50';
    private const GOLD_LIGHT = '#F0C878';
    private const SAND       = '#F5EFE0';
    private const GREY       = '#6B6358';
    private const RED        = '#C0392B';
    private const GREEN      = '#2E8B57';

    private const LOGO_URL = '/img/logo_golden.png'; // à adapter
    private const SITE_URL = 'http://localhost:8080'; // TODO: Modify when uploading the application

    /**
     * Squelette HTML commun à tous les emails.
     *
     * @param string $eyebrow   Petit texte au-dessus du titre (ex: "Bienvenue")
     * @param string $title     Titre principal (peut contenir <em> pour la partie dorée)
     * @param string $body      Corps du message (HTML autorisé, déjà dans des <p>)
     * @param ?array $button    ['label' => '...', 'url' => '...'] ou null
     * @param string $accentColor Couleur d'accent pour la bordure du titre (gold par défaut)
     */
    private static function layout(
        string $eyebrow,
        string $title,
        string $body,
        ?array $button = null,
        string $accentColor = self::GOLD
    ): string {
        $buttonHtml = '';
        if ($button !== null) {
            $buttonHtml = '
            <tr>
                <td align="center" style="padding: 8px 40px 36px 40px;">
                    <a href="' . htmlspecialchars($button['url']) . '"
                       style="display:inline-block; background-color:' . self::GOLD . '; color:' . self::OCEAN . ';
                              font-family:Arial, sans-serif; font-size:13px; font-weight:bold;
                              letter-spacing:1px; text-transform:uppercase; text-decoration:none;
                              padding:14px 32px; border-radius:30px;">
                        ' . htmlspecialchars($button['label']) . '
                    </a>
                </td>
            </tr>';
        }

        return '<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PennRide</title>
</head>
<body style="margin:0; padding:0; background-color:#F0EDE8; font-family: Arial, Helvetica, sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F0EDE8; padding: 32px 16px;">
<tr>
<td align="center">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:520px; background-color:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(13,59,94,0.08);">

    <!-- Header -->
    <tr>
        <td style="background-color:' . self::OCEAN . '; padding:28px 40px 24px 40px;" align="left">
            <img src="' . self::LOGO_URL . '" width="40" height="40" alt="PennRide" style="display:block; border-radius:10px; margin-bottom:16px;">
            <p style="margin:0 0 6px 0; font-family:Arial, sans-serif; font-size:10px; letter-spacing:2.5px; text-transform:uppercase; color:rgba(255,255,255,0.45);">
                ' . htmlspecialchars($eyebrow) . '
            </p>
            <h1 style="margin:0; font-family: Georgia, \'Times New Roman\', serif; font-size:26px; font-weight:normal; color:#ffffff; line-height:1.25;">
                ' . $title . '
            </h1>
            <div style="width:36px; height:3px; background-color:' . $accentColor . '; border-radius:2px; margin-top:14px;"></div>
        </td>
    </tr>

    <!-- Body -->
    <tr>
        <td style="padding:32px 40px 8px 40px;">
            <div style="font-family:Arial, sans-serif; font-size:14px; line-height:1.7; color:#2A2A2A;">
                ' . $body . '
            </div>
        </td>
    </tr>
' . $buttonHtml . '

    <!-- Footer -->
    <tr>
        <td style="padding:24px 40px 28px 40px; border-top:1px solid #EFEAE0;">
            <p style="margin:0; font-family:Arial, sans-serif; font-size:11px; color:' . self::GREY . '; line-height:1.6;">
                PennRide · Covoiturage solidaire — GRETA Bretagne Sud<br>
                Cet email est envoyé automatiquement, merci de ne pas y répondre directement.
            </p>
        </td>
    </tr>

</table>
</td>
</tr>
</table>
</body>
</html>';
    }

    // =====================================================================
    // 1. Création du compte
    // =====================================================================
    public static function accountCreated(string $firstName): string
    {
        $body = '
            <p style="margin:0 0 16px 0;">Bonjour ' . htmlspecialchars($firstName) . ',</p>
            <p style="margin:0 0 16px 0;">Ton compte PennRide a bien été créé. Avant de pouvoir accéder au service, il doit être validé par un administrateur du GRETA Bretagne Sud.</p>
            <p style="margin:0;">Tu recevras un email dès que ton compte sera activé. Merci de ta patience !</p>
        ';

        return self::layout(
            'Bienvenue sur PennRide',
            'Ton compte a été <em style="font-style:italic; color:' . self::GOLD . ';">créé</em>',
            $body
        );
    }

    // =====================================================================
    // 2. Compte validé par un admin
    // =====================================================================
    public static function accountValidated(string $firstName): string
    {
        $body = '
            <p style="margin:0 0 16px 0;">Bonjour ' . htmlspecialchars($firstName) . ',</p>
            <p style="margin:0 0 16px 0;">Bonne nouvelle ! Ton compte PennRide a été validé par un administrateur. Tu peux désormais te connecter et profiter de toutes les fonctionnalités du service.</p>
            <p style="margin:0;">Recherche un trajet, propose le tien, et rejoins la communauté de covoiturage du GRETA Bretagne Sud.</p>
        ';

        return self::layout(
            'Compte activé',
            'Ton compte est <em style="font-style:italic; color:' . self::GREEN . ';">validé !</em>',
            $body,
            ['label' => 'Accéder à PennRide', 'url' => self::SITE_URL],
            self::GREEN
        );
    }

    // =====================================================================
    // 3. Compte supprimé
    // =====================================================================
    public static function accountDeleted(string $firstName): string
    {
        $body = '
            <p style="margin:0 0 16px 0;">Bonjour ' . htmlspecialchars($firstName) . ',</p>
            <p style="margin:0 0 16px 0;">Nous te confirmons que ton compte PennRide ainsi que toutes les données associées ont été supprimés conformément à ta demande.</p>
            <p style="margin:0;">Si tu n\'es pas à l\'origine de cette suppression, contacte rapidement un administrateur du GRETA Bretagne Sud.</p>
        ';

        return self::layout(
            'Confirmation',
            'Ton compte a été <em style="font-style:italic; color:' . self::GREY . ';">supprimé</em>',
            $body,
            null,
            self::GREY
        );
    }

    // =====================================================================
    // 4. Compte banni par un administrateur
    // =====================================================================
    public static function accountBanned(string $firstName, string $reason = ''): string
    {
        $reasonHtml = $reason !== ''
            ? '<p style="margin:16px 0 0 0; padding:12px 16px; background-color:#FBEAE8; border-radius:8px; font-size:13px; color:' . self::RED . ';"><strong>Motif :</strong> ' . htmlspecialchars($reason) . '</p>'
            : '';

        $body = '
            <p style="margin:0 0 16px 0;">Bonjour ' . htmlspecialchars($firstName) . ',</p>
            <p style="margin:0 0 16px 0;">Ton compte PennRide a été suspendu par un administrateur en raison d\'un non-respect des conditions générales d\'utilisation du service.</p>
            ' . $reasonHtml . '
            <p style="margin:16px 0 0 0;">Si tu penses qu\'il s\'agit d\'une erreur, contacte l\'équipe des PennRiders via le formulaire de contact.</p>
        ';

        return self::layout(
            'Compte suspendu',
            'Ton compte a été <em style="font-style:italic; color:' . self::RED . ';">banni</em>',
            $body,
            null,
            self::RED
        );
    }

    // =====================================================================
    // 5. Valider la demande de réservation sur un trajet (rappel conducteur)
    // =====================================================================
    public static function bookingRequestPending(string $driverFirstName, string $passengerName, string $departure, string $arrival, string $date): string
    {
        $body = '
            <p style="margin:0 0 16px 0;">Bonjour ' . htmlspecialchars($driverFirstName) . ',</p>
            <p style="margin:0 0 16px 0;"><strong>' . htmlspecialchars($passengerName) . '</strong> souhaite rejoindre ton trajet :</p>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F7F4EE; border-radius:10px; margin:0 0 16px 0;">
                <tr><td style="padding:14px 18px; font-size:14px; color:#2A2A2A;">
                    <strong>' . htmlspecialchars($departure) . '</strong> → <strong>' . htmlspecialchars($arrival) . '</strong><br>
                    <span style="color:' . self::GREY . '; font-size:12px;">' . htmlspecialchars($date) . '</span>
                </td></tr>
            </table>
            <p style="margin:0;">Connecte-toi pour accepter ou refuser cette demande de réservation.</p>
        ';

        return self::layout(
            'Nouvelle demande',
            'Demande à <em style="font-style:italic; color:' . self::GOLD . ';">valider</em>',
            $body,
            ['label' => 'Voir la demande', 'url' => self::SITE_URL . '/myprofil ']
        );
    }

    // =====================================================================
    // 6. Le conducteur a accepté ma demande
    // =====================================================================
    public static function requestAccepted(string $passengerFirstName, string $departure, string $arrival, string $date, int $idJourneyDrive): string
    {
        $body = '
            <p style="margin:0 0 16px 0;">Bonjour ' . htmlspecialchars($passengerFirstName) . ',</p>
            <p style="margin:0 0 16px 0;">Ta demande de réservation a été <strong style="color:' . self::GREEN . ';">acceptée</strong> par le conducteur !</p>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F7F4EE; border-radius:10px; margin:0 0 16px 0;">
                <tr><td style="padding:14px 18px; font-size:14px; color:#2A2A2A;">
                    <strong>' . htmlspecialchars($departure) . '</strong> → <strong>' . htmlspecialchars($arrival) . '</strong><br>
                    <span style="color:' . self::GREY . '; font-size:12px;">' . htmlspecialchars($date) . '</span>
                </td></tr>
            </table>
            <p style="margin:0;">Retrouve tous les détails du trajet dans ton espace personnel.</p>
        ';

        return self::layout(
            'Réservation confirmée',
            'Ta demande est <em style="font-style:italic; color:' . self::GREEN . ';">acceptée !</em>',
            $body,
            ['label' => 'Voir le trajet', 'url' => self::SITE_URL . '/drive/show/' . $idJourneyDrive],
            self::GREEN
        );
    }

    // =====================================================================
    // 7. Le conducteur a refusé ma demande
    // =====================================================================
    public static function requestRefused(string $passengerFirstName, string $departure, string $arrival, string $date): string
    {
        $body = '
            <p style="margin:0 0 16px 0;">Bonjour ' . htmlspecialchars($passengerFirstName) . ',</p>
            <p style="margin:0 0 16px 0;">Le conducteur n\'a malheureusement pas pu accepter ta demande pour le trajet suivant :</p>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F7F4EE; border-radius:10px; margin:0 0 16px 0;">
                <tr><td style="padding:14px 18px; font-size:14px; color:#2A2A2A;">
                    <strong>' . htmlspecialchars($departure) . '</strong> → <strong>' . htmlspecialchars($arrival) . '</strong><br>
                    <span style="color:' . self::GREY . '; font-size:12px;">' . htmlspecialchars($date) . '</span>
                </td></tr>
            </table>
            <p style="margin:0;">Pas de souci, d\'autres trajets sont disponibles sur PennRide !</p>
        ';

        return self::layout(
            'Demande refusée',
            'Ta demande a été <em style="font-style:italic; color:' . self::RED . ';">refusée</em>',
            $body,
            ['label' => 'Rechercher un autre trajet', 'url' => self::SITE_URL . '/trajet'],
            self::RED
        );
    }

    // =====================================================================
    // 8. Confirmation de réception de la demande de réservation (passager)
    // =====================================================================
    public static function bookingRequestConfirmation(string $passengerFirstName, string $departure, string $arrival, string $date): string
    {
        $body = '
        <p style="margin:0 0 16px 0;">Bonjour ' . htmlspecialchars($passengerFirstName) . ',</p>
        <p style="margin:0 0 16px 0;">Ta demande de réservation pour le trajet suivant a bien été <strong>reçue</strong> et est en attente de validation par le conducteur :</p>
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F7F4EE; border-radius:10px; margin:0 0 16px 0;">
            <tr><td style="padding:14px 18px; font-size:14px; color:#2A2A2A;">
                <strong>' . htmlspecialchars($departure) . '</strong> → <strong>' . htmlspecialchars($arrival) . '</strong><br>
                <span style="color:' . self::GREY . '; font-size:12px;">' . htmlspecialchars($date) . '</span>
            </td></tr>
        </table>
        <p style="margin:0;">Tu recevras un email dès que le conducteur aura accepté ou refusé ta demande. Garde un œil sur ta boîte mail !</p>
    ';

        return self::layout(
            'Demande envoyée',
            'Ta demande est <em style="font-style:italic; color:' . self::GOLD . ';">en attente</em>',
            $body,
            ['label' => 'Voir mes réservations', 'url' => self::SITE_URL . '/myprofil'],
        );
    }

    // =====================================================================
    // 9. J'annule ma participation à un trajet (confirmation à l'utilisateur)
    // =====================================================================
    public static function passengerCancelledConfirmation(string $passengerFirstName, string $departure, string $arrival, string $date): string
    {
        $body = '
            <p style="margin:0 0 16px 0;">Bonjour ' . htmlspecialchars($passengerFirstName) . ',</p>
            <p style="margin:0 0 16px 0;">Nous confirmons l\'annulation de ta participation au trajet suivant :</p>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F7F4EE; border-radius:10px; margin:0 0 16px 0;">
                <tr><td style="padding:14px 18px; font-size:14px; color:#2A2A2A;">
                    <strong>' . htmlspecialchars($departure) . '</strong> → <strong>' . htmlspecialchars($arrival) . '</strong><br>
                    <span style="color:' . self::GREY . '; font-size:12px;">' . htmlspecialchars($date) . '</span>
                </td></tr>
            </table>
            <p style="margin:0;">Le conducteur a été informé de ton annulation.</p>
        ';

        return self::layout(
            'Annulation confirmée',
            'Participation <em style="font-style:italic; color:' . self::GREY . ';">annulée</em>',
            $body,
            null,
            self::GREY
        );
    }

    // =====================================================================
    // 10. Le conducteur annule un trajet sur lequel je m'étais positionné
    // =====================================================================
    public static function driverCancelledJourney(string $passengerFirstName, string $departure, string $arrival, string $date): string
    {
        $body = '
            <p style="margin:0 0 16px 0;">Bonjour ' . htmlspecialchars($passengerFirstName) . ',</p>
            <p style="margin:0 0 16px 0;">Le conducteur a annulé le trajet suivant auquel tu étais inscrit :</p>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#FBEAE8; border-radius:10px; margin:0 0 16px 0;">
                <tr><td style="padding:14px 18px; font-size:14px; color:#2A2A2A;">
                    <strong>' . htmlspecialchars($departure) . '</strong> → <strong>' . htmlspecialchars($arrival) . '</strong><br>
                    <span style="color:' . self::GREY . '; font-size:12px;">' . htmlspecialchars($date) . '</span>
                </td></tr>
            </table>
            <p style="margin:0;">Désolé pour le désagrément. N\'hésite pas à rechercher un trajet alternatif.</p>
        ';

        return self::layout(
            'Trajet annulé',
            'Le trajet a été <em style="font-style:italic; color:' . self::RED . ';">annulé</em>',
            $body,
            ['label' => 'Rechercher un autre trajet', 'url' => self::SITE_URL . '/trajet'],
            self::RED
        );
    }

    // =====================================================================
    // 11. Un autre utilisateur se joint à une requête que j'ai formulée
    // =====================================================================
    public static function someoneJoinedMyRequest(string $requesterFirstName, string $otherUserName, string $departure, string $arrival, string $date): string
    {
        $body = '
            <p style="margin:0 0 16px 0;">Bonjour ' . htmlspecialchars($requesterFirstName) . ',</p>
            <p style="margin:0 0 16px 0;"><strong>' . htmlspecialchars($otherUserName) . '</strong> a rejoint la demande de trajet que tu avais formulée :</p>
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F7F4EE; border-radius:10px; margin:0 0 16px 0;">
                <tr><td style="padding:14px 18px; font-size:14px; color:#2A2A2A;">
                    <strong>' . htmlspecialchars($departure) . '</strong> → <strong>' . htmlspecialchars($arrival) . '</strong><br>
                    <span style="color:' . self::GREY . '; font-size:12px;">' . htmlspecialchars($date) . '</span>
                </td></tr>
            </table>
            <p style="margin:0;">Avec plus de monde, un conducteur sera plus vite trouvé !</p>
        ';

        return self::layout(
            'Nouveau participant',
            'Quelqu\'un a <em style="font-style:italic; color:' . self::GOLD . ';">rejoint</em> ta demande',
            $body,
            ['label' => 'Voir la demande', 'url' => self::SITE_URL . '/trajet']
        );
    }

    // =====================================================================
    // 12. Réception d'un message de contact (administrateur)
    // =====================================================================
    public static function contactFormReceived(string $firstName, string $lastName, string $email, string $motif, string $message): string
    {
        $motifLabels = [
            'information' => 'Demande d\'information',
            'problem'     => 'Signaler un problème',
            'account'     => 'Problème de compte',
            'traject'     => 'Problème de trajet',
            'other'       => 'Autre',
        ];

        $motifLabel = $motifLabels[$motif] ?? $motif;

        $body = '
        <p style="margin:0 0 16px 0;">Un nouveau message a été envoyé via le formulaire de contact :</p>
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F7F4EE; border-radius:10px; margin:0 0 16px 0;">
            <tr><td style="padding:14px 18px; font-size:14px; color:#2A2A2A; line-height:1.8;">
                <strong>Nom :</strong> ' . htmlspecialchars($lastName) . '<br>
                <strong>Prénom :</strong> ' . htmlspecialchars($firstName) . '<br>
                <strong>Email :</strong> <a href="mailto:' . htmlspecialchars($email) . '" style="color:' . self::GOLD . '; text-decoration:none;">' . htmlspecialchars($email) . '</a><br>
                <strong>Motif :</strong> ' . htmlspecialchars($motifLabel) . '
            </td></tr>
        </table>
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F7F4EE; border-radius:10px; margin:0 0 16px 0;">
            <tr><td style="padding:14px 18px; font-size:14px; color:#2A2A2A; line-height:1.7;">
                <strong style="display:block; margin-bottom:8px;">Message :</strong>
                ' . nl2br(htmlspecialchars($message)) . '
            </td></tr>
        </table>
        <p style="margin:0; font-size:12px; color:' . self::GREY . ';">Pour répondre à cet utilisateur, réponds directement à l\'adresse : <a href="mailto:' . htmlspecialchars($email) . '" style="color:' . self::GOLD . '; text-decoration:none;">' . htmlspecialchars($email) . '</a></p>
    ';

        return self::layout(
            'Formulaire de contact',
            'Nouveau <em style="font-style:italic; color:' . self::GOLD . ';">message</em> reçu',
            $body
        );
    }
}
