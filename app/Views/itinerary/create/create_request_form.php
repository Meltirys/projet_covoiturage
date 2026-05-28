<?= form_open('request/save', ['class' => 'flex flex-col gap-4']) ?>

<!-- Départ / Arrivée -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6 items-start">

    <!-- Départ -->
    <div class="flex flex-col gap-1">
        <label for="start" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Départ</label>
        <input class="address-input border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey"
            type="text" name="request[start][label]" id="request-start"
            value="<?= esc(old('request[start][label]')) ?>"
            placeholder="Entrez le point de départ" required>
        <?php $startError = $errors['start.label'] ?? $errors['start.lat'] ?? $errors['start.lon'] ?? $errors['start.city'] ?? $errors['start.postcode'] ?? null;
        if ($startError): ?>
            <span class="text-xs text-red-500"><?= esc($startError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="request[start][lat]" value="<?= esc(old('request[start][lat]')) ?>">
        <input type="hidden" name="request[start][lon]" value="<?= esc(old('request[start][lon]')) ?>">
        <input type="hidden" name="request[start][city]" value="<?= esc(old('request[start][city]')) ?>">
        <input type="hidden" name="request[start][postcode]" value="<?= esc(old('request[start][postcode]')) ?>">
    </div>

    <!-- Arrivée -->
    <div class="flex flex-col gap-1">
        <label for="end" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Arrivée</label>
        <input class="address-input border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey"
            type="text" name="request[end][label]" id="request-end"
            value="<?= esc(old('request[end][label]')) ?>"
            placeholder="Entrez votre destination" required>
        <?php $endError = $errors['end.label'] ?? $errors['end.lat'] ?? $errors['end.lon'] ?? $errors['end.city'] ?? $errors['end.postcode'] ?? null;
        if ($endError): ?>
            <span class="text-xs text-red-500"><?= esc($endError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="request[end][lat]" value="<?= esc(old('request[end][lat]')) ?>">
        <input type="hidden" name="request[end][lon]" value="<?= esc(old('request[end][lon]')) ?>">
        <input type="hidden" name="request[end][city]" value="<?= esc(old('request[end][city]')) ?>">
        <input type="hidden" name="request[end][postcode]" value="<?= esc(old('request[end][postcode]')) ?>">
    </div>

</div>
<!--  -->

<!-- Date/heure départ / Date/heure arrivée -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">

    <div class="flex flex-col gap-1">
        <label for="start-date" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Date de départ</label>
        <input type="date" name="request[start-date]" id="request-start-date"
            value="<?= esc(old('request[start-date]')) ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['start-date'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['start-date']) ?></span>
        <?php endif ?>
    </div>

    <div class="flex flex-col gap-1">
        <label for="start-time" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Heure de départ</label>
        <input type="time" name="request[start-time]" id="request-start-time"
            value="<?= esc(old('request[start-time]')) ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['start-time'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['start-time']) ?></span>
        <?php endif ?>
    </div>
</div>


<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">
    <div class="flex flex-col gap-1">
        <label for="end-date" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Date d'arrivée</label>
        <input type="date" name="request[end-date]" id="request-end-date"
            value="<?= esc(old('request[end-date]')) ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['end-date'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['end-date']) ?></span>
        <?php endif ?>
    </div>

    <div class="flex flex-col gap-1">
        <label for="end-time" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Heure d'arrivée</label>
        <input type="time" name="request[end-time]" id="request-end-time"
            value="<?= esc(old('request[end-time]')) ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['end-time'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['end-time']) ?></span>
        <?php endif ?>
    </div>

</div>
<!--  -->

<!-- Disponibilité -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">

    <div class="flex flex-col gap-1">
        <label for="range-start" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Début de disponibilité</label>
        <input type="time" name="request[range-start]" id="request-range-start"
            value="<?= esc(old('request[range-start]')) ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['range-start'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['range-start']) ?></span>
        <?php endif ?>
    </div>

    <div class="flex flex-col gap-1">
        <label for="range-end" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Fin de disponibilité</label>
        <input type="time" name="request[range-end]" id="request-range-end"
            value="<?= esc(old('request[range-end]')) ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['range-end'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['range-end']) ?></span>
        <?php endif ?>
    </div>
</div>
<!--  -->

<!-- Description -->
<div class="flex flex-col gap-1">
    <label for="description" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Description</label>
    <textarea name="request[description]" id="request-description"
        placeholder="Entrez une description"
        class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey"><?= esc(old('request[description]')) ?></textarea>
    <?php if (isset($errors['description'])): ?>
        <span class="text-xs text-red-500"><?= esc($errors['description']) ?></span>
    <?php endif ?>
</div>
<!--  -->

<!-- Options -->
<div class="flex flex-col gap-1">
    <label for="options" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Options</label>
    <input type="text" name="request[options]" id="request-options"
        value="<?= esc(old('request[options]')) ?>"
        placeholder="Entrez vos options"
        class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
    <?php if (isset($errors['options'])): ?>
        <span class="text-xs text-red-500"><?= esc($errors['options']) ?></span>
    <?php endif ?>
</div>
<!--  -->

<!-- Validation -->
<div class="flex justify-center mt-2">
    <button type="submit" class="border border-bluegrey text-bluegrey bg-white text-sm font-poppins px-6 py-2 rounded-full hover:bg-bluegrey hover:!text-white transition-all duration-200">
        Créer le trajet →
    </button>
</div>
<!--  -->

<?= form_close() ?>