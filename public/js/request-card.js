const requestResultsEl = document.querySelector('#request-results')
const requestPaginationEl = document.querySelector('#request-pagination')
const requestPaginator = requestResultsEl ? new Paginator(requestResultsEl, requestPaginationEl, renderRequest) : null

function renderRequest(request) {
    const url = '/request/show/' + request['id_journey_request']

    const a = document.createElement('a')
    a.href = url
    a.className = 'no-underline'

    const card = document.createElement('div')
    card.className = 'bg-ocean-mid border border-ocean-light rounded-[14px] px-5 py-4 hover-border-gold transition-colors'

    const header = document.createElement('div')
    header.className = 'flex flex-col gap-2 md:flex-row md:items-center md:justify-between mb-3'

    const headerLeft = document.createElement('div')

    const cities = document.createElement('p')
    cities.className = 'text-sm font-medium text-lightgrey'
    cities.textContent = request['start_address'] + ' → ' + request['end_address']

    const timeRange = document.createElement('p')
    timeRange.className = 'text-xs text-grey mt-0.5'
    timeRange.textContent = 'Disponible : ' + request['earliest_departure'] + ' - ' + request['latest_departure']

    headerLeft.appendChild(cities)
    headerLeft.appendChild(timeRange)

    const memberSpan = document.createElement('span')
    memberSpan.className = 'text-xs font-bold bg-gold/10 border border-gold/20 text-gold rounded-full px-3 py-0.5 self-start md:self-auto whitespace-nowrap'
    memberSpan.textContent = (request['member_count'] ?? '0') + ' membre(s)'

    header.appendChild(headerLeft)
    header.appendChild(memberSpan)

    const details = document.createElement('div')
    details.className = 'text-xs text-grey mb-4'

    if (request['description']) {
        const desc = document.createElement('p')
        desc.textContent = request['description']
        details.appendChild(desc)
    }

    const creator = document.createElement('p')
    creator.innerHTML = '<span class="text-gold font-medium">Demandeur :</span> ' +
        request['creator_first_name'] + ' ' +
        (request['creator_last_name'] ?? '').charAt(0) + '.'
    details.appendChild(creator)

    const footer = document.createElement('div')
    footer.className = 'flex justify-end'

    const detailBtn = document.createElement('a')
    detailBtn.href = url
    detailBtn.className = 'bg-gold text-ocean font-semibold text-xs px-5 py-2 rounded-full hover:opacity-90 transition-opacity'
    detailBtn.textContent = 'Voir les détails'

    footer.appendChild(detailBtn)

    card.appendChild(header)
    card.appendChild(details)
    card.appendChild(footer)
    a.appendChild(card)

    return a
}
