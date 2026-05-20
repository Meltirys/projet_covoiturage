<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">

        <div class="header">
            <h1>Nouvelle demande de réservation</h1>
        </div>

        <div class="content">
            <p>Bonjour <strong><?= esc($driver_first_name) ?></strong>,</p>
            <p>
                Un passager souhaite rejoindre l'un de vos trajets.
                Voici les informations de la demande :
            </p>

            <div class="journey-details">
                <p>🗓️ <span>Date :</span> <?= esc($journey_date) ?></p>
                <p>📍 <span>Départ :</span> <?= esc($journey_departure) ?></p>
                <p>🏁 <span>Arrivée :</span> <?= esc($journey_arrival) ?></p>
                <p>💺 <span>Places restantes :</span> <?= esc($journey_seats) ?></p>
            </div>

            <div class="passenger-details">
                <p>👤 <span>Passager :</span> <?= esc($passenger_first_name) ?> <?= esc($passenger_last_name) ?></p>
                <p>📧 <span>Email :</span> <?= esc($passenger_email) ?></p>
                <?php if ($passenger_mobile): ?>
                    <p>📱 <span>Téléphone :</span> <?= esc($passenger_mobile) ?></p>
                <?php endif; ?>
            </div>

            <p>
                Connectez-vous à votre espace personnel pour accepter
                ou refuser cette demande.
            </p>
        </div>

        <div class="footer">
            <p>Vous recevez cet email car vous êtes conducteur sur notre plateforme.</p>
            <p>© <?= date('Y') ?> Covoiturage — Tous droits réservés</p>
        </div>

    </div>
</body>

</html>