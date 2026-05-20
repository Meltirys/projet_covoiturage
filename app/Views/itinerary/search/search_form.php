<?= form_open('itinerary/search', ['class' => 'flex flex-col gap-4']) ?>

<!-- Départ / Arrivée -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6 items-start">

    <!-- Départ -->
    <div class="flex flex-col gap-1">
        <label for="start" class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Départ</label>
        <input class="address-input border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]"
            type="text" name="start_label" id="start"
            value="<?= set_value('start') ?>"
            placeholder="Entrez votre départ" required>
        <?php if (isset($errors['start'])): ?>
            <span class="text-xs text-red-500"><?= $errors['start'] ?></span>
        <?php endif ?>
        <div class="address-results"></div>
        <input type="hidden" name="start_lat">
        <input type="hidden" name="start_lon">
        <input type="hidden" name="start_city">
        <input type="hidden" name="start_postcode">
    </div>

    <!-- Arrivée -->
    <div class="flex flex-col gap-1">
        <label for="end" class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Arrivée</label>
        <input class="address-input border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]"
            type="text" name="end_label" id="end"
            value="<?= set_value('end') ?>"
            placeholder="Entrez votre destination" required>
        <?php if (isset($errors['end'])): ?>
            <span class="text-xs text-red-500"><?= $errors['end'] ?></span>
        <?php endif ?>
        <div class="address-results"></div>
        <input type="hidden" name="end_lat">
        <input type="hidden" name="end_long">
        <input type="hidden" name="end_city">
        <input type="hidden" name="end_postcode">
    </div>

</div>

<!-- Date et heure départ / Date et heure arrivée -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">

    <div class="flex flex-col gap-1">
        <label for="start-time" class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Date et heure de départ</label>
        <input type="datetime-local" name="start-time" id="start-time"
            value="<?= set_value('start-time') ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]" required>
    </div>

    <div class="flex flex-col gap-1">
        <label for="end-time" class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Date et heure d'arrivée</label>
        <input type="datetime-local" name="end-time" id="end-time"
            value="<?= set_value('end-time') ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]" required>
        <?php if (isset($errors['time'])): ?>
            <span class="text-xs text-red-500"><?= $errors['time'] ?></span>
        <?php endif ?>
    </div>

</div>

<!-- Filtres -->
<div class="flex flex-col gap-1">
    <label for="filter" class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Filtres</label>
    <input type="text" name="filter" id="filter"
        value="<?= set_value('filter') ?>"
        placeholder="Entrez votre filtre"
        class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]" required>
    <?php if (isset($errors['filter'])): ?>
        <span class="text-xs text-red-500"><?= $errors['filter'] ?></span>
    <?php endif ?>
</div>

<!-- Bouton -->
<div class="flex justify-center mt-2">
    <button type="submit" class="border border-[#253F72] text-[#253F72] bg-white text-sm font-poppins px-6 py-2 rounded-full hover:bg-[#253F72] hover:!text-white transition-all duration-200">
        Rechercher →
    </button>
</div>

<?= form_close() ?>