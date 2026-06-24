<div>
    <?= form_open('/contact') ?>
    <div class="flex flex-col gap-4 mb-5">
        <div class="flex flex-col gap-1.5">
            <label for="last_name_contact" class="text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold">Nom</label>
            <input class="w-full rounded-[14px] bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors" type="text" id="last_name_contact" name="last_name_contact" placeholder="Dupont" value="<?= old('last_name_contact') ?>" required>
            <?php if (isset($errors['last_name_contact'])): ?><span class="text-xs text-red"><?= $errors['last_name_contact'] ?></span><?php endif ?>

        </div>
        <div class="flex flex-col gap-1.5">
            <label for="first_name_contact" class="text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold">Prénom</label>
            <input class="w-full rounded-[14px] bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors" type="text" id="first_name_contact" name="first_name_contact" value="<?= old('first_name_contact') ?>" placeholder="Marie" required>
            <?php if (isset($errors['first_name_contact'])): ?><span class="text-xs text-red"><?= $errors['first_name_contact'] ?></span><?php endif ?>

        </div>
        <div class="flex flex-col gap-1.5">
            <label for="email_contact" class="text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold">E-mail</label>
            <input class="w-full rounded-[14px] bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors" type="email" id="email_contact" name="email_contact" value="<?= old('email_contact') ?>" placeholder="ton@email.fr" required>
            <?php if (isset($errors['email_contact'])): ?><span class="text-xs text-red"><?= $errors['email_contact'] ?></span><?php endif ?>

        </div>
        <div class="flex flex-col gap-1.5">
            <label class="text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold">Motif</label>
            <select class="w-full rounded-[14px] bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" name="motif" required>
                <option value="" disabled selected>Sélectionner un motif</option>
                <option value="information" <?= old('motif') == 'information' ? 'selected' : '' ?>>Demande d'information</option>
                <option value="problem" <?= old('motif') == 'problem' ? 'selected' : '' ?>>Signaler un problème</option>
                <option value="account" <?= old('motif') == 'account' ? 'selected' : '' ?>>Problème de compte</option>
                <option value="traject" <?= old('motif') == 'traject' ? 'selected' : '' ?>>Problème de trajet</option>
                <option value="other" <?= old('motif') == 'other' ? 'selected' : '' ?>>Autre</option>
            </select>
            <?php if (isset($errors['motif'])): ?><span class="text-xs text-red"><?= $errors['motif'] ?></span><?php endif ?>

        </div>
        <div class="flex flex-col gap-1.5">
            <label for="message" class="text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold">Message</label>
            <textarea class="w-full rounded-[14px] bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors resize-none h-28" id="message" name="message" placeholder="Décris ton problème ou ta question..." required><?= old('message', '') ?></textarea>
            <?php if (isset($errors['message'])): ?><span class="text-xs text-red"><?= $errors['message'] ?></span><?php endif ?>
        </div>
    </div>
    <button type="submit" name="submit"
        class="w-full bg-gold text-ocean font-semibold rounded-[14px] px-4 py-3 text-sm hover:bg-gold-light transition-colors cursor-pointer">
        Envoyer →
    </button>
    <?= form_close() ?>
</div>