let userRoleSelect = document.createElement('select')
userRoleSelect.name = "new_role"
userRoleSelect.className = "rounded-xl bg-ocean-light border border-ocean-light px-3 py-1.5 text-sm text-lightgrey focus:outline-none focus:border-gold/40 transition-colors"

userRolePaginator = new Paginator(
    document.querySelector('#researchResultsRole'),
    document.querySelector('#paginationRole'),
    renderRoleResults
)

document.addEventListener('DOMContentLoaded', () => {
    fetch('/getAllPermissions/')
        .then((r) => {
            if (r.ok) return r.json()
        })
        .then(datas => {
            if (datas) {
                datas.forEach((elem) => {
                    userRoleSelect.add(new Option(elem['label'], elem['level']))
                })

                let searchInputRole = document.querySelector("#searchUserRole")
                searchInputRole.addEventListener("input", () => {
                    if (searchInputRole.value.length > 2) {
                        fetch('/searchUserWP/' + encodeURIComponent(searchInputRole.value))
                            .then((r) => {
                                if (r.ok) return r.json()
                            })
                            .then(datas => {
                                userRolePaginator.load(datas)
                            })
                            .catch(e => console.log(e))
                    }
                })
            }
        })
        .catch(e => console.log(e))
})

function renderRoleResults(element) {
    let userDiv         = document.createElement('div')
    let userInfos       = document.createElement('div')
    let userName        = document.createElement('p')
    let userMail        = document.createElement('p')
    let suppressionForm = document.createElement('form')
    let csrfToken       = document.createElement('input')
    let select          = userRoleSelect.cloneNode(true)
    let suppressionButton = document.createElement('button')

    userName.textContent          = element['name']
    userMail.textContent          = element['email']
    select.value                  = element['level']
    suppressionButton.textContent = 'Modifier le rôle'

    suppressionForm.appendChild(select)
    suppressionForm.appendChild(csrfToken)
    suppressionForm.appendChild(suppressionButton)
    suppressionForm.method = 'POST'
    suppressionForm.action = 'user/updateRole/' + element['id_user']
    suppressionButton.type = 'submit'

    csrfToken.type  = 'hidden'
    csrfToken.name  = document.querySelector('meta[name="csrf-name"]').content
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').content

    userDiv.className           = 'flex items-center justify-between bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 hover-border-gold transition-colors gap-3'
    userInfos.className         = 'flex flex-col'
    userName.className          = 'text-sm font-medium text-lightgrey'
    userMail.className          = 'text-xs text-grey mt-0.5'
    suppressionButton.className = 'text-xs border border-gold/40 text-gold rounded-full px-3 py-1 hover:bg-gold/10 transition-colors cursor-pointer whitespace-nowrap'

    userInfos.appendChild(userName)
    userInfos.appendChild(userMail)
    userDiv.appendChild(userInfos)
    userDiv.appendChild(suppressionForm)
    return userDiv
}