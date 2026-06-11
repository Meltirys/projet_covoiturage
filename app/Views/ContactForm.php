<div>
    <?= form_open('/contact') ?>
    <div class="flex flex-col gap-4 mb-5">

        <div class="flex flex-col gap-1.5">
            <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Nom</label>
            <input class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-all duration-200" type="text" name="last_name" placeholder="Dupont" required>
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Prénom</label>
            <input class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-all duration-200" type="text" name="first_name" placeholder="Marie" required>
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">E-mail</label>
            <input class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-all duration-200" type="email" name="email" placeholder="ton@email.fr" required>
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Motif</label>
            <select class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey focus:outline-none focus:border-gold/40 transition-all duration-200" name="motif" required>
                <option value="" disabled selected>Sélectionner un motif</option>
                <option value="information">Demande d'information</option>
                <option value="problem">Signaler un problème</option>
                <option value="account">Problème de compte</option>
                <option value="traject">Problème de trajet</option>
                <option value="other">Autre</option>
            </select>
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Message</label>
            <textarea class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-all duration-200 resize-none h-28" name="message" placeholder="Décris ton problème ou ta question..." required></textarea>
        </div>

    </div>

    <button type="submit" name="submit"
        class="w-full bg-gold text-ocean font-semibold rounded-xl py-3 text-xs tracking-widest transition-all duration-200 hover:opacity-90 active:scale-[0.98] cursor-pointer">
        Envoyer →
    </button>

    <?= form_close() ?>
</div>