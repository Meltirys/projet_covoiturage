<?php
$status = session()->getFlashdata('status');
$searchErrors = session()->getFlashdata('errors') ?? [];
$error  = session()->getFlashdata('error');
?>

<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

    <?php if (!empty($status)): ?>
        <p class="text-xs text-green-500 mb-3"><?= esc($status) ?></p>
    <?php endif ?>

    <?php if (!empty($error)): ?>
        <p class="text-xs text-red-500 mb-3"><?= esc($error) ?></p>
    <?php endif ?>

    <header class="flex justify-between items-center mb-6">
        <h2 class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Rechercher un trajet</h2>
    </header>

    <div class="bg-white border border-[rgba(37,63,114,0.25)] rounded-xl p-5">
        <?= view('itinerary/search/search_drive_form', ['errors' => $searchErrors]) ?>
    </div>

    <?php if (isset($journeys)): ?>
        <?php if (! empty($journeys)): ?>
            <div class="space-y-4 mt-4">
                <?php foreach ($journeys as $journey): ?>
                    <div class="p-4 border rounded-lg bg-slate-50">
                        <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                            <div>
                                <p class="text-sm font-semibold">Trajet #<?= esc($journey['id_journey_drive']) ?></p>
                                <p class="text-sm text-slate-700">
                                    <?= esc($journey['departure_city']) ?> → <?= esc($journey['arrival_city']) ?>
                                </p>
                            </div>
                            <p class="text-xs uppercase tracking-[0.15em] text-bluegrey">Voiture</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-3 text-sm text-slate-700">
                            <div>
                                <p><strong>Départ :</strong> <?= esc($journey['departure_address']) ?>, <?= esc($journey['departure_postcode']) ?> <?= esc($journey['departure_city']) ?></p>
                                <p><strong>Arrivée :</strong> <?= esc($journey['arrival_address']) ?>, <?= esc($journey['arrival_postcode']) ?> <?= esc($journey['arrival_city']) ?></p>
                            </div>
                            <div>
                                <p><strong>Date :</strong> <?= esc($journey['departure']) ?></p>
                                <p><strong>Voiture :</strong> <?= esc($journey['car_brand']) ?> <?= esc($journey['car_model']) ?></p>
                                <p><strong>Conducteur :</strong> <?= esc($journey['driver_first_name']) ?> <?= esc(substr($journey['driver_last_name'] ?? '', 0, 1)) ?>.</p>
                                <p><strong>Places restantes :</strong> <?= esc($journey['available_seats'] ?? $journey['number_of_place']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php else: ?>
            <p class="text-xs text-gray-500 mt-4">Aucun trajet trouvé pour cette recherche.</p>
        <?php endif ?>
    <?php endif ?>

</main>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="/js/geocoding.js"></script>
<script src="/js/address-fields.js"></script>
<?= $this->endSection() ?>