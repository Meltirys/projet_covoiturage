    function showForm(id) {
        document.querySelector('#' + id).style.display = 'flex'
        if (id === "add-car-form") {
            let brand = document.querySelector('#' + id).querySelector('#brand')
            let model = document.querySelector('#' + id).querySelector('#model')
            let year = document.querySelector('#' + id).querySelector('#year')
            let places = document.querySelector('#' + id).querySelector('#places')
            let color = document.querySelector('#' + id).querySelector('#color')
            brand.value = ''
            model.value = ''
            year.value = ''
            places.value = ''
            color.value = ''
            document.querySelector('#modify-car-form').style.display = 'none'
        } else if (id === "modify-car-form") {
            document.querySelector('#add-car-form').style.display = 'none'
        }
    }

    function hideForm(id) {
        document.querySelector('#' + id).style.display = 'none'
    }

    function toggleMode() {
        const driver = document.getElementById('driver');
        const passenger = document.getElementById('passenger');
        const statsDriver = document.getElementById('stats-driver');
        const statsPassenger = document.getElementById('stats-passenger');
        const thumb = document.getElementById('toggle-thumb');
        const isDriver = driver.style.display !== 'none';

        if (isDriver) {
            driver.style.display = 'none';
            passenger.style.display = 'block';
            statsDriver.classList.add('hidden');
            statsPassenger.classList.remove('hidden');
            thumb.style.left = '1.75rem';
            thumb.innerHTML = '<i class="fa-solid fa-person-walking" style="color: var(--color-gold)"></i>';
        } else {
            driver.style.display = 'block';
            passenger.style.display = 'none';
            statsDriver.classList.remove('hidden');
            statsPassenger.classList.add('hidden');
            thumb.style.left = '0.25rem';
            thumb.innerHTML = '<i class="fa-solid fa-car" style="color: var(--color-gold)"></i>';
        }
    }

    function setupModify(idCar) {
        showForm('modify-car-form')
        let form = document.querySelector('#modify-car-form form')
        form.action = BASE_URL + "car/modify/" + idCar
        let brand = form.querySelector('#brand')
        let model = form.querySelector('#model')
        let year = form.querySelector('#year')
        let places = form.querySelector('#places')
        let color = form.querySelector('#color')
        brand.value = document.querySelector('#car' + idCar + ' .car-brand').textContent
        model.value = document.querySelector('#car' + idCar + ' .car-model').textContent
        year.value = document.querySelector('#car' + idCar + ' .car-year').textContent
        places.value = document.querySelector('#car' + idCar + ' .car-places').textContent
        color.value = document.querySelector('#car' + idCar + ' .car-color').textContent
    }

    document.getElementById('passenger').style.display = 'none';
    document.getElementById('stats-passenger').classList.add('hidden');