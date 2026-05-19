<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<h1>Trajet vers :</h1>

<?= view('itinerary/search/search_form') ?>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script src="/js/geocoding.js"></script>
<?= $this->endSection() ?>