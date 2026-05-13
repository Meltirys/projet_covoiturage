<div>
    <h2>Mon profil</h2>
    <p>{button}</p>

    <div id="name">
        <span id="first-name"><?= session('user_first_name') ?></span>
        <span id="last-name"><?= session('user_last_name') ?></span>
    </div>
</div>

<section id="driver">

    <div id="stats-driver">
        <h3>Mes statistiques</h3>
    </div>
    <div id="car">
        <h3>Mes véhicules</h3>
        <div id="my-cars">
            <?php if (isset($usersCar) && !empty($usersCar)): ?>
            <?php else: ?>
                <p>Aucune voiture ajoutée pour le moment</p>
            <?php endif; ?>
        </div>
        <section id="add-car">

            <button onclick="showForm('add-car-form')">+ ajouter un véhicule</button>

            <div id="add-car-form" style="display: <?= (session()->getFlashdata('error_in_car_form')) ? 'flex' : 'none' ?>">
                <?= form_open("/newCar") ?>
                <div>
                    <div>
                        <label for="brand">Marque</label>
                        <input type="text" id="brand" name="brand">
                    </div>
                    <?php if ($errors['brand'] ?? null): ?>
                        <span class="error"><?= $errors['brand'] ?></span>
                    <?php endif ?>
                </div>
                <div>
                    <div>
                        <label for="model">Modèle</label>
                        <input type="text" id="model" name="model">
                    </div>
                    <?php if ($errors['model'] ?? null): ?>
                        <span class="error"><?= $errors['model'] ?></span>
                    <?php endif ?>
                </div>

                <div>
                    <div>
                        <label for="color">Couleur</label>
                        <input type="text" id="color" name="color">
                    </div>
                    <?php if ($errors['color'] ?? null): ?>
                        <span class="error"><?= $errors['color'] ?></span>
                    <?php endif ?>
                </div>

                <div>
                    <div>
                        <label for="year">Année</label>
                        <input type="text" id="year" name="year">
                    </div>
                    <?php if ($errors['year'] ?? null): ?>
                        <span class="error"><?= $errors['year'] ?></span>
                    <?php endif ?>
                </div>

                <div>
                    <div>
                        <label for="places">Nombre de places</label>
                        <input type="number" id="places" name="places">
                    </div>
                    <?php if ($errors['places'] ?? null): ?>
                        <span class="error"><?= $errors['places'] ?></span>
                    <?php endif ?>
                </div>

                <button type="submit">Ajouter</button>
                <button onclick="hideForm('add-car-form')">Annuler</button>
                <?= form_close() ?>
            </div>

        </section>
    </div>

    <div id="journey-driver">
        <h3>Mes trajets proposés</h3>
    </div>

    <?php if (isset($validationList)): //To modify when the function is done 
    ?>
        <div id="validations">
            <h3>Demandes en attente de validation</h3>
        </div>
    <?php endif; ?>


</section>

<hr>

<section id="passenger">
    <div id="stats-passenger">
        <h3>Mes statistiques</h3>
    </div>

    <div id="journey-passenger">

    </div>


</section>

<section id="parameters">
    <h3>Paramètres</h3>
    <div>
        <div>
            <h4>Compte</h4>
            <p>Informations personnelles</p>
            <p>Nom, email, photo...</p>
        </div>
        <span>></span>
    </div>

    <div>
        <div>
            <p>Mot de passe</p>
        </div>
        <span>></span>
    </div>

</section>

<section id="profil-buttons">
    <button>Supprimer mon compte</button>
    <a href="/logout">Se déconnecter</a>
</section>

<script>
    function showForm(formId) {
        let form = document.querySelector("#" + formId)
        form.style.display = "block"
    }

    function hideForm(formId) {
        let form = document.querySelector("#" + formId)
        form.style.display = "none"
    }
</script>