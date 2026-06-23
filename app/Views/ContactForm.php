<div>
    <?= form_open('/contact') ?>
    <div class="flex flex-col gap-4 mb-5">
        <div class="flex flex-col gap-1.5">
            <label class="text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold">Nom</label>
            <input class="w-full rounded-[14px] bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors" type="text" name="last_name" placeholder="Dupont" required>
            <?php if (isset($last_name)): ?><span class="text-xs text-red"><?= $last_name ?></span><?php endif ?>

        </div>
        <div class="flex flex-col gap-1.5">
            <label class="text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold">Prénom</label>
            <input class="w-full rounded-[14px] bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors" type="text" name="first_name" placeholder="Marie" required>
            <?php if (isset($first_name)): ?><span class="text-xs text-red"><?= $first_name ?></span><?php endif ?>

        </div>
        <div class="flex flex-col gap-1.5">
            <label class="text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold">E-mail</label>
            <input class="w-full rounded-[14px] bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors" type="email" name="email" placeholder="ton@email.fr" required>
            <?php if (isset($email)): ?><span class="text-xs text-red"><?= $email ?></span><?php endif ?>

        </div>
        <div class="flex flex-col gap-1.5">
            <label class="text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold">Motif</label>
            <select class="w-full rounded-[14px] bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" name="motif" required>
                <option value="" disabled selected>Sélectionner un motif</option>
                <option value="information">Demande d'information</option>
                <option value="problem">Signaler un problème</option>
                <option value="account">Problème de compte</option>
                <option value="traject">Problème de trajet</option>
                <option value="other">Autre</option>
            </select>
            <?php if (isset($motif)): ?><span class="text-xs text-red"><?= $motif ?></span><?php endif ?>

        </div>
        <div class="flex flex-col gap-1.5">
            <label class="text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold">Message</label>
            <textarea class="w-full rounded-[14px] bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors resize-none h-28" name="message" placeholder="Décris ton problème ou ta question..." required></textarea>
            <?php if (isset($message)): ?><span class="text-xs text-red"><?= $message ?></span><?php endif ?>
        </div>
    </div>
    <button type="submit" name="submit"
        class="w-full bg-gold text-ocean font-semibold rounded-[14px] px-4 py-3 text-sm hover:bg-gold-light transition-colors cursor-pointer">
        Envoyer →
    </button>
    <?= form_close() ?>
</div>