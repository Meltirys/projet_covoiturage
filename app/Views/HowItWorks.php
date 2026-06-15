<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<main class="min-h-screen font-poppins bg-ocean text-lightgrey">

    <!-- Hero -->
    <div class="profile-hero px-5 md:px-10 py-10 md:py-16 mb-8">
        <div class="relative z-10 max-w-5xl mx-auto">
            <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5">PennRide · Guide</p>
            <h1 class="font-pfd text-4xl md:text-5xl font-light leading-[0.92] tracking-tight text-lightgrey">
                Comment ça<br>
                <em class="italic text-gold">marche ?</em>
            </h1>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-5 md:px-10 pb-16">

        <!-- Étapes -->
        <div class="flex flex-col gap-0">

            <!-- Étape 1 -->
            <div class="flex gap-6 md:gap-12 py-8 md:py-10" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <div class="shrink-0 flex flex-col items-center gap-2">
                    <span class="font-pfd text-4xl md:text-5xl font-light text-gold opacity-40">01</span>
                    <div class="w-px flex-1 mt-2" style="background: rgba(180,140,60,0.15);"></div>
                </div>
                <div class="flex flex-col gap-3 pb-8">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: rgba(180,140,60,0.1); border: 0.5px solid rgba(180,140,60,0.3);">
                            <i class="fa-regular fa-user text-gold" style="font-size: 12px;"></i>
                        </div>
                        <p class="text-gold uppercase tracking-widest" style="font-size: 9px; letter-spacing: 0.2em;">Première étape</p>
                    </div>
                    <h2 class="font-pfd text-2xl md:text-3xl font-light text-lightgrey">Je crée mon <em class="italic text-gold">compte</em></h2>
                    <p class="text-grey text-sm leading-relaxed max-w-lg">Inscris-toi avec tes informations personnelles. Ton compte sera validé par un administrateur du GRETA avant que tu puisses accéder au service — c'est ce qui garantit que PennRide reste réservé aux membres de la communauté.</p>
                    <a href="/" class="inline-flex items-center gap-2 text-gold hover:opacity-70 transition-opacity mt-1" style="font-size: 11px; letter-spacing: 0.1em;">
                        Créer un compte <i class="fa-solid fa-arrow-right" style="font-size: 9px;"></i>
                    </a>
                </div>
            </div>

            <!-- Étape 2 -->
            <div class="flex gap-6 md:gap-12 py-8 md:py-10" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <div class="shrink-0 flex flex-col items-center gap-2">
                    <span class="font-pfd text-4xl md:text-5xl font-light text-gold opacity-40">02</span>
                    <div class="w-px flex-1 mt-2" style="background: rgba(180,140,60,0.15);"></div>
                </div>
                <div class="flex flex-col gap-3 pb-8">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: rgba(180,140,60,0.1); border: 0.5px solid rgba(180,140,60,0.3);">
                            <i class="fa-solid fa-magnifying-glass text-gold" style="font-size: 12px;"></i>
                        </div>
                        <p class="text-gold uppercase tracking-widest" style="font-size: 9px; letter-spacing: 0.2em;">Deuxième étape</p>
                    </div>
                    <h2 class="font-pfd text-2xl md:text-3xl font-light text-lightgrey">Je recherche ou propose <em class="italic text-gold">un trajet</em></h2>
                    <p class="text-grey text-sm leading-relaxed max-w-lg">Tu peux rechercher un trajet existant en renseignant ton point de départ, ta destination et ta date. Tu peux aussi proposer ton propre trajet si tu es conducteur — indique les détails et les places disponibles dans ton véhicule.</p>
                    <div class="flex gap-4 mt-1">
                        <a href="/trajet" class="inline-flex items-center gap-2 text-gold hover:opacity-70 transition-opacity" style="font-size: 11px; letter-spacing: 0.1em;">
                            Rechercher <i class="fa-solid fa-arrow-right" style="font-size: 9px;"></i>
                        </a>
                        <a href="/nouveau-trajet" class="inline-flex items-center gap-2 text-gold hover:opacity-70 transition-opacity" style="font-size: 11px; letter-spacing: 0.1em;">
                            Proposer <i class="fa-solid fa-arrow-right" style="font-size: 9px;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Étape 3 -->
            <div class="flex gap-6 md:gap-12 py-8 md:py-10" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <div class="shrink-0 flex flex-col items-center gap-2">
                    <span class="font-pfd text-4xl md:text-5xl font-light text-gold opacity-40">03</span>
                    <div class="w-px flex-1 mt-2" style="background: rgba(180,140,60,0.15);"></div>
                </div>
                <div class="flex flex-col gap-3 pb-8">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: rgba(180,140,60,0.1); border: 0.5px solid rgba(180,140,60,0.3);">
                            <i class="fa-solid fa-check text-gold" style="font-size: 12px;"></i>
                        </div>
                        <p class="text-gold uppercase tracking-widest" style="font-size: 9px; letter-spacing: 0.2em;">Troisième étape</p>
                    </div>
                    <h2 class="font-pfd text-2xl md:text-3xl font-light text-lightgrey">Je valide ou ma demande <em class="italic text-gold">est validée</em></h2>
                    <p class="text-grey text-sm leading-relaxed max-w-lg">En tant que passager, tu envoies une demande de réservation au conducteur. Ce dernier accepte ou refuse ta demande. En tant que conducteur, tu reçois les demandes des passagers et tu décides qui monte à bord.</p>
                </div>
            </div>

            <!-- Étape 4 -->
            <div class="flex gap-6 md:gap-12 py-8 md:py-10" style="border-top: 0.5px solid rgba(180,140,60,0.2); border-bottom: 0.5px solid rgba(180,140,60,0.2);">
                <div class="shrink-0">
                    <span class="font-pfd text-4xl md:text-5xl font-light text-gold opacity-40">04</span>
                </div>
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: rgba(180,140,60,0.1); border: 0.5px solid rgba(180,140,60,0.3);">
                            <i class="fa-solid fa-car text-gold" style="font-size: 12px;"></i>
                        </div>
                        <p class="text-gold uppercase tracking-widest" style="font-size: 9px; letter-spacing: 0.2em;">Quatrième étape</p>
                    </div>
                    <h2 class="font-pfd text-2xl md:text-3xl font-light text-lightgrey">On covoiture <em class="italic text-gold">ensemble !</em></h2>
                    <p class="text-grey text-sm leading-relaxed max-w-lg">Le jour J, rendez-vous au point de départ convenu. Simple, solidaire et éco-responsable — chaque trajet partagé c'est moins de CO₂ et plus de lien entre stagiaires du GRETA.</p>
                </div>
            </div>

        </div>

        <!-- CTA -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 mt-12 pt-8" style="border-top: 0.5px solid rgba(180,140,60,0.1);">
            <div>
                <p class="font-pfd text-xl font-light text-lightgrey mb-1">Prêt à démarrer ?</p>
                <p class="text-grey" style="font-size: 12px;">Rejoins la communauté PennRide dès maintenant.</p>
            </div>
            <div class="flex gap-3">
                <a href="/trajet" class="text-xs font-medium text-lightgrey border rounded-full px-5 py-2.5 hover:border-gold hover:text-gold transition-colors" style="border-color: rgba(180,140,60,0.3);">Voir les trajets</a>
                <a href="/" class="text-xs font-semibold text-ocean bg-gold rounded-full px-5 py-2.5 hover:opacity-90 transition-opacity">Proposer un trajet</a>
            </div>
        </div>

    </div>
</main>

<?= $this->endSection() ?>