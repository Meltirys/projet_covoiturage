<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<main class="min-h-screen font-poppins bg-ocean text-lightgrey">
    <div class="max-w-3xl mx-auto px-5 md:px-10 py-10 md:py-16">

        <!-- Hero -->
        <div class="mb-10">
            <p class="text-gold uppercase tracking-widest mb-3" style="font-size: 9px; letter-spacing: 0.2em;">PennRide · GRETA Bretagne Sud</p>
            <h1 class="font-pfd text-3xl md:text-4xl font-light text-lightgrey mb-4">Mentions <em class="italic text-gold">légales</em></h1>
            <div style="width: 40px; height: 1px; background: var(--color-gold); opacity: 0.4;"></div>
        </div>

        <!-- Sections -->
        <div class="flex flex-col gap-0">

            <div class="py-6" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <p class="text-gold uppercase tracking-widest mb-3" style="font-size: 9px; letter-spacing: 0.2em;">Éditeur du site</p>
                <p class="text-lightgrey text-sm leading-relaxed">Le site PennRide est édité par le <strong>GRETA Bretagne Sud — Agence de Vannes</strong>, établissement public de formation continue.</p>
                <p class="text-grey text-sm leading-relaxed mt-2">20 Rue Winston Churchill, 56000 Vannes, France</p>
            </div>

            <div class="py-6" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <p class="text-gold uppercase tracking-widest mb-3" style="font-size: 9px; letter-spacing: 0.2em;">Responsable de publication</p>
                <p class="text-lightgrey text-sm leading-relaxed">L'équipe des <strong>PennRiders</strong> — dans le cadre d'un projet pédagogique du GRETA Bretagne Sud.</p>
            </div>

            <div class="py-6" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <p class="text-gold uppercase tracking-widest mb-3" style="font-size: 9px; letter-spacing: 0.2em;">Hébergement</p>
                <p class="text-lightgrey text-sm leading-relaxed">Le site est hébergé par <strong>o2switch</strong>, SAS au capital de 100 000 €.</p>
                <p class="text-grey text-sm leading-relaxed mt-2">222-224 Boulevard Gustave Flaubert, 63000 Clermont-Ferrand, France<br>
                    Tél. : 04 44 44 60 40 · <a href="https://www.o2switch.fr" class="text-gold hover:opacity-70 transition-opacity">www.o2switch.fr</a></p>
            </div>

            <div class="py-6" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <p class="text-gold uppercase tracking-widest mb-3" style="font-size: 9px; letter-spacing: 0.2em;">Propriété intellectuelle</p>
                <p class="text-lightgrey text-sm leading-relaxed">L'ensemble des contenus présents sur PennRide (textes, images, logo, structure) est la propriété exclusive du GRETA Bretagne Sud et de l'équipe des PennRiders. Toute reproduction, même partielle, est interdite sans autorisation préalable.</p>
            </div>

            <div class="py-6" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <p class="text-gold uppercase tracking-widests mb-3" style="font-size: 9px; letter-spacing: 0.2em;">Données personnelles</p>
                <p class="text-lightgrey text-sm leading-relaxed">Conformément au Règlement Général sur la Protection des Données (RGPD) et à la loi Informatique et Libertés, vous disposez d'un droit d'accès, de rectification et de suppression de vos données personnelles.</p>
                <p class="text-grey text-sm leading-relaxed mt-2">Pour exercer ces droits, contactez-nous via le formulaire de contact disponible sur le site. Les données collectées (nom, prénom, adresse e-mail, adresse postale) sont utilisées uniquement dans le cadre du service de covoiturage PennRide et ne sont pas transmises à des tiers.</p>
            </div>

            <div class="py-6" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <p class="text-gold uppercase tracking-widests mb-3" style="font-size: 9px; letter-spacing: 0.2em;">Cookies</p>
                <p class="text-lightgrey text-sm leading-relaxed">PennRide utilise uniquement des cookies techniques nécessaires au bon fonctionnement du service (session utilisateur, préférence de thème). Aucun cookie publicitaire ou de tracking tiers n'est utilisé.</p>
            </div>

            <div class="py-6" style="border-top: 0.5px solid rgba(180,140,60,0.2); border-bottom: 0.5px solid rgba(180,140,60,0.2);">
                <p class="text-gold uppercase tracking-widests mb-3" style="font-size: 9px; letter-spacing: 0.2em;">Responsabilité</p>
                <p class="text-lightgrey text-sm leading-relaxed">PennRide est un service de mise en relation entre stagiaires du GRETA Bretagne Sud. L'équipe des PennRiders ne saurait être tenue responsable des trajets effectués, des incidents survenus lors de ceux-ci, ni des informations inexactes renseignées par les utilisateurs.</p>
            </div>

        </div>

        <p class="text-grey mt-8" style="font-size: 10px;">Dernière mise à jour : juin 2026</p>

    </div>
</main>

<?= $this->endSection() ?>