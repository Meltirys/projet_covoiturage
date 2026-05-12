<?php form_open('itinerary/create') ?>
<div>
    <label for="start">Départ&nbsp;:</label><br>
    <input type="text" name="start" id="start"
        value="<?= set_value('start') ?>"
        placeholder="Entrez votre départ" required>
    <?php if (isset($errors['start'])) echo ("<br><span class='error'>" . $errors['start'] . "</span>"); ?>
</div>

<div>
    <label for="end">Arrivée&nbsp;:</label><br>
    <input type="text" name="end" id="end"
        value="<?= set_value('end') ?>"
        placeholder="Entrez votre destination" required>
    <?php if (isset($errors["end"])) echo ("<br><span class='error'>" . $errors["end"] . "</span>"); ?>
</div>

<div>
    <label for="stops">Arrêts (optionnels)&nbsp;:</label><br>
    <input type="text" name="stops[]" id="stops"
        value="<?= set_value('stops[0]') ?>"
        placeholder="Entrer un arrêt" required>
    <?php // Rajouter des input après chaque input rempli, probablement en JS  
    ?>
    <?php if (isset($errors["stops"])) echo ("<br><span class='error'>" . $errors["stops"] . "</span>"); ?>
</div>

<div>
    <label for="start-time">Heure départ&nbsp;:</label><br>
    <input type="datetime-local" name="start-time" id="start-time"
        value="<?= set_value('start') ?>" required>
    <label for="end-time">Heure arrivée&nbsp;:</label><br>
    <input type="datetime-local" name="end-time" id="end-time"
        value="<?= set_value('end') ?>" required>
    <?php if (isset($errors["time"])) echo ("<br><span class='error'>" . $errors["time"] . "</span>"); ?>
</div>

<div>
    <label for="car">Véhicule&nbsp;:</label><br>
    <select name="car" id="car"
        value="<?= set_value('car') ?>" required>
        <option value="">--Choisissez le véhicule--</option>
        <?php // Ajoute au dropdown la ou les voitures de l'utilisateur
        if (isset($user['cars'])) {
            foreach ($user['cars'] as $car) { ?>
                <option value="<?= $car['label'] ?>"><?= $car['label'] ?></option>
        <?php }
        } ?>
        <?php if (isset($errors["car"])) echo ("<br><span class='error'>" . $errors["car"] . "</span>"); ?>
</div>

<div>
    <label for="seats">Nombre de places&nbsp;:</label><br>
    <select type="text" name="seats" id="seats"
        value="<?= set_value('seats') ?>" required>
        <?php if (isset($errors["seats"])) echo ("<br><span class='error'>" . $errors["seats"] . "</span>"); ?>
</div>

<div>
    <label for="options">Options&nbsp;:</label><br>
    <input type="text" name="options" id="options"
        value="<?= set_value('options') ?>"
        placeholder="Entrez vos options" required>
    <?php if (isset($errors["options"])) echo ("<br><span class='error'>" . $errors["options"] . "</span>"); ?>
</div>

<div>
    <input type="submit" value="Rechercher ->">
</div>
<?php form_close() ?>