<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php helper('french') ?>

<main>
    <h1>Réserver le trajet</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="error"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <section id="journey-details">
        <p>Trajet #<?= esc($journey['id_journey_drive']) ?></p>
        <p>Places disponibles : <?= esc($journey['number_of_place']) ?></p>
        <p>Départ : <?= format_date_fr($journey['departure'])  // Exemple d'écriture avec le helper?></p> 
        <p>Arrivée : <?= esc($journey['estimated_arrival']) ?></p>
        <?php // Villes de départ et d'arrivée — à afficher quand Track sera défini ?>
    </section>

    <?= form_open('reservation') ?>
        <input type="hidden" name="id_journey_drive" value="<?= esc($journey['id_journey_drive']) ?>">
        <input type="hidden" name="seat_taken" value="1">
        <button type="submit">Valider la réservation</button>
    <?= form_close() ?>
</main>

<?= $this->endSection() ?>

