<?= view('commons/header') ?>

<?php if (session()->getFlashdata('user_validation_success')): ?>
    <p class="text-xs text-green-600 mb-3"><?= session()->getFlashdata('user_validation_success') ?></p>
<?php endif ?>
<?php if (session()->getFlashdata('user_validation_error')): ?>
    <p class="text-xs text-red-500 mb-3"><?= session()->getFlashdata('user_validation_error') ?></p>
<?php endif ?>

<?php if (empty($users)): ?>
    <p>Aucun utilisateur en attente de validation.</p>
<?php else: ?>
    <?php foreach ($users as $user): ?>
        <div>
            <p><?= esc($user['first_name']) ?> <?= esc($user['last_name']) ?></p>
            <p><?= esc($user['email']) ?></p>

            <?= form_open('userValidation/accept/' . $user['id_user']) ?>
            <button type="submit">Accepter</button>
            <?= form_close() ?>

            <?= form_open('userValidation/refuse/' . $user['id_user']) ?>
            <button type="submit">Refuser</button>
            <?= form_close() ?>
        </div>
    <?php endforeach ?>
<?php endif ?>