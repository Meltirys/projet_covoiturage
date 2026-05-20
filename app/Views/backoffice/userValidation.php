<?= view('commons/header') ?>
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

