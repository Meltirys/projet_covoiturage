<?= view('commons/header') ?>

<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

    <header class="flex justify-between items-center mb-6">
        <h2 class="text-xs font-poppins tracking-[0.15em] text-[#253F72] uppercase">Validation des utilisateurs</h2>
    </header>

    <?php if (session()->getFlashdata('user_validation_success')): ?>
        <p class="text-xs text-green-600 mb-3"><?= session()->getFlashdata('user_validation_success') ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('user_validation_error')): ?>
        <p class="text-xs text-red-500 mb-3"><?= session()->getFlashdata('user_validation_error') ?></p>
    <?php endif ?>

    <?php if (empty($users)): ?>
        <p class="text-sm text-[#9AA5B4] text-center py-6">Aucun utilisateur en attente de validation.</p>
    <?php else: ?>
        <div class="flex flex-col gap-3">
            <?php foreach ($users as $user): ?>
                <div class="flex justify-between items-center bg-white border border-[rgba(37,63,114,0.25)] rounded-xl px-4 py-3">
                    <div>
                        <p class="text-sm font-poppins text-[#253F72]"><?= esc($user['first_name']) ?> <?= esc($user['last_name']) ?></p>
                        <p class="text-xs text-[#9AA5B4]"><?= esc($user['email']) ?></p>
                    </div>
                    <div class="flex gap-2">
                        <?= form_open('userValidation/accept/' . $user['id_user']) ?>
                            <button type="submit" class="text-xs text-green-600 border border-green-200 rounded-full px-3 py-1 hover:bg-green-50 transition-colors duration-150">Accepter</button>
                        <?= form_close() ?>
                        <?= form_open('userValidation/refuse/' . $user['id_user']) ?>
                            <button type="submit" class="text-xs text-[#E05353] border border-[rgba(224,83,83,0.3)] rounded-full px-3 py-1 hover:bg-red-50 transition-colors duration-150">Refuser</button>
                        <?= form_close() ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>

</main>