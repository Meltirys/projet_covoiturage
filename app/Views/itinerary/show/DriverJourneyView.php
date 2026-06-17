<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="profile-hero px-4 md:px-8 py-10 md:py-14 mb-8">
    <div class="relative z-10 max-w-5xl mx-auto">
        <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5">
            Trajets
        </p>
        <h1 class="font-pfd text-3xl md:text-5xl font-light leading-[0.95] tracking-tight text-lightgrey mb-3">
            <?= esc($journey['departure_city']) ?>
            <?php foreach ($journey['waypoints'] as $waypoint) : ?>
                <em class="italic text-gold"> → <?= esc($waypoint) ?></em>
            <?php endforeach; ?>
        </h1>
        <p class="text-sm text-grey"><?= esc($journey['departure']) ?></p>
    </div>
</div>

<main class="w-full max-w-5xl mx-auto px-4 md:px-8 pb-12 font-poppins">

    <?php if (session()->getFlashdata('success')): ?>
        <p class="text-xs text-green border border-green/30 rounded-lg px-3 py-2 mb-4"><?= session()->getFlashdata('success') ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p class="text-xs text-red border border-red/30 rounded-lg px-3 py-2 mb-4"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <!-- CARTE CONDUCTEUR -->
    <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden mb-6">
        <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
        <div class="p-5">
            <p class="text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-3">Le conducteur</p>
            <div class="flex items-center justify-between gap-3 flex-wrap">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-12 h-12 rounded-full bg-gold/10 border border-gold/15 flex items-center justify-center text-sm font-medium text-gold flex-shrink-0 overflow-hidden">
                        <?php if ($journey['avatar_filename']): ?>
                            <img src="<?= base_url('img/avatars/' . $journey['avatar_filename']) ?>" alt="<?= esc($journey['driver_name']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <!-- Initiales si pas d'avatar -->
                            <?= strtoupper(substr($journey['driver_name'], 0, 2)) ?>
                        <?php endif ?>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-lightgrey">
                            <?= esc($journey['driver_name']) ?>
                            <a href="#" class="text-xs text-gold hover:opacity-70 transition-opacity ml-2">voir le profil</a>
                        </p>
                        <p class="text-xs text-grey mt-0.5">
                            <?= esc($journey['car_brand']) ?> <?= esc($journey['car_model']) ?> · <?= esc($journey['car_color']) ?>
                        </p>
                    </div>
                </div>
                <a href="#" class="w-9 h-9 rounded-full bg-ocean-light border border-ocean-light flex items-center justify-center hover:border-gold/40 transition-colors flex-shrink-0">
                    <i class="fa-solid fa-envelope" style="color: var(--color-gold)"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="flex justify-end mb-6">
        <a href="<?= base_url('trajet/modification/' . $journey['id_journey_drive']) ?>"
            class="text-sm text-gold border border-gold/30 rounded-full px-4 py-1.5 hover:bg-gold/10 transition-colors">
            Modifier l'itinéraire
        </a>
    </div>

    <!-- CARTE MAP -->
    <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden mb-6">
        <div id="map"
            data-geojson="<?= esc($geojson) ?>"
            style="height: 400px; width: 100%;">
        </div>
    </div>

    <?= view('booking/BookingView', ['journey' => $journey]) ?>

</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="/js/journey-map.js"></script>
<?= $this->endSection() ?>