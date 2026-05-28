<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-name" content="<?= csrf_token() ?>">
    <link rel="icon" type="image/png" href="/img/logo.png">
    <link rel="stylesheet" href="/css/style.css">
    <title>PennRide</title>
</head>
<body>

    <?= $this->renderSection('content') ?>
    <?= $this->renderSection('scripts') ?>

    <!-- Overlay -->
    <div id="menuOverlay"
         class="fixed inset-0 z-40 hidden bg-bluegrey"
         style="transition: opacity 0.35s ease; opacity: 0;"
         onclick="toggleMobileMenu()">
    </div>

    <!-- Menu mobile -->
    <div id="mobileMenu" class="m-menu">
        <div class="flex items-center justify-between w-full mb-6 pb-4 border-b border-babyblue">
            <?php if (session('logged_in')): ?>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-ocean flex items-center justify-center text-sand text-xs font-medium">
                        <?= strtoupper(substr(session('user_first_name'), 0, 1)) ?><?= strtoupper(substr(session('user_last_name'), 0, 1)) ?>
                    </div>
                    <span class="text-xs text-bluegrey"><?= session('user_first_name') ?> <?= session('user_last_name') ?></span>
                </div>
            <?php else: ?>
                <span class="text-xs text-grey">Menu</span>
            <?php endif; ?>
            <button class="text-grey text-xl" onclick="toggleMobileMenu()">✕</button>
        </div>
        <?php if (session('logged_in')): ?>
            <a class="nav-m w-full py-3 border-b border-babyblue" href="<?= site_url('trajet') ?>" onclick="toggleMobileMenu()">Trajets</a>
            <a class="nav-m w-full py-3 border-b border-babyblue" href="/nouveau-trajet" onclick="toggleMobileMenu()">Proposer un trajet</a>
            <a class="nav-m w-full py-3 border-b border-babyblue" href="/myprofil" onclick="toggleMobileMenu()">Mon profil</a>
            <?php if (session('user_role') == 2): ?>
                <a class="text-sm font-poppins text-ocean font-medium w-full py-3 border-b border-babyblue" href="/backoffice" onclick="toggleMobileMenu()">Dashboard admin</a>
            <?php endif; ?>
            <a class="text-sm font-poppins text-red-500 w-full py-3 mt-2" href="/logout">Déconnexion</a>
        <?php else: ?>
            <a class="nav-m w-full py-3 border-b border-babyblue" href="/" onclick="toggleMobileMenu()">Connexion</a>
            <a class="nav-m w-full py-3" href="/" onclick="toggleMobileMenu()">Inscription</a>
        <?php endif; ?>
    </div>

    <script>
    function toggleMobileMenu() {
        const menu    = document.getElementById('mobileMenu');
        const overlay = document.getElementById('menuOverlay');
        const isOpen  = menu.classList.contains('open');
        if (isOpen) {
            menu.classList.remove('open');
            overlay.style.opacity = '0';
            setTimeout(() => overlay.classList.add('hidden'), 300);
        } else {
            overlay.classList.remove('hidden');
            requestAnimationFrame(() => overlay.style.opacity = '1');
            menu.classList.add('open');
        }
    }
    </script>

</body>
</html>