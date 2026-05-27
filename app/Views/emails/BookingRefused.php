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
            <h1>Réservation refusée</h1>
        </div>

        <div class="content">
            <p>Bonjour <strong><?= esc($passenger_first_name) ?></strong>,</p>
            <p>
                Nous vous informons que le conducteur a refusé votre demande
                de réservation pour le trajet suivant :
            </p>

            <div class="journey-details">
                <p>🗓️ <span>Date :</span> <?= esc($journey_date) ?></p>
                <p>📍 <span>Départ :</span> <?= esc($journey_departure) ?></p>
                <p>🏁 <span>Arrivée :</span> <?= esc($journey_arrival) ?></p>
                <p>👤 <span>Conducteur :</span> <?= esc($driver_first_name) ?> <?= esc($driver_last_name) ?></p>
            </div>

            <p>
                Nous vous invitons à rechercher un autre trajet disponible
                sur notre plateforme.
            </p>
        </div>

        <div class="footer">
            <p>© <?= date('Y') ?> Covoiturage — Tous droits réservés</p>
        </div>

    </div>
</body>

</html>