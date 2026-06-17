<?php helper('form'); ?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="profile-hero px-4 md:px-8 py-10 md:py-14 mb-8">
    <div class="relative z-10 max-w-5xl mx-auto">
        <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5">
            Contact
        </p>
        <h1 class="font-pfd text-4xl md:text-6xl font-light leading-[0.92] tracking-tight text-lightgrey">
            Nous<br>
            <em class="italic text-gold">contacter</em>
        </h1>
    </div>
</div>

<main class="w-full max-w-5xl mx-auto px-4 md:px-8 pb-12 font-poppins">

    <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden">
        <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
        <div class="p-5">
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
    </div>

</main>

<?= $this->endSection() ?>