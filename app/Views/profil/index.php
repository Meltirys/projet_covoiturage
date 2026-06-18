<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php helper('french') ?>
<div class="profile-hero px-4 md:px-8 py-10 md:py-14 mb-8">
    <div class="relative z-10 max-w-5xl mx-auto flex flex-col md:flex-row md:items-end md:justify-between gap-5 md:gap-8">

        <div>
            <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5">Mon profil</p>
            <div class="flex items-center gap-4 md:gap-6">
                <div class="profile-monogram w-14 h-14 md:w-20 md:h-20 rounded-full border flex items-center justify-center flex-shrink-0">
                    <?php if (session('avatar_filename')): ?>
                        <img src="<?= base_url('img/avatars/' . session('avatar_filename')) ?>" alt="Avatar" class="w-full h-full rounded-full object-cover">
                    <?php else: ?>
                        <span class="font-pfd text-xl text-gold">
                            <?= strtoupper(substr(session('user_first_name'), 0, 1)) ?><?= strtoupper(substr(session('user_last_name'), 0, 1)) ?>
                        </span>
                    <?php endif; ?>
                </div>
                <h1 class="font-pfd text-4xl md:text-6xl font-light leading-[0.92] tracking-tight text-lightgrey">
                    <?= session('user_first_name') ?><br>
                    <em class="italic text-gold"><?= session('user_last_name') ?></em>
                </h1>
            </div>
        </div>

        <div class="flex flex-col gap-3 md:gap-0 md:items-end">
            <div class="flex justify-end">
                <button
                    id="mode-toggle"
                    onclick="toggleMode()"
                    class="relative w-14 h-8 rounded-full flex items-center px-1 flex-shrink-0">
                    <span
                        id="toggle-thumb"
                        class="absolute pb-1 left-1 w-6 h-6 rounded-full transition-all duration-500 flex items-center justify-center"
                        style="background-color: var(--color-ocean-light);">
                        <i class="fa-solid fa-car" style="color: var(--color-gold)"></i>
                    </span>
                </button>
            </div>
            <!-- Colonne droite : tout le contenu -->
            <div class="profile-stats flex gap-2.5 flex-wrap" id="stats-driver">
                <div class="profile-stat flex-1 min-w-[120px] flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3">
                    <span class="profile-stat-n font-pfd text-4xl font-semibold leading-none text-gold flex-shrink-0"><?= $driverJourneyDone ?></span>
                    <span class="profile-stat-l text-[0.6875rem] font-semibold tracking-[0.08em] uppercase text-grey leading-snug">Trajets<br>proposés</span>
                </div>
                <div class="profile-stat flex-1 min-w-[120px] flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3">
                    <span class="profile-stat-n font-pfd text-4xl font-semibold leading-none text-gold flex-shrink-0"><?= $passengerTaken ?></span>
                    <span class="profile-stat-l text-[0.6875rem] font-semibold tracking-[0.08em] uppercase text-grey leading-snug">Passagers<br>transportés</span>
                </div>
            </div>

            <div class="profile-stats hidden flex gap-2.5 flex-wrap" id="stats-passenger">
                <div class="profile-stat flex-1 min-w-[120px] flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3">
                    <span class="profile-stat-n font-pfd text-4xl font-semibold leading-none text-gold flex-shrink-0"><?= $passengerJourneyDone ?></span>
                    <span class="profile-stat-l text-[0.6875rem] font-semibold tracking-[0.08em] uppercase text-grey leading-snug">Trajets<br>effectués</span>
                </div>
            </div>
        </div>

    </div>
</div>


