<?php
$status        = session()->getFlashdata('status');
$driveErrors   = session()->getFlashdata('drive_errors') ?? [];
$requestErrors = session()->getFlashdata('request_errors') ?? [];
$error         = session()->getFlashdata('error');
$oldTab        = session()->getFlashdata('tab');
?>
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="profile-hero px-4 md:px-8 py-10 md:py-14 mb-8">
    <div class="relative z-10 max-w-5xl mx-auto">
        <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5">
            Trajets
        </p>
        <h1 class="font-pfd text-4xl md:text-6xl font-light leading-[0.92] tracking-tight text-lightgrey">
            Proposer<br>
            <em class="italic text-gold">un trajet</em>
        </h1>
    </div>
</div>

<main class="w-full max-w-5xl mx-auto px-4 md:px-8 pb-12 font-poppins">

    <?php if (!empty($status)): ?>
        <p class="text-xs text-green border border-green/30 rounded-lg px-3 py-2 mb-4"><?= esc($status) ?></p>
    <?php endif ?>
    <?php if (!empty($error)): ?>
        <p class="text-xs text-red border border-red/30 rounded-lg px-3 py-2 mb-4"><?= esc($error) ?></p>
    <?php endif ?>

    <!-- Onglets -->
    <div class="flex gap-1 mb-6 border-b border-ocean-light">
        <button id="tab-drive"
            onclick="switchTab('drive')"
            class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold px-4 py-2.5 transition-colors border-b-2 -mb-px border-gold text-gold cursor-pointer">
            <i class="fa-solid fa-car" style="color: var(--color-gold)"></i> Conducteur
        </button>
        <button id="tab-request"
            onclick="switchTab('request')"
            class="text-[0.625rem] tracking-[0.2em] uppercase font-semibold px-4 py-2.5 transition-colors border-b-2 -mb-px border-transparent text-grey hover:text-sand cursor-pointer">
            <i class="fa-solid fa-person-walking" style="color: var(--color-gold)"></i> Passager
        </button>
    </div>

    <!-- Formulaire conducteur -->
    <div id="panel-drive">
        <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden">
            <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
            <div class="p-5">
                <?= view('itinerary/create/create_drive_form', ['errors' => $driveErrors, 'cars' => $cars ?? []]) ?>
            </div>
        </div>
    </div>

    <!-- Formulaire passager -->
    <div id="panel-request" style="display:none">
        <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden">
            <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
            <div class="p-5">
                <?= view('itinerary/create/create_request_form', ['errors' => $requestErrors]) ?>
            </div>
        </div>
    </div>

</main>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="js/geocoding.js"></script>
<script src="js/address-fields.js"></script>
<script src="js/formation-handdler.js"></script>
<script>
    //The name of the school, needed in the formation-handdler.js
    const schoolName = "<?= $schoolName ?>";
    // Tabs
    function switchTab(tab) {
        const isDrive = tab === 'drive'
        document.getElementById('panel-drive').style.display = isDrive ? 'block' : 'none'
        document.getElementById('panel-request').style.display = isDrive ? 'none' : 'block'
        document.getElementById('tab-drive').classList.toggle('border-gold', isDrive)
        document.getElementById('tab-drive').classList.toggle('text-gold', isDrive)
        document.getElementById('tab-drive').classList.toggle('border-transparent', !isDrive)
        document.getElementById('tab-drive').classList.toggle('text-grey', !isDrive)
        document.getElementById('tab-request').classList.toggle('border-gold', !isDrive)
        document.getElementById('tab-request').classList.toggle('text-gold', !isDrive)
        document.getElementById('tab-request').classList.toggle('border-transparent', isDrive)
        document.getElementById('tab-request').classList.toggle('text-grey', isDrive)
    }

    <?php if (!empty($requestErrors) || $oldTab === 'request'): ?>
        switchTab('request');
    <?php endif ?>

    // Car, seats and school name
    document.addEventListener('DOMContentLoaded', () => {
        const cars = <?= json_encode($cars ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
        const carSelect = document.getElementById('drive-car')
        const seatSelect = document.getElementById('drive-seats')
        const oldSeatValue = '<?= old('drive.seats') ?>'

        function populateSeats() {
            const car = cars.find(c => String(c.id_car) === carSelect.value)
            seatSelect.innerHTML = '<option value="">-- Choisissez le nombre de places disponibles --</option>'
            if (!car) return
            for (let i = 1; i <= car.seats; i++) {
                const opt = document.createElement('option')
                opt.value = i
                opt.textContent = `${i}`
                if (String(i) === oldSeatValue) opt.selected = true
                seatSelect.appendChild(opt)
            }
        }

        if (carSelect && seatSelect && Array.isArray(cars) && cars.length > 0) {
            carSelect.addEventListener('change', populateSeats)
            populateSeats()
        }

    })

</script>
<?= $this->endSection() ?>