<p class="text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-3">Réserver le trajet</p>

<div class="bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 mb-4 flex flex-col gap-2">
    <div class="flex items-center justify-between gap-3">
        <p class="text-xs text-grey">Trajet de <?= esc($journey['departure_city']) ?> → <?= esc($journey['arrival_city']) ?> par <?= esc($journey['driver_name']) ?></p>
        <span class="text-xs font-bold bg-gold/10 border border-gold/20 text-gold rounded-full px-3 py-0.5 whitespace-nowrap flex-shrink-0">
            <?= esc($journey['available_seats']) ?> place(s) disponible(s)
        </span>
    </div>
    <p class="text-sm text-lightgrey">Départ : <?= esc($journey['departure']) ?></p>
    <p class="text-sm text-lightgrey">Arrivée : <?= esc($journey['estimated_arrival']) ?></p>
</div>

<?php if (!$journey['is_driver']): ?>
    <?php if ($journey['has_booked']): ?>
        <?= form_open('reservation/annuler/' . $journey['has_booked']['id_booking']) ?>
        <input type="hidden" name="id_journey_drive" value="<?= esc($journey['id_journey_drive']) ?>">
        <input type="hidden" name="seat_taken" value="1">
        <div class="flex justify-center mt-4">
            <button type="submit" class="border border-red/40 text-red bg-transparent text-sm font-medium px-6 py-2 rounded-full hover:bg-red/20 transition-colors cursor-pointer">
                Annuler la réservation
            </button>
        </div>
        <?= form_close() ?>
    <?php else: ?>
        <?= form_open('reservation') ?>
        <input type="hidden" name="id_journey_drive" value="<?= esc($journey['id_journey_drive']) ?>">
        <input type="hidden" name="seat_taken" value="1">
        <div class="flex justify-center mt-4">
            <button type="submit" class="bg-gold text-ocean text-sm font-semibold px-6 py-2 rounded-full hover:opacity-90 transition-opacity cursor-pointer">
                Demander une place
            </button>
        </div>
        <?= form_close() ?>
    <?php endif ?>
<?php else: ?>
    <div class="flex justify-center mb-6 gap-3">
        <a href="<?= base_url('trajet/modification/' . $journey['id_journey_drive']) ?>"
            class="text-sm text-gold border border-gold/30 rounded-full px-4 py-1.5 hover:bg-gold/10 transition-colors">
            Modifier l'itinéraire
        </a>
        <?= form_open('reservation/trajet/annuler/' . $journey['id_journey_drive'], ['onsubmit' => "return confirm('Supprimer ce trajet ?')"]) ?>
        <button type="submit" class="bg-gold text-ocean text-sm font-semibold px-6 py-2 rounded-full hover:opacity-90 transition-opacity cursor-pointer">Supprimer</button>
        <?= form_close() ?>
    </div>
<?php endif ?>