<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1>Modifier le rôle d'un utilisateur</h1>
<?php if (session()->getFlashdata('success')): ?>
    <p class="text-xs text-green-600 mb-3"><?= session()->getFlashdata('success') ?></p>
<?php endif ?>
<?php if (session()->getFlashdata('error')): ?>
    <p class="text-xs text-red-500 mb-3"><?= session()->getFlashdata('error') ?></p>
<?php endif ?>
<div>
    <label for="searchUser">Rechercher un utilisateur</label>
    <input type="text" id="searchUser" placeholder="Entrez le nom de l'utilisateur recherché">
</div>

<div id="researchResults">

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script src="<?= base_url('js/user-role.js') ?>"></script>

<?= $this->endSection() ?>