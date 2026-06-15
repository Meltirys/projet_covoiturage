<?= view('layouts/main') ?>

<div class="profile-hero px-4 md:px-8 py-10 md:py-14 mb-8">
    <div class="relative z-10 max-w-5xl mx-auto">
        <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5">
            Mon espace
        </p>
        <h1 class="font-pfd text-4xl md:text-6xl font-light leading-[0.92] tracking-tight text-lightgrey">
            Informations<br>
            <em class="italic text-gold">personnelles</em>
        </h1>
    </div>
</div>

<main class="w-full max-w-5xl mx-auto px-4 md:px-8 pb-12 font-poppins">

    <?php if (session()->getFlashdata('success')): ?>
        <p class="text-xs text-green border border-green/30 rounded-lg px-3 py-2 mb-4"><?= session()->getFlashdata('success') ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p class="text-xs text-red border border-red/30 rounded-lg px-3 py-2 mb-4"><?= session()->getFlashdata('error') ?></p>
    <?php endif ?>

    <?= form_open('/user/update', ['enctype' => "multipart/form-data"]) ?>

    <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden mb-6">
        <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
        <div class="p-5 flex flex-col gap-4">

            <div class="flex flex-col gap-1">
                <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Nom</label>
                <input class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" type="text" name="last_name" value="<?= old('last_name', $user['last_name']) ?>" required>
                <?php if ($errors['last_name'] ?? null): ?><span class="text-xs text-red"><?= $errors['last_name'] ?></span><?php endif ?>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Prénom</label>
                <input class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" type="text" name="first_name" value="<?= old('first_name', $user['first_name']) ?>" required>
                <?php if ($errors['first_name'] ?? null): ?><span class="text-xs text-red"><?= $errors['first_name'] ?></span><?php endif ?>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Genre</label>
                <select class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" name="gender" required>
                    <option value="" disabled selected>Sélectionner</option>
                    <option value="female" <?= old('gender', $user['gender']) === 'female' ? 'selected' : '' ?>>Féminin</option>
                    <option value="male"   <?= old('gender', $user['gender']) === 'male'   ? 'selected' : '' ?>>Masculin</option>
                    <option value="none"   <?= old('gender', $user['gender']) === 'none'   ? 'selected' : '' ?>>Non communiqué</option>
                </select>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">E-mail</label>
                <input class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" type="email" name="email" value="<?= old('email', $user['email']) ?>" required>
                <?php if ($errors['email'] ?? null): ?><span class="text-xs text-red"><?= $errors['email'] ?></span><?php endif ?>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Adresse</label>
                <input class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" type="text" name="address" value="<?= old('address', $user['address']) ?>" required>
                <?php if ($errors['address'] ?? null): ?><span class="text-xs text-red"><?= $errors['address'] ?></span><?php endif ?>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1">
                    <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Code postal</label>
                    <input class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" type="text" name="postcode" value="<?= old('postcode', $user['postcode']) ?>">
                    <?php if ($errors['postcode'] ?? null): ?><span class="text-xs text-red"><?= $errors['postcode'] ?></span><?php endif ?>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Ville</label>
                    <input class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" type="text" name="city" value="<?= old('city', $user['city']) ?>" required>
                    <?php if ($errors['city'] ?? null): ?><span class="text-xs text-red"><?= $errors['city'] ?></span><?php endif ?>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-1">
                    <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Téléphone</label>
                    <input class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" type="tel" id="mobile" name="mobile" value="<?= old('mobile', $user['mobile']) ?>" oninput="formatPhone(this)">
                    <?php if ($errors['mobile'] ?? null): ?><span class="text-xs text-red"><?= $errors['mobile'] ?></span><?php endif ?>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Date de naissance</label>
                    <input class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" type="date" name="birth_date" value="<?= old('birth_date', $user['birth_date']) ?>" required>
                    <?php if ($errors['birth_date'] ?? null): ?><span class="text-xs text-red"><?= $errors['birth_date'] ?></span><?php endif ?>
                </div>
            </div>

        </div>
    </div>

    <div class="flex justify-end mb-10">
        <button type="submit" name="submit"
            class="bg-gold text-ocean font-semibold text-sm px-6 py-2.5 rounded-full hover:opacity-90 transition-opacity cursor-pointer">
            Enregistrer
        </button>
    </div>

    <?= form_close() ?>

    <?= form_open('user/avatar/update', ['enctype' => "multipart/form-data"]) ?>

    <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden mb-6">
        <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
        <div class="p-5 flex flex-col gap-4">

            <p class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Avatar</p>

            <?php if (session()->avatar_filename): ?>
                <div class="flex items-center gap-4">
                    <img src="<?= base_url('img/avatars/' . session()->avatar_filename) ?>" alt="Avatar" class="w-16 h-16 rounded-full object-cover border border-gold/20">
                    <span class="text-xs text-grey">Avatar actuel</span>
                </div>
            <?php else: ?>
                <p class="text-xs text-grey italic">Aucun avatar pour le moment.</p>
            <?php endif; ?>

            <div class="flex flex-col gap-1">
                <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-grey">Nouveau fichier</label>
                <input class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" type="file" name="avatar">
                <?php if ($errors['avatar'] ?? null): ?><span class="text-xs text-red"><?= $errors['avatar'] ?></span><?php endif ?>
            </div>

        </div>
    </div>

    <div class="flex justify-end gap-3">
        <button type="submit" form="deleteAvatarForm"
            class="border border-red/30 text-red text-sm px-6 py-2.5 rounded-full hover:bg-red/10 transition-colors cursor-pointer">
            Supprimer l'avatar
        </button>
        <button type="submit" name="submit"
            class="bg-gold text-ocean font-semibold text-sm px-6 py-2.5 rounded-full hover:opacity-90 transition-opacity cursor-pointer">
            <?= session('avatar_filename') ? 'Modifier' : 'Ajouter' ?>
        </button>
    </div>

    <?= form_close() ?>

    <?= form_open('user/avatar/delete', ['id' => 'deleteAvatarForm']) ?>
    <?= form_close() ?>

</main>

<script>
    function formatPhone(input) {
        let value = input.value.replace(/\D/g, '');
        value = value.match(/.{1,2}/g)?.join(' ') || '';
        input.value = value;
    }
    window.addEventListener('load', function() {
        const input = document.getElementById('mobile');
        if (input) formatPhone(input);
    });
</script>