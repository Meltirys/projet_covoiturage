
<section class="mb-8 pt-8 border-t border-gold/20">
    <?php if (session()->getFlashdata('user_validation_success')): ?>
        <p class="text-xs text-green border border-green/30 rounded-lg px-3 py-2 mb-4"><?= session()->getFlashdata('user_validation_success') ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('user_validation_error')): ?>
        <p class="text-xs text-red border border-red/30 rounded-lg px-3 py-2 mb-4"><?= session()->getFlashdata('user_validation_error') ?></p>
    <?php endif ?>
    <h2 class="text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-4">Validation des utilisateurs</h2>
    <div id="resultsValidation" class="flex flex-col gap-3"></div>
    <div id="paginationValidation" class="flex gap-2 mt-6"></div>
</section>
