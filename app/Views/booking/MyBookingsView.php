<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php helper('french') ?>
<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

    <header class="flex justify-between items-center mb-6">
        <h2 class="text-xs tracking-[0.15em] text-bluegrey uppercase">Mes réservations</h2>
    </header>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="text-xs text-green-600 border border-green-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p class="text-xs text-red-500 border border-red-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <!-- Section passager -->
    <section id="passager" class="mb-8">
        <h3 class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase mb-4">Mes trajets réservés</h3>

        <h4 class="text-xs font-poppins text-grey mb-2">À venir</h4>
        <ul class="flex flex-col gap-2 mb-4">
            <?php if (empty($upcomingConfirmed)): ?>
                <p class="text-sm text-grey">Aucun trajet confirmé.</p>
            <?php else: ?>
                <?php foreach ($upcomingConfirmed as $booking): ?>
                    <li class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                        <div>
                            <p class="text-sm font-poppins text-bluegrey"><?= esc($booking['journey']['departure']) ?></p>
                            <p class="text-xs text-grey"><?= esc($booking['driver_name']) ?></p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-white bg-green-500 rounded-full px-3 py-0.5">Confirmé</span>
                            <form action="<?= site_url('reservation/annuler/' . $booking['id_booking']) ?>" method="post">
                                <?= csrf_field() ?>
                                <button type="submit" class="text-xs text-red-500 border border-red-200 rounded-full px-3 py-1 hover:bg-red-50 transition-colors duration-150">Annuler</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <h4 class="text-xs font-poppins text-grey mb-2">En attente</h4>
        <ul class="flex flex-col gap-2 mb-4">
            <?php if (empty($upcomingPending)): ?>
                <p class="text-sm text-grey">Aucune demande en attente.</p>
            <?php else: ?>
                <?php foreach ($upcomingPending as $booking): ?>
                    <li class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                        <div>
                            <p class="text-sm font-poppins text-bluegrey"><?= esc($booking['journey']['departure']) ?></p>
                            <p class="text-xs text-grey"><?= esc($booking['driver_name']) ?></p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-white bg-orange-400 rounded-full px-3 py-0.5">En attente</span>
                            <form action="<?= site_url('reservation/annuler/' . $booking['id_booking']) ?>" method="post">
                                <?= csrf_field() ?>
                                <button type="submit" class="text-xs text-red-500 border border-red-200 rounded-full px-3 py-1 hover:bg-red-50 transition-colors duration-150">Annuler</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <h4 class="text-xs font-poppins text-grey mb-2">Passés</h4>
        <ul class="flex flex-col gap-2">
            <?php if (empty($pastJourney)): ?>
                <p class="text-sm text-grey">Aucun trajet passé.</p>
            <?php else: ?>
                <?php foreach ($pastJourney as $booking): ?>
                    <li class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                        <div>
                            <p class="text-sm font-poppins text-bluegrey"><?= esc($booking['journey']['departure']) ?></p>
                            <p class="text-xs text-grey"><?= esc($booking['driver_name']) ?></p>
                        </div>
                        <span class="text-xs text-grey bg-lightblue rounded-full px-3 py-0.5">
                            <?= $booking['is_validated'] ? 'Effectué' : 'Refusé' ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </section>

    <!-- Section conducteur -->
    <section id="conducteur" class="mb-8">
        <h3 class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase mb-4">Mes trajets proposés</h3>

        <h4 class="text-xs font-poppins text-grey mb-2">À venir</h4>
        <ul class="flex flex-col gap-2 mb-4">
            <?php if (empty($driveUpcoming)): ?>
                <p class="text-sm text-grey">Aucun trajet à venir.</p>
            <?php else: ?>
                <?php foreach ($driveUpcoming as $journey): ?>
                    <li class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                        <p class="text-sm font-poppins text-bluegrey"><?= esc($journey['departure']) ?></p>
                        <span class="text-xs text-bluegrey bg-lightblue rounded-full px-3 py-0.5">
                            <?= esc($journey['places_restantes']) ?>/<?= esc($journey['number_of_place']) ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <h4 class="text-xs font-poppins text-grey mb-2">Passés</h4>
        <ul class="flex flex-col gap-2 mb-6">
            <?php if (empty($drivePast)): ?>
                <p class="text-sm text-grey">Aucun trajet passé.</p>
            <?php else: ?>
                <?php foreach ($drivePast as $journey): ?>
                    <li class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                        <p class="text-sm font-poppins text-bluegrey"><?= esc($journey['departure']) ?></p>
                        <span class="text-xs text-grey bg-lightblue rounded-full px-3 py-0.5">Effectué</span>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <h3 class="text-xs font-poppins tracking-[0.15em] text-bluegrey uppercase mb-4">Demandes en attente de validation</h3>
        <ul class="flex flex-col gap-2">
            <?php if (empty($pendingRequests)): ?>
                <p class="text-sm text-grey">Aucune demande en attente.</p>
            <?php else: ?>
                <?php foreach ($pendingRequests as $request): ?>
                    <li class="flex justify-between items-center bg-white border border-babyblue rounded-xl px-4 py-3">
                        <div>
                            <p class="text-sm font-poppins text-bluegrey"><?= esc($request['passenger_name']) ?></p>
                            <p class="text-xs text-grey"><?= esc($request['journey']['departure']) ?></p>
                        </div>
                        <div class="flex gap-2">
                            <form action="<?= site_url('reservation/accepter/' . $request['id_booking']) ?>" method="post">
                                <?= csrf_field() ?>
                                <button type="submit" class="text-xs text-bluegrey border border-babyblue rounded-full px-3 py-1 hover:bg-lightblue transition-colors duration-150">✓</button>
                            </form>
                            <form action="<?= site_url('reservation/refuser/' . $request['id_booking']) ?>" method="post">
                                <?= csrf_field() ?>
                                <button type="submit" class="text-xs text-red-500 border border-red-200 rounded-full px-3 py-1 hover:bg-red-50 transition-colors duration-150">✗</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </section>

</main>

<?= $this->endSection() ?>