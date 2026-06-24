<?php
$status = session()->getFlashdata('status');
$errors = session()->getFlashdata('errors') ?? [];
$error  = session()->getFlashdata('error');
$selectedCar = old('drive.car', $journey['id_car']);
$selectedSeat = old('drive.seats', $journey['number_of_place']);
?>

<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="profile-hero px-4 md:px-8 py-10 md:py-14 mb-8">
    <div class="relative z-10 max-w-5xl mx-auto">
        <p class="section-title flex items-center gap-2 text-[0.625rem] tracking-[0.2em] uppercase font-bold text-gold mb-5">
            Trajets
        </p>
        <h1 class="font-pfd text-4xl md:text-6xl font-light leading-[0.92] tracking-tight text-lightgrey">
            Modifier<br>
            <em class="italic text-gold">mon trajet</em>
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

    <div class="bg-ocean-mid border border-ocean-light rounded-[14px] overflow-hidden">
        <div class="h-0.5 bg-linear-to-r from-gold/40 to-transparent"></div>
        <div class="p-5">
            <?= view('itinerary/edit/edit_drive_form', [
                'errors' => $errors,
                'journey' => $journey,
                'cars' => $cars,
                'selectedCar' => $selectedCar,
                'selectedSeat' => $selectedSeat
            ]) ?>
        </div>
    </div>

</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="/js/geocoding.js"></script>
<script src="/js/address-fields.js"></script>
<script src="/js/formation-handdler.js"></script>
<script>
    //The name of the school, needed in the formation-handdler.js
    const schoolName = "<?= $schoolName ?>";
    
    document.addEventListener('DOMContentLoaded', () => {
        // Création des nombres de places possibles
        const cars = <?= json_encode($cars ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
        // Gets the fields
        const carSelect = document.getElementById("drive-car");
        const seatSelect = document.getElementById("drive-seats");
        // Gets the values
        const selectedSeat = <?= json_encode($selectedSeat) ?>;
        const selectedCar = <?= json_encode($selectedCar) ?>;
        if (carSelect && seatSelect && Array.isArray(cars) && cars.length > 0) {
            // Initiate seat population on car selection change
            carSelect.addEventListener("change", populateSeats);
            // Initial population on page load
            populateSeats();
        }

        function populateSeats() {
            const selectedCarId = carSelect.value || selectedCar;
            const car = cars.find(c => String(c.id_car) === String(selectedCarId)); // match l'id des voitures dans cars à l'id sélectionné dans le dropdown
            seatSelect.innerHTML = '<option value="">-- Choisissez le nombre de places disponibles --</option>';
            if (!car) return;
            for (let i = 1; i <= car.number_of_seat; i++) {
                const option = document.createElement("option");
                option.value = i;
                option.textContent = i;
                // Repopulate old seat selection
                if (String(i) === String(selectedSeat)) {
                    option.selected = true;
                }
                seatSelect.appendChild(option);
            }
        }
    });
</script>
<?= $this->endSection() ?>