<?= $this->extend('layouts/blank') ?>

<?= $this->section('content') ?>

<main class="min-h-screen font-poppins bg-sand-light" id="main-page">

    <?php if (!session('logged_in')) : ?>

        <div class="flex flex-col md:flex-row md:min-h-screen">

            <!-- ===== COLONNE GAUCHE — HERO ===== -->
            <div class="relative bg-ocean md:w-[42%] md:min-h-screen px-6 pt-8 pb-14 md:pb-0 md:pt-0 overflow-hidden flex flex-col md:justify-center md:px-12">

                <div class="orb orb-1 bg-ocean-light"></div>
                <div class="orb orb-2 bg-sand"></div>
                <div class="orb orb-3 bg-ocean-light"></div>
                <div class="orb orb-4 border border-sand/20"></div>

                <!-- Logo -->
                <div class="relative z-10 mb-10 md:mb-16 penn-eyebrow">
                    <img src="/img/logo.png" alt="PennRide" class="w-10 h-10 rounded-xl">
                </div>

                <!-- Eyebrow -->
                <p class="relative z-10 text-[9px] tracking-[2.5px] text-white/40 uppercase mb-4 leading-relaxed penn-eyebrow">
                    Covoiturage étudiant<br>réservé aux membres du GRETA.
                </p>

                <!-- Hero -->
                <h1 class="relative z-10 text-3xl md:text-[2.6rem] md:leading-[1.1] font-light text-white leading-tight mb-6 penn-hero">
                    Tu es membre du GRETA ? <br>
                    Tu cherches une solution de covoiturage ? <br>
                    Tu es au bon <em class="font-pfd italic text-sand not-italic">endroit.</em> 🚗
                </h1>

                <!-- Sous-titre desktop -->
                <p class="hidden md:block relative z-10 text-sm text-white/50 leading-relaxed mb-12 max-w-xs penn-hero">
                    Partage tes trajets avec d'autres stagiaires.<br>Simple, solidaire, éco-responsable.
                </p>

                <!-- Stats desktop -->
                <div class="hidden md:flex gap-8 relative z-10 penn-stats">
                    <div class="flex flex-col gap-1">
                        <span class="text-2xl font-light text-sand">Texte</span>
                        <span class="text-[9px] tracking-widest text-white/40 uppercase">Texte</span>
                    </div>
                    <div class="w-px bg-white/10 self-stretch"></div>
                    <div class="flex flex-col gap-1">
                        <span class="text-2xl font-light text-sand">Texte</span>
                        <span class="text-[9px] tracking-widest text-white/40 uppercase">Texte</span>
                    </div>
                    <div class="w-px bg-white/10 self-stretch"></div>
                    <div class="flex flex-col gap-1">
                        <span class="text-2xl font-light text-sand">Texte</span>
                        <span class="text-[9px] tracking-widest text-white/40 uppercase">Texte</span>
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
            <div class="md:w-[58%] md:min-h-screen flex flex-col md:justify-center md:items-center bg-sand-light">
                <div class="px-4 -mt-5 pb-10 w-full md:mt-0 md:pb-0 md:px-12 md:max-w-xl">
                    <div class="bg-white rounded-2xl shadow-[0_4px_32px_rgba(13,59,94,0.10)] p-5 md:p-8 penn-card">

                        <!-- Titre desktop -->
                        <div class="hidden md:block mb-8">
                            <p class="text-[9px] tracking-[2px] text-grey uppercase mb-2">Bienvenue sur PennRide</p>
                            <h2 class="text-2xl font-light text-bluegrey">Connecte-toi ou crée<br>ton <em class="font-pfd italic text-ocean not-italic">compte.</em></h2>
                        </div>

                        <!-- ONGLETS -->
                        <div class="relative flex border-b border-gray-100 mb-6" id="penn-tabs">
                            <div id="tab-indicator" class="absolute bottom-[-1px] h-[2px] bg-ocean rounded-full transition-all duration-300"></div>
                            <button class="penn-tab-btn flex-1 text-[10px] font-medium tracking-widest uppercase py-2.5 text-ocean transition-colors duration-200" data-tab="tab-login">Connexion</button>
                            <button class="penn-tab-btn flex-1 text-[10px] font-medium tracking-widest uppercase py-2.5 text-grey transition-colors duration-200" data-tab="tab-inscription">Inscription</button>
                            <button class="penn-tab-btn flex-1 text-[10px] font-medium tracking-widest uppercase py-2.5 text-grey transition-colors duration-200" data-tab="tab-contact">Contact</button>
                        </div>

                        <!-- CONNEXION -->
                        <div id="tab-login" class="auth-panel">
                            <?php if (session()->getFlashdata('success')): ?>
                                <p class="text-[11px] text-green-600 mb-3"><?= session()->getFlashdata('success') ?></p>
                            <?php endif ?>
                            <?php if (!empty($message) && ($activeTab ?? 'login') === 'login'): ?>
                                <p class="text-[11px] text-red-500 mb-3"><?= esc($message) ?></p>
                            <?php endif; ?>
                            <?= form_open("/authentification") ?>
                            <div class="flex flex-col gap-4 mb-5">
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey" for="email-auth">Email</label>
                                    <input class="penn-input w-full border border-input-border bg-input-bg rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white focus:shadow-[0_0_0_3px_rgba(13,59,94,0.08)] transition-all duration-200" type="email" id="email-auth" name="email-auth" placeholder="ton@email.fr" required>
                                </div>
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey" for="password-auth">Mot de passe</label>
                                    <input class="penn-input w-full border border-input-border bg-input-bg rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white focus:shadow-[0_0_0_3px_rgba(13,59,94,0.08)] transition-all duration-200" type="password" id="password-auth" name="password-auth" placeholder="••••••••" required>
                                </div>
                                <?php if (session()->getFlashdata('auth_error')): ?>
                                    <p class="text-[11px] text-red-500"><?= session()->getFlashdata('auth_error') ?></p>
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="penn-btn w-full bg-ocean hover:bg-ocean-light text-white rounded-xl py-3 text-xs font-medium tracking-widest transition-all duration-200 hover:shadow-[0_4px_16px_rgba(13,59,94,0.25)] active:scale-[0.98]">
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
                                        <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">Nom</label>
                                        <input class="penn-input w-full border border-input-border bg-input-bg rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white focus:shadow-[0_0_0_3px_rgba(13,59,94,0.08)] transition-all duration-200" type="text" name="last_name" value="<?= set_value('last_name') ?>" placeholder="Dupont" required>
                                        <?php if ($errors['last_name'] ?? null): ?><span class="text-[10px] text-red-500"><?= esc($errors['last_name']) ?></span><?php endif ?>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">Prénom</label>
                                        <input class="penn-input w-full border border-input-border bg-input-bg rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white focus:shadow-[0_0_0_3px_rgba(13,59,94,0.08)] transition-all duration-200" type="text" name="first_name" value="<?= set_value('first_name') ?>" placeholder="Marie" required>
                                        <?php if ($errors['first_name'] ?? null): ?><span class="text-[10px] text-red-500"><?= esc($errors['first_name']) ?></span><?php endif ?>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">Genre</label>
                                    <select class="penn-input w-full border border-input-border bg-input-bg rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white transition-all duration-200" name="gender" required>
                                        <option value="" disabled <?= old('gender', null) ?? 'selected' ?>>Sélectionner</option>
                                        <option value="female" <?= old('gender') === 'female' ? 'selected' : '' ?>>Féminin</option>
                                        <option value="male" <?= old('gender') === 'male' ? 'selected' : '' ?>>Masculin</option>
                                        <option value="none" <?= old('gender') === 'none' ? 'selected' : '' ?>>Non communiqué</option>
                                    </select>
                                    <?php if ($errors['gender'] ?? null): ?><span class="text-[10px] text-red-500"><?= esc($errors['gender']) ?></span><?php endif ?>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">E-mail</label>
                                    <input class="penn-input w-full border border-input-border bg-input-bg rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white focus:shadow-[0_0_0_3px_rgba(13,59,94,0.08)] transition-all duration-200" type="email" name="email-signup" value="<?= set_value('email-signup') ?>" placeholder="ton@email.fr" required>
                                    <?php if ($errors['email'] ?? null): ?><span class="text-[10px] text-red-500"><?= esc($errors['email']) ?></span><?php endif ?>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">Adresse</label>
                                    <input class="address-input penn-input w-full border border-input-border bg-input-bg rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white focus:shadow-[0_0_0_3px_rgba(13,59,94,0.08)] transition-all duration-200" type="text" name="address" value="<?= set_value('address') ?>" placeholder="10 rue de la Paix" required>
                                    <?php if ($errors['address'] ?? null): ?><span class="text-[10px] text-red-500"><?= esc($errors['address']) ?></span><?php endif ?>
                                    <div class="results"></div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">Code postal</label>
                                        <input id="postcode-input" class="penn-input w-full border border-input-border bg-input-bg rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white transition-all duration-200" type="text" name="postcode" value="<?= set_value('postcode') ?>" placeholder="29000">
                                        <?php if ($errors['postcode'] ?? null): ?><span class="text-[10px] text-red-500"><?= esc($errors['postcode']) ?></span><?php endif ?>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">Ville</label>
                                        <input id="city-input" class="penn-input w-full border border-input-border bg-input-bg rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white transition-all duration-200" type="text" name="city" value="<?= set_value('city') ?>" placeholder="Brest" required>
                                        <?php if ($errors['city'] ?? null): ?><span class="text-[10px] text-red-500"><?= esc($errors['city']) ?></span><?php endif ?>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">Téléphone</label>
                                        <input class="penn-input w-full border border-input-border bg-input-bg rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white transition-all duration-200" type="tel" name="mobile" value="<?= set_value('mobile') ?>" placeholder="06 00 00 00 00">
                                        <?php if ($errors['mobile'] ?? null): ?><span class="text-[10px] text-red-500"><?= esc($errors['mobile']) ?></span><?php endif ?>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">Date de naissance</label>
                                        <input class="penn-input w-full border border-input-border bg-input-bg rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white transition-all duration-200" type="date" name="birth_date" value="<?= set_value('birth_date') ?>" required>
                                        <?php if ($errors['birth_date'] ?? null): ?><span class="text-[10px] text-red-500"><?= esc($errors['birth_date']) ?></span><?php endif ?>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">
                                        Mot de passe
                                        <span class="normal-case font-light tracking-normal text-grey/70 block mt-0.5">(8 car. min., 1 majuscule, 1 chiffre, 1 spécial)</span>
                                    </label>
                                    <input class="penn-input w-full border border-input-border bg-input-bg rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white focus:shadow-[0_0_0_3px_rgba(13,59,94,0.08)] transition-all duration-200" type="password" name="password" required>
                                    <?php if ($errors['password'] ?? null): ?><span class="text-[10px] text-red-500"><?= esc($errors['password']) ?></span><?php endif ?>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">Confirmation du mot de passe</label>
                                    <input class="penn-input w-full border border-input-border bg-input-bg rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white focus:shadow-[0_0_0_3px_rgba(13,59,94,0.08)] transition-all duration-200" type="password" name="password_conf" required>
                                    <?php if ($errors['password_conf'] ?? null): ?><span class="text-[10px] text-red-500"><?= esc($errors['password_conf']) ?></span><?php endif ?>
                                </div>

                            </div>
                            <button type="submit" name="submit" class="penn-btn w-full bg-ocean hover:bg-ocean-light text-white rounded-xl py-3 text-xs font-medium tracking-widest transition-all duration-200 hover:shadow-[0_4px_16px_rgba(13,59,94,0.25)] active:scale-[0.98]">
                                Je m'inscris →
                            </button>
                            <?= form_close() ?>
                        </div>

                        <!-- CONTACT -->
                        <div id="tab-contact" class="auth-panel hidden">
                            <p class="text-xs text-grey leading-relaxed mb-5">
                                <strong class="text-bluegrey">Une interrogation ? Besoin d'un renseignement ?</strong><br>
                                Écris-nous et un membre de l'administration reviendra vers toi rapidement.
                            </p>
                            <?= view('ContactForm') ?>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    <?php else: ?>

        <!-- Header compact — identique à main.php -->
        <div class="bg-ocean px-5 md:px-10 flex items-center justify-between h-16">
            <a href="/" class="flex items-center gap-3">
                <img src="/img/logo.png" alt="PennRide" class="w-10 h-10 rounded-xl">
                <span class="hidden md:block text-sand text-xs tracking-widest uppercase font-light">PennRide</span>
            </a>
            <nav class="hidden md:flex items-center gap-2">
                <a class="nav-d hover:text-sand transition-colors px-3 py-2 rounded-lg hover:bg-ocean-light" href="<?= site_url('trajet') ?>">Trajets</a>
                <a class="nav-d hover:text-sand transition-colors px-3 py-2 rounded-lg hover:bg-ocean-light" href="/nouveau-trajet">Proposer</a>
                <a class="nav-d hover:text-sand transition-colors px-3 py-2 rounded-lg hover:bg-ocean-light" href="/myprofil">Mon profil</a>
                <?php if (session('user_role') == 2): ?>
                    <a class="text-xs font-poppins text-ocean bg-sand px-3 py-1 rounded-full font-medium ml-2" href="/backoffice">Admin</a>
                <?php endif; ?>
            </nav>
            <div class="flex items-center gap-3">
                <div class="hidden md:flex items-center gap-2 border border-sand rounded-full px-3 py-1">
                    <span class="text-xs text-sand font-medium">
                        <?= strtoupper(substr(session('user_first_name'), 0, 1)) ?><?= strtoupper(substr(session('user_last_name'), 0, 1)) ?>
                    </span>
                    <span class="text-xs text-babyblue"><?= session('user_first_name') ?></span>
                </div>
                <button class="md:hidden p-2" onclick="toggleMobileMenu()">
                    <svg width="20" height="16" viewBox="0 0 20 16" fill="none">
                        <rect y="0" width="20" height="2" rx="1" fill="#F0C878" />
                        <rect y="7" width="20" height="2" rx="1" fill="#F0C878" />
                        <rect y="14" width="20" height="2" rx="1" fill="#F0C878" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Contenu connecté -->
        <div class="px-4 md:px-12 py-8">
            <div class="max-w-sm mx-auto flex flex-col gap-3">
                <a href="/trajet" class="block w-full bg-ocean hover:bg-ocean-light text-white text-center py-3 rounded-xl text-xs font-medium tracking-widest uppercase transition-all duration-200">Voir les trajets →</a>
                <a href="/nouveau-trajet" class="block w-full border border-ocean text-ocean text-center py-3 rounded-xl text-xs font-medium tracking-widest uppercase transition-colors duration-200 hover:bg-sand-light">Proposer un trajet</a>
                <a href="/myprofil" class="block w-full border border-input-border text-bluegrey text-center py-3 rounded-xl text-xs font-medium tracking-widest uppercase transition-colors duration-200 hover:bg-sand-light">Mon profil</a>
                <?php if (session('user_role') == 2): ?>
                    <a href="/backoffice" class="block w-full border border-sand text-ocean text-center py-3 rounded-xl text-xs font-medium tracking-widest uppercase transition-colors duration-200 hover:bg-sand">Dashboard admin</a>
                <?php endif; ?>
                <a href="/logout" class="block w-full border border-red-200 text-red-400 text-center py-3 rounded-xl text-xs font-medium tracking-widest uppercase transition-colors duration-200 hover:bg-red-50">Se déconnecter</a>
            </div>
        </div>

    <?php endif; ?>


