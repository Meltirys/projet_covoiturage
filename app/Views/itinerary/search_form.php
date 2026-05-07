<form action="/search-route" method="post">
    <?= csrf_field() ?>

    <div>
        <label for="start">Départ : </label><br>
        <input type="start" name="start" id="start"
            value="<?= set_value('start') ?>"
            placeholder="Entrez votre départ" required>
        <?php if (isset($errors['start'])) echo ("<br><span class='error'>" . $errors['start'] . "</span>"); ?>
    </div>

    <div>
        <label for="end">Arrivée : </label><br>
        <input type="end" name="end" id="end"
            value="<?= set_value('end') ?>"
            placeholder="Entrez votre destination" required>
        <?php if (isset($errors["end"])) echo ("<br><span class='error'>" . $errors["end"] . "</span>"); ?>
    </div>

    <div>
        <label for="date">Date : </label><br>
        <input type="date" name="date" id="date"
            value="<?= set_value('date') ?>"
            placeholder="Entrez la date" required>
        <?php if (isset($errors["date"])) echo ("<br><span class='error'>" . $errors["date"] . "</span>"); ?>
    </div>

    <div>
        <label for="time">Horaire : </label><br>
        <input type="time" name="time" id="time"
            value="<?= set_value('start') ?>"
            placeholder="Entrez vos horaires" required>
        <?php if (isset($errors["time"])) echo ("<br><span class='error'>" . $errors["time"] . "</span>"); ?>
    </div>

    <div>
        <label for="filter">Filtres : </label><br>
        <input type="filter" name="filter" id="filter"
            value="<?= set_value('filter') ?>"
            placeholder="Entrez votre filtre" required>
        <?php if (isset($errors["filter"])) echo ("<br><span class='error'>" . $errors["filter"] . "</span>"); ?>
    </div>

    <div>
        <input type="submit" value="Rechercher ->">
    </div>
</form>