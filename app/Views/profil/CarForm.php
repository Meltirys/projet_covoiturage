<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
    <div class="flex flex-col gap-1">
        <label for="brand" class="text-[0.625rem] tracking-[0.15em] uppercase text-grey">Marque</label>
        <input type="text" id="brand" name="brand" value="<?= session()->getFlashdata('car_success') ? '' : esc(old('brand')) ?>"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-babyblue" required>
        <?php if ($errors['brand'] ?? null): ?><span class="text-xs text-red"><?= $errors['brand'] ?></span><?php endif ?>
    </div>
    <div class="flex flex-col gap-1">
        <label for="model" class="text-[0.625rem] tracking-[0.15em] uppercase text-grey">Modèle</label>
        <input type="text" id="model" name="model" value="<?= session()->getFlashdata('car_success') ? '' : esc(old('model')) ?>"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-babyblue" required>
        <?php if ($errors['model'] ?? null): ?><span class="text-xs text-red"><?= $errors['model'] ?></span><?php endif ?>
    </div>
    <div class="flex flex-col gap-1">
        <label for="color" class="text-[0.625rem] tracking-[0.15em] uppercase text-grey">Couleur</label>
        <input type="text" id="color" name="color" value="<?= session()->getFlashdata('car_success') ? '' : esc(old('color')) ?>"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-babyblue" required>
        <?php if ($errors['color'] ?? null): ?><span class="text-xs text-red"><?= $errors['color'] ?></span><?php endif ?>
    </div>
    <div class="flex flex-col gap-1">
        <label for="year" class="text-[0.625rem] tracking-[0.15em] uppercase text-grey">Année</label>
        <input type="text" id="year" name="year" value="<?= session()->getFlashdata('car_success') ? '' : esc(old('year')) ?>"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-babyblue" required>
        <?php if ($errors['year'] ?? null): ?><span class="text-xs text-red"><?= $errors['year'] ?></span><?php endif ?>
    </div>
    <div class="flex flex-col gap-1 md:col-span-2">
        <label for="places" class="text-[0.625rem] tracking-[0.15em] uppercase text-grey">Nombre de places</label>
        <?php $selectedPlaces = session()->getFlashdata('car_success') ? '1' : old('places', '1'); ?>
        <select id="places" name="places"
            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-babyblue">
            <option value="1" <?= $selectedPlaces === '1' ? 'selected' : '' ?>>1</option>
            <option value="2" <?= $selectedPlaces === '2' ? 'selected' : '' ?>>2</option>
            <option value="3" <?= $selectedPlaces === '3' ? 'selected' : '' ?>>3</option>
            <option value="4" <?= $selectedPlaces === '4' ? 'selected' : '' ?>>4</option>
            <option value="5" <?= $selectedPlaces === '5' ? 'selected' : '' ?>>5</option>
            <option value="6" <?= $selectedPlaces === '6' ? 'selected' : '' ?>>6</option>
            <option value="7" <?= $selectedPlaces === '7' ? 'selected' : '' ?>>7</option>
        </select>
        <?php if ($errors['number_of_seat'] ?? null): ?><span class="text-xs text-red"><?= $errors['number_of_seat'] ?></span><?php endif ?>
    </div>
</div>