</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="/js/geocoding.js"></script>
<script src="/js/profile-address.js"></script>
<script>
    // ===== ANIMATIONS D'ENTRÉE =====
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

    // ===== ONGLETS AVEC SLIDING INDICATOR =====
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
            b.classList.remove('text-ocean');
            b.classList.add('text-grey');
        });
        const activeBtn = document.querySelector(`[data-tab="${tabId}"]`);
        if (activeBtn) {
            activeBtn.classList.remove('text-grey');
            activeBtn.classList.add('text-ocean');
            moveIndicator(activeBtn);
        }
    }

    btns.forEach(btn => btn.addEventListener('click', () => showTab(btn.dataset.tab)));
    window.addEventListener('resize', () => {
        const active = document.querySelector('.penn-tab-btn.text-ocean');
        moveIndicator(active);
    });
    setTimeout(() => moveIndicator(document.querySelector('.penn-tab-btn.text-ocean')), 50);

    // ===== SHAKE SUR SUBMIT INVALIDE =====
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

    // ===== TAB INITIAL =====
    <?php if (session()->getFlashdata('singup_error') || !empty($errors)): ?>
        showTab('tab-inscription');
    <?php else: ?>
        showTab('tab-login');
    <?php endif; ?>
</script>
<?= $this->endSection() ?>