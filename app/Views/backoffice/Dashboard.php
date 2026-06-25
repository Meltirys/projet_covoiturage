<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="profile-hero px-4 md:px-8 py-10 md:py-14 mb-8">
    <div class="relative z-10 max-w-5xl mx-auto">
        <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5">Admin</p>
        <h1 class="font-pfd text-4xl md:text-6xl font-light leading-[0.92] tracking-tight text-lightgrey">
            Dashboard<br>
            <em class="italic text-gold">administration</em>
        </h1>
    </div>
</div>

<main class="w-full max-w-5xl mx-auto px-4 md:px-8 pb-12 font-poppins">

    <!-- ===== ONGLETS PRINCIPAUX — CARDS ===== -->
    <div class="grid grid-cols-3 gap-3 mb-8" id="admin-tabs">
        <button class="admin-tab-btn text-left p-3 rounded-xl border transition-all duration-200 flex items-center gap-3"
            data-tab="tab-signalements"
            style="border-color: rgba(180,140,60,0.5); background: rgba(180,140,60,0.08);">
            <i class="fa-regular fa-flag text-gold" style="font-size: 16px;"></i>
            <span class="flex flex-col gap-0.5">
                <span class="text-gold uppercase tracking-widest" style="font-size: 9px; letter-spacing: 0.15em;">Signalements</span>
                <span class="font-pfd text-xl font-light text-gold"><?= $totalReports ?? '—' ?></span>
            </span>
        </button>
        <button class="admin-tab-btn text-left p-3 rounded-xl border transition-all duration-200 flex items-center gap-3"
            data-tab="tab-utilisateurs"
            style="border-color: rgba(180,140,60,0.2); background: var(--color-ocean-mid);">
            <i class="fa-regular fa-user text-grey" style="font-size: 16px; opacity: 0.6;"></i>
            <span class="flex flex-col gap-0.5">
                <span class="text-grey uppercase tracking-widest" style="font-size: 9px; letter-spacing: 0.15em;">Utilisateurs</span>
                <span class="font-pfd text-xl font-light text-grey"><?= $totalUsers ?? '—' ?></span>
            </span>
        </button>
        <?php if (session()->user_role == 3): ?>
            <button class="admin-tab-btn text-left p-3 rounded-xl border transition-all duration-200 flex items-center gap-3"
                data-tab="tab-roles"
                style="border-color: rgba(180,140,60,0.2); background: var(--color-ocean-mid);">
                <i class="fa-regular fa-shield text-grey" style="font-size: 16px; opacity: 0.6;"></i>
                <span class="flex flex-col gap-0.5">
                    <span class="text-grey uppercase tracking-widest" style="font-size: 9px; letter-spacing: 0.15em;">Rôles</span>
                    <span class="font-pfd text-xl font-light text-grey"><?= $totalRoles ?? '—' ?></span>
        </span>
            </button>
        <?php endif; ?>
    </div>

    <!-- ===== PANNEAU SIGNALEMENTS ===== -->
    <div id="tab-signalements" class="admin-panel">
        <div class="relative flex border-b border-ocean-light mb-6" id="report-tabs">
            <div id="report-tab-indicator" class="absolute bottom-[-1px] h-[2px] bg-gold rounded-full transition-all duration-300"></div>
            <button class="report-tab-btn flex-1 md:flex-none md:px-5 text-[10px] font-medium tracking-widest uppercase py-2.5 text-gold transition-colors duration-200" data-tab="subtab-signalements-encours">En cours</button>
            <button class="report-tab-btn flex-1 md:flex-none md:px-5 text-[10px] font-medium tracking-widest uppercase py-2.5 text-grey transition-colors duration-200" data-tab="subtab-signalements-historique">Historique</button>
        </div>
        <div id="subtab-signalements-encours" class="report-panel">
            <?= view('backoffice/ReportManagement') ?>
        </div>
        <div id="subtab-signalements-historique" class="report-panel hidden">
            <?= view('backoffice/ReportHistory') ?>
        </div>
    </div>

    <!-- ===== PANNEAU UTILISATEURS ===== -->
    <div id="tab-utilisateurs" class="admin-panel hidden">
        <div class="relative flex border-b border-ocean-light mb-6" id="user-tabs">
            <div id="user-tab-indicator" class="absolute bottom-[-1px] h-[2px] bg-gold rounded-full transition-all duration-300"></div>
            <button class="user-tab-btn flex-1 md:flex-none md:px-5 text-[10px] font-medium tracking-widest uppercase py-2.5 text-gold transition-colors duration-200" data-tab="subtab-validation">Validation</button>
            <button class="user-tab-btn flex-1 md:flex-none md:px-5 text-[10px] font-medium tracking-widest uppercase py-2.5 text-grey transition-colors duration-200" data-tab="subtab-bannir">Bannir</button>
            <button class="user-tab-btn flex-1 md:flex-none md:px-5 text-[10px] font-medium tracking-widest uppercase py-2.5 text-grey transition-colors duration-200" data-tab="subtab-supprimer">Supprimer</button>
        </div>
        <div id="subtab-validation" class="user-panel">
            <?= view('backoffice/UserValidation') ?>
        </div>
        <div id="subtab-bannir" class="user-panel hidden">
            <?= view('backoffice/UserBan') ?>
        </div>
        <div id="subtab-supprimer" class="user-panel hidden">
            <?= view('backoffice/UserSuppression') ?>
        </div>
    </div>

    <!-- ===== PANNEAU RÔLES ===== -->
    <?php if (session()->user_role == 3): ?>
        <div id="tab-roles" class="admin-panel hidden">
            <?= view('backoffice/UserRole') ?>
        </div>
    <?php endif; ?>

