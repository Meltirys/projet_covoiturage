<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<main class="min-h-screen font-poppins bg-ocean text-lightgrey">
    <div class="max-w-3xl mx-auto px-5 md:px-10 py-10 md:py-16">

        <!-- Hero -->
        <div class="mb-10">
            <p class="text-gold uppercase tracking-widest mb-3" style="font-size: 9px; letter-spacing: 0.2em;">PennRide · GRETA Bretagne Sud</p>
            <h1 class="font-pfd text-3xl md:text-4xl font-light text-lightgrey mb-4">Conditions générales <em class="italic text-gold">d'utilisation</em></h1>
            <div style="width: 40px; height: 1px; background: var(--color-gold); opacity: 0.4;"></div>
        </div>

        <!-- Sections -->
        <div class="flex flex-col gap-0">

            <div class="py-6" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <p class="text-gold uppercase tracking-widest mb-3" style="font-size: 9px; letter-spacing: 0.2em;">1. Présentation du service</p>
                <p class="text-lightgrey text-sm leading-relaxed">PennRide est une plateforme de covoiturage interne réservée exclusivement aux stagiaires et membres du <strong>GRETA Bretagne Sud</strong>. Elle permet la mise en relation entre conducteurs et passagers pour des trajets liés à leur formation.</p>
                <p class="text-grey text-sm leading-relaxed mt-2">L'accès au service est soumis à validation préalable par un administrateur. Toute inscription d'une personne extérieure au GRETA est interdite.</p>
            </div>

            <div class="py-6" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <p class="text-gold uppercase tracking-widest mb-3" style="font-size: 9px; letter-spacing: 0.2em;">2. Inscription et accès</p>
                <p class="text-lightgrey text-sm leading-relaxed">Pour accéder à PennRide, l'utilisateur doit créer un compte en renseignant des informations exactes et à jour. Tout compte créé avec de fausses informations pourra être supprimé sans préavis.</p>
                <p class="text-grey text-sm leading-relaxed mt-2">L'utilisateur est responsable de la confidentialité de ses identifiants et s'engage à ne pas les partager avec des tiers.</p>
            </div>

            <div class="py-6" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <p class="text-gold uppercase tracking-widest mb-3" style="font-size: 9px; letter-spacing: 0.2em;">3. Règles de conduite</p>
                <p class="text-lightgrey text-sm leading-relaxed">En utilisant PennRide, l'utilisateur s'engage à :</p>
                <ul class="flex flex-col gap-1 mt-2 ml-4" style="list-style: disc;">
                    <li class="text-grey text-sm leading-relaxed">Respecter les autres utilisateurs et maintenir un comportement courtois</li>
                    <li class="text-grey text-sm leading-relaxed">Honorer les trajets proposés ou prévenir en cas d'empêchement</li>
                    <li class="text-grey text-sm leading-relaxed">Renseigner des informations exactes sur les trajets (départ, arrivée, horaires, places disponibles)</li>
                    <li class="text-grey text-sm leading-relaxed">Ne pas utiliser le service à des fins commerciales ou lucratives</li>
                    <li class="text-grey text-sm leading-relaxed">Respecter le Code de la route et les règles de sécurité routière</li>
                </ul>
            </div>

            <div class="py-6" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <p class="text-gold uppercase tracking-widest mb-3" style="font-size: 9px; letter-spacing: 0.2em;">4. Responsabilités</p>
                <p class="text-lightgrey text-sm leading-relaxed">PennRide est un service de mise en relation uniquement. Le GRETA Bretagne Sud et l'équipe des PennRiders <strong>ne sauraient être tenus responsables</strong> :</p>
                <ul class="flex flex-col gap-1 mt-2 ml-4" style="list-style: disc;">
                    <li class="text-grey text-sm leading-relaxed">Des accidents ou incidents survenus lors des trajets</li>
                    <li class="text-grey text-sm leading-relaxed">Du non-respect des engagements entre utilisateurs</li>
                    <li class="text-grey text-sm leading-relaxed">Des informations inexactes publiées par les utilisateurs</li>
                    <li class="text-grey text-sm leading-relaxed">De toute interruption ou indisponibilité du service</li>
                </ul>
                <p class="text-grey text-sm leading-relaxed mt-2">Chaque conducteur reste seul responsable de son véhicule et de sa conduite. Il est fortement recommandé de vérifier que votre assurance couvre le covoiturage.</p>
            </div>

            <div class="py-6" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <p class="text-gold uppercase tracking-widest mb-3" style="font-size: 9px; letter-spacing: 0.2em;">5. Participation aux frais</p>
                <p class="text-lightgrey text-sm leading-relaxed">Le partage des frais entre conducteur et passagers est autorisé dans la limite du coût réel du trajet (carburant, péages). PennRide n'est pas une plateforme de transport rémunéré. Aucune commission ou transaction financière ne transite par le service.</p>
            </div>

            <div class="py-6" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <p class="text-gold uppercase tracking-widest mb-3" style="font-size: 9px; letter-spacing: 0.2em;">6. Données personnelles</p>
                <p class="text-lightgrey text-sm leading-relaxed">Les données personnelles collectées (nom, prénom, adresse, e-mail, téléphone) sont utilisées uniquement pour le fonctionnement de PennRide. Elles ne sont ni vendues ni transmises à des tiers. Conformément au RGPD, l'utilisateur peut demander la suppression de son compte et de ses données à tout moment depuis son profil.</p>
            </div>

            <div class="py-6" style="border-top: 0.5px solid rgba(180,140,60,0.2);">
                <p class="text-gold uppercase tracking-widest mb-3" style="font-size: 9px; letter-spacing: 0.2em;">7. Suspension et suppression de compte</p>
                <p class="text-lightgrey text-sm leading-relaxed">L'équipe des PennRiders se réserve le droit de suspendre ou supprimer tout compte ne respectant pas les présentes CGU, sans préavis ni justification obligatoire.</p>
            </div>

            <div class="py-6" style="border-top: 0.5px solid rgba(180,140,60,0.2); border-bottom: 0.5px solid rgba(180,140,60,0.2);">
                <p class="text-gold uppercase tracking-widest mb-3" style="font-size: 9px; letter-spacing: 0.2em;">8. Modifications des CGU</p>
                <p class="text-lightgrey text-sm leading-relaxed">Les présentes CGU peuvent être modifiées à tout moment. Les utilisateurs seront informés de toute modification significative. La poursuite de l'utilisation du service après modification vaut acceptation des nouvelles CGU.</p>
            </div>

        </div>

        <p class="text-grey mt-8" style="font-size: 10px;">Dernière mise à jour : juin 2026</p>

    </div>
</main>

<?= $this->endSection() ?>