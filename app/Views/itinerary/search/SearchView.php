<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Demander comment on devrait faire la recherche
 Faut-il faire un formulaire de recherche différent selon le type de trajet (drive/request) ou non -->
<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

    <header class="flex justify-between items-center mb-6">
        <h2 class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Rechercher un trajet</h2>
    </header>

    <div class="bg-white border border-[rgba(37,63,114,0.25)] rounded-xl p-5">
        <?= view('itinerary/search/search_form') ?>
    </div>

</main>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="/js/geocoding.js"></script>
<?= $this->endSection() ?>