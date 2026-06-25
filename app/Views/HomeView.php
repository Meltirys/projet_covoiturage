<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main class="min-h-screen font-poppins bg-ocean" id="main-page">

    <?php

 if (!session('logged_in')) : ?>

        <div class="flex flex-col md:flex-row md:min-h-screen">

            <!-- ===== COLONNE GAUCHE — HERO ===== -->
            <div class="relative md:w-[42%] md:min-h-screen px-6 pt-8 pb-14 md:pb-0 md:pt-0 overflow-hidden flex flex-col md:justify-center md:px-12 profile-hero">

                <div class="orb orb-1 bg-ocean-light"></div>
                <div class="orb orb-2 bg-sand"></div>
                <div class="orb orb-3 bg-ocean-light"></div>
                <div class="orb orb-4 border border-sand/20"></div>

                <!-- Logo -->
                <div class="relative z-10 mb-10 md:mb-16 penn-eyebrow">
                    <img src="<?= base_url('img/logo_golden.png') ?>" alt="PennRide" class="w-10 h-10 rounded-xl">
                </div>

                <!-- Eyebrow -->
                <p class="relative z-10 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5 penn-eyebrow">
                    Covoiturage étudiant<br>réservé aux membres du GRETA.
                </p>

                <!-- Hero -->
                <h1 class="relative z-10 font-pfd text-4xl md:text-5xl font-light leading-[0.92] tracking-tight text-lightgrey mb-6 penn-hero">
                    Tu es membre<br>du GRETA ?<br>
                    <em class="italic text-gold">Bienvenue.</em>
                </h1>

                <!-- Sous-titre desktop -->
                <p class="hidden md:block relative z-10 text-sm text-grey leading-relaxed mb-12 max-w-xs penn-hero">
                    Partage tes trajets avec d'autres stagiaires.<br>Simple, solidaire, éco-responsable.
                </p>

                <!-- Stats desktop -->
                <div class="hidden md:flex gap-8 relative z-10 penn-stats">
                    <div class="flex flex-col gap-1">
                        <span class="font-pfd text-2xl font-light text-gold">Nombre de trajets effectués</span>
                        <span class="text-[0.625rem] tracking-[0.2em] uppercase text-grey"><?= $numberOfJourney ?></span>
                    </div>
                    <div class="w-px bg-ocean-light self-stretch"></div>
                    <div class="flex flex-col gap-1">
                        <span class="font-pfd text-2xl font-light text-gold">Nombre de conducteurs uniques</span>
                        <span class="text-[0.625rem] tracking-[0.2em] uppercase text-grey"><?= $numberOfDrivers ?></span>
                    </div>
                    <div class="w-px bg-ocean-light self-stretch"></div>
                    <div class="flex flex-col gap-1">
                        <span class="font-pfd text-2xl font-light text-gold">Nombre de passagers transportés</span>
                        <span class="text-[0.625rem] tracking-[0.2em] uppercase text-grey"><?= $numberOfPassenger ?></span>
                    </div>
                </div>

                <!-- Illustration SVG -->
                <div class="hidden md:block absolute bottom-12 right-0 opacity-10 z-0 pointer-events-none">
                    <svg width="180" height="180" viewBox="0 0 180 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="90" cy="90" r="85" stroke="white" stroke-width="1" />
                        <circle cx="90" cy="90" r="60" stroke="white" stroke-width="1" />
                        <circle cx="90" cy="90" r="35" stroke="white" stroke-width="1" />
                        <line x1="5" y1="90" x2="175" y2="90" stroke="white" stroke-width="1" />
                        <line x1="90" y1="5" x2="90" y2="175" stroke="white" stroke-width="1" />
                        <line x1="30" y1="30" x2="150" y2="150" stroke="white" stroke-width="0.5" />
                        <line x1="150" y1="30" x2="30" y2="150" stroke="white" stroke-width="0.5" />
                    </svg>
                </div>
            </div>

            <!-- ===== COLONNE DROITE — FORMULAIRES ===== -->
            <div class="md:w-[58%] md:min-h-screen flex flex-col md:justify-center md:items-center bg-ocean-mid">
                <div class="px-4 -mt-5 pb-10 w-full md:mt-0 md:pb-0 md:px-12 md:max-w-xl">
                    <div class="bg-ocean border border-ocean-light rounded-[14px] overflow-hidden p-5 md:p-8 penn-card">
                        <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent -mx-5 md:-mx-8 -mt-5 md:-mt-8 mb-6"></div>

                        <!-- Titre desktop -->
                        <div class="hidden md:block mb-8">
                            <p class="text-[0.625rem] tracking-[0.2em] uppercase text-grey mb-2">Bienvenue sur PennRide</p>
                            <h2 class="font-pfd text-2xl font-light text-lightgrey">Connecte-toi ou crée<br>ton <em class="italic text-gold">compte.</em></h2>
                        </div>

                        <!-- ONGLETS -->
                        <div class="relative flex border-b border-ocean-light mb-6" id="penn-tabs">
                            <div id="tab-indicator" class="absolute bottom-[-1px] h-[2px] bg-gold rounded-full transition-all duration-300"></div>
                            <button class="penn-tab-btn flex-1 text-[10px] font-medium tracking-widest uppercase py-2.5 text-gold transition-colors duration-200" data-tab="tab-login">Connexion</button>
                            <button class="penn-tab-btn flex-1 text-[10px] font-medium tracking-widest uppercase py-2.5 text-grey transition-colors duration-200" data-tab="tab-inscription">Inscription</button>
                            <button class="penn-tab-btn flex-1 text-[10px] font-medium tracking-widest uppercase py-2.5 text-grey transition-colors duration-200" data-tab="tab-contact">Contact</button>
                        </div>

                        <!-- CONNEXION -->
                        <div id="tab-login" class="auth-panel">
                            <?php if (session()->getFlashdata('success')): ?>
                                <p class="text-xs text-green mb-3"><?= session()->getFlashdata('success') ?></p>
                            <?php endif ?>
                            <?php if (!empty($message) && ($activeTab ?? 'login') === 'login'): ?>
                                <p class="text-xs text-red mb-3"><?= esc($message) ?></p>
                            <?php endif; ?>
                            <?= form_open("/authentification") ?>
                            <div class="flex flex-col gap-4 mb-5">
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold" for="email-auth">Email</label>
                                    <input class="penn-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-all duration-200" type="email" id="email-auth" name="email-auth" value="<?= old('email-auth') ?>" placeholder="ton@email.fr" required>
                                </div>
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold" for="password-auth">Mot de passe</label>
                                    <input class="penn-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-all duration-200" type="password" id="password-auth" name="password-auth" placeholder="••••••••" required>
                                </div>
                                <?php if (session()->getFlashdata('auth_error')): ?>
                                    <p class="text-xs text-red"><?= session()->getFlashdata('auth_error') ?></p>
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="penn-btn w-full bg-gold text-ocean font-semibold rounded-xl py-3 text-xs tracking-widest transition-all duration-200 hover:opacity-90 active:scale-[0.98] cursor-pointer">
                                Je me connecte →
                            </button>
                            <?= form_close() ?>
                        </div>

                        <!-- INSCRIPTION -->
                        <div id="tab-inscription" class="auth-panel hidden">
                            <?= form_open('/signup') ?>
                            <div class="flex flex-col gap-4 mb-5">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Nom</label>
                                        <input class="penn-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-all duration-200" type="text" name="last_name" value="<?= set_value('last_name') ?>" placeholder="Dupont" required>
                                        <?php if ($errors['last_name'] ?? null): ?><span class="text-xs text-red"><?= esc($errors['last_name']) ?></span><?php endif ?>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Prénom</label>
                                        <input class="penn-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-all duration-200" type="text" name="first_name" value="<?= set_value('first_name') ?>" placeholder="Marie" required>
                                        <?php if ($errors['first_name'] ?? null): ?><span class="text-xs text-red"><?= esc($errors['first_name']) ?></span><?php endif ?>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Genre</label>
                                    <select class="penn-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey focus:outline-none focus:border-gold/40 transition-all duration-200" name="gender" required>
                                        <option value="" disabled>Sélectionner</option>
                                        <option value="female" <?= old('gender') === 'female' ? 'selected' : '' ?>>Féminin</option>
                                        <option value="male" <?= old('gender') === 'male' ? 'selected' : '' ?>>Masculin</option>
                                        <option value="none" <?= old('gender') === 'none' ? 'selected' : '' ?>>Non communiqué</option>
                                    </select>
                                    <?php if ($errors['gender'] ?? null): ?><span class="text-xs text-red"><?= esc($errors['gender']) ?></span><?php endif ?>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">E-mail</label>
                                    <input class="penn-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-all duration-200" type="email" name="email-signup" value="<?= set_value('email-signup') ?>" placeholder="ton@email.fr" required>
                                    <?php if ($errors['email'] ?? null): ?><span class="text-xs text-red"><?= esc($errors['email']) ?></span><?php endif ?>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Adresse</label>
                                    <input class="address-input penn-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-all duration-200" type="text" name="address" value="<?= set_value('address') ?>" placeholder="10 rue de la Paix" required>
                                    <?php if ($errors['address'] ?? null): ?><span class="text-xs text-red"><?= esc($errors['address']) ?></span><?php endif ?>
                                    <div class="results"></div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Code postal</label>
                                        <input id="postcode-input" class="penn-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-all duration-200" type="text" name="postcode" value="<?= set_value('postcode') ?>" placeholder="29000">
                                        <?php if ($errors['postcode'] ?? null): ?><span class="text-xs text-red"><?= esc($errors['postcode']) ?></span><?php endif ?>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Ville</label>
                                        <input id="city-input" class="penn-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-all duration-200" type="text" name="city" value="<?= set_value('city') ?>" placeholder="Brest" required>
                                        <?php if ($errors['city'] ?? null): ?><span class="text-xs text-red"><?= esc($errors['city']) ?></span><?php endif ?>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Téléphone</label>
                                        <input class="penn-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-all duration-200" type="tel" name="mobile" value="<?= set_value('mobile') ?>" placeholder="06 00 00 00 00">
                                        <?php if ($errors['mobile'] ?? null): ?><span class="text-xs text-red"><?= esc($errors['mobile']) ?></span><?php endif ?>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Date de naissance</label>
                                        <input class="penn-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey focus:outline-none focus:border-gold/40 transition-all duration-200" type="date" name="birth_date" value="<?= set_value('birth_date') ?>" required>
                                        <?php if ($errors['birth_date'] ?? null): ?><span class="text-xs text-red"><?= esc($errors['birth_date']) ?></span><?php endif ?>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">
                                        Mot de passe
                                        <span class="normal-case font-light tracking-normal text-grey block mt-0.5">(8 car. min., 1 majuscule, 1 chiffre, 1 spécial)</span>
                                    </label>
                                    <input class="penn-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-all duration-200" type="password" name="password" required>
                                    <?php if ($errors['password'] ?? null): ?><span class="text-xs text-red"><?= esc($errors['password']) ?></span><?php endif ?>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold text-gold">Confirmation du mot de passe</label>
                                    <input class="penn-input w-full rounded-xl bg-ocean-light border border-ocean-light px-3 py-2.5 text-xs text-lightgrey placeholder:text-grey focus:outline-none focus:border-gold/40 transition-all duration-200" type="password" name="password_conf" required>
                                    <?php if ($errors['password_conf'] ?? null): ?><span class="text-xs text-red"><?= esc($errors['password_conf']) ?></span><?php endif ?>
                                </div>

                            </div>
                            <button type="submit" name="submit" class="penn-btn w-full bg-gold text-ocean font-semibold rounded-xl py-3 text-xs tracking-widest transition-all duration-200 hover:opacity-90 active:scale-[0.98] cursor-pointer">
                                Je m'inscris →
                            </button>
                            <?= form_close() ?>
                        </div>

                        <!-- CONTACT -->
                        <div id="tab-contact" class="auth-panel hidden">
                            <p class="text-xs text-grey leading-relaxed mb-5">
                                <strong class="text-lightgrey">Une interrogation ? Besoin d'un renseignement ?</strong><br>
                                Écris-nous et un membre de l'administration reviendra vers toi rapidement.
                            </p>
                            <?= view('ContactForm') ?>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    <?php else: ?>

        <!-- ===== CONNECTÉ ===== -->
        <div class="min-h-screen bg-ocean">

            <!-- CARTE + HERO -->
            <div class="relative overflow-hidden" style="height: 280px;">
                <img
                    src="https://staticmap.openstreetmap.de/staticmap.php?center=47.6480,2.7600&zoom=14&size=1200x300"
                    alt="Carte Vannes"
                    class="w-full h-full object-cover object-center"
                    style="filter: saturate(0.25) brightness(0.9) sepia(0.2);">
                <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(13,17,23,0.97) 0%, rgba(13,17,23,0.6) 45%, rgba(13,17,23,0.1) 100%);"></div>

                <!-- Marqueur GRETA -->
                <div class="absolute" style="top: 30%; left: 46%; transform: translate(-50%, -100%);">
                    <div class="relative flex items-center justify-center">
                        <div class="absolute rounded-full" style="width:32px;height:32px;background:rgba(218,175,80,0.25);animation:pulse-map 2s ease-out infinite;top:50%;left:50%;transform:translate(-50%,-50%);"></div>
                        <div class="rounded-full border-2 border-lightgrey" style="width:14px;height:14px;background:#DAAF50;box-shadow:0 2px 8px rgba(218,175,80,0.5);"></div>
                    </div>
                    <div class="absolute text-center whitespace-nowrap" style="bottom: calc(100% + 6px); left: 50%; transform: translateX(-50%); background:#DAAF50; color:#1E1A0E; font-size:9px; font-weight:600; padding:3px 10px; border-radius:20px; letter-spacing:0.5px;">
                        Lycée Alain Lesage
                    </div>
                </div>

                <span class="absolute bottom-2 right-3 text-lightgrey/40" style="font-size:9px;">© OpenStreetMap contributors</span>

                <!-- Contenu hero superposé -->
                <div class="absolute bottom-5 left-5 right-5 z-10">
                    <p class="text-gold/70 uppercase tracking-widest mb-1" style="font-size:9px;letter-spacing:0.2em;">Bonjour, <?= session('user_first_name') ?></p>
                    <h1 class="font-pfd text-lightgrey font-light leading-tight mb-3" style="font-size:1.6rem;">Où vas-tu <em class="italic text-gold">aujourd'hui ?</em></h1>

                    <!-- BLOC PROCHAIN TRAJET -->
                    <?php if (!empty($next_trip)): ?>
                        <a href="<?= site_url('myprofil') ?>" class="inline-flex items-center gap-0 rounded-xl overflow-hidden no-underline hover:opacity-90 transition-opacity" style="background:rgba(212,168,67,0.06);border:1px solid rgba(212,168,67,0.3);max-width:420px;">
                            <div class="flex flex-col gap-1.5 px-4 py-3" style="border-right:1px solid rgba(212,168,67,0.3);">
                                <div class="flex items-center gap-1.5" style="font-size:8px;letter-spacing:0.12em;text-transform:uppercase;color:#d4a843;">
                                    <div style="width:5px;height:5px;border-radius:50%;background:#d4a843;flex-shrink:0;"></div>
                                    <?= $next_trip['is_driver'] ? 'Conducteur' : 'Passager' ?> · <?= date('D. d M · H\hi', strtotime($next_trip['departure'])) ?>
                                </div>
                                <div class="font-pfd text-lightgrey font-light flex items-center gap-1" style="font-size:14px;white-space:nowrap;">
                                    <?= esc($next_trip['departure_city']) ?>
                                    <span style="color:#d4a843;font-size:12px;">→</span>
                                    <?= esc($next_trip['arrival_city']) ?>
                                </div>
                                <div class="text-grey" style="font-size:10px;">
                                    <?= $next_trip['is_driver'] ? ($next_trip['passenger_count'] ?? 0) . ' passager(s) confirmé(s)' : 'Réservé' ?>
                                </div>
                            </div>
                            <?php if ($next_trip_count > 0): ?>
                                <div class="flex flex-col items-center justify-center gap-0.5 px-4 py-3" style="flex-shrink:0;">
                                    <span class="font-pfd text-gold font-light" style="font-size:18px;line-height:1;">+<?= $next_trip_count ?></span>
                                    <span class="text-grey uppercase tracking-widest" style="font-size:8px;">autres</span>
                                </div>
                            <?php endif; ?>
                        </a>
                    <?php else: ?>
                        <div class="inline-flex items-start gap-3 rounded-xl px-4 py-3" style="background:rgba(212,168,67,0.04);border:1px solid rgba(212,168,67,0.15);">
                            <div class="flex items-center justify-center rounded-full mt-0.5" style="width:28px;height:28px;border:1px solid rgba(212,168,67,0.3);flex-shrink:0;">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#d4a843" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" opacity="0.4">
                                    <rect x="3" y="4" width="18" height="18" rx="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                    <line x1="10" y1="14" x2="14" y2="18" />
                                    <line x1="14" y1="14" x2="10" y2="18" />
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:12px;color:rgba(232,234,240,0.55);">Aucun trajet prévu pour le moment.</p>
                                <p style="font-size:10px;color:#6b7380;">Recherche un trajet ou propose le tien.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- CONTENU PRINCIPAL -->
            <div class="px-4 md:px-8 py-6 max-w-5xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start">

                    <!-- FORMULAIRE RECHERCHE -->
                    <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden">
                        <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
                        <div class="p-5">
                            <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-4">Rechercher un trajet</p>
                            <?= view('itinerary/search/search_drive_form', ['errors' => $searchErrors ?? []]) ?>
                        </div>
                    </div>

                    <!-- TRAJETS DISPONIBLES -->
                    <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden">
                        <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
                        <div class="p-5">
                            <div class="flex items-baseline justify-between mb-4">
                                <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-0">Trajets disponibles</p>
                                <a href="<?= site_url('trajet') ?>" class="text-xs text-grey hover:text-gold transition-colors">Voir tout →</a>
                            </div>
                            <?php if (!empty($journeys)): ?>
                                <?= view('/itinerary/search/journeyCard', $journeys) ?>
                            <?php else: ?>
                                <div class="flex flex-col items-center justify-center py-8 text-grey">
                                    <p class="font-pfd italic text-xl text-gold/40 mb-2">Aucun trajet</p>
                                    <p class="text-xs">Aucun trajet disponible pour le moment.</p>
                                    <a href="<?= site_url('nouveau-trajet') ?>" class="mt-4 text-gold border border-gold/30 rounded-full px-4 py-1.5 text-xs hover:bg-gold/10 transition-colors">Proposer le premier →</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <!-- LIENS RAPIDES -->
                <div class="grid grid-cols-3 gap-3 mt-5">
                    <a href="<?= site_url('nouveau-trajet') ?>" class="flex flex-col items-center gap-2 bg-ocean-mid border border-ocean-light rounded-[14px] py-4 px-3 text-center hover:border-gold/30 transition-colors group no-underline">
                        <span class="text-lg text-gold/60 group-hover:text-gold transition-colors">+</span>
                        <span class="text-[0.625rem] text-grey uppercase tracking-[0.2em]">Proposer</span>
                    </a>
                    <a href="<?= site_url('myprofil') ?>" class="flex flex-col items-center gap-2 bg-ocean-mid border border-ocean-light rounded-[14px] py-4 px-3 text-center hover:border-gold/30 transition-colors group no-underline">
                        <span class="text-lg text-gold/60 group-hover:text-gold transition-colors">◎</span>
                        <span class="text-[0.625rem] text-grey uppercase tracking-[0.2em]">Mon profil</span>
                    </a>
                    <?php if (session('user_role') == 2): ?>
                        <a href="<?= site_url('backoffice') ?>" class="flex flex-col items-center gap-2 bg-ocean-mid border border-gold/20 rounded-[14px] py-4 px-3 text-center hover:border-gold/50 transition-colors group no-underline">
                            <span class="text-lg text-gold/60 group-hover:text-gold transition-colors">⊞</span>
                            <span class="text-[0.625rem] text-gold/70 uppercase tracking-[0.2em]">Admin</span>
                        </a>
                    <?php else: ?>
                        <a href="<?= site_url('logout') ?>" class="flex flex-col items-center gap-2 bg-ocean-mid border border-ocean-light rounded-[14px] py-4 px-3 text-center hover:border-red/30 transition-colors group no-underline">
                            <span class="text-lg text-grey group-hover:text-red transition-colors">⏻</span>
                            <span class="text-[0.625rem] text-grey uppercase tracking-[0.2em]">Quitter</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php if (!session('logged_in')): ?>
    <script src="<?= base_url('js/geocoding.js') ?>"></script>
    <script src="<?= base_url('js/profile-address.js') ?>"></script>
