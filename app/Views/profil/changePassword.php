<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="profile-hero px-4 md:px-8 py-10 md:py-14 mb-8">
    <div class="relative z-10 max-w-5xl mx-auto">
        <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5">
            Mon espace
        </p>
        <h1 class="font-pfd text-4xl md:text-6xl font-light leading-[0.92] tracking-tight text-lightgrey">
            Sécurité<br>
            <em class="italic text-gold">du compte</em>
        </h1>
    </div>
</div>

<main class="w-full max-w-5xl mx-auto px-4 md:px-8 pb-12 font-poppins">

    <?php if (session()->getFlashdata('password_success')): ?>
        <p class="text-xs text-green border border-green/30 rounded-lg px-3 py-2 mb-4"><?= session()->getFlashdata('password_success') ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('password_error')): ?>
        <p class="text-xs text-red border border-red/30 rounded-lg px-3 py-2 mb-4"><?= session()->getFlashdata('password_error') ?></p>
    <?php endif ?>

    <?= form_open('/user/updatePassword') ?>

    <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden mb-6">
        <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
        <div class="p-5 flex flex-col gap-4">

            <div class="flex flex-col gap-1">
                <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Ancien mot de passe</label>
                <input class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" type="password" name="old_password" required>
                <?php if ($errors['old_password'] ?? null): ?><span class="text-xs text-red"><?= $errors['old_password'] ?></span><?php endif ?>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">
                    Nouveau mot de passe
                    <span class="normal-case font-light tracking-normal text-grey"> (8 caractères min., 1 majuscule, 1 chiffre et un caractère spécial)</span>
                </label>
                <input class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" type="password" name="password" required>
                <?php if ($errors['password'] ?? null): ?><span class="text-xs text-red"><?= $errors['password'] ?></span><?php endif ?>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Confirmation du nouveau mot de passe</label>
                <input class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" type="password" name="password_conf" required>
                <?php if ($errors['password_conf'] ?? null): ?><span class="text-xs text-red"><?= $errors['password_conf'] ?></span><?php endif ?>
            </div>

        </div>
    </div>

    <div class="flex justify-end mb-10">
        <button type="submit" name="submit"
            class="bg-gold text-ocean font-semibold text-sm px-6 py-2.5 rounded-full hover:opacity-90 transition-opacity cursor-pointer">
            Modifier le mot de passe
        </button>
    </div>

    <?= form_close() ?>

</main>
<?= $this->endSection() ?>