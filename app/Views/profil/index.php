<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php helper('french') ?>
<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

    <!-- En-tête -->
    <header class="flex justify-between items-center mb-4">
        <h2 class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase">Mon profil</h2>
        <div class="flex items-center gap-2">
            <button id="mode-toggle"
                onclick="toggleMode()"
                class="relative w-14 h-8 bg-bluegrey rounded-full transition-colors duration-500 flex items-center px-1">
                <span id="toggle-thumb"
                    class="absolute pb-1 left-1 w-6 h-6 bg-white rounded-full transition-all duration-500 flex items-center justify-center text-sm">
                    🚗
                </span>
            </button>
        </div>
    </header>

    <!-- Nom -->
    <h1 class="text-3xl font-poppins text-gray-900 mb-6">
        <?= session('user_first_name') ?><br>
        <?= session('user_last_name') ?>
    </h1>

    <div class="flex flex-col gap-6">


        <!-- Colonne droite : tout le contenu -->
        <div class="flex flex-col gap-6">

            <!-- Section conducteur -->
            <section id="driver">

                <!-- Stats conducteur -->
                <div class="mb-6">
                    <h3 class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase mb-2">Mes statistiques</h3>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <li class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                            <span class="text-sm text-bluegrey">Trajets proposés</span>
                            <span class="nav-d bg-lightblue rounded-full px-3 py-0.5">0</span>
                        </li>
                        <li class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                            <span class="text-sm text-bluegrey">Passagers transportés</span>
                            <span class="nav-d bg-lightblue rounded-full px-3 py-0.5">0</span>
                        </li>
                    </ul>
                </div>

                <!-- Véhicules -->
                <div class="mb-6">
                    <h3 class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase mb-2">Mes véhicules</h3>

                    <div class="grid grid-cols-1 gap-2 mb-3">
                        <?php if ($cars): ?>
                            <?php foreach ($cars as $car): ?>
                                <div class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                                    <div>
                                        <p class="nav-m">
                                            <?= esc($car['brand']) ?> <?= esc($car['model']) ?>
                                        </p>
                                        <p class="text-xs text-grey">
                                            <?= esc($car['color']) ?> - <?= esc($car['year']) ?> - <?= esc($car['number_of_seat']) ?> places
                                        </p>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="button" class="text-xs text-bluegrey border border-babyblue rounded-full px-3 py-1 hover:bg-lightblue transition-colors duration-150">Modifier</button>
                                        <?= form_open('/car/delete/' . $car['id_car']) ?>
                                        <button type="submit" class="text-xs text-red-500 border border-red-200 rounded-full px-3 py-1 hover:bg-red-50 transition-colors duration-150">Supprimer</button>
                                        <?= form_close() ?>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        <?php else: ?>
                            <p class="text-sm text-grey text-center py-3">Aucune voiture ajoutée pour le moment</p>
                        <?php endif; ?>
                    </div>

                    <?php if (session()->getFlashdata('car_added')): ?>
                        <p class="text-xs text-green-600 mb-3"><?= session()->getFlashdata('car_added') ?></p>
                    <?php endif ?>
                    <?php if (session()->getFlashdata('car_not_added')): ?>
                        <p class="text-xs text-red-500 mb-3"><?= session()->getFlashdata('car_not_added') ?></p>
                    <?php endif ?>

                    <button onclick="showForm('add-car-form')" class="text-xs text-grey underline block text-right w-full mb-3">
                        + ajouter un véhicule
                    </button>

                    <div id="add-car-form" style="display: <?= session()->getFlashdata('error_in_car_form') ? 'flex' : 'none' ?>" class="flex-col gap-3">
                        <?= form_open("car/add") ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                            <div class="flex flex-col gap-1">
                                <label for="brand" class="text-xs text-grey">Marque</label>
                                <input type="text" id="brand" name="brand" value="<?= old('brand') ?>" class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
                                <?php if ($errors['brand'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['brand'] ?></span><?php endif ?>
                            </div>

                            <div class="flex flex-col gap-1">
                                <label for="model" class="text-xs text-grey">Modèle</label>
                                <input type="text" id="model" name="model" value="<?= old('model') ?>" class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
                                <?php if ($errors['model'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['model'] ?></span><?php endif ?>
                            </div>

                            <div class="flex flex-col gap-1">
                                <label for="color" class="text-xs text-grey">Couleur</label>
                                <input type="text" id="color" name="color" value="<?= old('color') ?>" class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
                                <?php if ($errors['color'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['color'] ?></span><?php endif ?>
                            </div>

                            <div class="flex flex-col gap-1">
                                <label for="year" class="text-xs text-grey">Année</label>
                                <input type="text" id="year" name="year" value="<?= old('year') ?>" class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
                                <?php if ($errors['year'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['year'] ?></span><?php endif ?>
                            </div>

                            <div class="flex flex-col gap-1 md:col-span-2">
                                <label for="places" class="text-xs text-grey">Nombre de places</label>
                                <input type="number" id="places" name="places" value="<?= old('places') ?>" class="border border-babyblue rounded-lg px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey">
                                <?php if ($errors['number_of_seat'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['number_of_seat'] ?></span><?php endif ?>
                            </div>

                        </div>

                        <div class="flex gap-2 mt-2">
                            <button type="submit" class="flex-1 bg-bluegrey hover:bg-[#1a2f55] text-white rounded-xl py-2 text-sm transition-colors duration-200">Ajouter</button>
                            <button type="button" onclick="hideForm('add-car-form')" class="flex-1 border border-babyblue text-bluegrey rounded-xl py-2 text-sm hover:bg-lightblue transition-colors duration-200">Annuler</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>

                <!-- Trajets conducteur -->
                <div class="mb-6">
                    <h3 class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase mb-2">Mes trajets proposés</h3>
                    <h4 class="text-xs font-poppins text-grey mb-2">À venir</h4>
                    <ul class="flex flex-col gap-2">
                        <!-- boucle trajets à venir -->
                        <?php if (empty($driveUpcoming)): ?>
                            <p class="text-sm text-grey">Aucun trajet à venir.</p>
                        <?php else: ?>
                            <?php foreach ($driveUpcoming as $journey): ?>
                                <li class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                                    <div>
                                        <?php // Villes — à décommenter quand Track sera défini 
                                        ?>
                                        <p class="nav-m"><?= format_date_fr($journey['departure']) ?></p>
                                    </div>
                                    <span class="nav-d bg-lightblue rounded-full px-3 py-0.5"><?= esc($journey['places_restantes']) ?>/<?= esc($journey['number_of_place']) ?></span>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <!-- boucle trajets passés -->
                        <?php if (empty($drivePast)): ?>
                            <p class="text-sm text-grey">Aucun trajet passé.</p>
                        <?php else: ?>
                            <?php foreach ($drivePast as $journey): ?>
                                <li class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                                    <div>
                                        <?php // Villes — à décommenter quand Track sera défini 
                                        ?>
                                        <p class="nav-m"><?= format_date_fr($journey['departure']) ?></p>
                                    </div>
                                    <span class="text-xs font-poppins text-grey bg-lightblue rounded-full px-3 py-0.5">Effectué</span>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Demandes en attente -->
                <?php if (isset($pendingRequests)): ?>
                    <div class="mb-6">
                        <h3 class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase mb-2">Demandes en attente de validation</h3>
                        <ul class="flex flex-col gap-2">
                            <!-- boucle validations -->
                            <?php if (empty($pendingRequests)): ?>
                                <p class="text-sm text-grey">Aucune demande en attente.</p>
                            <?php else: ?>
                                <?php foreach ($pendingRequests as $request): ?>
                                    <li class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                                        <div>
                                            <?php // Villes — à décommenter quand Track sera défini 
                                            ?>
                                            <p class="nav-m"><?= esc($request['passenger_name']) ?></p>
                                            <p class="text-xs text-grey"><?= esc($request['journey']['departure']) ?></p>
                                        </div>
                                        <div class="flex gap-2">
                                            <form action="<?= site_url('reservation/accepter/' . $request['id_booking']) ?>" method="post">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="text-xs text-bluegrey border border-babyblue rounded-full px-3 py-1 hover:bg-lightblue transition-colors duration-150">✓</button>
                                            </form>
                                            <form action="<?= site_url('reservation/refuser/' . $request['id_booking']) ?>" method="post">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="text-xs text-red-500 border border-red-200 rounded-full px-3 py-1 hover:bg-red-50 transition-colors duration-150">✗</button>
                                            </form>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </ul>
                    </div>
                <?php endif; ?>

            </section>

            <!-- Section passager -->
            <section id="passenger" class="mb-6">

                <div class="mb-6">
                    <h3 class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase mb-2">Mes statistiques</h3>
                    <ul class="flex flex-col gap-2">
                        <li class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                            <span class="text-sm text-bluegrey">Trajets effectués</span>
                            <span class="nav-d bg-lightblue rounded-full px-3 py-0.5">0</span>
                        </li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase mb-2">Mes trajets</h3>
                    <!-- boucle trajets passager -->
                    <h4 class="text-xs font-poppins text-grey mb-2">À venir</h4>
                    <ul class="flex flex-col gap-2 mb-3">
                        <?php if (empty($upcomingConfirmed)): ?>
                            <p class="text-sm text-grey">Aucun trajet confirmé.</p>
                        <?php else: ?>
                            <?php foreach ($upcomingConfirmed as $booking): ?>
                                <li class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                                    <div>
                                        <?php // Villes — à décommenter quand Track sera défini 
                                        ?>
                                        <p class="nav-m"><?= format_date_fr($booking['journey']['departure']) ?></p>
                                        <p class="text-xs text-grey"><?= esc($booking['driver_name']) ?></p>
                                    </div>
                                    <span class="text-xs font-poppins text-white bg-green-500 rounded-full px-3 py-0.5">Confirmé</span>
                                    <form action="<?= site_url('reservation/annuler/' . $booking['id_booking']) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="text-xs text-red-500 border border-red-200 rounded-full px-3 py-1 hover:bg-red-50 transition-colors duration-150">Annuler</button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>

                    <h4 class="text-xs font-poppins text-grey mb-2">En attente</h4>
                    <ul class="flex flex-col gap-2 mb-3">
                        <?php if (empty($upcomingPending)): ?>
                            <p class="text-sm text-grey">Aucune demande en attente.</p>
                        <?php else: ?>
                            <?php foreach ($upcomingPending as $booking): ?>
                                <li class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                                    <div>
                                        <?php // Villes — à décommenter quand Track sera défini 
                                        ?>
                                        <p class="nav-m"><?= format_date_fr($booking['journey']['departure']) ?></p>
                                        <p class="text-xs text-grey"><?= esc($booking['driver_name']) ?></p>
                                    </div>
                                    <span class="text-xs font-poppins text-white bg-orange-400 rounded-full px-3 py-0.5">En attente</span>
                                    <form action="<?= site_url('reservation/annuler/' . $booking['id_booking']) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="text-xs text-red-500 border border-red-200 rounded-full px-3 py-1 hover:bg-red-50 transition-colors duration-150">Annuler</button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>

                    <h4 class="text-xs font-poppins text-grey mb-2">Passés</h4>
                    <ul class="flex flex-col gap-2">
                        <?php if (empty($pastJourney)): ?>
                            <p class="text-sm text-grey">Aucun trajet passé.</p>
                        <?php else: ?>
                            <?php foreach ($pastJourney as $booking): ?>
                                <li class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                                    <div>
                                        <?php // Villes — à décommenter quand Track sera défini 
                                        ?>
                                        <p class="nav-m"><?= format_date_fr($booking['journey']['departure']) ?></p>
                                        <p class="text-xs text-grey"><?= esc($booking['driver_name']) ?></p>
                                    </div>
                                    <span class="text-xs font-poppins text-grey bg-lightblue rounded-full px-3 py-0.5"><?= $booking['is_validated'] ? 'Effectué' : 'Refusé' ?></span>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>

                </div>

            </section>

            <!-- Paramètres -->
            <section id="parameters" class="mb-6">
                <h3 class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase mb-2">Paramètres</h3>
                <h4 class="text-xs font-poppins text-grey mb-2">Compte</h4>
                <ul class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <li>
                        <a href="profil/modify" class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3 hover:bg-lightblue transition-colors duration-150">
                            <div>
                                <p class="nav-m">Informations personnelles</p>
                                <p class="text-xs text-grey">Nom, email, photo...</p>
                            </div>
                            <span class="text-grey">›</span>
                        </a>
                    </li>
                    <li>
                        <a href="profil/changePassword" class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3 hover:bg-lightblue transition-colors duration-150">
                            <p class="nav-m">Mot de passe</p>
                            <span class="text-grey">›</span>
                        </a>
                    </li>
                </ul>
            </section>

            <!-- Boutons -->
            <section class="flex flex-col md:flex-row-reverse gap-3 pb-6">
                <form action="user/delete" method="post" class="w-full">
                    <?= csrf_field() ?>
                    <button type="submit" class="w-full border border-red-200 text-red-500 rounded-xl py-3 text-sm hover:bg-red-50 transition-colors duration-200">
                        Supprimer mon compte
                    </button>
                </form>
                <a href="/logout" class="w-full border border-babyblue text-bluegrey rounded-xl py-3 text-sm hover:bg-lightblue transition-colors duration-200 text-center block">
                    Se déconnecter
                </a>
            </section>

        </div>
    </div>

</main>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function showForm(id) {
        document.querySelector('#' + id).style.display = 'flex'
    }

    function hideForm(id) {
        document.querySelector('#' + id).style.display = 'none'
    }

    function toggleMode() {
        const driver = document.getElementById('driver');
        const passenger = document.getElementById('passenger');
        const thumb = document.getElementById('toggle-thumb');

        const isDriver = driver.style.display !== 'none';

        if (isDriver) {
            driver.style.display = 'none';
            passenger.style.display = 'block';
            thumb.style.left = '1.75rem';
            thumb.textContent = '🚶';
        } else {
            driver.style.display = 'block';
            passenger.style.display = 'none';
            thumb.style.left = '0.25rem';
            thumb.textContent = '🚗';
        }
    }

    document.getElementById('passenger').style.display = 'none';
</script>
<?= $this->endSection() ?>