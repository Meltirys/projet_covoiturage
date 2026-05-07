<?= view('commons/header') ?>

<main>
    <?php //utilisateur non connecté 
    ?>
    <div class="auth-screen">

        <div class="auth-menu">
            <button class="auth-menu-btn <?= ($activeTab ?? 'login') === 'login' ? 'active' : '' ?>" data-tab="tab-login">
                <span class="auth-selector"></span> Connexion
            </button>
            <button class="auth-menu-btn <?= ($activeTab ?? 'login') === 'inscription' ? 'active' : '' ?>" data-tab="tab-inscription">
                <span class="auth-selector"></span> Inscription
            </button>
        </div>
        <!-- Formulaire de Connexion -->
        <div id="tab-login" class="auth-form-panel <?= ($activeTab ?? 'login') === 'login' ? 'active' : '' ?>">

            <?php if (!empty($message) && ($activeTab ?? 'login') === 'login'): ?>
                <div class="auth-message"><?= $message ?></div>
            <?php endif; ?>

            <form action="<?= site_url('auth/connexion') ?>" method="POST" class="auth-form">
                <div class="auth-field">
                    <label class="auth-label" for="login-email">Email</label>
                    <input class="auth-input" type="email" id="login-email" name="email" required>
                </div>
                <div class="auth-field">
                    <label class="auth-label" for="login-mdp">Mot de passe</label>
                    <input class="auth-input" type="password" id="login-mdp" name="mdp" required>
                </div>
                <button type="submit" class="btn-auth">Se connecter</button>
            </form>

        </div>

        <!-- Formulaire Inscription -->
        <div id="tab-inscription" class="auth-form-panel <?= ($activeTab ?? 'login') === 'inscription' ? 'active' : '' ?>">

            <?php if (!empty($message) && ($activeTab ?? 'login') === 'inscription'): ?>
                <div class="auth-message"><?= $message ?></div>
            <?php endif; ?>



            <?= form_open('/signup') ?>

            <div class="auth-field-group">
                <div class="auth-field">
                    <div class="auth-input">
                        <label class="auth-label" for="first_name">Prénom</label>
                        <input class="auth-input" type="text" name="first_name" value="<?= set_value('first_name') ?>" required>
                    </div>
                    <?php if ($errors['first_name'] ?? null): ?>
                        <span class="error"><?= $errors['first_name'] ?></span>
                    <?php endif ?>
                </div>

                <div class="auth-field">
                    <div class="auth-input">
                        <label class="auth-label" for="last_name">Nom</label>
                        <input class="auth-input" type="text" name="last_name" value="<?= set_value('last_name') ?>" required>
                    </div>
                   <?php if ($errors['last_name'] ?? null): ?>
                        <span class="error"><?= $errors['last_name'] ?></span>
                    <?php endif ?>

                </div>
            </div>

            <div class="auth-field-group">
                <div class="auth-field">
                    <div class="auth-input">
                        <label class="auth-label" for="email">Mail</label>
                        <input class="auth-input" type="email" name="email" value="<?= set_value('email') ?>" required>
                    </div>

                   <?php if ($errors['email'] ?? null): ?>
                        <span class="error"><?= $errors['email'] ?></span>
                    <?php endif ?>

                </div>

                <div class="auth-field">
                    <div class="auth-input">
                        <label class="auth-label" for="phone">Téléphone</label>
                        <input class="auth-input" type="phone" name="phone" value="<?= set_value('phone') ?>">
                    </div>
                   <?php if ($errors['phone'] ?? null): ?>
                        <span class="error"><?= $errors['phone'] ?></span>
                    <?php endif ?>
                </div>

            </div>


            <div class="auth-field-group">
                <div class="auth-field">
                    <div class="auth-input">
                        <label class="auth-label" for="password">Mot de passe</label>
                        <input class="auth-input" type="password" name="password" required>
                    </div>

                   <?php if ($errors['password'] ?? null): ?>
                        <span class="error"><?= $errors['password'] ?></span>
                    <?php endif ?>
                </div>

                <div class="auth-field">
                    <div class="auth-input">
                        <label class="auth-label" for="passwordconf">Confirmation du mot de passe</label>
                        <input class="auth-input" type="password" name="passwordconf" required>
                    </div>

                   <?php if ($errors['passwordconf'] ?? null): ?>
                        <span class="error"><?= $errors['passwordconf'] ?></span>
                    <?php endif ?>
                </div>
            </div>

            <div class="auth-field">
                <div class="auth-input">
                    <label class="auth-label" for="address">Adresse</label>
                    <input class="auth-input" type="text" name="address" value="<?= set_value('address') ?>" required>
                </div>

                   <?php if ($errors['address'] ?? null): ?>
                        <span class="error"><?= $errors['address'] ?></span>
                    <?php endif ?>
            </div>

            <div class="auth-field-group">
                <div class="auth-field">
                    <div class="auth-input">
                        <label class="auth-label" for="city">Ville</label>
                        <input class="auth-input" type="text" name="city" value="<?= set_value('city') ?>" required>
                    </div>

                   <?php if ($errors['city'] ?? null): ?>
                        <span class="error"><?= $errors['city'] ?></span>
                    <?php endif ?>
                </div>

                <div class="auth-field">
                    <div class="auth-input">
                        <label class="auth-label" for="post_code">Code Postal</label>
                        <input class="auth-input" type="text" name="post_code" value="<?= set_value('post_code') ?>" required>
                    </div>

                   <?php if ($errors['post_code'] ?? null): ?>
                        <span class="error"><?= $errors['post_code'] ?></span>
                    <?php endif ?>
                </div>
            </div>

            <button type="submit" name="submit">Je m'inscris</button>
            <?= form_close() ?>

            <div class="auth-field">
                <label class="auth-label" for="reg-pseudo">Pseudo</label>
                <input class="auth-input" type="text" id="reg-pseudo" name="pseudo" required>
            </div>
            <div class="auth-field">
                <label class="auth-label" for="reg-email">Email</label>
                <input class="auth-input" type="email" id="reg-email" name="email" required>
            </div>
            <div class="auth-field">
                <label class="auth-label" for="reg-mdp">Mot de passe <span class="auth-required">(8 caractères min.)</span></label>
                <input class="auth-input" type="password" id="reg-mdp" name="mdp" required>
            </div>
            <button type="submit" class="btn-auth">Créer mon compte</button>


        </div>
    </div>

    <?php //utilisateur connecté 
    ?>

</main>

<!-- Script de sélection du formulaire actif (à redéplacer dans un fichier JS)-->
<script>
    document.querySelectorAll('.auth-menu-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {

            // Changer l'onglet actif
            document.querySelectorAll('.auth-menu-btn').forEach(function(b) {
                b.classList.remove('active');
            });
            document.querySelectorAll('.auth-form-panel').forEach(function(p) {
                p.classList.remove('active');
            });
            btn.classList.add('active');
            document.getElementById(btn.dataset.tab).classList.add('active');
        });
    });
</script>