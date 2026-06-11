<?= form_open('drive/save', ['class' => 'flex flex-col gap-4']) ?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6 items-start">

    <div class="flex flex-col gap-1">
        <label for="drive-start" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Départ</label>
        <input class="address-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors"
            type="text" name="drive[start][address]" id="drive-start"
            value="<?= esc(old('drive.start.address')) ?>"
            placeholder="Entrez le point de départ" required>
        <?php $startError = $errors['start.address'] ?? $errors['start.label'] ?? $errors['start.lat'] ?? $errors['start.lon'] ?? $errors['start.city'] ?? $errors['start.postcode'] ?? null;
        if ($startError): ?>
            <span class="text-xs text-red"><?= esc($startError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="drive[start][label]" value="<?= esc(old('drive.start.label')) ?>">
        <input type="hidden" name="drive[start][lat]" value="<?= esc(old('drive.start.lat')) ?>">
        <input type="hidden" name="drive[start][lon]" value="<?= esc(old('drive.start.lon')) ?>">
        <input type="hidden" name="drive[start][city]" value="<?= esc(old('drive.start.city')) ?>">
        <input type="hidden" name="drive[start][postcode]" value="<?= esc(old('drive.start.postcode')) ?>">
    </div>

    <div class="flex flex-col gap-1">
        <label for="drive-end" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Arrivée</label>
        <input class="address-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors"
            type="text" name="drive[end][address]" id="drive-end"
            value="<?= esc(old('drive.end.address')) ?>"
            placeholder="Entrez votre destination" required>
        <?php $endError = $errors['end.address'] ?? $errors['end.label'] ?? $errors['end.lat'] ?? $errors['end.lon'] ?? $errors['end.city'] ?? $errors['end.postcode'] ?? $errors['end'] ?? null;
        if ($endError): ?>
            <span class="text-xs text-red"><?= esc($endError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="drive[end][label]" value="<?= esc(old('drive.end.label')) ?>">
        <input type="hidden" name="drive[end][lat]" value="<?= esc(old('drive.end.lat')) ?>">
        <input type="hidden" name="drive[end][lon]" value="<?= esc(old('drive.end.lon')) ?>">
        <input type="hidden" name="drive[end][city]" value="<?= esc(old('drive.end.city')) ?>">
        <input type="hidden" name="drive[end][postcode]" value="<?= esc(old('drive.end.postcode')) ?>">
    </div>

</div>

<div class="flex flex-col gap-1">
    <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">
        Arrêts <span class="normal-case font-normal tracking-normal text-grey">(optionnels)</span>
    </label>
    <div id="stops-container" class="flex flex-col gap-2">
        <?php $stops = old('drive.stops') ?? [[]]; ?>
        <?php foreach ($stops as $index => $stop): ?>
            <div class="stop address-field flex flex-col gap-1">
                <input type="text" name="drive[stops][<?= $index ?>][address]"
                    class="stop-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors"
                    value="<?= esc($stop['address'] ?? '') ?>"
                    placeholder="Entrer un arrêt">
                <input type="hidden" name="drive[stops][<?= $index ?>][label]" value="<?= esc($stop['label'] ?? '') ?>">
                <input type="hidden" name="drive[stops][<?= $index ?>][lat]" value="<?= esc($stop['lat'] ?? '') ?>">
                <input type="hidden" name="drive[stops][<?= $index ?>][lon]" value="<?= esc($stop['lon'] ?? '') ?>">
                <input type="hidden" name="drive[stops][<?= $index ?>][city]" value="<?= esc($stop['city'] ?? '') ?>">
                <input type="hidden" name="drive[stops][<?= $index ?>][postcode]" value="<?= esc($stop['postcode'] ?? '') ?>">
                <div class="results"></div>
                <?php if ($index > 0): ?>
                    <button type="button" class="remove-stop text-xs text-grey hover:text-red underline text-right bg-transparent border-none cursor-pointer transition-colors">
                        Retirer
                    </button>
                <?php endif; ?>
                <?php $stopError = $errors["stops.$index.address"] ?? $errors["stops.$index.label"] ?? $errors["stops.$index.lat"] ?? $errors["stops.$index.lon"] ?? $errors["stops.$index.city"] ?? $errors["stops.$index.postcode"] ?? null;
                if ($stopError): ?>
                    <span class="text-xs text-red"><?= esc($stopError) ?></span>
                <?php endif ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">
    <div class="flex flex-col gap-1">
        <label for="drive-start-date" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Date de départ</label>
        <input type="date" name="drive[start-date]" id="drive-start-date"
            value="<?= esc(old('drive.start-date')) ?>"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" required>
        <?php if (isset($errors['start-date'])): ?>
            <span class="text-xs text-red"><?= esc($errors['start-date']) ?></span>
        <?php endif ?>
    </div>
    <div class="flex flex-col gap-1">
        <label for="drive-start-time" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Heure de départ</label>
        <input type="time" name="drive[start-time]" id="drive-start-time"
            value="<?= esc(old('drive.start-time')) ?>"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" required>
        <?php if (isset($errors['start-time'])): ?>
            <span class="text-xs text-red"><?= esc($errors['start-time']) ?></span>
        <?php endif ?>
    </div>
    <div class="flex flex-col gap-2">
        <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">
            Récurrence <span class="normal-case font-normal tracking-normal text-grey">(optionnel)</span>
        </label>
        <div class="flex flex-wrap gap-3">
            <?php foreach (['monday' => 'Lun', 'tuesday' => 'Mar', 'wednesday' => 'Mer', 'thursday' => 'Jeu', 'friday' => 'Ven', 'saturday' => 'Sam', 'sunday' => 'Dim'] as $value => $label): ?>
                <label class="flex items-center gap-1 text-sm text-lightgrey cursor-pointer">
                    <input type="checkbox" name="drive[recurrence][]" value="<?= $value ?>"
                        <?= in_array($value, old('drive.recurrence', [])) ? 'checked' : '' ?>>
                    <?= $label ?>
                </label>
            <?php endforeach ?>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">
    <div class="flex flex-col gap-1">
        <label for="drive-car" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Véhicule</label>
        <select name="drive[car]" id="drive-car" required
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors">
            <option value="">-- Choisissez le véhicule --</option>
            <?php if (isset($cars)): ?>
                <?php foreach ($cars as $car): ?>
                    <option value="<?= $car['id_car'] ?>" <?= set_select('drive[car]', $car['id_car']) ?>><?= esc($car['label']) ?></option>
                <?php endforeach ?>
            <?php endif ?>
        </select>
        <?php if (isset($errors['car'])): ?>
            <span class="text-xs text-red"><?= esc($errors['car']) ?></span>
        <?php endif ?>
    </div>
    <div class="flex flex-col gap-1">
        <label for="drive-seats" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Nombre de places</label>
        <select name="drive[seats]" id="drive-seats" required
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors">
        </select>
        <?php if (isset($errors['seats'])): ?>
            <span class="text-xs text-red"><?= esc($errors['seats']) ?></span>
        <?php endif ?>
    </div>
</div>

<div class="flex flex-col gap-1">
    <label for="drive-options" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">
        Options <span class="normal-case font-normal tracking-normal text-grey">(optionnel)</span>
    </label>
    <input type="text" name="drive[options]" id="drive-options"
        value="<?= esc(old('drive.options')) ?>"
        placeholder="Entrez vos options"
        class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors">
    <?php if (isset($errors['options'])): ?>
        <span class="text-xs text-red"><?= esc($errors['options']) ?></span>
    <?php endif ?>
</div>

<div class="flex justify-end mt-2">
    <button type="submit"
        class="bg-gold text-ocean font-semibold text-sm px-6 py-2 rounded-full hover:opacity-90 transition-opacity cursor-pointer">
        Créer le trajet →
    </button>
</div>

<?= form_close() ?>