<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="profile-hero px-4 md:px-8 py-10 md:py-14 mb-8">
    <div class="relative z-10 max-w-5xl mx-auto">
        <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5">
            Admin
        </p>
        <h1 class="font-pfd text-4xl md:text-6xl font-light leading-[0.92] tracking-tight text-lightgrey">
            Dashboard<br>
            <em class="italic text-gold">administration</em>
        </h1>
    </div>
</div>

<main class="w-full max-w-5xl mx-auto px-4 md:px-8 pb-12 font-poppins">
    <?= view('backoffice/ReportManagement') ?>
    <?= view('backoffice/ReportHistory') ?>
    <?= view('backoffice/UserBan') ?>
    <?php if (session()->user_role == 3): ?>
        <?= view('backoffice/UserRole') ?>
    <?php endif; ?>
    <?= view('backoffice/UserSuppression') ?>
    <?= view('backoffice/UserValidation') ?>
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
    const reports      = <?= json_encode($reports) ?>; // Ne pas oublier les ; !!
    const reportHistory = <?= json_encode($reportsHistory) ?>;
    const toValidateUsers = <?= json_encode($users) ?>;
    reportManagementPaginator.load(reports)
    reportHistoryPaginator.load(reportHistory)
    validationPaginator.load(toValidateUsers)
</script>
<?= $this->endSection() ?>