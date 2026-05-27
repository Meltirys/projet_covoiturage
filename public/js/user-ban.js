let searchInput = document.querySelector("#searchUser")

//Creating the listener on text input
searchInput.addEventListener("input", () => {
    //Only fetches when there are more than two characters entered
    if (searchInput.value.length > 2) {
        fetch('/searchUser/' + searchInput.value)
            .then((r) => {
                if (r.ok) {
                    return r.json()
                }
            })
            .then(datas => {
                console.log(datas)
                //Displays the results of the fetch
                populateResearchResults(datas)
            })
            .catch(e => console.log(e))
    }
})

function populateResearchResults(datas) {

    let researchResult = document.querySelector("#researchResults")
    researchResult.replaceChildren() //Emptying the current results

    console.log(datas);

    if (datas.length === 0) {
        let p = document.createElement('p') //Creation of the element
        p.textContent = "Aucune utilisateur ne correspond à votre recherche" //Adding the text
        return //Stopping the function
    }

    datas.forEach(element => {
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
        suppressionButton.textContent = "Bannir"

        //Setting up the form
        suppressionForm.appendChild(csrfToken)
        suppressionForm.appendChild(suppressionButton)
        suppressionForm.method = "POST"
        suppressionForm.action = "user/ban/" + element['id_user']
        suppressionButton.type = "submit"
        //CSRF token
        csrfToken.type = "hidden"
        csrfToken.name = document.querySelector('meta[name="csrf-name"]').content
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content

        //Adding the styles
        userDiv.className = "flex items-center justify-between bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm"
        userInfos.className = "flex flex-col"
        userName.className = "text-sm font-semibold text-gray-800"
        userMail.className = "text-xs text-gray-500"
        suppressionButton.className = "btn-danger"

        //Building everything together
        userInfos.appendChild(userName)
        userInfos.appendChild(userMail)
        userDiv.appendChild(userInfos)
        userDiv.appendChild(suppressionForm)

        researchResult.appendChild(userDiv)


    });
}