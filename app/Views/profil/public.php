<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="profile-hero px-4 md:px-8 py-10 md:py-14 mb-8">
    <div class="relative z-10 max-w-5xl mx-auto flex flex-col md:flex-row md:items-end md:justify-between gap-5 md:gap-8">

        <div>
            <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5">Profil</p>
            <div class="flex items-center gap-4 md:gap-6">
                <div class="profile-monogram w-14 h-14 md:w-20 md:h-20 rounded-full border flex items-center justify-center flex-shrink-0">
                    <?php if (!empty($user['avatar_filename'])): ?>
                        <img src="<?= base_url('img/avatars/' . $user['avatar_filename']) ?>" alt="Avatar" class="w-full h-full rounded-full object-cover">
                    <?php else: ?>
                        <span class="font-pfd text-xl text-gold">
                            <?= strtoupper(substr($user['first_name'], 0, 1)) ?><?= strtoupper(substr($user['last_name'], 0, 1)) ?>
                        </span>
                    <?php endif; ?>
                </div>
                <h1 class="font-pfd text-4xl md:text-6xl font-light leading-[0.92] tracking-tight text-lightgrey">
                    <?= esc($user['first_name']) ?><br>
                    <em class="italic text-gold"><?= esc($user['last_name']) ?></em>
                </h1>
            </div>
        </div>

        <div class="profile-stats flex gap-2.5 flex-wrap">
            <div class="profile-stat flex-1 min-w-[120px] flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3">
                <span class="profile-stat-n font-pfd text-4xl font-semibold leading-none text-gold flex-shrink-0"><?= $driverJourneyDone ?></span>
                <span class="profile-stat-l text-[0.6875rem] font-semibold tracking-[0.08em] uppercase text-grey leading-snug">Trajets<br>proposés</span>
            </div>
            <div class="profile-stat flex-1 min-w-[120px] flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3">
                <span class="profile-stat-n font-pfd text-4xl font-semibold leading-none text-gold flex-shrink-0"><?= $passengerTaken ?></span>
                <span class="profile-stat-l text-[0.6875rem] font-semibold tracking-[0.08em] uppercase text-grey leading-snug">Passagers<br>transportés</span>
            </div>
            <div class="profile-stat flex-1 min-w-[120px] flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3">
                <span class="profile-stat-n font-pfd text-4xl font-semibold leading-none text-gold flex-shrink-0"><?= $passengerJourneyDone ?></span>
                <span class="profile-stat-l text-[0.6875rem] font-semibold tracking-[0.08em] uppercase text-grey leading-snug">Trajets<br>effectués</span>
            </div>
        </div>

    </div>
</div>

<main class="w-full max-w-5xl mx-auto px-4 md:px-8 pb-12 font-poppins">

    <?php if (!empty(session()->getFlashdata('success'))): ?>
        <p class="text-xs text-green border border-green/30 rounded-lg px-3 py-2 mb-4"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif ?>
    <?php if (!empty(session()->getFlashdata('error'))): ?>
        <p class="text-xs text-red border border-red/30 rounded-lg px-3 py-2 mb-4"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif ?>

    <?php if ($canReport): ?>
        <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden">
            <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
            <div class="p-5">
                <h3 class="section-title text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-3">Signaler cet utilisateur</h3>
                <?= form_open('user/report/' . $user['id_user'], ['class' => 'flex flex-col gap-3']) ?>
                    <div class="flex flex-col gap-1">
                        <label for="comment" class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Motif</label>
                        <textarea name="comment" id="comment"
                            class="w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2 text-sm text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-colors"
                            placeholder="Décrivez la raison du signalement" required></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="text-xs font-bold bg-red/10 border border-red/20 text-red rounded-full px-5 py-2 hover:bg-red/20 transition-colors cursor-pointer">
                            Signaler
                        </button>
                    </div>
                <?= form_close() ?>
            </div>
        </div>
    <?php endif ?>

</main>

<?= $this->endSection() ?>
