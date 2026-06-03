<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

    <header class="flex justify-between items-center mb-6">
        <h2 class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Validation des utilisateurs</h2>
    </header>

    <?php if (session()->getFlashdata('user_validation_success')): ?>
        <p class="text-xs text-green-600 mb-3"><?= session()->getFlashdata('user_validation_success') ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('user_validation_error')): ?>
        <p class="text-xs text-red-500 mb-3"><?= session()->getFlashdata('user_validation_error') ?></p>
    <?php endif ?>

    <div id="resultsValidation" class="space-y-3">

    </div>
    <div id="paginationValidation" class="space-x-3">

    </div>
</main>