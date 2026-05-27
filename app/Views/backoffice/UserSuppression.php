<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

    <header class="flex justify-between items-center mb-6">
        <h2 class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Supprimer un utilisateur</h2>
    </header>
    <?php if (session()->getFlashdata('suppression_success')): ?>
        <p class="text-xs text-green-600 border border-green-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('suppression_success') ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('suppression_error')): ?>
        <p class="text-xs text-red-500 border border-red-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('suppression_error') ?></p>
    <?php endif ?>
    <div class="mb-6">
        <label for="searchUser" class="block text-sm font-poppins text-gray-700 mb-1">Rechercher un utilisateur</label>
        <input type="text" id="searchInputSuppression" placeholder="Entrez le nom de l'utilisateur recherché" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-babyblue focus:border-transparent">
    </div>

    <div id="researchResultsSuppression" class="space-y-3">

    </div>

</main>

