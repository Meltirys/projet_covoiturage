<div>
    <?= form_open('/contact', ['class' => '']) ?>
    <div class="bg-babyblue border border-bluegrey rounded-2xl p-5 mb-4 flex flex-col gap-3">

        <div class="flex flex-col gap-1">
            <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">Nom</label>
            <input class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="text" name="last_name" required>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">Prénom</label>
            <input class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="text" name="first_name" required>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">E-mail</label>
            <input class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="email" name="email" required>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">Motif</label>
            <select class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" name="motif" required>
                <option value="" disabled selected>Sélectionner un motif</option>
                <option value="information">Demande d'information</option>
                <option value="problem">Signaler un problème</option>
                <option value="account">Problème de compte</option>
                <option value="traject">Problème de trajet</option>
                <option value="other">Autre</option>
            </select>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">Message</label>
            <textarea class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none resize-none h-28" name="message" required></textarea>
        </div>



    </div>

    <div class="flex justify-center mt-2">
        <button type="submit" name="submit" class="border border-bluegrey text-bluegrey bg-babyblue text-sm font-medium px-6 py-2 rounded-full hover:bg-bluegrey hover:text-white transition-all">
            Envoyer
        </button>
    </div>
    <?= form_close() ?>
</div>