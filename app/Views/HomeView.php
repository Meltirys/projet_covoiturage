<?= view('commons/header') ?>

<main class="bg-lightgrey min-h-screen px-5 py-8 font-poppins">

    <?php if (!session('logged_in')) : ?>

        <!-- HERO -->
        <section class="mb-8">
            <div class="flex items-start gap-3 mb-4">
                <img src="/img/logo.png" alt="PennRide" class="w-12 h-12 rounded-xl">
            </div>
            <p class="text-xs tracking-widest text-grey uppercase mb-4">
                L'application de covoiturage<br>réservée aux membres du GRETA.
            </p>
            <h1 class="text-xl font-light text-dark leading-snug font-medium mb-4">
                Tu es membre du GRETA ?<br>
                Tu cherches une solution<br>
                de covoiturage ?<br>
                Tu es au bon endroit. 🚗
            </h1>
            <p class="text-sm text-grey leading-relaxed">
                <strong class="font-semibold">Cette application est uniquement accessible aux membres du GRETA.</strong><br>
                S'il s'agit de ton cas, crée ton compte et commence à covoiturer avec tes collègues.
            </p>
        </section>

        <!-- ONGLETS -->
        <div class="flex gap-6 mb-5 border-b border-babyblue">
            <button class="auth-menu-btn text-xs font-medium text-bluegrey border-b-2 border-bluegrey pb-2 -mb-px transition-all" data-tab="tab-login">
                TE CONNECTER
            </button>
            <button class="auth-menu-btn text-xs font-medium text-grey border-b-2 border-transparent pb-2 -mb-px transition-all" data-tab="tab-inscription">
                T'INSCRIRE
            </button>
            <button class="auth-menu-btn text-xs font-medium text-grey border-b-2 border-transparent pb-2 -mb-px transition-all" data-tab="tab-inscription">
                NOUS CONTACTER
            </button>
        </div>

        <!-- FORMULAIRE CONNEXION -->
        <div id="tab-login" class="auth-form-panel">
            <?php if (!empty($message) && ($activeTab ?? 'login') === 'login'): ?>
                <div class="text-xs text-red-500 mb-3"><?= $message ?></div>
            <?php endif; ?>

            <div class="bg-babyblue rounded-2xl p-5 border border-bluegrey flex flex-col gap-4">
                <form action="<?= site_url('authentification') ?>" method="POST" class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium tracking-widest text-bluegrey uppercase" for="email-auth">E-mail</label>
                        <input class="w-full rounded-xl bg-lightblue! border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="email" id="email-auth" name="email-auth" required>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium tracking-widest text-bluegrey uppercase" for="password-auth">Mot de passe</label>
                        <input class="w-full rounded-xl bg-lightblue! border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="password" id="password-auth" name="password-auth" required>
                    </div>
                    <div class="flex justify-center mt-2">
                        <button type="submit" class="border border-bluegrey text-bluegrey text-xs font-medium px-6 py-2 rounded-full hover:bg-bluegrey hover:text-white transition-all">
                            Je me connecte
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- FORMULAIRE INSCRIPTION -->
        <div id="tab-inscription" class="auth-form-panel hidden">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="text-sm text-green-600 mb-3"><?= session()->getFlashdata('success') ?></div>
            <?php endif ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="text-sm text-red-500 mb-3"><?= session()->getFlashdata('error') ?></div>
            <?php endif ?>

            <div class="bg-babyblue rounded-2xl p-5 flex flex-col gap-4">
                <?= form_open('/signup') ?>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold tracking-widest text-bluegrey uppercase">Nom</label>
                        <input class="w-full bg-transparent border-b border-bluegrey pb-1 text-sm text-bluegrey focus:outline-none" type="text" name="last_name" value="<?= set_value('last_name') ?>" required>
                        <?php if ($errors['last_name'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['last_name'] ?></span><?php endif ?>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold tracking-widest text-bluegrey uppercase">Prénom</label>
                        <input class="w-full bg-transparent border-b border-bluegrey pb-1 text-sm text-bluegrey focus:outline-none" type="text" name="first_name" value="<?= set_value('first_name') ?>" required>
                        <?php if ($errors['first_name'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['first_name'] ?></span><?php endif ?>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold tracking-widest text-bluegrey uppercase">E-mail</label>
                        <input class="w-full bg-transparent border-b border-bluegrey pb-1 text-sm text-bluegrey focus:outline-none" type="email" name="email-signup" value="<?= set_value('email-signup') ?>" required>
                        <?php if ($errors['email'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['email'] ?></span><?php endif ?>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold tracking-widest text-bluegrey uppercase">Téléphone</label>
                            <input class="w-full bg-transparent border-b border-bluegrey pb-1 text-sm text-bluegrey focus:outline-none" type="tel" name="phone" value="<?= set_value('phone') ?>">
                            <?php if ($errors['phone'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['phone'] ?></span><?php endif ?>
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold tracking-widest text-bluegrey uppercase">Date de naissance</label>
                            <input class="w-full bg-transparent border-b border-bluegrey pb-1 text-sm text-bluegrey focus:outline-none" type="date" name="birth_date" value="<?= set_value('birth_date') ?>" required>
                            <?php if ($errors['birth_date'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['birth_date'] ?></span><?php endif ?>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold tracking-widest text-bluegrey uppercase">
                            Mot de passe
                            <span class="normal-case font-light tracking-normal text-grey"> (8 caractères min., 1 majuscule, 1 chiffre)</span>
                        </label>
                        <input class="w-full bg-transparent border-b border-bluegrey pb-1 text-sm text-bluegrey focus:outline-none" type="password" name="password" required>
                        <?php if ($errors['password'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['password'] ?></span><?php endif ?>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold tracking-widest text-bluegrey uppercase">Confirmation du mot de passe</label>
                        <input class="w-full bg-transparent border-b border-bluegrey pb-1 text-sm text-bluegrey focus:outline-none" type="password" name="password_conf" required>
                        <?php if ($errors['password_conf'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['password_conf'] ?></span><?php endif ?>
                    </div>

                    <div class="flex justify-center mt-2">
                        <button type="submit" name="submit" class="border border-bluegrey text-bluegrey text-sm font-medium px-6 py-2 rounded-full hover:bg-bluegrey hover:text-white transition-all">
                            Je m'inscris
                        </button>
                    </div>

                <?= form_close() ?>
            </div>
        </div>

    <?php else: ?>
        <p class="text-bluegrey">Bonjour <?= session()->user_name ?></p>
        <a href="/logout" class="text-sm text-grey underline">Se déconnecter</a>
    <?php endif; ?>

</main>

<script>
    const btns = document.querySelectorAll('.auth-menu-btn');
    const panels = document.querySelectorAll('.auth-form-panel');

    btns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            panels.forEach(p => p.classList.add('hidden'));
            document.getElementById(btn.dataset.tab).classList.remove('hidden');

            btns.forEach(b => {
                b.classList.remove('text-bluegrey', 'border-bluegrey');
                b.classList.add('text-grey', 'border-transparent');
            });
            btn.classList.remove('text-grey', 'border-transparent');
            btn.classList.add('text-bluegrey', 'border-bluegrey');
        });
    });
</script>