<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="profile-hero px-4 md:px-8 py-10 md:py-14 mb-8">
    <div class="relative z-10 max-w-5xl mx-auto">
        <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5">
            Trajets
        </p>
        <h1 class="font-pfd text-4xl md:text-6xl font-light leading-[0.92] tracking-tight text-lightgrey">
            Modifier<br>
            <em class="italic text-gold">ma demande</em>
        </h1>
    </div>
</div>

<main class="w-full max-w-5xl mx-auto px-4 md:px-8 pb-12 font-poppins">

    <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden">
        <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
        <div class="p-5">

            <?= form_open('request/update/' . $request['id_journey_request'], ['class' => 'flex flex-col gap-4']) ?>

            <!-- Horaires de disponibilité -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6">
                <div class="flex flex-col gap-1">
                    <label for="request-range-start" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Début de disponibilité</label>
                    <input type="time" name="request[range-start]" id="request-range-start"
                        value="<?= esc($request['earliest_departure']) ?>"
                        class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" required>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="request-range-end" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Fin de disponibilité</label>
                    <input type="time" name="request[range-end]" id="request-range-end"
                        value="<?= esc($request['latest_departure']) ?>"
                        class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors" required>
                </div>
            </div>

            <!-- Description -->
            <div class="flex flex-col gap-1">
                <label for="request-description" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Description</label>
                <textarea name="request[description]" id="request-description"
                    class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors"
                    placeholder="Entrez une description"><?= esc($request['description']) ?></textarea>
            </div>

            <div class="flex justify-end mt-2">
                <button type="submit"
                    class="bg-gold text-ocean font-semibold text-sm px-6 py-2 rounded-full hover:opacity-90 transition-opacity cursor-pointer">
                    Sauvegarder les modifications →
                </button>
            </div>

            <?= form_close() ?>

        </div>
    </div>

</main>

<?= $this->endSection() ?>
