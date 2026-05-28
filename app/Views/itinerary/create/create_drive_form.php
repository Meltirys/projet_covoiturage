<?= form_open('drive/save', ['class' => 'flex flex-col gap-4']) ?>

<!-- Départ / Arrivée -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6 items-start">

    <!-- Départ -->
    <div class="flex flex-col gap-1">
        <label for="drive-start" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Départ</label>
        <input class="address-input border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey"
            type="text" name="drive[start][label]" id="drive-start"
            value="<?= old('drive.start.label') ?>"
            placeholder="Entrez le point de départ" required>
        <?php $startError = $errors['start.label'] ?? $errors['start.lat'] ?? $errors['start.lon'] ?? $errors['start.city'] ?? $errors['start.postcode'] ?? null;
        if ($startError): ?>
            <span class="text-xs text-red-500"><?= esc($startError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="drive[start][lat]" value="<?= old('drive.start.lat') ?>">
        <input type="hidden" name="drive[start][lon]" value="<?= old('drive.start.lon') ?>">
        <input type="hidden" name="drive[start][city]" value="<?= old('drive.start.city') ?>">
        <input type="hidden" name="drive[start][postcode]" value="<?= old('drive.start.postcode') ?>">
    </div>

    <!-- Arrivée -->
    <div class="flex flex-col gap-1">
        <label for="drive-end" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Arrivée</label>
        <input class="address-input border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey"
            type="text" name="drive[end][label]" id="drive-end"
            value="<?= old('drive.end.label') ?>"
            placeholder="Entrez votre destination" required>
        <?php $endError = $errors['end.label'] ?? $errors['end.lat'] ?? $errors['end.lon'] ?? $errors['end.city'] ?? $errors['end.postcode'] ?? null;
        if ($endError): ?>
            <span class="text-xs text-red-500"><?= esc($endError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="drive[end][lat]" value="<?= old('drive.end.lat') ?>">
        <input type="hidden" name="drive[end][lon]" value="<?= old('drive.end.lon') ?>">
        <input type="hidden" name="drive[end][city]" value="<?= old('drive.end.city') ?>">
        <input type="hidden" name="drive[end][postcode]" value="<?= old('drive.end.postcode') ?>">
    </div>

</div>
<!--  -->

<!-- Arrêts -->
<div class="flex flex-col gap-1">
    <label class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">
        Arrêts <span class="normal-case font-normal tracking-normal text-[#9AA5B4]">(optionnels)</span>
    </label>
    <div id="stops-container" class="flex flex-col gap-2">
        <?php $stops = old('drive.stops') ?? [[]]; ?>
        <?php foreach ($stops as $index => $stop): ?>
            <div class="stop address-field flex flex-col gap-1">
                <input type="text" name="drive[stops][<?= $index ?>][label]"
                    class="stop-input border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey"
                    value="<?= esc($stop['label'] ?? '') ?>"
                    placeholder="Entrer un arrêt">
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
                <?php $stopError = $errors["stops.$index.label"] ?? $errors["stops.$index.lat"] ?? $errors["stops.$index.lon"] ?? $errors["stops.$index.city"] ?? $errors["stops.$index.postcode"] ?? null;
                if ($stopError): ?>
                    <span class="text-xs text-red-500"><?= esc($stopError) ?></span>
                <?php endif ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!--  -->

<!-- Date départ / Heure départ -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">

    <div class="flex flex-col gap-1">
        <label for="drive-start-date" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Date de départ</label>
        <input type="date" name="drive[start-date]" id="drive-start-date"
            value="<?= old('drive.start-date') ?>"
            class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['start-date'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['start-date']) ?></span>
        <?php endif ?>
    </div>

    <div class="flex flex-col gap-1">
        <label for="drive-start-time" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Heure de départ</label>
        <input type="time" name="drive[start-time]" id="drive-start-time"
            value="<?= old('drive.start-time') ?>"
            class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['start-time'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['start-time']) ?></span>
        <?php endif ?>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">
    <!-- Date arrivée / Heure arrivée -->
    <div class="flex flex-col gap-1">
        <label for="drive-end-date" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Date d'arrivée</label>
        <input type="date" name="drive[end-date]" id="drive-end-date"
            value="<?= old('drive.end-date') ?>"
            class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['end-date'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['end-date']) ?></span>
        <?php endif ?>
    </div>

    <div class="flex flex-col gap-1">
        <label for="drive-end-time" class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Heure d'arrivée</label>
        <input type="time" name="drive[end-time]" id="drive-end-time"
            value="<?= old('drive.end-time') ?>"
            class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" required>
        <?php if (isset($errors['end-time'])): ?>
            <span class="text-xs text-red-500"><?= esc($errors['end-time']) ?></span>
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
                    <option value="<?= $car['id_car'] ?>" <?= set_select('drive[car]', $car['id_car']) ?>><?= esc($car['label']) ?></option>
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
        value="<?= old('drive.options') ?>"
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
        Créer le trajet →
    </button>
</div>
<!--  -->

<?= form_close() ?>