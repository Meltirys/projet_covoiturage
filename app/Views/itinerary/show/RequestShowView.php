<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<main>
    <h2>Demande de <?= esc($author['first_name']) ?></h2>

    <p>Départ : <?= esc($request['start_address']) ?></p>
    <p>Arrivée : <?= esc($request['end_address']) ?></p>
    <p>Disponibilité : <?= esc($request['range_of_time']) ?></p>
    <p>Description : <?= esc($request['description']) ?></p>

    <?php if ($ownRequest): ?>
        <a href="<?= site_url('request/edit/' . $request['id_journey_request']) ?>">Modifier</a>
        <?= form_open('request/delete/' . $request['id_journey_request']) ?>
        <button type="submit">Supprimer</button>
        <?= form_close() ?>
    <?php endif ?>
</main>

<?= $this->endSection() ?>