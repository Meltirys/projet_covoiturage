<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<main>
    <h1>Mes réservations</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="success"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p class="error"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <section id="passager">
        <h2>Mes trajets réservés</h2>

        <h3>À venir</h3>
        <?php if (empty($upcomingConfirmed)): ?>
            <p>Aucun trajet confirmé</p>
        <?php else: ?>
            <?php foreach ($upcomingConfirmed as $booking): ?>
                <div>
                    <?php // Ville départ → arrivée - à afficher quand Track sera fini ?>
                    <p>Départ : <?= esc($booking['journey']['departure']) ?></p>
                    <p>Conducteur : <?= esc($booking['driver_name']) ?></p>
                    <p>Statut : Confirmé</p>
                    <form action="<?= site_url('reservation/annuler/' . $booking['id_booking']) ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit">Annuler</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <h3>En attente</h3>
        <?php if (empty($upcomingPending)): ?>
            <p>Aucune demande en attente.</p>
        <?php else: ?>
            <?php foreach ($upcomingPending as $booking): ?>
                <div>
                    <?php // Ville départ → arrivée - à afficher quand Track sera fini ?>
                    <p>Départ : <?= esc($booking['journey']['departure']) ?></p>
                    <p>Conducteur : <?= esc($booking['driver_name']) ?></p>
                    <p>Statut : En attente de validation</p>
                    <form action="<?= site_url('reservation/annuler/' . $booking['id_booking']) ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit">Annuler</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <h3>Passés</h3>
        <?php if (empty($pastJourney)): ?>
            <p>Aucun trajet passé.</p>
        <?php else: ?>
            <?php foreach ($pastJourney as $booking): ?>
                <div>
                    <?php // Ville départ → arrivée - à afficher quand Track sera fini ?>
                    <p>Départ : <?= esc($booking['journey']['departure']) ?></p>
                    <p>Conducteur : <?= esc($booking['driver_name']) ?></p>
                    <p>Statut : <?= $booking['is_validated'] ? 'Effectué' : 'Refusé' ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <section id="conducteur">
        <h2>Mes trajets proposés</h2>

        <h3>À venir</h3>
        <?php if (empty($driveUpcoming)): ?>
            <p>Aucun trajet à venir.</p>
        <?php else: ?>
            <?php foreach ($driveUpcoming as $journey): ?>
                <div>
                    <?php // Ville départ → arrivée - à afficher quand Track sera fini ?>
                    <p>Départ : <?= esc($journey['departure']) ?></p>
                    <p>Places : <?= esc($journey['places_restantes']) ?>/<?= esc($journey['number_of_place']) ?></p>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <h3>Passés</h3>
        <?php if (empty($drivePast)): ?>
            <p>Aucun trajet passé.</p>
        <?php else: ?>
            <?php foreach ($drivePast as $journey): ?>
                <div>
                    <?php // Ville départ → arrivée - à afficher quand Track sera fini ?>
                    <p>Départ : <?= esc($journey['departure']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <h3>Demandes en attente de validation</h3>
        <?php if (empty($pendingRequests)): ?>
            <p>Aucune demande en attente.</p>
        <?php else: ?>
            <?php foreach ($pendingRequests as $request): ?>
                <div>
                    <p>Passager #<?= esc($request['id_user']) ?></p>
                    <?php // Ville départ → arrivée - à afficher quand Track sera fini ?>
                    <p>Départ : <?= esc($request['journey']['departure']) ?></p>
                    <form action="<?= site_url('reservation/accepter/' . $request['id_booking']) ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit">Accepter</button>
                    </form>
                    <form action="<?= site_url('reservation/refuser/' . $request['id_booking']) ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit">Refuser</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>

<?= $this->endSection() ?>


