<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<?php helper('french') ?>

<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

    <header class="flex justify-between items-center mb-6">
        <h2 class="text-xs tracking-[0.15em] text-bluegrey uppercase">Réserver le trajet</h2>
    </header>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="text-xs text-red-500 border border-red-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <div class="bg-white border border-babyblue rounded-xl px-4 py-3 mb-4 flex flex-col gap-2">
        <p class="text-xs text-grey">Trajet #<?= esc($journey['id_journey_drive']) ?></p>
        <p class="text-sm font-poppins text-bluegrey">Départ : <?= format_date_fr($journey['departure']) ?></p>
        <p class="text-sm font-poppins text-bluegrey">Arrivée : <?= esc($journey['estimated_arrival']) ?></p>
        <span class="text-xs text-bluegrey bg-lightblue rounded-full px-3 py-0.5 w-fit">
            <?= esc($journey['number_of_place']) ?> place(s) disponible(s)
        </span>
    </div>

    <?= form_open('reservation') ?>
    <input type="hidden" name="id_journey_drive" value="<?= esc($journey['id_journey_drive']) ?>">
    <input type="hidden" name="seat_taken" value="1">

    <div class="flex justify-center mt-4">
        <button type="submit" class="border border-babyblue text-bluegrey bg-white text-sm font-medium px-6 py-2 rounded-full hover:bg-bluegrey hover:text-white transition-all duration-200">
            Valider la réservation
        </button>
    </div>
    <?= form_close() ?>

</main>

<?= $this->endSection() ?>