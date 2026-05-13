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
    <header class="header flex items-center justify-evenly pt-5 px-5 bg-lightgrey">
        <img src="/img/logo.png" alt="PennRide" class="w-12 h-12 rounded-xl">

        <?php if (session('logged_in')): ?>
            <nav>
                <ul class="flex gap-4">
                    <li><a class="text-xs font-poppins text-bluegrey" href="<?= site_url('trajet') ?>">Trajet</a></li>
                    <li><a class="text-xs font-poppins text-bluegrey" href="/nouveau-trajet">Nouveau trajet</a></li>
                    <li><a class="text-xs font-poppins text-bluegrey" href="#">Contact</a></li>
                    <li><a class="text-xs font-poppins text-bluegrey" href="/myprofil">Mon profil</a></li>
                </ul>
            </nav>
        <?php else: ?>
            <p class="text-xs font-poppins text-bluegrey">Non connecté</p>
        <?php endif; ?>
    </header>