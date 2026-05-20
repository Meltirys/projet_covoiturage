<?php form_open('itinerary/create') ?>

<div>
    <label for="start">Départ&nbsp;:</label><br>
    <input class="address-input" type="text" name="start_label" id="start"
        value="<?= set_value('start') ?>"
        placeholder="Entrez le point de départ" required>
    <?php if (isset($errors['start'])) echo ("<br><span class='error'>" . $errors['start'] . "</span>"); ?>

    <input type="hidden" name="start_lat">
    <input type="hidden" name="start_lon">
    <input type="hidden" name="start_city">
    <input type="hidden" name="start_postcode">
</div>

<div>
    <label for="end">Arrivée&nbsp;:</label><br>
    <input class="address-input" type="text" name="end_label" id="end"
        value="<?= set_value('end') ?>"
        placeholder="Entrez votre destination" required>
    <?php if (isset($errors["end"])) echo ("<br><span class='error'>" . $errors["end"] . "</span>"); ?>


    <input type="hidden" name="end_lat">
    <input type="hidden" name="end_lon">
    <input type="hidden" name="end_city">
    <input type="hidden" name="end_postcode">
</div>

<div id="stops-container">
    <label for="stop">Arrêts (optionnels)&nbsp;:</label><br>

    <?php $stops = old('stops') ?? [[]]; ?>

    <?php foreach ($stops as $index => $stop): ?>
        <div class="stop address-field">
            <input type="text" name="stops[<?= $index ?>][address]" class="address-input" value="<?= esc($stop['address'] ?? '') ?>">

            <input type="hidden" name="stops[<?= $index ?>][lat]" value="<?= esc($stop['lat'] ?? '') ?>">
            <input type="hidden" name="stops[<?= $index ?>][lon]" value="<?= esc($stop['lon'] ?? '') ?>">
            <input type="hidden" name="stops[<?= $index ?>][city]" value="<?= esc($stop['city'] ?? '') ?>">
            <input type="hidden" name="stops[<?= $index ?>][postcode]" value="<?= esc($stop['postcode'] ?? '') ?>">

            <div class="results"></div> <button type="button" class="remove-stop">Retirer</button>
        </div>
    <?php endforeach; ?>

    <?php if (isset($errors["stops"])) echo ("<br><span class='error'>" . $errors["stops"] . "</span>"); ?>
</div>



<label for="start-time">Heure départ&nbsp;:</label><br>
<input type="datetime-local" name="start-time" id="start-time"
    value="<?= set_value('start') ?>" required>
<label for="end-time">Heure arrivée&nbsp;:</label><br>
<input type="datetime-local" name="end-time" id="end-time"
    value="<?= set_value('end') ?>" required>
<?php if (isset($errors["time"])) echo ("<br><span class='error'>" . $errors["time"] . "</span>"); ?>



<label for="car">Véhicule&nbsp;:</label><br>
<select name="car" id="car" value="<?= set_value('car') ?>" required>
    <option value="">--Choisissez le véhicule--</option>
    <?php // Ajoute au dropdown la ou les voitures de l'utilisateur
    if (isset($cars)) {
        foreach ($cars as $car) { ?>
            <option value="<?= $car['id_car'] ?>"><?= $car['brand'] ?> - <?= $car['model'] ?></option>
    <?php }
    } ?>
</select>
<?php if (isset($errors["car"])) echo ("<br><span class='error'>" . $errors["car"] . "</span>"); ?>



<label for="seats">Nombre de places&nbsp;:</label><br>
<select type="text" name="seats" id="seats"
    value="<?= set_value('seats') ?>" required>
</select>
<?php if (isset($errors["seats"])) echo ("<br><span class='error'>" . $errors["seats"] . "</span>"); ?>



<label for="options">Options&nbsp;:</label><br>
<input type="text" name="options" id="options"
    value="<?= set_value('options') ?>"
    placeholder="Entrez vos options" required>
<?php if (isset($errors["options"])) echo ("<br><span class='error'>" . $errors["options"] . "</span>"); ?>



<input type="submit" value="Rechercher ->">
</div>

<?php form_close() ?>