</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/pagination.js') ?>"></script>
<script src="<?= base_url('js/user-ban.js') ?>"></script>
<script src="<?= base_url('js/user-suppression.js') ?>"></script>
<script src="<?= base_url('js/user-validation.js') ?>"></script>
<script src="<?= base_url('js/report-manager.js') ?>"></script>
<?php if (session()->user_role == 3): ?>
    <script src="<?= base_url('js/user-role.js') ?>"></script>
<?php endif; ?>

<script>
    const reports = <?= json_encode($reports) ?>;
    const reportHistory = <?= json_encode($reportsHistory) ?>;
    const toValidateUsers = <?= json_encode($users) ?>;
    reportManagementPaginator.load(reports);
    reportHistoryPaginator.load(reportHistory);
    validationPaginator.load(toValidateUsers);

    function setCardActive(btn) {
        document.querySelectorAll('.admin-tab-btn').forEach(b => {
            b.style.borderColor = 'rgba(180,140,60,0.2)';
            b.style.background = 'var(--color-ocean-mid)';
            b.querySelectorAll('i').forEach(i => {
                i.style.opacity = '0.6';
                i.classList.remove('text-gold');
                i.classList.add('text-grey');
            });
            b.querySelectorAll('span').forEach(s => {
                s.classList.remove('text-gold');
                s.classList.add('text-grey');
            });
        });
        btn.style.borderColor = 'rgba(180,140,60,0.5)';
        btn.style.background = 'rgba(180,140,60,0.08)';
        btn.querySelectorAll('i').forEach(i => {
            i.style.opacity = '1';
            i.classList.remove('text-grey');
            i.classList.add('text-gold');
        });
        btn.querySelectorAll('span').forEach(s => {
            s.classList.remove('text-grey');
            s.classList.add('text-gold');
        });
    }

    function showAdminPanel(tabId) {
        document.querySelectorAll('.admin-panel').forEach(p => {
            p.classList.add('hidden');
            p.style.opacity = '';
            p.style.transform = '';
            p.style.transition = '';
        });
        const panel = document.getElementById(tabId);
        if (panel) {
            panel.style.opacity = '0';
            panel.style.transform = 'translateY(6px)';
            panel.classList.remove('hidden');
            requestAnimationFrame(() => requestAnimationFrame(() => {
                panel.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                panel.style.opacity = '1';
                panel.style.transform = 'translateY(0)';
            }));
        }
    }

    document.querySelectorAll('.admin-tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            setCardActive(btn);
            showAdminPanel(btn.dataset.tab);
        });
    });

    function initTabs(btnSelector, panelSelector, indicatorId, defaultTab) {
        const btns = document.querySelectorAll(btnSelector);
        const panels = document.querySelectorAll(panelSelector);
        const indicator = document.getElementById(indicatorId);

        function moveIndicator(btn) {
            if (!indicator || !btn) return;
            indicator.style.left = btn.offsetLeft + 'px';
            indicator.style.width = btn.offsetWidth + 'px';
        }

        function showTab(tabId) {
            panels.forEach(p => {
                p.classList.add('hidden');
                p.style.opacity = '';
                p.style.transform = '';
                p.style.transition = '';
            });
            const panel = document.getElementById(tabId);
            if (panel) {
                panel.style.opacity = '0';
                panel.style.transform = 'translateY(6px)';
                panel.classList.remove('hidden');
                requestAnimationFrame(() => requestAnimationFrame(() => {
                    panel.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                    panel.style.opacity = '1';
                    panel.style.transform = 'translateY(0)';
                }));
            }
            btns.forEach(b => {
                b.classList.remove('text-gold');
                b.classList.add('text-grey');
            });
            const activeBtn = document.querySelector(`${btnSelector}[data-tab="${tabId}"]`);
            if (activeBtn) {
                activeBtn.classList.remove('text-grey');
                activeBtn.classList.add('text-gold');
                moveIndicator(activeBtn);
            }
        }

        btns.forEach(btn => btn.addEventListener('click', () => showTab(btn.dataset.tab)));
        window.addEventListener('resize', () => moveIndicator(document.querySelector(`${btnSelector}.text-gold`)));
        setTimeout(() => showTab(defaultTab), 50);
    }

    initTabs('.report-tab-btn', '.report-panel', 'report-tab-indicator', 'subtab-signalements-encours');
    initTabs('.user-tab-btn', '.user-panel', 'user-tab-indicator', 'subtab-validation');

    setTimeout(() => {
        setCardActive(document.querySelector('.admin-tab-btn[data-tab="tab-signalements"]'));
        showAdminPanel('tab-signalements');
    }, 50);
</script>
<?= $this->endSection() ?>