<?php
$request   = service('request');
$start     = $request->getGet('start') ?? [];
$end       = $request->getGet('end') ?? [];
$date      = $request->getGet('date') ?? '';
$freeSeats = $request->getGet('free-seats') ?? '';
$filter    = $request->getGet('filter') ?? '';
?>

<?= form_open(site_url('trajet'), ['class' => 'flex flex-col gap-4', 'method' => 'get']) ?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6 items-start">

    <div class="flex flex-col gap-1">
        <label for="start" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Départ</label>
        <input class="address-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors"
            type="text" name="start[label]" id="start"
            value="<?= esc($start['label'] ?? '') ?>"
            placeholder="Entrez votre départ" required>
        <?php $startError = $errors['start.label'] ?? $errors['start.lat'] ?? $errors['start.lon'] ?? $errors['start.city'] ?? $errors['start.postcode'] ?? null;
        if ($startError): ?>
            <span class="text-xs text-red"><?= esc($startError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="start[lat]"      value="<?= esc($start['lat'] ?? '') ?>">
        <input type="hidden" name="start[lon]"      value="<?= esc($start['lon'] ?? '') ?>">
        <input type="hidden" name="start[city]"     value="<?= esc($start['city'] ?? '') ?>">
        <input type="hidden" name="start[postcode]" value="<?= esc($start['postcode'] ?? '') ?>">
    </div>

    <div class="flex flex-col gap-1">
        <label for="end" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Arrivée</label>
        <input class="address-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors"
            type="text" name="end[label]" id="end"
            value="<?= esc($end['label'] ?? '') ?>"
            placeholder="Entrez votre destination" required>
        <?php $endError = $errors['end.label'] ?? $errors['end.lat'] ?? $errors['end.lon'] ?? $errors['end.city'] ?? $errors['end.postcode'] ?? null;
        if ($endError): ?>
            <span class="text-xs text-red"><?= esc($endError) ?></span>
        <?php endif ?>
        <div class="results"></div>
        <input type="hidden" name="end[lat]"      value="<?= esc($end['lat'] ?? '') ?>">
        <input type="hidden" name="end[lon]"      value="<?= esc($end['lon'] ?? '') ?>">
        <input type="hidden" name="end[city]"     value="<?= esc($end['city'] ?? '') ?>">
        <input type="hidden" name="end[postcode]" value="<?= esc($end['postcode'] ?? '') ?>">
    </div>

</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">
    <div class="flex flex-col gap-1">
        <label for="start-date" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Date</label>
        <input type="date" name="date" id="start-date"
            value="<?= esc($date) ?>"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" required>
        <?php if (isset($errors['date'])): ?>
            <span class="text-xs text-red"><?= esc($errors['date']) ?></span>
        <?php endif ?>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">
    <div class="flex flex-col gap-1">
        <label for="passengers" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Passagers</label>
        <input type="number" name="free-seats" id="passengers"
            placeholder="1"
            value="<?= esc($freeSeats) ?>"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors">
        <?php if (isset($errors['free-seats'])): ?>
            <span class="text-xs text-red"><?= esc($errors['free-seats']) ?></span>
        <?php endif ?>
    </div>
</div>

<div class="flex flex-col gap-1">
    <label for="filter" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Filtres <span class="text-grey font-normal normal-case tracking-normal">(optionnel)</span></label>
    <input type="text" name="filter" id="filter"
        value="<?= esc($filter) ?>"
        placeholder="Entrez vos filtres"
        class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors">
    <?php if (isset($errors['filter'])): ?>
        <span class="text-xs text-red"><?= esc($errors['filter']) ?></span>
    <?php endif ?>
</div>

<div class="flex justify-end mt-2">
    <button type="submit"
        class="bg-gold text-ocean font-semibold text-sm px-6 py-2 rounded-full hover:opacity-90 transition-opacity cursor-pointer">
        Rechercher →
    </button>
</div>

<?= form_close() ?>