 <?= view('commons/header') ?>

 <main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">
     <header class="flex justify-between items-center mb-6">
         <h2 class="text-xs tracking-widest text-bluegrey uppercase">Informations personnelles</h2>
     </header>

     <?= form_open('/user/update') ?>


     <div class="bg-white border border-[rgba(37,63,114,0.25)] rounded-xl p-5 flex flex-col gap-3 mb-4">

         <div class="flex flex-col gap-1">
             <label class="text-xs tracking-widest text-bluegrey uppercase">Nom</label>
             <input class="w-full rounded-xl border border-[rgba(37,63,114,0.25)] px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-[rgba(37,63,114,0.25)]" type="text" name="last_name" value="<?= $user['last_name'] ?>" required>
             <?php if ($errors['last_name'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['last_name'] ?></span><?php endif ?>
         </div>
         <div class="flex flex-col gap-1">
             <label class="text-xs tracking-widest text-bluegrey uppercase">Prénom</label>
             <input class="w-full rounded-xl border border-[rgba(37,63,114,0.25)] px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-[rgba(37,63,114,0.25)]" type="text" name="first_name" value="<?= $user['first_name'] ?>" required>
             <?php if ($errors['first_name'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['first_name'] ?></span><?php endif ?>
         </div>
         <div class="flex flex-col gap-1">
             <label class="text-xs tracking-widest text-bluegrey uppercase">Genre</label>
             <input class="w-full rounded-xl border border-[rgba(37,63,114,0.25)] px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-[rgba(37,63,114,0.25)]" type="text" name="gender" value="<?= $user['gender'] ?>" required>
             <?php if ($errors['gender'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['gender'] ?></span><?php endif ?>
         </div>
         <div class="flex flex-col gap-1">
             <label class="text-xs tracking-widest text-bluegrey uppercase">E-mail</label>
             <input class="w-full rounded-xl border border-[rgba(37,63,114,0.25)] px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-[rgba(37,63,114,0.25)]" type="email" name="email-signup" value="<?= $user['email']  ?>" required>
             <?php if ($errors['email'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['email'] ?></span><?php endif ?>
         </div>
         <div class="flex flex-col gap-1">
             <label class="text-xs tracking-widest text-bluegrey uppercase">Adresse</label>
             <input class="w-full rounded-xl border border-[rgba(37,63,114,0.25)] px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-[rgba(37,63,114,0.25)]" type="text" name="address" value="<?= set_value('address') ?>" required>
             <?php if ($errors['address'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['address'] ?></span><?php endif ?>
         </div>
         <div class="grid grid-cols-2 gap-3">
             <div class="flex flex-col gap-1">
                 <label class="text-xs tracking-widest text-bluegrey uppercase">Code postal</label>
                 <input class="w-full rounded-xl border border-[rgba(37,63,114,0.25)] px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-[rgba(37,63,114,0.25)]" type="text" name="postcode" value="<?= set_value('postcode') ?>">
                 <?php if ($errors['postcode'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['postcode'] ?></span><?php endif ?>
             </div>
             <div class="flex flex-col gap-1">
                 <label class="text-xs tracking-widest text-bluegrey uppercase">Ville</label>
                 <input class="w-full rounded-xl border border-[rgba(37,63,114,0.25)] px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-[rgba(37,63,114,0.25)]" type="text" name="city" value="<?= set_value('city') ?>" required>
                 <?php if ($errors['city'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['city'] ?></span><?php endif ?>
             </div>
         </div>
         <div class="grid grid-cols-2 gap-3">
             <div class="flex flex-col gap-1">
                 <label class="text-xs tracking-widest text-bluegrey uppercase">Téléphone</label>
                 <input class="w-full rounded-xl border border-[rgba(37,63,114,0.25)] px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-[rgba(37,63,114,0.25)]" type="tel" id="mobile" name="mobile" value="<?= $user['mobile']  ?>" oninput="formatPhone(this)">
                 <?php if ($errors['mobile'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['mobile'] ?></span><?php endif ?>
             </div>
             <div class="flex flex-col gap-1">
                 <label class="text-xs tracking-widest text-bluegrey uppercase">Date de naissance</label>
                 <input class="w-full rounded-xl border border-[rgba(37,63,114,0.25)] px-3 py-2 text-sm text-bluegrey focus:outline-none focus:border-[rgba(37,63,114,0.25)]" type="date" name="birth_date" value="<?= $user['birth_date'] ?>" required>
                 <?php if ($errors['birth_date'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['birth_date'] ?></span><?php endif ?>
             </div>
         </div>

     </div>
     <div class="flex justify-center mt-2">
         <button type="submit" name="submit" class="border border-[rgba(37,63,114,0.25)] text-bluegrey bg-white text-sm font-medium px-6 py-2 rounded-full hover:bg-bluegrey hover:text-white transition-all">
             Modifier
         </button>
     </div>

     <?= form_close() ?>

 </main>
 <script>
     function formatPhone(input) {
         let value = input.value.replace(/\D/g, '');
         value = value.match(/.{1,2}/g)?.join(' ') || '';
         input.value = value;
     }

     window.addEventListener('load', function() {
         const input = document.getElementById('mobile');
         if (input) formatPhone(input);
     });
 </script>
 <?= view('commons/footer') ?>