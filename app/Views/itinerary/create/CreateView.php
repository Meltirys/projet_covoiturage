<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

    <header class="flex justify-between items-center mb-6">
        <h2 class="text-[10px] font-poppins tracking-[0.15em] text-[#253F72] uppercase">Proposer un trajet</h2>
    </header>

    <div class="bg-white border border-[rgba(37,63,114,0.25)] rounded-xl p-5">
        <?= view('itinerary/create/drive_form') ?>
    </div>

</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="/js/geocoding.js"></script>
<script src="/js/journey-create.js"></script>
<script>
    // Attribue les options de places
    const cars = <?= json_encode($cars) ?>;

    const carSelect = document.getElementById("car");
    const seatSelect = document.getElementById("seats");

    carSelect.addEventListener("change", () => {
        const car = cars.find(c => c.id_car == carSelect.value); // match l'id des voitures dans cars à l'id sélectionné dans le dropdown

        seatSelect.innerHTML = '<option value="">-- Choisissez le nombre de places disponibles --</option>';
        if (!car) return;

        for (let i = 1; i <= car.seats; i++) {
            const opt = document.createElement("option");
            opt.value = i;
            opt.textContent = `${i}`;
            seatSelect.appendChild(opt);
        }
    });
</script>
<?= $this->endSection() ?>