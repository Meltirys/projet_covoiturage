<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php $range = array_map('trim', explode('-', $request['range_of_time'], 2)) ?>

<main>
    <?= view('itinerary/edit/edit_request_form', [
        'errors' => $errors,
    ]) ?>
</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="/js/geocoding.js"></script>
<script src="/js/address-fields.js"></script>
<?= $this->endSection() ?>