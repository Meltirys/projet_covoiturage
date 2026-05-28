<?= form_open('drive/search', ['class' => 'flex flex-col gap-4']) ?>

<!-- Départ / Arrivée -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6 items-start">

    <!-- Départ -->
    <div class="flex flex-col gap-1">
        <label for="start" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Départ</label>
        <input class="address-input border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey"
            type="text" name="start[label]" id="start"
            value="<?= set_value('start[label]') ?>"
            placeholder="Entrez votre départ" required>
        <?php $startError = $errors['start.label'] ?? $errors['start.lat'] ?? $errors['start.lon'] ?? $errors['start.city'] ?? $errors['start.postcode'] ?? null;
        if ($startError): ?>
            <span class="text-xs text-red-500"><?= esc($startError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="start[lat]">
        <input type="hidden" name="start[lon]">
        <input type="hidden" name="start[city]">
        <input type="hidden" name="start[postcode]">
    </div>

    <!-- Arrivée -->
    <div class="flex flex-col gap-1">
        <label for="end" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Arrivée</label>
        <input class="address-input border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey"
            type="text" name="end[label]" id="end"
            value="<?= set_value('end[label]') ?>"
            placeholder="Entrez votre destination" required>
        <?php $endError = $errors['end.label'] ?? $errors['end.lat'] ?? $errors['end.lon'] ?? $errors['end.city'] ?? $errors['end.postcode'] ?? null;
        if ($endError): ?>
            <span class="text-xs text-red-500"><?= esc($endError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="end[lat]">
        <input type="hidden" name="end[lon]">
        <input type="hidden" name="end[city]">
        <input type="hidden" name="end[postcode]">
    </div>

</div>

<!-- Date départ -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">

    <div class="flex flex-col gap-1">
        <label for="start-date" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Date</label>
        <input type="date" name="start-date" id="start-date"
            value="<?= set_value('start-date') ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['start-date'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['start-date']) ?></span>
        <?php endif ?>
    </div>

</div>
<!--  -->

<!-- Passagers -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">

    <div class="flex flex-col gap-1">
        <label for="passengers" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Passagers</label>
        <input type="number" name="passengers" id="passengers"
            placeholder="1"
            value="<?= set_value('passengers') ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
        <?php if (isset($errors['passengers'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['passengers']) ?></span>
        <?php endif ?>
    </div>

</div>
<!--  -->


<!-- Filtres -->
<div class="flex flex-col gap-1">
    <label for="filter" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Filtres (optionnel)</label>
    <input type="text" name="filter" id="filter"
        value="<?= set_value('filter') ?>"
        placeholder="Entrez vos filtres"
        class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
    <?php if (isset($errors['filter'])): ?>
        <span class="text-xs text-red-500"><?= esc($errors['filter']) ?></span>
    <?php endif ?>
</div>
<!--  -->

<!-- Validation -->
<div class="flex justify-center mt-2">
    <button type="submit" class="border border-bluegrey text-bluegrey bg-white text-sm font-poppins px-6 py-2 rounded-full hover:bg-bluegrey hover:!text-white transition-all duration-200">
        Rechercher →
    </button>
</div>
<!--  -->
<?= form_close() ?>