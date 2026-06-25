<div class="flex flex-col gap-3 mt-6">
    <?php foreach ($journeys as $journey): ?>
            <div class="bg-ocean-mid border border-ocean-light rounded-[14px] px-5 py-4 hover-border-gold transition-colors"
            onclick="window.location='<?= site_url('drive/show/' . $journey['id_journey_drive']) ?>'">
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between mb-3">
                    <div>
                        <p class="text-sm font-medium text-lightgrey">
                            <?= esc($journey['departure_city']) ?> → <?= esc($journey['arrival_city']) ?>
                        </p>
                        <p class="text-xs text-grey mt-0.5"><?= esc($journey['departure']) ?></p>
                    </div>
                    <span class="text-xs font-bold bg-gold/10 border border-gold/20 text-gold rounded-full px-3 py-0.5 self-start md:self-auto whitespace-nowrap">
                        <?= esc($journey['available_seats'] ?? $journey['number_of_place']) ?> place<?= ($journey['available_seats'] ?? $journey['number_of_place']) > 1 ? 's' : '' ?>
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-grey mb-4">
                    <div class="flex flex-col gap-1">
                        <p><span class="text-gold font-medium">Départ :</span> <?= esc($journey['departure_address']) ?>, <?= esc($journey['departure_postcode']) ?> <?= esc($journey['departure_city']) ?></p>
                        <p><span class="text-gold font-medium">Arrivée :</span> <?= esc($journey['arrival_address']) ?>, <?= esc($journey['arrival_postcode']) ?> <?= esc($journey['arrival_city']) ?></p>
                    </div>
                    <div class="flex flex-col gap-1">
                        <p><span class="text-gold font-medium">Voiture :</span> <?= esc($journey['car_brand']) ?> <?= esc($journey['car_model']) ?></p>
                        <p><span class="text-gold font-medium">Conducteur :</span> <?= esc($journey['driver_first_name']) ?> <?= esc(substr($journey['driver_last_name'] ?? '', 0, 1)) ?>.</p>
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="<?= site_url('drive/show/' . $journey['id_journey_drive']) ?>"
                        class="bg-gold text-ocean font-semibold text-xs px-5 py-2 rounded-full hover:opacity-90 transition-opacity"
                        onclick="event.stopPropagation()">
                        Réserver
                    </a>
                </div>
            </div>
    <?php endforeach ?>
</div>