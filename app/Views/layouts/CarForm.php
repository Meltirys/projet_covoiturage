<div class="grid grid-cols-1 md:grid-cols-2 gap-3">

    <div class="flex flex-col gap-1">
        <label for="brand" class="text-xs text-grey">Marque</label>
        <input type="text" id="brand" name="brand" value="<?= session()->getFlashdata('car_success') ? '' : old('brand')  ?>" class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
        <?php if ($errors['brand'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['brand'] ?></span><?php endif ?>
    </div>

    <div class="flex flex-col gap-1">
        <label for="model" class="text-xs text-grey">Modèle</label>
        <input type="text" id="model" name="model" value="<?= session()->getFlashdata('car_success') ? '' : old('model')  ?>" class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
        <?php if ($errors['model'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['model'] ?></span><?php endif ?>
    </div>

    <div class="flex flex-col gap-1">
        <label for="color" class="text-xs text-grey">Couleur</label>
        <input type="text" id="color" name="color" value="<?= session()->getFlashdata('car_success') ? '' : old('color')  ?>" class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
        <?php if ($errors['color'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['color'] ?></span><?php endif ?>
    </div>

    <div class="flex flex-col gap-1">
        <label for="year" class="text-xs text-grey">Année</label>
        <input type="text" id="year" name="year" value="<?= session()->getFlashdata('car_success') ? '' : old('year')  ?>" class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
        <?php if ($errors['year'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['year'] ?></span><?php endif ?>
    </div>

    <div class="flex flex-col gap-1 md:col-span-2">
        <label for="places" class="text-xs text-grey">Nombre de places</label>
        <input type="number" id="places" name="places" value="<?= session()->getFlashdata('car_success') ? '' : old('places')  ?>" class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
        <?php if ($errors['number_of_seat'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['number_of_seat'] ?></span><?php endif ?>
    </div>

</div>

