<div>
    <?= form_open('/contact') ?>

    <div class="flex flex-col gap-4 mb-5">

        <div class="flex flex-col gap-1.5">
            <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">Nom</label>
            <input class="w-full border border-input-border bg-input-bg rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white focus:shadow-[0_0_0_3px_rgba(13,59,94,0.08)] transition-all duration-200" type="text" name="last_name" placeholder="Dupont" required>
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">Prénom</label>
            <input class="w-full border border-[rgba(13,59,94,0.25)] bg-[#F7FAFB] rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white focus:shadow-[0_0_0_3px_rgba(13,59,94,0.08)] transition-all duration-200" type="text" name="first_name" placeholder="Marie" required>
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">E-mail</label>
            <input class="w-full border border-[rgba(13,59,94,0.25)] bg-[#F7FAFB] rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white focus:shadow-[0_0_0_3px_rgba(13,59,94,0.08)] transition-all duration-200" type="email" name="email" placeholder="ton@email.fr" required>
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">Motif</label>
            <select class="w-full border border-[rgba(13,59,94,0.25)] bg-[#F7FAFB] rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white transition-all duration-200" name="motif" required>
                <option value="" disabled selected>Sélectionner un motif</option>
                <option value="information">Demande d'information</option>
                <option value="problem">Signaler un problème</option>
                <option value="account">Problème de compte</option>
                <option value="traject">Problème de trajet</option>
                <option value="other">Autre</option>
            </select>
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">Message</label>
            <textarea class="w-full border border-[rgba(13,59,94,0.25)] bg-[#F7FAFB] rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white focus:shadow-[0_0_0_3px_rgba(13,59,94,0.08)] transition-all duration-200 resize-none h-28" name="message" placeholder="Décris ton problème ou ta question..." required></textarea>
        </div>

    </div>

    <button type="submit" name="submit" class="w-full bg-ocean hover:bg-ocean-light text-white rounded-xl py-3 text-xs font-medium tracking-widest transition-all duration-200 hover:shadow-[0_4px_16px_rgba(13,59,94,0.25)] active:scale-[0.98]">
        Envoyer →
    </button>

    <?= form_close() ?>
</div>