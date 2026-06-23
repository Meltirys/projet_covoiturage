const resultsEl = document.querySelector('#journey-results')
const paginationEl = document.querySelector('#journey-pagination')
const journeyPaginator = resultsEl ? new Paginator(resultsEl, paginationEl, renderJourney) : null


function renderJourney(journey) {
    const seats      = journey['available_seats'] ?? journey['number_of_place']
    const seatsLabel = seats > 1 ? 'places' : 'place'
    const url        = '/drive/show/' + journey['id_journey_drive']

    // Lien principal
    const a      = document.createElement('a')
    a.href       = url

    // Carte
    const card       = document.createElement('div')
    card.className   = 'bg-ocean-mid border border-ocean-light rounded-[14px] px-5 py-4 hover-border-gold transition-colors'

    // Header carte
    const header       = document.createElement('div')
    header.className   = 'flex flex-col gap-2 md:flex-row md:items-center md:justify-between mb-3'

    const headerLeft     = document.createElement('div')

    const cities         = document.createElement('p')
    cities.className     = 'text-sm font-medium text-lightgrey'
    cities.textContent   = journey['departure_city'] + ' → ' + journey['arrival_city']

    const departure      = document.createElement('p')
    departure.className  = 'text-xs text-grey mt-0.5'
    departure.textContent = journey['departure']

    headerLeft.appendChild(cities)
    headerLeft.appendChild(departure)

    const seatsSpan       = document.createElement('span')
    seatsSpan.className   = 'text-xs font-bold bg-gold/10 border border-gold/20 text-gold rounded-full px-3 py-0.5 self-start md:self-auto whitespace-nowrap'
    seatsSpan.textContent = seats + ' ' + seatsLabel

    header.appendChild(headerLeft)
    header.appendChild(seatsSpan)

    // Détails
    const details      = document.createElement('div')
    details.className  = 'grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-grey mb-4'

    const detailsLeft      = document.createElement('div')
    detailsLeft.className  = 'flex flex-col gap-1'

    const departureDetail      = document.createElement('p')
    departureDetail.innerHTML  = '<span class="text-gold font-medium">Départ :</span> ' +
                                  journey['departure_address'] + ', ' +
                                  journey['departure_postcode'] + ' ' +
                                  journey['departure_city']

    const arrivalDetail        = document.createElement('p')
    arrivalDetail.innerHTML    = '<span class="text-gold font-medium">Arrivée :</span> ' +
                                  journey['arrival_address'] + ', ' +
                                  journey['arrival_postcode'] + ' ' +
                                  journey['arrival_city']

    detailsLeft.appendChild(departureDetail)
    detailsLeft.appendChild(arrivalDetail)

    const detailsRight     = document.createElement('div')
    detailsRight.className = 'flex flex-col gap-1'

    const carDetail        = document.createElement('p')
    carDetail.innerHTML    = '<span class="text-gold font-medium">Voiture :</span> ' +
                              journey['car_brand'] + ' ' +
                              journey['car_model']

    const driverDetail     = document.createElement('p')
    driverDetail.innerHTML = '<span class="text-gold font-medium">Conducteur :</span> ' +
                              journey['driver_first_name'] + ' ' +
                              (journey['driver_last_name'] ?? '').charAt(0) + '.'

    detailsRight.appendChild(carDetail)
    detailsRight.appendChild(driverDetail)

    details.appendChild(detailsLeft)
    details.appendChild(detailsRight)

    // Bouton réserver
    const footer       = document.createElement('div')
    footer.className   = 'flex justify-end'

    const reserveBtn       = document.createElement('a')
    reserveBtn.href        = url
    reserveBtn.className   = 'bg-gold text-ocean font-semibold text-xs px-5 py-2 rounded-full hover:opacity-90 transition-opacity'
    reserveBtn.textContent = 'Réserver'

    footer.appendChild(reserveBtn)

    // Assemblage
    card.appendChild(header)
    card.appendChild(details)
    card.appendChild(footer)
    a.appendChild(card)

    return a
}