<main class="w-full max-w-5xl mx-auto">
    <div class="px-4 md:px-8 pb-8">
        <div class="grid grid-cols-1 md:grid-cols-[1fr_280px] md:gap-8 items-start">

            <div class="flex flex-col gap-8 py-4">

                <!-- ════════════════════════════
             SECTION CONDUCTEUR
        ════════════════════════════ -->
                <section id="driver">

                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-0">Mon véhicule</h3>
                            <button
                                onclick="showForm('add-car-form')"
                                class="text-xs text-gold hover:opacity-70 transition-opacity cursor-pointer bg-transparent border-none underline">
                                + Ajouter
                            </button>
                        </div>

                        <?php if (session()->getFlashdata('car_success')): ?>
                            <p class="text-xs text-green mb-2"><?= session()->getFlashdata('car_success') ?></p>
                        <?php endif ?>
                        <?php if (session()->getFlashdata('car_error')): ?>
                            <p class="text-xs text-red mb-2"><?= session()->getFlashdata('car_error') ?></p>
                        <?php endif ?>
                        <?php if (isset($errors) && $errors['idCar']): ?>
                            <p class="text-xs text-red mb-2"><?= $errors['idCar'] ?></p>
                        <?php endif; ?>

                        <div class="flex flex-col gap-2 mb-3">
                            <?php if ($cars): ?>
                                <?php foreach ($cars as $car): ?>
                                    <div id="car<?= $car['id_car'] ?>"
                                        class="flex items-center justify-between bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 hover-border-gold transition-colors gap-3">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-10 h-10 rounded-xl bg-gold/10 border border-gold/15 flex items-center justify-center text-lg flex-shrink-0"><i class="fa-solid fa-car-side" style="color: var(--color-gold)"></i></div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-lightgrey">
                                                    <span class="car-brand"><?= esc($car['brand']) ?></span>
                                                    <span class="car-model"><?= esc($car['model']) ?></span>
                                                </p>
                                                <p class="text-xs text-grey flex flex-wrap gap-1 mt-0.5">
                                                    <span class="car-color"><?= esc($car['color']) ?></span>
                                                    <span>·</span>
                                                    <span class="car-year"><?= esc($car['year']) ?></span>
                                                    <span>·</span>
                                                    <span class="car-places"><?= esc($car['number_of_seat']) ?></span>
                                                    <span>places</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex gap-1.5 flex-shrink-0 items-center">
                                            <button type="button" onclick="setupModify(<?= $car['id_car'] ?>)"
                                                class="text-xs rounded-full px-3 py-1 border border-ocean-light text-grey hover:border-gold/40 hover:text-gold transition-colors cursor-pointer whitespace-nowrap">
                                                Modifier
                                            </button>
                                            <?= form_open('/car/delete/' . $car['id_car']) ?>
                                            <button type="submit"
                                                class="text-xs rounded-full px-3 py-1 border border-red/30 text-red hover:bg-red/10 transition-colors cursor-pointer whitespace-nowrap">
                                                Supprimer
                                            </button>
                                            <?= form_close() ?>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php else: ?>
                                <div class="flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3">
                                    <div class="w-8 h-8 rounded-lg bg-ocean-light flex items-center justify-center text-sm flex-shrink-0"><i class="fa-solid fa-car-side" style="color: var(--color-gold)"></i></div>
                                    <p class="text-xs text-grey italic">Aucune voiture ajoutée pour le moment.</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div id="add-car-form" class="flex-col gap-3"
                            style="display:<?= session()->getFlashdata('error_in_add_car_form') ? 'flex' : 'none' ?>">
                            <?= form_open("car/add") ?>
                            <?= view('profil/CarForm') ?>
                            <div class="flex gap-2 mt-2">
                                <button type="submit"
                                    class="w-full bg-gold text-ocean font-semibold rounded-[14px] px-4 py-3 text-sm hover:bg-gold-light transition-colors cursor-pointer">
                                    Ajouter
                                </button>
                                <button type="button" onclick="hideForm('add-car-form')"
                                    class="w-full bg-ocean-mid text-gold border border-ocean-light rounded-[14px] px-4 py-3 text-sm hover:bg-ocean-light transition-colors cursor-pointer">
                                    Annuler
                                </button>
                            </div>
                            <?= form_close() ?>
                        </div>

                        <div id="modify-car-form" class="flex-col gap-3"
                            style="display:<?= session()->getFlashdata('error_in_modify_car_form') ? 'flex' : 'none' ?>">
                            <?= form_open("car/modify/" . session()->getFlashdata('idCar') ?? '') ?>
                            <?= view('/profil/CarForm') ?>
                            <div class="flex gap-2 mt-2">
                                <button type="submit"
                                    class="w-full bg-gold text-ocean font-semibold rounded-[14px] px-4 py-3 text-sm hover:bg-gold-light transition-colors cursor-pointer">
                                    Modifier
                                </button>
                                <button type="button" onclick="hideForm('modify-car-form')"
                                    class="w-full bg-ocean-mid text-gold border border-ocean-light rounded-[14px] px-4 py-3 text-sm hover:bg-ocean-light transition-colors cursor-pointer">
                                    Annuler
                                </button>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-3">Mes trajets proposés</h3>

                        <p class="text-[0.625rem] tracking-[0.12em] uppercase font-semibold text-grey mb-2 mt-3">À venir</p>
                        <ul class="flex flex-col gap-2 mb-4">
                            <?php if (empty($driveUpcoming)): ?>
                                <li class="flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3">
                                    <div class="w-8 h-8 rounded-lg bg-ocean-light flex items-center justify-center text-sm flex-shrink-0"><i class="fa-regular fa-calendar-days" style="color: var(--color-gold)"></i></div>
                                    <p class="text-xs text-grey italic">Aucun trajet à venir.</p>
                                </li>
                            <?php else: ?>
                                <?php foreach ($driveUpcoming as $journey): ?>
                                    <a href="drive/show/<?= $journey['id_journey_drive'] ?>" class="no-underline">
                                        <li class="flex justify-between items-center bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 hover-border-gold transition-colors">
                                            <p class="text-sm font-medium text-lightgrey"><?= format_date_fr($journey['departure']) ?></p>
                                            <span class="text-xs font-bold bg-gold/10 border border-gold/20 text-gold rounded-full px-3 py-0.5 whitespace-nowrap">
                                                <?= esc($journey['places_restantes']) ?>/<?= esc($journey['number_of_place']) ?>
                                            </span>
                                        </li>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>

                        <p class="text-[0.625rem] tracking-[0.12em] uppercase font-semibold text-grey mb-2">Passés</p>
                        <ul class="flex flex-col gap-2">
                            <?php if (empty($drivePast)): ?>
                                <li class="flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3">
                                    <div class="w-8 h-8 rounded-lg bg-ocean-light flex items-center justify-center text-sm flex-shrink-0"><i class="fa-regular fa-calendar-check" style="color: var(--color-gold)"></i></div>
                                    <p class="text-xs text-grey italic">Aucun trajet passé.</p>
                                </li>
                            <?php else: ?>
                                <?php foreach ($drivePast as $journey): ?>
                                    <a href="drive/show/<?= $journey['id_journey_drive'] ?>" class="no-underline">
                                        <li class="flex justify-between items-center bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 hover:bg-ocean-light transition-colors">
                                            <p class="text-sm font-medium text-lightgrey"><?= format_date_fr($journey['departure']) ?></p>
                                            <span class="text-xs font-medium bg-ocean-light text-grey rounded-full px-3 py-0.5">Effectué</span>
                                        </li>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <?php if (isset($pendingRequests)): ?>
                        <div class="mb-8">
                            <div class="flex items-center gap-2 mb-3">
                                <h3 class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-0">Demandes en attente</h3>
                                <span class="bg-ocean-light text-grey text-[0.625rem] font-semibold rounded-full px-2 py-0.5"><?= count($pendingRequests) ?></span>
                            </div>
                            <ul class="flex flex-col gap-2">
                                <?php if (empty($pendingRequests)): ?>
                                    <li class="flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3">
                                        <div class="w-8 h-8 rounded-lg bg-ocean-light flex items-center justify-center text-sm flex-shrink-0"><i class="fa-regular fa-calendar" style="color: var(--color-gold)"></i></div>
                                        <p class="text-xs text-grey italic">Aucune demande en attente.</p>
                                    </li>
                                <?php else: ?>
                                    <?php foreach ($pendingRequests as $request): ?>
                                        <a href="drive/show/<?= $request['id_journey_drive'] ?>" class="no-underline">
                                            <li class="flex justify-between items-center bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 hover-border-gold transition-colors gap-3">
                                                <div class="min-w-0">
                                                    <p class="text-sm font-medium text-lightgrey truncate"><?= esc($request['passenger_name']) ?></p>
                                                    <p class="text-xs text-grey"><?= esc($request['journey']['departure']) ?></p>
                                                </div>
                                                <div class="flex gap-2 flex-shrink-0">
                                                    <form action="<?= site_url('reservation/accepter/' . $request['id_booking']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <button type="submit"
                                                            class="text-[0.6875rem] rounded-full px-2.5 py-0.5 border border-green/50 text-green hover:bg-green/20 transition-colors cursor-pointer">✓</button>
                                                    </form>
                                                    <form action="<?= site_url('reservation/refuser/' . $request['id_booking']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <button type="submit"
                                                            class="text-[0.6875rem] rounded-full px-2.5 py-0.5 border border-red/40 text-red hover:bg-red/20 transition-colors cursor-pointer">✗</button>
                                                    </form>
                                                </div>
                                            </li>
                                        </a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                </section>

                <!-- ════════════════════════════
             SECTION PASSAGER
        ════════════════════════════ -->
                <section id="passenger">

                    <div class="mb-8">
                        <h3 class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-3">Mes trajets</h3>

                        <p class="text-[0.625rem] tracking-[0.12em] uppercase font-semibold text-grey mb-2 mt-3">À venir</p>
                        <ul class="flex flex-col gap-2 mb-4">
                            <?php if (empty($upcomingConfirmed)): ?>
                                <li class="flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3">
                                    <div class="w-8 h-8 rounded-lg bg-ocean-light flex items-center justify-center text-sm flex-shrink-0"><i class="fa-regular fa-calendar-days" style="color: var(--color-gold)"></i></div>
                                    <p class="text-xs text-grey italic">Aucun trajet confirmé.</p>
                                </li>
                            <?php else: ?>
                                <?php foreach ($upcomingConfirmed as $booking): ?>
                                    <a href="drive/show/<?= $booking['id_journey_drive'] ?>" class="no-underline">
                                        <li class="flex justify-between items-center bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 hover-border-gold transition-colors gap-3 flex-wrap">
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-lightgrey"><?= format_date_fr($booking['journey']['departure']) ?></p>
                                                <p class="text-xs text-grey"><?= esc($booking['driver_name']) ?></p>
                                            </div>
                                            <div class="flex items-center gap-2 flex-shrink-0">
                                                <span class="text-xs font-medium bg-green/15 border border-green/30 text-green rounded-full px-3 py-0.5">Confirmé</span>
                                                <form action="<?= site_url('reservation/annuler/' . $booking['id_booking']) ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <button type="submit"
                                                        class="text-[0.6875rem] rounded-full px-2.5 py-0.5 border border-red/40 text-red hover:bg-red/20 transition-colors cursor-pointer whitespace-nowrap">
                                                        Annuler
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>

                        <p class="text-[0.625rem] tracking-[0.12em] uppercase font-semibold text-grey mb-2">En attente</p>
                        <ul class="flex flex-col gap-2 mb-4">
                            <?php if (empty($upcomingPending)): ?>
                                <li class="flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3">
                                    <div class="w-8 h-8 rounded-lg bg-ocean-light flex items-center justify-center text-sm flex-shrink-0"><i class="fa-regular fa-calendar-check" style="color: var(--color-gold)"></i></div>
                                    <p class="text-xs text-grey italic">Aucune demande en attente.</p>
                                </li>
                            <?php else: ?>
                                <?php foreach ($upcomingPending as $booking): ?>
                                    <a href="drive/show/<?= $booking['id_journey_drive'] ?>" class="no-underline">
                                        <li class="flex justify-between items-center bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 hover-border-gold transition-colors gap-3 flex-wrap">
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-lightgrey"><?= format_date_fr($booking['journey']['departure']) ?></p>
                                                <p class="text-xs text-grey"><?= esc($booking['driver_name']) ?></p>
                                            </div>
                                            <div class="flex items-center gap-2 flex-shrink-0">
                                                <span class="text-xs font-medium bg-gold/10 border border-gold/20 text-gold rounded-full px-3 py-0.5">En attente</span>
                                                <form action="<?= site_url('reservation/annuler/' . $booking['id_booking']) ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <button type="submit"
                                                        class="text-[0.6875rem] rounded-full px-2.5 py-0.5 border border-red/40 text-red hover:bg-red/20 transition-colors cursor-pointer whitespace-nowrap">
                                                        Annuler
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>

                        <p class="text-[0.625rem] tracking-[0.12em] uppercase font-semibold text-grey mb-2">Passés</p>
                        <ul class="flex flex-col gap-2">
                            <?php if (empty($pastJourney)): ?>
                                <li class="flex items-center gap-3 bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3">
                                    <div class="w-8 h-8 rounded-lg bg-ocean-light flex items-center justify-center text-sm flex-shrink-0"><i class="fa-regular fa-calendar-check" style="color: var(--color-gold)"></i></div>
                                    <p class="text-xs text-grey italic">Aucun trajet passé.</p>
                                </li>
                            <?php else: ?>
                                <?php foreach ($pastJourney as $booking): ?>
                                    <a href="drive/show/<?= $booking['id_journey_drive'] ?>" class="no-underline">
                                        <li class="flex justify-between items-center bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 hover:bg-ocean-light transition-colors gap-3">
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-lightgrey"><?= format_date_fr($booking['journey']['departure']) ?></p>
                                                <p class="text-xs text-grey"><?= esc($booking['driver_name']) ?></p>
                                            </div>
                                            <span class="text-xs font-medium bg-ocean-light text-grey rounded-full px-3 py-0.5 flex-shrink-0">
                                                <?= $booking['is_validated'] ? 'Effectué' : 'Refusé' ?>
                                            </span>
                                        </li>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>

                </section>

            </div>

            <div class="flex flex-col gap-4 md:py-4 md:sticky md:top-20">

                <!-- ════════════════════════════
             PARAMÈTRES
        ════════════════════════════ -->
                <section id="parameters" class="mb-2">
                    <h3 class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-3">Paramètres du compte</h3>
                    <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden mb-2">
                        <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
                        <a href="profil/modify"
                            class="flex items-center justify-between px-4 py-3 hover-border-gold border-b border-ocean-light transition-colors no-underline group gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-[9px] bg-gold/10 border border-gold/15 flex items-center justify-center text-sm flex-shrink-0"><i class="fa-solid fa-user" style="color: var(--color-gold)"></i></div>
                                <div>
                                    <p class="text-sm font-medium text-lightgrey">Informations personnelles</p>
                                    <p class="text-xs text-grey">Nom, email, photo…</p>
                                </div>
                            </div>
                            <span class="param-arrow text-grey text-base transition-all flex-shrink-0"><i class="fa-solid fa-angle-right" style="color: var(--color-gold)"></i></span>
                        </a>
                        <a href="profil/changePassword"
                            class="flex items-center justify-between px-4 py-3 hover-border-gold transition-colors no-underline group gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-[9px] bg-ocean-light border border-ocean-light flex items-center justify-center text-sm flex-shrink-0"><i class="fa-solid fa-key" style="color: var(--color-gold)"></i></div>
                                <div>
                                    <p class="text-sm font-medium text-lightgrey">Mot de passe</p>
                                    <p class="text-xs text-grey">Modifier la sécurité</p>
                                </div>
                            </div>
                            <span class="param-arrow text-grey text-base transition-all flex-shrink-0"><i class="fa-solid fa-angle-right" style="color: var(--color-gold)"></i></span>
                        </a>
                    </div>
                </section>

                <!-- ════════════════════════════
             SESSION
        ════════════════════════════ -->
                <section class="flex flex-col gap-2">
                    <form action="user/delete" method="post" class="w-full">
                        <?= csrf_field() ?>
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-transparent border border-red/30 text-red rounded-[14px] px-4 py-3 text-sm hover:bg-red/15 transition-colors cursor-pointer">
                            <span><i class="fa-solid fa-trash-can" style="color: var(--color-gold)"></i></span> Supprimer mon compte
                        </button>
                    </form>
                    <a href="/logout"
                        class="w-full flex items-center justify-center gap-2 bg-ocean-mid border border-ocean-light text-grey rounded-[14px] px-4 py-3 text-sm hover:border-white/20 hover:text-lightgrey transition-colors no-underline">
                        <span><i class="fa-solid fa-right-to-bracket" style="color: var(--color-gold)"></i></span> Se déconnecter
                    </a>
                </section>

            </div>

        </div>
    </div>

