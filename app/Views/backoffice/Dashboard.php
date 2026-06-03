<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<aside>

</aside>

<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

    <?= view('backoffice/ReportManagement') ?>
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
<script src="<?= base_url('js/report-manager.js') ?>"></script>
<?php if (session()->user_role == 3): ?>
    <script src="<?= base_url('js/user-role.js') ?>">
    </script>
<?php endif; ?>

<script>
    const reports = <?= json_encode($reports) ?>; //Preloading the reports
    console.log(reports)
    reportManagementPaginator.load(reports);
</script>


<?= $this->endSection() ?>