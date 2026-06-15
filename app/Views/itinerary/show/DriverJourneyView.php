<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div>
    <?php if (session()->getFlashdata('success')): ?>
        <p class="text-xs text-green-600 border border-green-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('success') ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p class="text-xs text-red-500 border border-red-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <div>

        <span><?= esc($journey['departure']) ?></span>

        <div>
            <h1><?= esc($journey['departure_city']) ?>
                <?php foreach ($journey['waypoints'] as $waypoint) : ?>
                    <span>-> <?= $waypoint ?></span>
                <?php endforeach; ?>
            </h1>

        </div>

        <div>
            <p>LE CONDUCTEUR</p>
            <div>
                <div>
                    <div>
                        <?php if ($journey['avatar_filename']): ?>
                            <img src="<?= base_url('img/avatars/' . $journey['avatar_filename']) ?>" alt="<?= esc($journey['driver_name']) ?>">
                        <?php else: ?>
                            <!-- Initiales si pas d'avatar -->
                            <span><?= strtoupper(substr($journey['driver_name'], 0, 2)) ?></span>
                        <?php endif ?>
                    </div>
                    <div>
                        <p>
                            <?= esc($journey['driver_name']) ?>
                            <a href="#">voir le profil</a>
                        </p>
                        <p>
                            <?= esc($journey['car_brand']) ?>
                            <?= esc($journey['car_model']) ?>
                            <?= esc($journey['car_color']) ?>
                        </p>
                    </div>
                </div>
                <a href="#">
                    <img src="/img/mail.svg" alt="Contacter le conducteur">
                </a>
            </div>
        </div>

        <a href="<?= base_url('trajet/modification/' . $journey['id_journey_drive']) ?>">
            Modifier l'itinéraire
        </a>

    </div>
    <div id="map"
        data-geojson="<?= esc($geojson) ?>"
        style="height: 400px; width: 100%; border-radius: 12px;">
    </div>
    <?= view('booking/BookingView', ['journey' => $journey]) ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="/js/journey-map.js"></script>
<?= $this->endSection() ?>