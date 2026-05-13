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
    <header class="header">
        <?php if (session('logged_in')): ?>
            <nav>
                <ul>
                    <li><a href="<?= site_url('trajet') ?>">Trajet</a></li>
                    <li><a href="/nouveau-trajet">Nouveau trajet</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="/myprofil">Mon profil</a></li>
                </ul>
            </nav>
        <?php else: ?>
            <p>Non conntecté</p>
        <?php endif; ?>
    </header>