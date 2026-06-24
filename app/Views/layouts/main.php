<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= base_url() ?>">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-name" content="<?= csrf_token() ?>">
    <script>
        if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark')
    </script>
    <link rel="icon" type="image/png" href="<?= base_url('img/logo_golden.png') ?>">
    <script src="<?= base_url('js/theme-toggle.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>PennRide</title>
</head>

<body class="min-h-screen font-poppins bg-ocean text-lightgrey">

    <?php if (session('logged_in') || uri_string() !== ''): ?>
        <header class="flex items-center justify-between px-5 md:px-10 h-16 bg-ocean-mid border-b border-gold/30">

            <a href="<?= base_url('index.php') ?>" class="flex items-center gap-3">
                <img src="<?= base_url('img/logo_golden.png') ?>" alt="PennRide" class="w-10 h-10 rounded-xl">
                <span class="hidden md:block font-pfd text-lg text-bluegrey">Penn<em class="italic text-gold">Ride</em></span>
            </a>

            <?php if (session('logged_in')): ?>

                <nav class="hidden md:flex items-center gap-2">
                    <a class="nav-d text-xs font-poppins text-gold px-3 py-2 rounded-lg hover:bg-gold hover:text-ocean transition-colors" href="<?= site_url('comment-ca-marche') ?>">Comment ça marche ?</a>
                    <a class="nav-d text-xs font-poppins text-gold px-3 py-2 rounded-lg hover:bg-gold hover:text-ocean transition-colors" href="<?= site_url('trajet') ?>">Trajets</a>
                    <a class="nav-d text-xs font-poppins text-gold px-3 py-2 rounded-lg hover:bg-gold hover:text-ocean transition-colors" href="<?= site_url('requetes') ?>">Requêtes</a>
                    <a class="nav-d text-xs font-poppins text-gold px-3 py-2 rounded-lg hover:bg-gold hover:text-ocean transition-colors" href="<?= site_url('nouveau-trajet') ?>">Proposer</a>
                    <a class="nav-d text-xs font-poppins text-gold px-3 py-2 rounded-lg hover:bg-gold hover:text-ocean transition-colors" href="<?= site_url('contact-page') ?>">Contact</a>
                    <a class="nav-d text-xs font-poppins text-gold px-3 py-2 rounded-lg hover:bg-gold hover:text-ocean transition-colors" href="<?= site_url('myprofil') ?>">Mon profil</a>
                    <?php if (session('user_role') == 2 || session('user_role') == 3): ?>
                        <a class="nav-d text-xs font-poppins text-gold px-3 py-2 rounded-lg hover:bg-gold hover:text-ocean transition-colors" href="/backoffice">Admin</a>
                    <?php endif; ?>
                </nav>

                <div class="flex items-center gap-3">
                    <button id="theme-toggle-btn" onclick="toggleTheme()" class="text-lg p-1 cursor-pointer">🌙</button>
                    <div>
                        <div class="hidden md:flex items-center gap-2 border border-gold/30 rounded-full px-2 py-1">
                            <?php if (session('avatar_filename')): ?>
                                <a href="<?= site_url('myprofil') ?>"><img src="<?= base_url('img/avatars/' . session('avatar_filename')) ?>" alt="Avatar" class="w-6 h-6 rounded-full object-cover"></a>
                            <?php else: ?>
                                <span class="text-xs font-medium text-gold">
                                    <?= strtoupper(substr(session('user_first_name'), 0, 1)) ?><?= strtoupper(substr(session('user_last_name'), 0, 1)) ?>
                                </span>
                            <?php endif; ?>
                            <span class="text-xs text-grey pr-1"><?= session('user_first_name') ?></span>
                        </div>
                    </div>
                    <button class="md:hidden p-2 text-grey" onclick="toggleMobileMenu()">
                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none">
                            <rect y="0" width="20" height="2" rx="1" fill="currentColor" />
                            <rect y="7" width="20" height="2" rx="1" fill="currentColor" />
                            <rect y="14" width="20" height="2" rx="1" fill="currentColor" />
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
    <?php endif; ?>

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
            <a class="nav-m text-sm font-poppins text-grey w-full py-3 border-b border-ocean-light" href="/comment-ca-marche" onclick="toggleMobileMenu()">Comment ça marche ?</a>
            <a class="nav-m text-sm font-poppins text-grey w-full py-3 border-b border-ocean-light" href="<?= site_url('trajet') ?>" onclick="toggleMobileMenu()">Trajets</a>
            <a class="nav-m text-sm font-poppins text-grey w-full py-3 border-b border-ocean-light" href="/requetes" onclick="toggleMobileMenu()">Requêtes</a>
            <a class="nav-m text-sm font-poppins text-grey w-full py-3 border-b border-ocean-light" href="/nouveau-trajet" onclick="toggleMobileMenu()">Proposer un trajet</a>
            <a class="nav-m text-sm font-poppins text-grey w-full py-3 border-b border-ocean-light" href="/contact-page" onclick="toggleMobileMenu()">Contact</a>
            <a class="nav-m text-sm font-poppins text-grey w-full py-3 border-b border-ocean-light" href="/myprofil" onclick="toggleMobileMenu()">Mon profil</a>
            <?php if (session('user_role') == 2 || session('user_role') == 3): ?>
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

        const BASE_URL = document.querySelector('meta[name="base-url"]').content

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

    <footer class="mt-auto" style="border-top: 0.5px solid rgba(180,140,60,0.15); background: var(--color-ocean-mid);">
        <div class="px-5 md:px-10 py-8 max-w-5xl mx-auto">

            <!-- Ligne principale -->
            <div class="flex flex-col md:flex-row md:items-start gap-8 md:gap-0 md:justify-between mb-8">

                <!-- Brand -->
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-2">
                        <img src="<?= base_url('img/logo_golden.png') ?>" alt="PennRide" class="w-7 h-7 rounded-lg opacity-80">
                        <span class="font-pfd text-base text-bluegrey">Penn<em class="italic text-gold">Ride</em></span>
                    </div>
                    <p class="text-grey leading-relaxed" style="font-size: 11px; max-width: 180px;">Le covoiturage solidaire</p>
                </div>

                <!-- Liens -->
                <div class="flex gap-12">
                    <div class="flex flex-col gap-2">
                        <p class="text-gold uppercase mb-1" style="font-size: 9px; letter-spacing: 0.2em;">Navigation</p>
                        <a href="<?= site_url('trajet') ?>" class="text-grey hover:text-gold transition-colors" style="font-size: 11px;">Trajets</a>
                        <a href="<?= site_url('nouveau-trajet') ?>" class="text-grey hover:text-gold transition-colors" style="font-size: 11px;">Proposer</a>
                        <a href="<?= site_url('myprofil') ?>" class="text-grey hover:text-gold transition-colors" style="font-size: 11px;">Mon profil</a>
                    </div>
                    <div class="flex flex-col gap-2">
                        <p class="text-gold uppercase mb-1" style="font-size: 9px; letter-spacing: 0.2em;">Informations</p>
                        <a href="<?= site_url('mentions-legales') ?>" class="text-grey hover:text-gold transition-colors" style="font-size: 11px;">Mentions légales</a>
                        <a href="<?= site_url('cgu') ?>" class="text-grey hover:text-gold transition-colors" style="font-size: 11px;">CGU</a>
                        <a href="<?= site_url('contact-page') ?>" class="text-grey hover:text-gold transition-colors" style="font-size: 11px;">Contact</a>
                    </div>
                </div>

            </div>

            <!-- Barre du bas -->
            <div class="flex items-center justify-between pt-5" style="border-top: 0.5px solid rgba(180,140,60,0.1);">
                <p class="text-grey" style="font-size: 10px;">© 2026 <span class="text-gold">PennRide</span> · GRETA Bretagne Sud, Agence de Vannes · Développé en Bretagne avec amour</p>
                <div class="flex items-center gap-2">
                    <a href="https://github.com/Meltirys/projet_covoiturage.git" class="text-grey hover:text-gold transition-colors" style="font-size: 13px;"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="text-grey hover:text-gold transition-colors" style="font-size: 13px;"><i class="fa-regular fa-envelope"></i></a>
                </div>
            </div>

        </div>
    </footer>

    <style>
        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }
        }
    </style>

</body>

</html>