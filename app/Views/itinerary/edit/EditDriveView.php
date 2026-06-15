<?php
$status = session()->getFlashdata('status');
$errors = session()->getFlashdata('errors') ?? [];
$error  = session()->getFlashdata('error');
$selectedCar = old('drive.car', $journey['id_car']);
$selectedSeat = old('drive.seats', $journey['number_of_place']);
?>

<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

    <header class="flex justify-between items-center mb-6">
        <h2 class="text-[10px] font-poppins tracking-[0.15em] text-bluegrey uppercase">Modifier un trajet</h2>
    </header>

    <?php if (!empty($status)): ?>
        <p class="text-xs text-green-500 mb-3"><?= esc($status) ?></p>
    <?php endif ?>

    <?php if (!empty($error)): ?>
        <p class="text-xs text-red-500 mb-3"><?= esc($error) ?></p>
    <?php endif ?>

    <div class="bg-white border border-[rgba(37,63,114,0.25)] rounded-xl p-5">
        <?= view('itinerary/edit/edit_drive_form', [
            'errors' => $errors,
            'journey' => $journey,
            'cars' => $cars,
            'selectedCar' => $selectedCar,
            'selectedSeat' => $selectedSeat
        ]) ?>
    </div>
</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="/js/geocoding.js"></script>
<script src="/js/address-fields.js"></script>
<script>
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