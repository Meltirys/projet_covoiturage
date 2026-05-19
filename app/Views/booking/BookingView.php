<?= view('commons/header') ?>

<main>
    <h1>Réserver le trajet</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="error"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>
    
    <section class="x" id="journey-details">
        <p>Trajet #<?= esc($journey['id_journey_drive']) ?></p>
        <p>Places disponibles : <?= esc($journey['number_of_place']) ?></p>
        <p>Départ : <?= esc($journey['departure']) ?></p>
        <p>Arrivée : <?= esc($journey['estimated_arrival']) ?></p>
        <?php //Villes de départ et d'arriver ?>
    </section>

    <?= form_open('reservation') ?>
        <input type="hidden" name="id_journey_drive" value="<?= esc($journey['id_journey_drive']) ?>">
        <input type="hidden" name="seat_taken" value="1">
        <button type="submit">Valider la réservation</button>
    <?= form_close() ?>
</main>

<?= view('commons/footer') ?>
