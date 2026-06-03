<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<aside>

</aside>

<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

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
<?php if (session()->user_role == 3): ?>
    <script src="<?= base_url('js/user-role.js') ?>">
        </script>
    <?php endif; ?>


    <?= $this->endSection() ?>