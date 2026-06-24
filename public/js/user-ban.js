let searchInputBan = document.querySelector("#searchUserBan")

userBanPaginator = new Paginator(
    document.querySelector('#researchResultsBan'),
    document.querySelector('#paginationBan'),
    renderBanResults
)

searchInputBan.addEventListener("input", () => {
    if (searchInputBan.value.length > 2) {
        fetch(BASE_URL + 'searchUser/' + encodeURIComponent(searchInputBan.value))
            .then((r) => {
                if (r.ok) return r.json()
            })
            .then(datas => {
                userBanPaginator.load(datas)
            })
            .catch(e => console.log(e))
    }
})

function renderBanResults(element) {
    let userDiv         = document.createElement('div')
    let userInfos       = document.createElement('div')
    let userName        = document.createElement('p')
    let userMail        = document.createElement('p')
    let suppressionForm = document.createElement('form')
    let csrfToken       = document.createElement('input')
    let suppressionButton = document.createElement('button')

    userName.textContent          = element['name']
    userMail.textContent          = element['email']
    suppressionButton.textContent = 'Bannir'

    suppressionForm.appendChild(csrfToken)
    suppressionForm.appendChild(suppressionButton)
    suppressionForm.method = 'POST'
    suppressionForm.action = 'user/ban/' + element['id_user']
    suppressionButton.type = 'submit'

    csrfToken.type  = 'hidden'
    csrfToken.name  = document.querySelector('meta[name="csrf-name"]').content
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').content

    userDiv.className           = 'flex items-center justify-between bg-ocean-mid border border-ocean-light rounded-[14px] px-4 py-3 hover-border-gold transition-colors gap-3'
    userInfos.className         = 'flex flex-col'
    userName.className          = 'text-sm font-medium text-lightgrey'
    userMail.className          = 'text-xs text-grey mt-0.5'
    suppressionButton.className = 'text-xs border border-red/40 text-red rounded-full px-3 py-1 hover:bg-red/20 transition-colors cursor-pointer'

    userInfos.appendChild(userName)
    userInfos.appendChild(userMail)
    userDiv.appendChild(userInfos)
    userDiv.appendChild(suppressionForm)
    return userDiv
}