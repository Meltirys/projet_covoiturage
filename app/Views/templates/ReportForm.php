<main>
    <?php if (session()->getFlashdata('success')): ?>
        <p class="text-xs text-green-600 border border-green-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('success') ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p class="text-xs text-red-500 border border-red-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('error') ?></p>
    <?php endif ?>
    <?= form_open('user/report/1') ?>
    <div class="flex flex-col gap-1.5">
        <label for="comment" class="text-[9px] font-medium tracking-[1.5px] uppercase text-grey">Message</label>
        <textarea class="w-full border border-[rgba(13,59,94,0.25)] bg-[#F7FAFB] rounded-xl px-3 py-2.5 text-xs text-bluegrey focus:outline-none focus:border-ocean focus:bg-white focus:shadow-[0_0_0_3px_rgba(13,59,94,0.08)] transition-all duration-200 resize-none h-28" name="comment" id="comment" placeholder="Décris la raison du signalement en 255 caractères" required></textarea>
    </div>
    <button type="submit" class="w-full bg-ocean hover:bg-ocean-light text-white rounded-xl py-3 text-xs font-medium tracking-widest transition-all duration-200 hover:shadow-[0_4px_16px_rgba(13,59,94,0.25)] active:scale-[0.98]">
        Envoyer le signalement
    </button>
    <?= form_close() ?>
</main>