<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

    <header class="flex justify-between items-center mb-6">
        <h2 class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Gérer les signalements</h2>
    </header>
    <?php if (session()->getFlashdata('report_success')): ?>
        <p class="text-xs text-green-600 border border-green-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('report_success') ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('report_error')): ?>
        <p class="text-xs text-red-500 border border-red-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('report_error') ?></p>
    <?php endif ?>

    <div id="researchResultsReport" class="space-y-3">

    </div>
    <div id="paginationReport" class="space-x-3">

    </div>


</main>