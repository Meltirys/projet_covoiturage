<?= view('commons/header') ?>

<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

    <header class="flex justify-between items-center mb-6">
        <h2 class="text-xs tracking-[0.15em] text-bluegrey uppercase">Changer le mot de passe</h2>
    </header>

    <?php if (session()->getFlashdata('password_success')): ?>
        <p class="text-xs text-green-600 border border-green-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('password_success') ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('password_error')): ?>
        <p class="text-xs text-red-500 border border-red-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('password_error') ?></p>
    <?php endif ?>

    <?= form_open('/user/updatePassword') ?>

    <div class="bg-white border border-babyblue rounded-xl p-5 flex flex-col gap-3 mb-4">

        <div class="flex flex-col gap-1">
            <label class="text-xs tracking-widest text-bluegrey uppercase">Ancien mot de passe</label>
            <input class="w-full rounded-xl border border-babyblue px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" type="password" name="old_password" required>
            <?php if ($errors['old_password'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['old_password'] ?></span><?php endif ?>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-xs tracking-widest text-bluegrey uppercase">
                Nouveau mot de passe
                <span class="normal-case font-light tracking-normal text-grey"> (8 caractères min., 1 majuscule, 1 chiffre et un caractère spécial)</span>
            </label>
            <input class="w-full rounded-xl border border-babyblue px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" type="password" name="password" required>
            <?php if ($errors['password'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['password'] ?></span><?php endif ?>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-xs tracking-widest text-bluegrey uppercase">Confirmation du nouveau mot de passe</label>
            <input class="w-full rounded-xl border border-babyblue px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-bluegrey" type="password" name="password_conf" required>
            <?php if ($errors['password_conf'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['password_conf'] ?></span><?php endif ?>
        </div>

    </div>

    <div class="flex justify-center mt-2">
        <button type="submit" name="submit" class="border border-babyblue text-bluegrey bg-white text-sm font-medium px-6 py-2 rounded-full hover:bg-bluegrey hover:text-white transition-all">
            Modifier le mot de passe
        </button>
    </div>

    <?= form_close() ?>

</main>

<?= view('commons/footer') ?>