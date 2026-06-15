<?= form_open('drive/edit/' . $journey['id_journey_drive'], ['class' => 'flex flex-col gap-4']) ?>

<!-- Départ / Arrivée -->
<div class=" grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6 items-start">

    <!-- Départ -->
    <div class="flex flex-col gap-1">
        <label for="drive-start" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Départ</label>
        <input class="address-input border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey"
            type="text" name="drive[start][address]" id="drive-start"
            value="<?= esc(old('drive.start.address', $journey['departure_address'])) ?>"
            placeholder="Entrez le point de départ" required>
        <?php $startError = $errors['start.address'] ?? $errors['start.label'] ?? $errors['start.lat'] ?? $errors['start.lon'] ?? $errors['start.city'] ?? $errors['start.postcode'] ?? null;
        if ($startError): ?>
            <span class="text-xs text-red-500"><?= esc($startError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="drive[start][label]" value="<?= esc(old('drive.start.label', $journey['departure_label'])) ?>">
        <input type="hidden" name="drive[start][lat]" value="<?= esc(old('drive.start.lat', $journey['departure_lat'])) ?>">
        <input type="hidden" name="drive[start][lon]" value="<?= esc(old('drive.start.lon', $journey['departure_lon'])) ?>">
        <input type="hidden" name="drive[start][city]" value="<?= esc(old('drive.start.city', $journey['departure_city'])) ?>">
        <input type="hidden" name="drive[start][postcode]" value="<?= esc(old('drive.start.postcode', $journey['departure_postcode'])) ?>">
    </div>

    <!-- Arrivée -->
    <div class="flex flex-col gap-1">
        <label for="drive-end" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Arrivée</label>
        <input class="address-input border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey"
            type="text" name="drive[end][address]" id="drive-end"
            value="<?= esc(old('drive.end.address', $journey['arrival_address'])) ?>"
            placeholder="Entrez votre destination" required>
        <?php $endError = $errors['end.address'] ?? $errors['end.label'] ?? $errors['end.lat'] ?? $errors['end.lon'] ?? $errors['end.city'] ?? $errors['end.postcode'] ?? $errors['end'] ?? null;
        if ($endError): ?>
            <span class="text-xs text-red-500"><?= esc($endError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="drive[end][label]" value="<?= esc(old('drive.end.label', $journey['arrival_label'])) ?>">
        <input type="hidden" name="drive[end][lat]" value="<?= esc(old('drive.end.lat', $journey['arrival_lat'])) ?>">
        <input type="hidden" name="drive[end][lon]" value="<?= esc(old('drive.end.lon', $journey['arrival_lon'])) ?>">
        <input type="hidden" name="drive[end][city]" value="<?= esc(old('drive.end.city', $journey['arrival_city'])) ?>">
        <input type="hidden" name="drive[end][postcode]" value="<?= esc(old('drive.end.postcode', $journey['arrival_postcode'])) ?>">
    </div>

</div>
<!--  -->

<!-- Arrêts -->
<div class="flex flex-col gap-1">
    <label class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">
        Arrêts <span class="normal-case font-normal tracking-normal text-[#9AA5B4]">(optionnels)</span>
    </label>
    <div id="stops-container" class="flex flex-col gap-2">
        <?php $stops = old('drive.stops') ?? $journey['stages'] ?? [[]]; ?>
        <?php foreach ($stops as $index => $stop): ?>
            <div class="stop address-field flex flex-col gap-1">
                <input type="text" name="drive[stops][<?= $index ?>][address]"
                    class="stop-input border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey"
                    value="<?= esc($stop['address'] ?? '') ?>"
                    placeholder="Entrer un arrêt">
                <input type="hidden" name="drive[stops][<?= $index ?>][label]" value="<?= esc($stop['label'] ?? '') ?>">
                <input type="hidden" name="drive[stops][<?= $index ?>][lat]" value="<?= esc($stop['lat'] ?? '') ?>">
                <input type="hidden" name="drive[stops][<?= $index ?>][lon]" value="<?= esc($stop['lon'] ?? '') ?>">
                <input type="hidden" name="drive[stops][<?= $index ?>][city]" value="<?= esc($stop['city'] ?? '') ?>">
                <input type="hidden" name="drive[stops][<?= $index ?>][postcode]" value="<?= esc($stop['postcode'] ?? '') ?>">
                <div class="results"></div>
                <?php if ($index > 0): ?>
                    <button type="button" class="remove-stop text-xs text-[rgba(37,63,114,0.5)] underline text-right bg-transparent border-none cursor-pointer">
                        Retirer
                    </button>
                <?php endif; ?>
                <?php if (isset($errors['stops'])): ?>
                    <span class="text-xs text-red-500"><?= esc($errors['stops']) ?></span>
                <?php endif ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!--  -->

<!-- Date départ -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">

    <div class="flex flex-col gap-1">
        <label for="drive-start-date" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Date de départ</label>
        <input type="date" name="drive[start-date]" id="drive-start-date"
            value="<?= esc(old('drive.start-date', $journey['departure_date'])) ?>"
            class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['start-date'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['start-date']) ?></span>
        <?php endif ?>
    </div>

    <div class="flex flex-col gap-1">
        <label for="drive-start-time" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Heure de départ</label>
        <input type="time" name="drive[start-time]" id="drive-start-time"
            value="<?= esc(old('drive.start-time', $journey['departure_time'])) ?>"
            class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['start-time'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['start-time']) ?></span>
        <?php endif ?>
    </div>
</div>
<!--  -->

<!-- Véhicule / Places -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">

    <div class="flex flex-col gap-1">
        <label for="drive-car" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Véhicule</label>
        <select name="drive[car]" id="drive-car" required
            class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey bg-white">
            <option value="">-- Choisissez le véhicule --</option>
            <?php if (isset($cars)): ?>
                <?php foreach ($cars as $car): ?>
                    <option value="<?= $car['id_car'] ?>" <?= $selectedCar == $car['id_car'] ? 'selected' : '' ?>><?= esc($car['brand']) . ' ' . esc($car['model']) ?></option>
                <?php endforeach ?>
            <?php endif ?>
        </select>
        <?php if (isset($errors['car'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['car']) ?></span>
        <?php endif ?>
    </div>

    <div class="flex flex-col gap-1">
        <label for="drive-seats" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Nombre de places</label>
        <select name="drive[seats]" id="drive-seats" required
            class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey bg-white">
        </select>
        <?php if (isset($errors['seats'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['seats']) ?></span>
        <?php endif ?>
    </div>

</div>
<!--  -->

<!-- Options -->
<div class="flex flex-col gap-1">
    <label for="drive-options" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Options</label>
    <input type="text" name="drive[options]" id="drive-options"
        value="<?= esc(old('drive.options', $journey['options'] ?? "")) ?>"
        placeholder="Entrez vos options"
        class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
    <?php if (isset($errors['options'])): ?>
        <span class="text-xs text-red-500"><?= esc($errors['options']) ?></span>
    <?php endif ?>
</div>
<!--  -->

<!-- Confirmation -->
<div class="flex justify-center mt-2">
    <button type="submit" class="border border-bluegrey text-bluegrey bg-white text-sm font-poppins px-6 py-2 rounded-full hover:bg-bluegrey hover:!text-white transition-all duration-200">
        Sauvegarder les modifications →
    </button>
</div>
<!--  -->

<?= form_close() ?>