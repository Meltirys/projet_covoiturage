<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php $range = array_map('trim', explode('-', $request['range_of_time'], 2)) ?>

<main>
    <?= form_open('request/update/' . $request['id_journey_request']) ?>

        <div>
            <label for="request-description">Description</label>
            <textarea name="request[description]" id="request-description"><?= esc($request['description']) ?></textarea>
        </div>

        <div>
            <label for="request-range-start">Début de disponibilité</label>
            <input type="time" name="request[range-start]" id="request-range-start"
                value="<?= esc($range[0]) ?>">
        </div>

        <div>
            <label for="request-range-end">Fin de disponibilité</label>
            <input type="time" name="request[range-end]" id="request-range-end"
                value="<?= esc($range[1]) ?>">
        </div>

        <button type="submit">Mettre à jour</button>

    <?= form_close() ?>
</main>

<?= $this->endSection() ?>
