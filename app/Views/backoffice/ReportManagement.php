<section class="mb-8">
    <?php if (session()->getFlashdata('report_success')): ?>
        <p class="text-xs text-green border border-green/30 rounded-lg px-3 py-2 mb-4"><?= session()->getFlashdata('report_success') ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('report_error')): ?>
        <p class="text-xs text-red border border-red/30 rounded-lg px-3 py-2 mb-4"><?= session()->getFlashdata('report_error') ?></p>
    <?php endif ?>
    <h2 class="text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-4">Gérer les signalements</h2>
    <div id="researchResultsReport" class="flex flex-col gap-3"></div>
    <div id="paginationReport" class="flex gap-2 mt-6"></div>
</section>