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
            <h1>Réservation acceptée !</h1>
        </div>

        <div class="content">
            <p>Bonjour <strong><?= esc($passenger_name) ?></strong>,</p>
            <p>
                Bonne nouvelle ! Le conducteur a accepté votre demande
                de réservation pour le trajet suivant :
            </p>

            <div class="journey-details">
                <p>🗓️ <span>Date :</span> <?= esc($journey_date) ?></p>
                <p>📍 <span>Départ :</span> <?= esc($journey_departure) ?></p>
                <p>🏁 <span>Arrivée :</span> <?= esc($journey_arrival) ?></p>
                <p>👤 <span>Conducteur :</span> <?= esc($driver_name) ?></p>
            </div>

            <p>
                Nous vous souhaitons un agréable trajet !
            </p>
        </div>

        <div class="footer">
            <p>© <?= date('Y') ?> Covoiturage — Tous droits réservés</p>
        </div>

    </div>
</body>

</html>