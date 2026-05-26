<?= form_open('request/save', ['class' => 'flex flex-col gap-4']) ?>

<!-- Départ / Arrivée -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6 items-start">

    <!-- Départ -->
    <div class="flex flex-col gap-1">
        <label for="start" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Départ</label>
        <input class="address-input border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey"
            type="text" name="start[label]" id="start"
            value="<?= set_value('start[label]') ?>"
            placeholder="Entrez le point de départ" required>
        <?php if (isset($errors['start'])): ?>
            <span class="text-xs text-red-500"><?= $errors['start'] ?></span>
        <?php endif ?>
        <div class="address-results"></div>
        <input type="hidden" name="start[lat]">
        <input type="hidden" name="start[lon]">
        <input type="hidden" name="start[city]">
        <input type="hidden" name="start[postcode]">
    </div>

    <!-- Arrivée -->
    <div class="flex flex-col gap-1">
        <label for="end" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Arrivée</label>
        <input class="address-input border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey"
            type="text" name="end[label]" id="end"
            value="<?= set_value('end[label]') ?>"
            placeholder="Entrez votre destination" required>
        <?php if (isset($errors['end'])): ?>
            <span class="text-xs text-red-500"><?= $errors['end'] ?></span>
        <?php endif ?>
        <div class="address-results"></div>
        <input type="hidden" name="end[lat]">
        <input type="hidden" name="end[lon]">
        <input type="hidden" name="end[city]">
        <input type="hidden" name="end[postcode]">
    </div>

</div>
<!--  -->

<!-- Heure départ / Heure arrivée -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">

    <div class="flex flex-col gap-1">
        <label for="start-date" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Date de départ</label>
        <input type="date" name="start-date" id="start-date"
            value="<?= set_value('start-date') ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
    </div>

    <div class="flex flex-col gap-1">
        <label for="start-time" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Heure de départ</label>
        <input type="time" name="start-time" id="start-time"
            value="<?= set_value('start-time') ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
    </div>




    <div class="flex flex-col gap-1">
        <label for="end-date" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Date d'arrivée</label>
        <input type="date" name="end-date" id="end-date"
            value="<?= set_value('end-date') ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['time'])): ?>
            <span class="text-xs text-red-500"><?= $errors['time'] ?></span>
        <?php endif ?>
    </div>

    <div class="flex flex-col gap-1">
        <label for="end-time" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Heure d'arrivée</label>
        <input type="time" name="end-time" id="end-time"
            value="<?= set_value('end-time') ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['time'])): ?>
            <span class="text-xs text-red-500"><?= $errors['time'] ?></span>
        <?php endif ?>
    </div>

</div>
<!--  -->

<!-- Options -->
<div class="flex flex-col gap-1">
    <label for="options" class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Options</label>
    <input type="text" name="options" id="options"
        value="<?= set_value('options') ?>"
        placeholder="Entrez vos options"
        class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
    <?php if (isset($errors['options'])): ?>
        <span class="text-xs text-red-500"><?= $errors['options'] ?></span>
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