<?= view('commons/header') ?>

<h1>Changer le mot de passe</h1>

<!-- Error or success message block -->
<?php if (session()->getFlashdata('password_success')): ?>
    <p class="text-xs text-green-600 mb-3"><?= session()->getFlashdata('password_success') ?></p>
<?php endif ?>
<?php if (session()->getFlashdata('password_error')): ?>
    <p class="text-xs text-red-500 mb-3"><?= session()->getFlashdata('password_error') ?></p>
<?php endif ?>

<!-- Form -->
<?= form_open('/user/updatePassword') ?>
<div>

    <div class="bg-babyblue border border-bluegrey rounded-2xl p-5 flex flex-col gap-3 mb-4">

        <!-- Old password -->
        <div class="flex flex-col gap-1">
            <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">
                Ancien mot de passe <br>
            </label>
            <input class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="password" name="old_password" required>
            <?php if ($errors['old_password'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['old_password'] ?></span><?php endif ?>
        </div>

        <!-- New password -->
        <div class="flex flex-col gap-1">
            <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">
                Nouveau mot de passe <br>
                <span class="normal-case font-light tracking-normal text-grey"> (8 caractères min., 1 majuscule, 1 chiffre et un caractère spécial)</span>
            </label>
            <input class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="password" name="password" required>
            <?php if ($errors['password'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['password'] ?></span><?php endif ?>
        </div>

        <!-- New password confirmation -->
        <div class="flex flex-col gap-1">
            <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">Confirmation du nouveau mot de passe</label>
            <input class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="password" name="password_conf" required>
            <?php if ($errors['password_conf'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['password_conf'] ?></span><?php endif ?>
        </div>

    </div>
    <div class="flex justify-center mt-2">
        <button type="submit" name="submit" class="border border-bluegrey text-bluegrey bg-babyblue text-sm font-medium px-6 py-2 rounded-full hover:bg-bluegrey hover:text-white transition-all">
            Modifier le mot de passe
        </button>
    </div>
</div>
<?= form_close() ?>