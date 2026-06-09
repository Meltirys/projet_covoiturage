const validationPaginator = new Paginator(
    document.querySelector('#resultsValidation'),
    document.querySelector('#paginationValidation'),
    renderValidationUser
)

function renderValidationUser(user) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content
    const csrfName  = document.querySelector('meta[name="csrf-name"]').content

    const div = document.createElement('div')
    div.className = 'flex justify-between items-center bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 hover-border-gold transition-colors gap-3'

    // Infos utilisateur
    const infosDiv = document.createElement('div')
    const name  = document.createElement('p')
    const email = document.createElement('p')
    name.className  = 'text-sm font-medium text-lightgrey'
    email.className = 'text-xs text-grey mt-0.5'
    name.textContent  = user['first_name'] + ' ' + user['last_name']
    email.textContent = user['email']
    infosDiv.appendChild(name)
    infosDiv.appendChild(email)

    // Boutons
    const buttonsDiv = document.createElement('div')
    buttonsDiv.className = 'flex gap-2 flex-shrink-0'

    // Formulaire accepter
    const acceptForm   = document.createElement('form')
    acceptForm.method  = 'POST'
    acceptForm.action  = '/userValidation/accept/' + user['id_user']
    const acceptCsrf   = document.createElement('input')
    acceptCsrf.type    = 'hidden'
    acceptCsrf.name    = csrfName
    acceptCsrf.value   = csrfToken
    const acceptButton = document.createElement('button')
    acceptButton.type      = 'submit'
    acceptButton.className = 'text-xs border border-green/50 text-green rounded-full px-3 py-1 hover:bg-green/20 transition-colors cursor-pointer'
    acceptButton.textContent = 'Accepter'
    acceptForm.appendChild(acceptCsrf)
    acceptForm.appendChild(acceptButton)

    // Formulaire refuser
    const refuseForm   = document.createElement('form')
    refuseForm.method  = 'POST'
    refuseForm.action  = '/userValidation/refuse/' + user['id_user']
    const refuseCsrf   = document.createElement('input')
    refuseCsrf.type    = 'hidden'
    refuseCsrf.name    = csrfName
    refuseCsrf.value   = csrfToken
    const refuseButton = document.createElement('button')
    refuseButton.type      = 'submit'
    refuseButton.className = 'text-xs border border-red/40 text-red rounded-full px-3 py-1 hover:bg-red/20 transition-colors cursor-pointer'
    refuseButton.textContent = 'Refuser'
    refuseForm.appendChild(refuseCsrf)
    refuseForm.appendChild(refuseButton)

    // Assemblage
    buttonsDiv.appendChild(acceptForm)
    buttonsDiv.appendChild(refuseForm)
    div.appendChild(infosDiv)
    div.appendChild(buttonsDiv)
    return div
}