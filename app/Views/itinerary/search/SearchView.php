<?php
$status       = session()->getFlashdata('status');
$searchErrors = session()->getFlashdata('errors') ?? [];
$error        = session()->getFlashdata('error');
?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="profile-hero px-4 md:px-8 py-10 md:py-14 mb-8">
    <div class="relative z-10 max-w-5xl mx-auto">
        <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5">
            Trajets
        </p>
        <h1 class="font-pfd text-4xl md:text-6xl font-light leading-[0.92] tracking-tight text-lightgrey">
            Rechercher<br>
            <em class="italic text-gold">un trajet</em>
        </h1>
    </div>
</div>

<main class="w-full max-w-5xl mx-auto px-4 md:px-8 pb-12 font-poppins">

    <?php if (!empty($status)): ?>
        <p class="text-xs text-green border border-green/30 rounded-lg px-3 py-2 mb-4"><?= esc($status) ?></p>
    <?php endif ?>
    <?php if (!empty($error)): ?>
        <p class="text-xs text-red border border-red/30 rounded-lg px-3 py-2 mb-4"><?= esc($error) ?></p>
    <?php endif ?>

    <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden mb-6">
        <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
        <div class="p-5">
            <?= view('itinerary/search/search_drive_form', ['errors' => $searchErrors]) ?>
        </div>
    </div>

    <?php if (isset($journeys)): ?>
        <?php if (!empty($journeys)): ?>
            <div class="flex flex-col gap-3 mt-6">
                <?php foreach ($journeys as $journey): ?>
                    <div class="bg-ocean-mid border border-ocean-light rounded-[14px] px-5 py-4 hover-border-gold transition-colors">
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
                                class="bg-gold text-ocean font-semibold text-xs px-5 py-2 rounded-full hover:opacity-90 transition-opacity">
                                Réserver
                            </a>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php else: ?>
            <div class="flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 mt-6">
                <div class="w-8 h-8 rounded-lg bg-ocean-light flex items-center justify-center text-sm flex-shrink-0">🔍</div>
                <p class="text-xs text-grey italic">Aucun trajet trouvé pour cette recherche.</p>
            </div>
        <?php endif ?>
    <?php endif ?>

</main>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="/js/geocoding.js"></script>
<script src="/js/address-fields.js"></script>
<?= $this->endSection() ?>