</main>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function showForm(id) {
        document.querySelector('#' + id).style.display = 'flex'
        if (id === "add-car-form") {
            let brand = document.querySelector('#' + id).querySelector('#brand')
            let model = document.querySelector('#' + id).querySelector('#model')
            let year = document.querySelector('#' + id).querySelector('#year')
            let places = document.querySelector('#' + id).querySelector('#places')
            let color = document.querySelector('#' + id).querySelector('#color')
            brand.value = ''
            model.value = ''
            year.value = ''
            places.value = ''
            color.value = ''
            document.querySelector('#modify-car-form').style.display = 'none'
        } else if (id === "modify-car-form") {
            document.querySelector('#add-car-form').style.display = 'none'
        }
    }

    function hideForm(id) {
        document.querySelector('#' + id).style.display = 'none'
    }

    function toggleMode() {
        const driver = document.getElementById('driver');
        const passenger = document.getElementById('passenger');
        const statsDriver = document.getElementById('stats-driver');
        const statsPassenger = document.getElementById('stats-passenger');
        const thumb = document.getElementById('toggle-thumb');
        const isDriver = driver.style.display !== 'none';

        if (isDriver) {
            driver.style.display = 'none';
            passenger.style.display = 'block';
            statsDriver.classList.add('hidden');
            statsPassenger.classList.remove('hidden');
            thumb.style.left = '1.75rem';
            thumb.innerHTML = '<i class="fa-solid fa-person-walking" style="color: var(--color-gold)"></i>';
        } else {
            driver.style.display = 'block';
            passenger.style.display = 'none';
            statsDriver.classList.remove('hidden');
            statsPassenger.classList.add('hidden');
            thumb.style.left = '0.25rem';
            thumb.innerHTML = '<i class="fa-solid fa-car" style="color: var(--color-gold)"></i>';
        }
    }

    function setupModify(idCar) {
        showForm('modify-car-form')
        let form = document.querySelector('#modify-car-form form')
        form.action = "car/modify/" + idCar
        let brand = form.querySelector('#brand')
        let model = form.querySelector('#model')
        let year = form.querySelector('#year')
        let places = form.querySelector('#places')
        let color = form.querySelector('#color')
        brand.value = document.querySelector('#car' + idCar + ' .car-brand').textContent
        model.value = document.querySelector('#car' + idCar + ' .car-model').textContent
        year.value = document.querySelector('#car' + idCar + ' .car-year').textContent
        places.value = document.querySelector('#car' + idCar + ' .car-places').textContent
        color.value = document.querySelector('#car' + idCar + ' .car-color').textContent
    }

    document.getElementById('passenger').style.display = 'none';
    document.getElementById('stats-passenger').classList.add('hidden');
</script>
<?= $this->endSection() ?>