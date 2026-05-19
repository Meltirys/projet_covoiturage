 <?= view('commons/header') ?>
 <?= form_open('/user/update') ?>
 <div>
     <div class="bg-babyblue border border-bluegrey rounded-2xl p-5 flex flex-col gap-3 mb-4">

         <div class="flex flex-col gap-1">
             <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">Nom</label>
             <input class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="text" name="last_name" value="<?= $user['last_name'] ?>" required>
             <?php if ($errors['last_name'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['last_name'] ?></span><?php endif ?>
         </div>
         <div class="flex flex-col gap-1">
             <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">Prénom</label>
             <input class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="text" name="first_name" value="<?= $user['first_name'] ?>" required>
             <?php if ($errors['first_name'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['first_name'] ?></span><?php endif ?>
         </div>
         <div class="flex flex-col gap-1">
             <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">Genre</label>
             <input class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="text" name="gender" value="<?= $user['gender'] ?>" required>
             <?php if ($errors['gender'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['gender'] ?></span><?php endif ?>
         </div>
         <div class="flex flex-col gap-1">
             <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">E-mail</label>
             <input class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="email" name="email-signup" value="<?= $user['email']  ?>" required>
             <?php if ($errors['email'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['email'] ?></span><?php endif ?>
         </div>
         <div class="flex flex-col gap-1">
             <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">Adresse</label>
             <input class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="text" name="address" value="<?= set_value('address') ?>" required>
             <?php if ($errors['address'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['address'] ?></span><?php endif ?>
         </div>
         <div class="grid grid-cols-2 gap-3">
             <div class="flex flex-col gap-1">
                 <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">Code postal</label>
                 <input class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="text" name="post_code" value="<?= set_value('post_code') ?>">
                 <?php if ($errors['post_code'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['post_code'] ?></span><?php endif ?>
             </div>
             <div class="flex flex-col gap-1">
                 <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">Ville</label>
                 <input class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="text" name="city" value="<?= set_value('city') ?>" required>
                 <?php if ($errors['city'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['city'] ?></span><?php endif ?>
             </div>
         </div>
         <div class="grid grid-cols-2 gap-3">
             <div class="flex flex-col gap-1">
                 <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">Téléphone</label>
                 <input class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="tel" name="mobile" value="<?= $user['mobile']  ?>">
                 <?php if ($errors['mobile'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['mobile'] ?></span><?php endif ?>
             </div>
             <div class="flex flex-col gap-1">
                 <label class="text-xs font-medium tracking-widest text-bluegrey uppercase">Date de naissance</label>
                 <input class="w-full rounded-xl border border-bluegrey px-3 py-2 text-xs text-bluegrey focus:outline-none" type="date" name="birth_date" value="<?= $user['birth_date'] ?>" required>
                 <?php if ($errors['birth_date'] ?? null): ?><span class="text-xs text-red-500"><?= $errors['birth_date'] ?></span><?php endif ?>
             </div>
         </div>

     </div>
     <div class="flex justify-center mt-2">
         <button type="submit" name="submit" class="border border-bluegrey text-bluegrey bg-babyblue text-sm font-medium px-6 py-2 rounded-full hover:bg-bluegrey hover:text-white transition-all">
             Modifier
         </button>
     </div>
 </div>
 <?= form_close() ?>

 <?= view('commons/footer') ?>