<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PennRide</title>
</head>

<body>
    <header class="header">
        <nav>
            <ul>
                <li><a href="<?= site_url('trajet') ?>">Trajet</a></li>
                <li><a href="/nouveau-trajet">Nouveau trajet</a></li>
                <li><a href="#">Contact</a></li>
                <?php if (session('logged_in')): ?>
                    <li>
                        <form action="<?= site_url('logout') ?>" method="POST">
                            <?= csrf_field() ?>
                            <button type="submit">Se déconnecter</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li><a href="<?= site_url('authentification') ?>">Authentification</a></li>
                <?php endif; ?>

            </ul>
        </nav>
    </header>