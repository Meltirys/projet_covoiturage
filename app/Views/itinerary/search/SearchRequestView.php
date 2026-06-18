<?php
$status       = session()->getFlashdata('status');
$searchErrors = session()->getFlashdata('errors') ?? [];
$error        = session()->getFlashdata('error');
?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="profile-hero px-4 md:px-8 py-10 md:py-14 mb-8">
    <div class="relative z-10 max-w-5xl mx-auto">
        <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5">
            Requêtes
        </p>
        <h1 class="font-pfd text-4xl md:text-6xl font-light leading-[0.92] tracking-tight text-lightgrey">
            Consulter<br>
            <em class="italic text-gold">les requêtes</em>
        </h1>
    </div>
</div>

<main class="w-full max-w-5xl mx-auto px-4 md:px-8 pb-12 font-poppins">

    <?php if (!empty($status)): ?>
        <p class="text-xs text-green border border-green/30 rounded-lg px-3 py-2 mb-4"><?= esc($status) ?></p>
    <?php endif ?>
    <?php if (!empty($error)): ?>
        <p class="text-xs text-red border border-red/30 rounded-lg px-3 py-2 mb-4"><?= esc($error) ?></p>
    <?php endif ?>

    <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden mb-6">
        <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
        <div class="p-5">
            <?= view('itinerary/search/search_request_form', ['errors' => $searchErrors]) ?>
        </div>
    </div>

    <?php if (isset($journeys) && !empty($journeys)): ?>
        <div id="journey-results" class="flex flex-col gap-3"></div>
        <div id="journey-pagination" class="flex gap-2 mt-6"></div>

    <?php else: ?>
        <div class="flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 mt-6">
            <div class="w-8 h-8 rounded-lg bg-ocean-light flex items-center justify-center text-sm flex-shrink-0">🔍</div>
            <p class="text-xs text-grey italic">Aucun trajet trouvé pour cette recherche.</p>
        </div>
    <?php endif ?>

</main>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="/js/geocoding.js"></script>
<script src="/js/address-fields.js"></script>
<script src="/js/pagination.js"></script>
<script src="/js/journey-card.js"></script>
<script>
    let journeys = <?= json_encode($journeys ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
    //If there are datas available, load them
    if (journeys) {
        journeyPaginator.load(journeys)
    }
</script>

<?= $this->endSection() ?>