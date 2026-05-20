<?php form_open('itinerary/search') ?>

<div>
    <label for="start">Départ&nbsp;:</label><br>
    <input class="address-input" type="text" name="start_label" id="start"
        value="<?= set_value('start') ?>"
        placeholder="Entrez votre départ" required>
    <?php if (isset($errors['start'])) echo ("<br><span class='error'>" . $errors['start'] . "</span>"); ?>
    <div class="address-results"></div>

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
    <div class="address-results"></div>

    <input type="hidden" name="end_lat">
    <input type="hidden" name="end_long">
    <input type="hidden" name="end_city">
    <input type="hidden" name="end_postcode">
</div>

<label for="start-time">Heure départ&nbsp;:</label><br>
<input type="datetime-local" name="start-time" id="start-time"
    value="<?= set_value('start') ?>" required>

<label for="end-time">Heure arrivée&nbsp;:</label><br>
<input type="datetime-local" name="end-time" id="end-time"
    value="<?= set_value('end') ?>" required>
<?php if (isset($errors["time"])) echo ("<br><span class='error'>" . $errors["time"] . "</span>"); ?>



<label for="filter">Filtres&nbsp;:</label><br>
<input type="text" name="filter" id="filter"
    value="<?= set_value('filter') ?>"
    placeholder="Entrez votre filtre" required>
<?php if (isset($errors["filter"])) echo ("<br><span class='error'>" . $errors["filter"] . "</span>"); ?>



<input type="submit" value="Rechercher ->">

<?php form_close() ?>