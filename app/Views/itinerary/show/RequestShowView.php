<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<main>
    <h2>Demande de <?= esc($author['first_name']) ?></h2>

    <p>Départ : <?= esc($request['start_address']) ?></p>
    <p>Arrivée : <?= esc($request['end_address']) ?></p>
    <p>Disponibilité : <?= esc($request['earliest_departure']) ?> - <?= esc($request['latest_departure']) ?></p>
    <p>Description : <?= esc($request['description']) ?></p>

    <div class="flex items-center gap-3 mt-4">
        <?php if ($ownRequest): ?>
            <a href="<?= site_url('request/edit/' . $request['id_journey_request']) ?>"
                class="bg-gold text-ocean font-semibold text-xs px-5 py-2 rounded-full hover:opacity-90 transition-opacity">
                Modifier
            </a>
            <?= form_open('request/delete/' . $request['id_journey_request'], ['onsubmit' => "return confirm('Supprimer cette demande ?')"]) ?>
                <button type="submit"
                    class="text-xs font-bold bg-red/10 border border-red/20 text-red rounded-full px-5 py-2 hover:bg-red/20 transition-colors">
                    Supprimer
                </button>
            <?= form_close() ?>
        <?php elseif (!$hasJoined): ?>
            <?= form_open('request/join/' . $request['id_journey_request']) ?>
                <button type="submit"
                    class="bg-gold text-ocean font-semibold text-xs px-5 py-2 rounded-full hover:opacity-90 transition-opacity cursor-pointer">
                    Rejoindre cette demande
                </button>
            <?= form_close() ?>
        <?php else: ?>
            <span class="text-xs font-bold bg-gold/10 border border-gold/20 text-gold rounded-full px-5 py-2">
                Vous avez déjà rejoint cette demande
            </span>
        <?php endif ?>
    </div>
</main>

<?= $this->endSection() ?>