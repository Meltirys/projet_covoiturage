<?= form_open('request/save', ['class' => 'flex flex-col gap-4']) ?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6 items-start">

    <div class="flex flex-col gap-1">
        <label for="request-start" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Départ</label>
        <input class="address-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors"
            type="text" name="request[start][address]" id="request-start"
            value="<?= esc(old('request[start][address]')) ?>"
            placeholder="Entrez le point de départ" required>
        <?php $startError = $errors['start.address'] ?? $errors['start.label'] ?? $errors['start.lat'] ?? $errors['start.lon'] ?? $errors['start.city'] ?? $errors['start.postcode'] ?? null;
        if ($startError): ?>
            <span class="text-xs text-red"><?= esc($startError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="request[start][label]"    value="<?= esc(old('request[start][label]')) ?>">
        <input type="hidden" name="request[start][lat]"      value="<?= esc(old('request[start][lat]')) ?>">
        <input type="hidden" name="request[start][lon]"      value="<?= esc(old('request[start][lon]')) ?>">
        <input type="hidden" name="request[start][city]"     value="<?= esc(old('request[start][city]')) ?>">
        <input type="hidden" name="request[start][postcode]" value="<?= esc(old('request[start][postcode]')) ?>">
    </div>

    <div class="flex flex-col gap-1">
        <label for="request-end" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Arrivée</label>
        <input class="address-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors"
            type="text" name="request[end][address]" id="request-end"
            value="<?= esc(old('request[end][address]')) ?>"
            placeholder="Entrez votre destination" required>
        <?php $endError = $errors['end.address'] ?? $errors['end.label'] ?? $errors['end.lat'] ?? $errors['end.lon'] ?? $errors['end.city'] ?? $errors['end.postcode'] ?? null;
        if ($endError): ?>
            <span class="text-xs text-red"><?= esc($endError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="request[end][label]"    value="<?= esc(old('request[end][label]')) ?>">
        <input type="hidden" name="request[end][lat]"      value="<?= esc(old('request[end][lat]')) ?>">
        <input type="hidden" name="request[end][lon]"      value="<?= esc(old('request[end][lon]')) ?>">
        <input type="hidden" name="request[end][city]"     value="<?= esc(old('request[end][city]')) ?>">
        <input type="hidden" name="request[end][postcode]" value="<?= esc(old('request[end][postcode]')) ?>">
    </div>

</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">
    <div class="flex flex-col gap-1">
        <label for="request-start-date" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Date de départ</label>
        <input type="date" name="request[start-date]" id="request-start-date"
            value="<?= esc(old('request[start-date]')) ?>"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" required>
        <?php if (isset($errors['start-date'])): ?>
            <span class="text-xs text-red"><?= esc($errors['start-date']) ?></span>
        <?php endif ?>
    </div>
    <div class="flex flex-col gap-1">
        <label for="request-start-time" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Heure de départ</label>
        <input type="time" name="request[start-time]" id="request-start-time"
            value="<?= esc(old('request[start-time]')) ?>"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" required>
        <?php if (isset($errors['start-time'])): ?>
            <span class="text-xs text-red"><?= esc($errors['start-time']) ?></span>
        <?php endif ?>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">
    <div class="flex flex-col gap-1">
        <label for="request-end-date" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Date d'arrivée</label>
        <input type="date" name="request[end-date]" id="request-end-date"
            value="<?= esc(old('request[end-date]')) ?>"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" required>
        <?php if (isset($errors['end-date'])): ?>
            <span class="text-xs text-red"><?= esc($errors['end-date']) ?></span>
        <?php endif ?>
    </div>
    <div class="flex flex-col gap-1">
        <label for="request-end-time" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Heure d'arrivée</label>
        <input type="time" name="request[end-time]" id="request-end-time"
            value="<?= esc(old('request[end-time]')) ?>"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" required>
        <?php if (isset($errors['end-time'])): ?>
            <span class="text-xs text-red"><?= esc($errors['end-time']) ?></span>
        <?php endif ?>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">
    <div class="flex flex-col gap-1">
        <label for="request-range-start" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Début de disponibilité</label>
        <input type="time" name="request[range-start]" id="request-range-start"
            value="<?= esc(old('request[range-start]')) ?>"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" required>
        <?php if (isset($errors['range-start'])): ?>
            <span class="text-xs text-red"><?= esc($errors['range-start']) ?></span>
        <?php endif ?>
    </div>
    <div class="flex flex-col gap-1">
        <label for="request-range-end" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Fin de disponibilité</label>
        <input type="time" name="request[range-end]" id="request-range-end"
            value="<?= esc(old('request[range-end]')) ?>"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" required>
        <?php if (isset($errors['range-end'])): ?>
            <span class="text-xs text-red"><?= esc($errors['range-end']) ?></span>
        <?php endif ?>
    </div>
</div>

<div class="flex flex-col gap-1">
    <label for="request-description" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Description</label>
    <textarea name="request[description]" id="request-description"
        placeholder="Entrez une description"
        class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors"><?= esc(old('request[description]')) ?></textarea>
    <?php if (isset($errors['description'])): ?>
        <span class="text-xs text-red"><?= esc($errors['description']) ?></span>
    <?php endif ?>
</div>

<div class="flex flex-col gap-1">
    <label for="request-options" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">
        Options <span class="normal-case font-normal tracking-normal text-grey">(optionnel)</span>
    </label>
    <input type="text" name="request[options]" id="request-options"
        value="<?= esc(old('request[options]')) ?>"
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