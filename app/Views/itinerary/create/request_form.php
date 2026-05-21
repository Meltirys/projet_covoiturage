<?= form_open('itinerary/create', ['class' => 'flex flex-col gap-4']) ?>

<!-- Départ / Arrivée -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6 items-start">

    <!-- Départ -->
    <div class="flex flex-col gap-1">
        <label for="start" class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Départ</label>
        <input class="address-input border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]"
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
        <label for="end" class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Arrivée</label>
        <input class="address-input border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]"
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

<!-- Arrêts -->
<div class="flex flex-col gap-1">
    <label for="stop" class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">
        Arrêts <span class="normal-case font-normal tracking-normal text-[#9AA5B4]">(optionnels)</span>
    </label>
    <div id="stops-container" class="flex flex-col gap-2">
        <?php $stops = old('stops') ?? [[]]; ?>
        <?php foreach ($stops as $index => $stop): ?>
            <div class="stop address-field flex flex-col gap-1">
                <input type="text" name="stops[<?= $index ?>][label]"
                    class="stop-input border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]"
                    value="<?= esc($stop['label'] ?? '') ?>"
                    placeholder="Entrer un arrêt">
                <input type="hidden" name="stops[<?= $index ?>][lat]" value="<?= esc($stop['lat'] ?? '') ?>">
                <input type="hidden" name="stops[<?= $index ?>][lon]" value="<?= esc($stop['lon'] ?? '') ?>">
                <input type="hidden" name="stops[<?= $index ?>][city]" value="<?= esc($stop['city'] ?? '') ?>">
                <input type="hidden" name="stops[<?= $index ?>][postcode]" value="<?= esc($stop['postcode'] ?? '') ?>">
                <div class="results"></div>
                <?php if ($index > 0): ?>
                    <button type="button" class="remove-stop text-xs text-[rgba(37,63,114,0.5)] underline text-right bg-transparent border-none cursor-pointer">
                        Retirer
                    </button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if (isset($errors['stops'])): ?>
        <span class="text-xs text-red-500"><?= $errors['stops'] ?></span>
    <?php endif ?>
</div>

<!-- Heure départ / Heure arrivée -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">

    <div class="flex flex-col gap-1">
        <label for="start-date" class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Date de départ</label>
        <input type="date" name="start-date" id="start-date"
            value="<?= set_value('start-date') ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]" required>
    </div>

    <div class="flex flex-col gap-1">
        <label for="start-time" class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Heure de départ</label>
        <input type="time" name="start-time" id="start-time"
            value="<?= set_value('start-time') ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]" required>
    </div>




    <div class="flex flex-col gap-1">
        <label for="end-date" class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Date d'arrivée</label>
        <input type="date" name="end-date" id="end-date"
            value="<?= set_value('end-date') ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]" required>
        <?php if (isset($errors['time'])): ?>
            <span class="text-xs text-red-500"><?= $errors['time'] ?></span>
        <?php endif ?>
    </div>

    <div class="flex flex-col gap-1">
        <label for="end-time" class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Heure d'arrivée</label>
        <input type="time" name="end-time" id="end-time"
            value="<?= set_value('end-time') ?>"
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]" required>
        <?php if (isset($errors['time'])): ?>
            <span class="text-xs text-red-500"><?= $errors['time'] ?></span>
        <?php endif ?>
    </div>

</div>

<!-- Véhicule / Places -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">

    <div class="flex flex-col gap-1">
        <label for="car" class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Véhicule</label>
        <select name="car" id="car" required
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72] bg-white">
            <option value="">-- Choisissez le véhicule --</option>
            <?php if (isset($cars)): ?>
                <?php foreach ($cars as $car): ?>
                    <option value="<?= $car['id_car'] ?>"><?= $car['brand'] ?> - <?= $car['model'] ?></option>
                <?php endforeach ?>
            <?php endif ?>
        </select>
        <?php if (isset($errors['car'])): ?>
            <span class="text-xs text-red-500"><?= $errors['car'] ?></span>
        <?php endif ?>
    </div>

    <div class="flex flex-col gap-1">
        <label for="seats" class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Nombre de places</label>
        <select name="seats" id="seats" required
            class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72] bg-white">
        </select>
        <?php if (isset($errors['seats'])): ?>
            <span class="text-xs text-red-500"><?= $errors['seats'] ?></span>
        <?php endif ?>
    </div>

</div>

<!-- Options -->
<div class="flex flex-col gap-1">
    <label for="options" class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Options</label>
    <input type="text" name="options" id="options"
        value="<?= set_value('options') ?>"
        placeholder="Entrez vos options"
        class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]">
    <?php if (isset($errors['options'])): ?>
        <span class="text-xs text-red-500"><?= $errors['options'] ?></span>
    <?php endif ?>
</div>

<!-- Bouton -->
<div class="flex justify-center mt-2">
    <button type="submit" class="border border-[#253F72] text-[#253F72] bg-white text-sm font-poppins px-6 py-2 rounded-full hover:bg-[#253F72] hover:!text-white transition-all duration-200">
        Créer le trajet →
    </button>
</div>

<?= form_close() ?>