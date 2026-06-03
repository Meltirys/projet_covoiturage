let searchInputSuppression = document.querySelector("#searchInputSuppression")

userSuppressionPaginator = new Paginator(
    document.querySelector('#researchResultsSuppression'),
    document.querySelector('#paginationSuppression'),
    renderUserSuppression
)

//Creating the listener on text input
searchInputSuppression.addEventListener("input", () => {
    //Only fetches when there are more than two characters entered
    if (searchInputSuppression.value.length > 2) {
        fetch('/searchUser/' + searchInputSuppression.value)
            .then((r) => {
                if (r.ok) {
                    return r.json()
                }
            })
            .then(datas => {
                userSuppressionPaginator.load(datas)
            })
            .catch(e => console.log(e))
    }
})

function renderUserSuppression(element) {

    //Creating the elements
    let userDiv = document.createElement('div')
    let userInfos = document.createElement('div')
    let userName = document.createElement('p')
    let userMail = document.createElement('p')
    let suppressionForm = document.createElement('form')
    let csrfToken = document.createElement('input')
    let suppressionButton = document.createElement('button')

    //Filling up the content
    userName.textContent = element['name']
    userMail.textContent = element['email']
    suppressionButton.textContent = "Supprimer"

    //Setting up the form
    suppressionForm.appendChild(csrfToken)
    suppressionForm.appendChild(suppressionButton)
    suppressionForm.method = "POST"
    suppressionForm.action = "user/delete/" + element['id_user']
    suppressionButton.type = "submit"
    //CSRF token
    csrfToken.type = "hidden"
    csrfToken.name = document.querySelector('meta[name="csrf-name"]').content
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').content

    //Adding the styles
    userDiv.className = "flex items-center justify-between bg-white border border-babyblue rounded-lg px-4 py-3 shadow-sm"
    userInfos.className = "flex flex-col"
    userName.className = "text-sm font-semibold text-bluegrey"
    userMail.className = "text-xs text-grey"
    suppressionButton.className = "btn-danger"

    //Building everything together
    userInfos.appendChild(userName)
    userInfos.appendChild(userMail)
    userDiv.appendChild(userInfos)
    userDiv.appendChild(suppressionForm)

    return userDiv

}