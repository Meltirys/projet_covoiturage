<form method="post">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="email">Email : </label><br>
        <input type="email" name="email" id="email"
            value="<?= set_value('email') ?>" placeholder="Entrez votre email" required>
        <?php if (isset($errors['email'])) echo ("<br><span class='error'>" . $errors['email'] . "</span>"); ?>
    </div>

    <div class="form-group">
        <label for="password">Mot de passe : </label><br>
        <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe" required>
        <?php if (isset($errors["password"])) echo ("<br><span class='error'>" . $errors["password"] . "</span>"); ?>
    </div>

    <p><a class="blue-link" href="?action=register">Vous n'avez pas de compte&nbsp;?</a></p>

    <div class="submit">
        <input type="submit" class="button" value="Valider">
    </div>
</form>