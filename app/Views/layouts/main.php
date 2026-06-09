<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-name" content="<?= csrf_token() ?>">
    <script>if(localStorage.getItem('theme')==='dark')document.documentElement.classList.add('dark')</script>
    <link rel="icon" type="image/png" href="/img/logo.png">
    <script src="/js/theme-toggle.js"></script>
    <link rel="stylesheet" href="/css/style.css">
    <title>PennRide</title>
</head>

<body class="min-h-screen font-poppins bg-ocean text-lightgrey">

    <header class="flex items-center justify-between px-5 md:px-10 h-16 bg-ocean-mid border-b border-gold/30">

        <a href="/" class="flex items-center gap-3">
            <img src="/img/logo.png" alt="PennRide" class="w-10 h-10 rounded-xl">
            <span class="hidden md:block text-xs tracking-widest uppercase font-light text-sand">PennRide</span>
        </a>

        <?php if (session('logged_in')): ?>

            <nav class="hidden md:flex items-center gap-2">
                <a class="nav-d text-xs font-poppins text-gold px-3 py-2 rounded-lg hover:bg-gold hover:text-ocean transition-colors" href="<?= site_url('trajet') ?>">Trajets</a>
                <a class="nav-d text-xs font-poppins text-gold px-3 py-2 rounded-lg hover:bg-gold hover:text-ocean transition-colors" href="/nouveau-trajet">Proposer</a>
                <a class="nav-d text-xs font-poppins text-gold px-3 py-2 rounded-lg hover:bg-gold hover:text-ocean transition-colors" href="/myprofil">Mon profil</a>
                <?php if (session('user_role') == 2): ?>
                    <a class="nav-d text-xs font-poppins text-gold px-3 py-2 rounded-lg hover:bg-gold hover:text-ocean transition-colors" href="/backoffice">Admin</a>
                <?php endif; ?>
            </nav>

            <div class="flex items-center gap-3">
                <button id="theme-toggle-btn" onclick="toggleTheme()" class="text-lg p-1 cursor-pointer">🌙</button>
                <div class="hidden md:flex items-center gap-2 border border-gold/30 rounded-full px-3 py-1">
                    <?php if (session('avatar_filename')): ?>
                        <img src="<?= base_url('img/avatars/' . session('avatar_filename')) ?>" alt="Avatar">
                    <?php else: ?>
                        <span class="text-xs font-medium text-gold">
                            <?= strtoupper(substr(session('user_first_name'), 0, 1)) ?><?= strtoupper(substr(session('user_last_name'), 0, 1)) ?>
                        </span>
                    <?php endif; ?>
                    <span class="text-xs text-grey"><?= session('user_first_name') ?></span>
                </div>
                <button class="md:hidden p-2 text-grey" onclick="toggleMobileMenu()">
                    <svg width="20" height="16" viewBox="0 0 20 16" fill="none">
                        <rect y="0"  width="20" height="2" rx="1" fill="currentColor"/>
                        <rect y="7"  width="20" height="2" rx="1" fill="currentColor"/>
                        <rect y="14" width="20" height="2" rx="1" fill="currentColor"/>
                    </svg>
                </button>
            </div>

        <?php else: ?>
            <div class="flex gap-2">
                <button id="theme-toggle-btn" onclick="toggleTheme()" class="text-lg p-1 cursor-pointer">🌙</button>
                <a href="/" class="text-xs font-poppins text-grey border border-ocean-light rounded-full px-4 py-1.5 hover:bg-ocean-light transition-colors">Connexion</a>
                <a href="/" class="text-xs font-poppins font-medium bg-sand text-ocean rounded-full px-4 py-1.5 hover:opacity-90 transition-opacity">Inscription</a>
            </div>
        <?php endif; ?>

    </header>

    <div id="menuOverlay"
        class="fixed inset-0 z-40 hidden"
        style="background:rgba(0,0,0,0.5); transition: opacity 0.35s ease; opacity: 0;"
        onclick="toggleMobileMenu()">
    </div>

    <div id="mobileMenu" class="m-menu">
        <div class="flex items-center justify-between w-full mb-6 pb-4 border-b border-ocean-light">
            <?php if (session('logged_in')): ?>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-ocean-mid flex items-center justify-center text-xs font-medium text-gold">
                        <?= strtoupper(substr(session('user_first_name'), 0, 1)) ?><?= strtoupper(substr(session('user_last_name'), 0, 1)) ?>
                    </div>
                    <span class="text-xs text-grey"><?= session('user_first_name') ?> <?= session('user_last_name') ?></span>
                </div>
            <?php else: ?>
                <span class="text-xs text-grey">Menu</span>
            <?php endif; ?>
            <button class="text-xl text-grey" onclick="toggleMobileMenu()">✕</button>
        </div>

        <?php if (session('logged_in')): ?>
            <a class="nav-m text-sm font-poppins text-grey w-full py-3 border-b border-ocean-light" href="<?= site_url('trajet') ?>" onclick="toggleMobileMenu()">Trajets</a>
            <a class="nav-m text-sm font-poppins text-grey w-full py-3 border-b border-ocean-light" href="/nouveau-trajet" onclick="toggleMobileMenu()">Proposer un trajet</a>
            <a class="nav-m text-sm font-poppins text-grey w-full py-3 border-b border-ocean-light" href="/myprofil" onclick="toggleMobileMenu()">Mon profil</a>
            <?php if (session('user_role') == 2): ?>
                <a class="text-sm font-poppins font-medium text-sand w-full py-3 border-b border-ocean-light" href="/backoffice" onclick="toggleMobileMenu()">Dashboard admin</a>
            <?php endif; ?>
            <a class="text-sm font-poppins text-red w-full py-3 mt-2" href="/logout">Déconnexion</a>
        <?php else: ?>
            <a class="nav-m text-sm font-poppins text-grey w-full py-3 border-b border-ocean-light" href="/" onclick="toggleMobileMenu()">Connexion</a>
            <a class="nav-m text-sm font-poppins text-grey w-full py-3" href="/" onclick="toggleMobileMenu()">Inscription</a>
        <?php endif; ?>
    </div>

    <?= $this->renderSection('content') ?>

    <?= $this->renderSection('scripts') ?>
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

    <footer>
        <ul></ul>
    </footer>

</body>

</html>