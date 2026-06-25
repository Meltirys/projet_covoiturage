<section class="mb-8 pt-8 border-t border-gold/20">
    <?php if (session()->getFlashdata('role_success')): ?>
        <p class="text-xs text-green border border-green/30 rounded-lg px-3 py-2 mb-4"><?= session()->getFlashdata('role_success') ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('role_error')): ?>
        <p class="text-xs text-red border border-red/30 rounded-lg px-3 py-2 mb-4"><?= session()->getFlashdata('role_error') ?></p>
    <?php endif ?>
    <h2 class="text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-4">Modifier le rôle d'un utilisateur</h2>
    <div class="mb-4">
        <label for="searchInputSuppression" class="text-[0.625rem] tracking-[0.12em] uppercase font-semibold text-grey block mb-2">Rechercher un utilisateur</label>
        <input type="text" id="searchUserRole"
            placeholder="Entrez le nom de l'utilisateur recherché"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors">
    </div>
    <div id="researchResultsRole" class="flex flex-col gap-3"></div>
    <div id="paginationRole" class="flex gap-2 mt-6"></div>
</section>