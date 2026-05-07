<?= view('commons/header') ?>

<main>
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

        <form action="<?= site_url('auth/inscription') ?>" method="POST" class="auth-form">
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
        </form>

    </div>
</div>
</main>

<!-- Script de sélection du formulaire actif (à redéplacer dans un fichier JS)-->
<script>
document.querySelectorAll('.auth-menu-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {

        // Changer l'onglet actif
        document.querySelectorAll('.auth-menu-btn').forEach(function(b) { b.classList.remove('active'); });
        document.querySelectorAll('.auth-form-panel').forEach(function(p) { p.classList.remove('active'); });
        btn.classList.add('active');
        document.getElementById(btn.dataset.tab).classList.add('active');
    });
});
</script>