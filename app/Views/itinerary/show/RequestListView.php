<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<main class="w-full max-w-3xl mx-auto px-4 py-6 font-poppins">
    <h2 class="text-xs tracking-[0.15em] text-bluegrey uppercase mb-4">Demandes de trajets</h2>

    <?php if (empty($requests)): ?>
        <p>Aucune demande pour le moment.</p>
    <?php else: ?>
        <?php foreach ($requests as $request): ?>
            <div>
                <p><?= esc($request['start_address']) ?> → <?= esc($request['end_address']) ?></p>
                <p><?= esc($request['range_of_time']) ?></p>
                <a href="<?= site_url('request/show/' . $request['id_journey_request']) ?>">Voir les détails</a>
            </div>
        <?php endforeach ?>
    <?php endif ?>
</main>

<?= $this->endSection() ?>