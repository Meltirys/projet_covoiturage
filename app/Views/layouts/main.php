<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/img/logo.png">
    <link rel="stylesheet" href="/css/style.css">
    <title>PennRide</title>
</head>

<body>

    <header class="header flex items-center py-4 px-5 bg-lightgrey">
        <img src="/img/logo.png" alt="PennRide" class="w-12 h-12 rounded-xl">
        <?php if (session('logged_in')): ?>
            <!-- Nav desktop -->
            <nav class="hidden md:flex justify-end items-center gap-6">
                <a class="nav-d" href="<?= site_url('trajet') ?>">Trajets</a>
                <a class="nav-d" href="/nouveau-trajet">Nouveau trajet</a>
                <a class="nav-d" href="#">Contact</a>
                <a class="nav-d" href="/myprofil">Mon profil</a>
                <?php if (session('user_role') == 2): ?>
                    <a class="text-xs font-poppins text-white bg-bluegrey px-3 py-1 rounded-full" href="/backoffice">Dashboard</a>
                <?php endif; ?>
            </nav>
            <!-- Burger mobile -->
            <button class="md:hidden flex flex-col gap-1.5 p-2" onclick="toggleMobileMenu()">
                <span class="block w-6 h-0.5 bg-bluegrey"></span>
                <span class="block w-6 h-0.5 bg-bluegrey"></span>
                <span class="block w-6 h-0.5 bg-bluegrey"></span>
            </button>
        <?php else: ?>
            <p class="flex-1 px-6 text-xs font-poppins text-bluegrey hidden md:block">Tu n'es pas connecté : pour profiter des fonctionnalités de PennRide, connecte-toi ou créé un compte.</p>
            <div class="flex gap-2">
                <a href="/login" class="text-xs font-poppins text-bluegrey border border-babyblue rounded-full px-3 py-1">Connexion</a>
                <a href="/register" class="text-xs font-poppins text-white bg-bluegrey rounded-full px-3 py-1">Inscription</a>
            </div>
        <?php endif; ?>
    </header>

    <!-- Menu mobile -->
    <div id="mobileMenu" class="m-menu">
        <?php if (session('logged_in')): ?>
            <a class="nav-m" href="<?= site_url('trajet') ?>" onclick="toggleMobileMenu()">Trajets</a>
            <a class="nav-m" href="/nouveau-trajet" onclick="toggleMobileMenu()">Nouveau trajet</a>
            <a class="nav-m" href="#" onclick="toggleMobileMenu()">Contact</a>
            <a class="nav-m" href="/myprofil" onclick="toggleMobileMenu()">Mon profil</a>
            <?php if (session('user_role') == 2): ?>
                <a class="text-sm font-poppins text-white bg-bluegrey px-3 py-1 rounded-full w-fit" href="/backoffice" onclick="toggleMobileMenu()">Dashboard</a>
            <?php endif; ?>
            <a class="text-sm font-poppins text-grey" href="/logout">Déconnexion</a>
        <?php else: ?>
            <a class="nav-m" href="/login" onclick="toggleMobileMenu()">Connexion</a>
            <a class="nav-m" href="/register" onclick="toggleMobileMenu()">Inscription</a>
        <?php endif; ?>
    </div>

    <script>
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('open')
        }
    </script>

    <?= $this->renderSection('content') ?>
    <?= $this->renderSection('scripts') ?>
    <footer>
        <ul></ul>
    </footer>
</body>

</html>