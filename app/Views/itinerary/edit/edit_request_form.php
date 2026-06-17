<?= form_open('request/update/' . $request['id_journey_request']) ?>


<!-- Départ / Arrivée -->
<div class=" grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6 items-start">

    <!-- Départ -->
    <div class="flex flex-col gap-1">
        <label for="request-start" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Départ</label>
        <input class="address-input border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey"
            type="text" name="request[start][address]" id="request-start"
            value="<?= esc(old('request.start.address', $journey['departure_address'])) ?>"
            placeholder="Entrez le point de départ" required>
        <?php $startError = $errors['start.address'] ?? $errors['start.label'] ?? $errors['start.lat'] ?? $errors['start.lon'] ?? $errors['start.city'] ?? $errors['start.postcode'] ?? null;
        if ($startError): ?>
            <span class="text-xs text-red-500"><?= esc($startError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="request[start][label]" value="<?= esc(old('request.start.label', $journey['departure_label'])) ?>">
        <input type="hidden" name="request[start][lat]" value="<?= esc(old('request.start.lat', $journey['departure_lat'])) ?>">
        <input type="hidden" name="request[start][lon]" value="<?= esc(old('request.start.lon', $journey['departure_lon'])) ?>">
        <input type="hidden" name="request[start][city]" value="<?= esc(old('request.start.city', $journey['departure_city'])) ?>">
        <input type="hidden" name="request[start][postcode]" value="<?= esc(old('request.start.postcode', $journey['departure_postcode'])) ?>">
    </div>

    <!-- Arrivée -->
    <div class="flex flex-col gap-1">
        <label for="request-end" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Arrivée</label>
        <input class="address-input border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey"
            type="text" name="request[end][address]" id="request-end"
            value="<?= esc(old('request.end.address', $journey['arrival_address'])) ?>"
            placeholder="Entrez votre destination" required>
        <?php $endError = $errors['end.address'] ?? $errors['end.label'] ?? $errors['end.lat'] ?? $errors['end.lon'] ?? $errors['end.city'] ?? $errors['end.postcode'] ?? $errors['end'] ?? null;
        if ($endError): ?>
            <span class="text-xs text-red-500"><?= esc($endError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="request[end][label]" value="<?= esc(old('request.end.label', $journey['arrival_label'])) ?>">
        <input type="hidden" name="request[end][lat]" value="<?= esc(old('request.end.lat', $journey['arrival_lat'])) ?>">
        <input type="hidden" name="request[end][lon]" value="<?= esc(old('request.end.lon', $journey['arrival_lon'])) ?>">
        <input type="hidden" name="request[end][city]" value="<?= esc(old('request.end.city', $journey['arrival_city'])) ?>">
        <input type="hidden" name="request[end][postcode]" value="<?= esc(old('request.end.postcode', $journey['arrival_postcode'])) ?>">
    </div>

</div>
<!--  -->

<!-- Date -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">

    <div class="flex flex-col gap-1">
        <label for="request-date" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Date</label>
        <input type="date" name="request[date]" id="request-date"
            value="<?= esc(old('request.date', $journey['departure_date'])) ?>"
            class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['date'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['date']) ?></span>
        <?php endif ?>
    </div>
</div>
<!--  -->

<!-- Nombre de participants -->
<div class="flex flex-col gap-1">
    <label for="request-seats" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Nombre de participants</label>
    <?php $selectedPlaces = session()->getFlashdata('car_success') ? '1' : old('places', '1'); ?>
    <select id="places" name="places"
        class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
        <option value="1" <?= $selectedPlaces === '1' ? 'selected' : '' ?>>1</option>
        <option value="2" <?= $selectedPlaces === '2' ? 'selected' : '' ?>>2</option>
        <option value="3" <?= $selectedPlaces === '3' ? 'selected' : '' ?>>3</option>
        <option value="4" <?= $selectedPlaces === '4' ? 'selected' : '' ?>>4</option>
        <option value="5" <?= $selectedPlaces === '5' ? 'selected' : '' ?>>5</option>
        <option value="6" <?= $selectedPlaces === '6' ? 'selected' : '' ?>>6</option>
        <option value="7" <?= $selectedPlaces === '7' ? 'selected' : '' ?>>7</option>
    </select>
    <?php if (isset($errors['seats'])): ?>
        <span class="text-xs text-red-500"><?= esc($errors['seats']) ?></span>
    <?php endif ?>
</div>
<!--  -->

<!-- Options -->
<div class="flex flex-col gap-1">
    <label for="request-options" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Options</label>
    <input type="text" name="request[options]" id="request-options"
        value="<?= esc(old('request.options', $journey['options'] ?? "")) ?>"
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