<?php else: ?>
    <script src="<?= base_url('js/geocoding.js') ?>"></script>
    <script src="<?= base_url('js/address-fields.js') ?>"></script>
<?php endif; ?>

<script>
    (function() {
        const isMobile = window.innerWidth < 768;
        const els = [{
                el: document.querySelector('.penn-eyebrow'),
                delay: 100
            },
            {
                el: document.querySelector('.penn-hero'),
                delay: 250
            },
            {
                el: document.querySelector('.penn-stats'),
                delay: 380
            },
            {
                el: document.querySelector('.penn-card'),
                delay: isMobile ? 420 : 200
            },
        ];
        els.forEach(({
            el,
            delay
        }) => {
            if (!el) return;
            el.style.opacity = '0';
            el.style.transform = 'translateY(14px)';
            setTimeout(() => {
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, delay);
        });
    })();

    const btns = document.querySelectorAll('.penn-tab-btn');
    const panels = document.querySelectorAll('.auth-panel');
    const indicator = document.getElementById('tab-indicator');

    function moveIndicator(btn) {
        if (!indicator || !btn) return;
        indicator.style.left = btn.offsetLeft + 'px';
        indicator.style.width = btn.offsetWidth + 'px';
    }

    function showTab(tabId) {
        panels.forEach(p => {
            p.classList.add('hidden');
            p.style.animation = '';
        });
        const panel = document.getElementById(tabId);
        if (panel) {
            panel.classList.remove('hidden');
            panel.style.animation = 'fadeSlideIn 0.3s ease forwards';
        }
        btns.forEach(b => {
            b.classList.remove('text-gold');
            b.classList.add('text-grey');
        });
        const activeBtn = document.querySelector(`[data-tab="${tabId}"]`);
        if (activeBtn) {
            activeBtn.classList.remove('text-grey');
            activeBtn.classList.add('text-gold');
            moveIndicator(activeBtn);
        }
    }

    btns.forEach(btn => btn.addEventListener('click', () => showTab(btn.dataset.tab)));
    window.addEventListener('resize', () => {
        const active = document.querySelector('.penn-tab-btn.text-gold');
        moveIndicator(active);
    });
    setTimeout(() => moveIndicator(document.querySelector('.penn-tab-btn.text-gold')), 50);

    document.querySelectorAll('.penn-btn').forEach(btn => {
        btn.closest('form')?.addEventListener('submit', function(e) {
            const inputs = this.querySelectorAll('[required]');
            let invalid = false;
            inputs.forEach(input => {
                if (!input.value.trim()) invalid = true;
            });
            if (invalid) {
                e.preventDefault();
                btn.style.animation = '';
                void btn.offsetWidth;
                btn.style.animation = 'shake 0.4s cubic-bezier(.36,.07,.19,.97)';
                btn.addEventListener('animationend', () => btn.style.animation = '', {
                    once: true
                });
            }
        });
    });

    <?php if (session()->getFlashdata('signup_error')): ?>
        showTab('tab-inscription');
    <?php elseif(session()->getFlashdata('contact_error')):  ?>
        showTab('tab-contact');
    <?php else: ?>
        showTab('tab-login')
    <?php endif; ?>
</script>
<?= $this->endSection() ?>