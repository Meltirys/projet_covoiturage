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

    <?php if (session()->getFlashdata('success')): ?>
        <p class="text-xs text-green mb-3"><?= session()->getFlashdata('success') ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p class="text-xs text-red mb-3"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden">
        <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
        <div class="p-5">
            <?= view('ContactForm') ?>
        </div>
    </div>

</main>

<?= $this->endSection() ?>