<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="profile-hero px-4 md:px-8 py-10 md:py-14 mb-8">
    <div class="relative z-10 max-w-5xl mx-auto">
        <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5">
            Demandes
        </p>
        <h1 class="font-pfd text-4xl md:text-6xl font-light leading-[0.92] tracking-tight text-lightgrey">
            Demandes<br>
            <em class="italic text-gold">de trajets</em>
        </h1>
    </div>
</div>

<main class="w-full max-w-5xl mx-auto px-4 md:px-8 pb-12 font-poppins">

    <?php if (!empty($requests)): ?>
        <div id="request-results" class="flex flex-col gap-3"></div>
        <div id="request-pagination" class="flex gap-2 mt-6"></div>
    <?php else: ?>
        <div class="flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 mt-6">
            <div class="w-8 h-8 rounded-lg bg-ocean-light flex items-center justify-center text-sm flex-shrink-0">🔍</div>
            <p class="text-xs text-grey italic">Aucune demande de trajet pour le moment.</p>
        </div>
    <?php endif ?>

</main>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="<?= base_url('js/pagination.js') ?>"></script>
<script src="<?= base_url('js/request-card.js') ?>"></script>
<script>
    let requests = <?= json_encode($requests ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
    if (requests && requests.length > 0 && typeof requestPaginator !== 'undefined' && requestPaginator) {
        requestPaginator.load(requests)
    }
</script>

<?= $this->endSection() ?>
