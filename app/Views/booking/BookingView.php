<header class="flex justify-between items-center mb-6">
    <h2 class="text-xs tracking-[0.15em] text-bluegrey uppercase">Réserver le trajet</h2>
</header>

<div class="bg-white border border-babyblue rounded-xl px-4 py-3 mb-4 flex flex-col gap-2">
    <p class="text-xs text-grey">Trajet #<?= esc($journey['id_journey_drive']) ?></p>
    <p class="text-sm font-poppins text-bluegrey">Départ : <?= esc($journey['departure']) ?></p>
    <p class="text-sm font-poppins text-bluegrey">Arrivée : <?= esc($journey['estimated_arrival']) ?></p>
    <span class="text-xs text-bluegrey bg-lightblue rounded-full px-3 py-0.5 w-fit">
        <?= esc($journey['number_of_place']) ?> place(s) disponible(s)
    </span>
</div>

<?php if (!$journey['is_driver']): ?>

    <?php if ($journey['has_booked']): ?>
        <?= form_open('reservation/annuler/' . $journey['has_booked']['id_booking']) ?>
        <input type="hidden" name="id_journey_drive" value="<?= esc($journey['id_journey_drive']) ?>">
        <input type="hidden" name="seat_taken" value="1">

        <div class="flex justify-center mt-4">
            <button type="submit" class="border border-babyblue text-bluegrey bg-white text-sm font-medium px-6 py-2 rounded-full hover:bg-bluegrey hover:text-white transition-all duration-200">
                Annuler la réservation
            </button>
        </div>

    <?php else: ?>
        <?= form_open('reservation') ?>
        <input type="hidden" name="id_journey_drive" value="<?= esc($journey['id_journey_drive']) ?>">
        <input type="hidden" name="seat_taken" value="1">

        <div class="flex justify-center mt-4">
            <button type="submit" class="border border-babyblue text-bluegrey bg-white text-sm font-medium px-6 py-2 rounded-full hover:bg-bluegrey hover:text-white transition-all duration-200">
                Demander une place
            </button>
        </div>
        <?= form_close() ?>
    <?php endif ?>
<?php endif ?>