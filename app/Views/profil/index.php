<?= view('commons/header') ?>

<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

    <!-- En-tête -->
    <header class="flex justify-between items-center mb-4">
        <h2 class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Mon profil</h2>
        <p>{button}</p>
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
                    <h3 class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase mb-2">Mes statistiques</h3>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <li class="flex justify-between items-center bg-white border border-[rgba(37,63,114,0.25)] rounded-xl px-4 py-3">
                            <span class="text-sm text-[#253F72]">Trajets proposés</span>
                            <span class="text-xs font-poppins text-[#253F72] bg-[#D6E0F0] rounded-full px-3 py-0.5">0</span>
                        </li>
                        <li class="flex justify-between items-center bg-white border border-[rgba(37,63,114,0.25)] rounded-xl px-4 py-3">
                            <span class="text-sm text-[#253F72]">Passagers transportés</span>
                            <span class="text-xs font-poppins text-[#253F72] bg-[#D6E0F0] rounded-full px-3 py-0.5">0</span>
                        </li>
                    </ul>
                </div>

                <!-- Véhicules -->
                <div class="mb-6">
                    <h3 class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase mb-2">Mes véhicules</h3>

                    <div class="grid grid-cols-1 gap-2 mb-3">
                        <?php if ($cars): ?>
                            <?php foreach ($cars as $car): ?>
                                <div class="flex justify-between items-center bg-white border border-[rgba(37,63,114,0.25)] rounded-xl px-4 py-3">
                                    <div>
                                        <p class="text-sm font-poppins text-[#253F72]">
                                            <?= esc($car['brand']) ?> <?= esc($car['model']) ?>
                                        </p>
                                        <p class="text-xs text-[#9AA5B4]">
                                            <?= esc($car['color']) ?> - <?= esc($car['year']) ?> - <?= esc($car['number_of_seat']) ?> places
                                        </p>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="button">Modifier</button>
                                        <?= form_open('/car/delete/' . $car['id_car']) ?>
                                        <button type="submit">Supprimer</button>
                                        <?= form_close() ?>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        <?php else: ?>
                            <p class="text-sm text-[#9AA5B4] text-center py-3">Aucune voiture ajoutée pour le moment</p>
                        <?php endif; ?>
                    </div>

                    <?php if (session()->getFlashdata('car_added')): ?>
                        <p class="text-xs text-green-600 mb-3"><?= session()->getFlashdata('car_added') ?></p>
                    <?php endif ?>
                    <?php if (session()->getFlashdata('car_not_added')): ?>
                        <p class="text-xs text-red-500 mb-3"><?= session()->getFlashdata('car_not_added') ?></p>
                    <?php endif ?>

                    <button onclick="showForm('add-car-form')" class="text-xs text-[#9AA5B4] underline block text-right w-full mb-3">
                        + ajouter un véhicule
                    </button>

                    <div id="add-car-form" style="display: <?= session()->getFlashdata('error_in_car_form') ? 'flex' : 'none' ?>" class="flex-col gap-3">
                        <?= form_open("car/add") ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                            <div class="flex flex-col gap-1">
                                <label for="brand" class="text-xs text-[#9AA5B4]">Marque</label>
                                <input type="text" id="brand" name="brand" value="<?= old('brand') ?>" class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]">
                                <?php if ($errors['brand'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['brand'] ?></span><?php endif ?>
                            </div>

                            <div class="flex flex-col gap-1">
                                <label for="model" class="text-xs text-[#9AA5B4]">Modèle</label>
                                <input type="text" id="model" name="model" value="<?= old('model') ?>" class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]">
                                <?php if ($errors['model'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['model'] ?></span><?php endif ?>
                            </div>

                            <div class="flex flex-col gap-1">
                                <label for="color" class="text-xs text-[#9AA5B4]">Couleur</label>
                                <input type="text" id="color" name="color" value="<?= old('color') ?>" class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]">
                                <?php if ($errors['color'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['color'] ?></span><?php endif ?>
                            </div>

                            <div class="flex flex-col gap-1">
                                <label for="year" class="text-xs text-[#9AA5B4]">Année</label>
                                <input type="text" id="year" name="year" value="<?= old('year') ?>" class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]">
                                <?php if ($errors['year'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['year'] ?></span><?php endif ?>
                            </div>

                            <div class="flex flex-col gap-1 md:col-span-2">
                                <label for="places" class="text-xs text-[#9AA5B4]">Nombre de places</label>
                                <input type="number" id="places" name="places" value="<?= old('places') ?>" class="border border-[rgba(37,63,114,0.25)] rounded-lg px-3 py-2 text-sm text-[#253F72] focus:outline-none focus:border-[#253F72]">
                                <?php if ($errors['number_of_seat'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['number_of_seat'] ?></span><?php endif ?>
                            </div>

                        </div>

                        <div class="flex gap-2 mt-2">
                            <button type="submit" class="flex-1 bg-[#253F72] hover:bg-[#1a2f55] text-white rounded-xl py-2 text-sm transition-colors duration-200">Ajouter</button>
                            <button type="button" onclick="hideForm('add-car-form')" class="flex-1 border border-[rgba(37,63,114,0.25)] text-[#253F72] rounded-xl py-2 text-sm hover:bg-[#D6E0F0] transition-colors duration-200">Annuler</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>

                <!-- Trajets conducteur -->
                <div class="mb-6">
                    <h3 class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase mb-2">Mes trajets proposés</h3>
                    <h4 class="text-xs font-poppins text-[#9AA5B4] mb-2">À venir</h4>
                    <ul class="flex flex-col gap-2">
                        <!-- boucle trajets à venir -->
                    </ul>
                    <h4 class="text-xs font-poppins text-[#9AA5B4] mb-2">Passés</h4>
                    <ul class="flex flex-col gap-2">
                        <!-- boucle trajets passés -->
                    </ul>
                </div>

                <!-- Demandes en attente -->
                <?php if (isset($validationList)): ?>
                    <div class="mb-6">
                        <h3 class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase mb-2">Demandes en attente de validation</h3>
                        <ul class="flex flex-col gap-2">
                            <!-- boucle validations -->
                        </ul>
                    </div>
                <?php endif; ?>

            </section>

            <!-- Section passager -->
            <section id="passenger" class="mb-6">

                <div class="mb-6">
                    <h3 class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase mb-2">Mes statistiques</h3>
                    <ul class="flex flex-col gap-2">
                        <li class="flex justify-between items-center bg-white border border-[rgba(37,63,114,0.25)] rounded-xl px-4 py-3">
                            <span class="text-sm text-[#253F72]">Trajets effectués</span>
                            <span class="text-xs font-poppins text-[#253F72] bg-[#D6E0F0] rounded-full px-3 py-0.5">0</span>
                        </li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase mb-2">Mes trajets</h3>
                    <!-- boucle trajets passager -->
                </div>

            </section>

            <!-- Paramètres -->
            <section id="parameters" class="mb-6">
                <h3 class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase mb-2">Paramètres</h3>
                <h4 class="text-xs font-poppins text-[#9AA5B4] mb-2">Compte</h4>
                <ul class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <li>
                        <a href="#" class="flex justify-between items-center bg-white border border-[rgba(37,63,114,0.25)] rounded-xl px-4 py-3 hover:bg-[#D6E0F0] transition-colors duration-150">
                            <div>
                                <p class="text-sm font-poppins text-[#253F72]">Informations personnelles</p>
                                <p class="text-xs text-[#9AA5B4]">Nom, email, photo...</p>
                            </div>
                            <span class="text-[#9AA5B4]">›</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex justify-between items-center bg-white border border-[rgba(37,63,114,0.25)] rounded-xl px-4 py-3 hover:bg-[#D6E0F0] transition-colors duration-150">
                            <p class="text-sm font-poppins text-[#253F72]">Mot de passe</p>
                            <span class="text-[#9AA5B4]">›</span>
                        </a>
                    </li>
                </ul>
            </section>

            <!-- Boutons -->
            <section class="flex flex-col md:flex-row-reverse gap-3 pb-6">
                <button class="w-full border border-[rgba(224,83,83,0.3)] text-[#E05353] rounded-xl py-3 text-sm hover:bg-red-50 transition-colors duration-200">
                    Supprimer mon compte
                </button>
                <a href="/logout" class="w-full border border-[rgba(37,63,114,0.25)] text-[#253F72] rounded-xl py-3 text-sm hover:bg-[#D6E0F0] transition-colors duration-200 text-center block">
                    Se déconnecter
                </a>
            </section>

        </div>
    </div>

</main>

<script>
    function showForm(id) {
        document.querySelector('#' + id).style.display = 'flex'
    }

    function hideForm(id) {
        document.querySelector('#' + id).style.display = 'none'
    }
</script>