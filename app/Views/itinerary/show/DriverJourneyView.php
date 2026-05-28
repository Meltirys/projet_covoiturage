<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div>
    <?php if (session()->getFlashdata('error')): ?>
        <p class="text-xs text-red-500 border border-red-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <div>
        <span><?= esc($journey['departure']) ?></span>

        <div>
            <h1><?= esc($journey['departure_city']) ?></h1>
            <h1>→ <?= esc($journey['arrival_city']) ?></h1>
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

        <?php if (!empty($journey['stages'])): ?>
            <div>
                <p>LES ÉTAPES</p>
                <?php foreach ($journey['stages'] as $stage): ?>
                    <div>
                        <p><?= esc($stage['address']) ?></p>
                        <p><?= esc($stage['city_name']) ?> - <?= esc($stage['postcode']) ?></p>
                        <p><?= esc(date('H\Hi', strtotime($stage['passing_time']))) ?></p>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>

    </div>

    <?= view('booking/BookingView', ['journey' => $journey]) ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>