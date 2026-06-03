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

<body class="min-h-screen font-poppins bg-sand-light">

    <!-- ===== HEADER ===== -->
    <header class="bg-ocean px-5 md:px-10 flex items-center justify-between h-16">

        <!-- Logo -->
        <a href="/" class="flex items-center gap-3">
            <img src="/img/logo.png" alt="PennRide" class="w-10 h-10 rounded-xl">
            <span class="hidden md:block text-sand text-xs tracking-widest uppercase font-light">PennRide</span>
        </a>

        <?php if (session('logged_in')): ?>

            <!-- Nav desktop -->
            <nav class="hidden md:flex items-center gap-2">
                <a class="nav-d hover:text-sand transition-colors px-3 py-2 rounded-lg hover:bg-ocean-light" href="<?= site_url('trajet') ?>">Trajets</a>
                <a class="nav-d hover:text-sand transition-colors px-3 py-2 rounded-lg hover:bg-ocean-light" href="/nouveau-trajet">Proposer</a>
                <a class="nav-d hover:text-sand transition-colors px-3 py-2 rounded-lg hover:bg-ocean-light" href="/myprofil">Mon profil</a>
                <?php if (session('user_role') == 2): ?>
                    <a class="text-xs font-poppins text-ocean bg-sand px-3 py-1 rounded-full font-medium ml-2" href="/backoffice">Admin</a>
                <?php endif; ?>
            </nav>

            <!-- Avatar + burger -->
            <div class="flex items-center gap-3">
                <!-- Avatar desktop -->
                <div class="hidden md:flex items-center gap-2 border border-sand rounded-full px-3 py-1">
                    <span class="text-xs text-sand font-medium">
                        <?= strtoupper(substr(session('user_first_name'), 0, 1)) ?><?= strtoupper(substr(session('user_last_name'), 0, 1)) ?>
                    </span>
                    <span class="text-xs text-babyblue"><?= session('user_first_name') ?></span>
                </div>
                <!-- Burger mobile -->
                <button class="md:hidden p-2" onclick="toggleMobileMenu()">
                    <svg width="20" height="16" viewBox="0 0 20 16" fill="none">
                        <rect y="0" width="20" height="2" rx="1" fill="#F0C878" />
                        <rect y="7" width="20" height="2" rx="1" fill="#F0C878" />
                        <rect y="14" width="20" height="2" rx="1" fill="#F0C878" />
                    </svg>
                </button>
            </div>

        <?php else: ?>
            <div class="flex gap-2">
                <a href="/" class="text-xs font-poppins text-babyblue border border-babyblue rounded-full px-4 py-1.5 hover:bg-ocean-light transition-colors">Connexion</a>
                <a href="/" class="text-xs font-poppins text-ocean bg-sand rounded-full px-4 py-1.5 font-medium hover:bg-sand-light transition-colors">Inscription</a>
            </div>
        <?php endif; ?>

    </header>

    <!-- Overlay -->
    <div id="menuOverlay"
        class="fixed inset-0 z-40 hidden bg-bluegrey"
        style="transition: opacity 0.35s ease; opacity: 0;"
        onclick="toggleMobileMenu()">
    </div>

    <!-- Menu mobile -->
    <div id="mobileMenu" class="m-menu">
        <!-- Header menu -->
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

    <!-- Contenu -->
    <?= $this->renderSection('content') ?>

    <!-- Scripts -->
    <?= $this->renderSection('scripts') ?>
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const overlay = document.getElementById('menuOverlay');
            const isOpen = menu.classList.contains('open');
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