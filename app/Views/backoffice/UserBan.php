<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<main class="w-full max-w-5xl mx-auto px-4 py-6 md:px-8 md:py-10 font-poppins">

    <header class="flex justify-between items-center mb-6">
        <h2 class="text-xs tracking-[0.15em] text-bluegrey uppercase">Bannir un utilisateur</h2>
    </header>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="text-xs text-green-600 border border-green-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('success') ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p class="text-xs text-red-500 border border-red-200 rounded px-3 py-2 mb-4"><?= session()->getFlashdata('error') ?></p>
    <?php endif ?>

    <div class="mb-6">
        <label for="searchUser" class="block text-sm text-gray-700 mb-1">Rechercher un utilisateur</label>
        <input type="text" id="searchUser" placeholder="Entrez le nom de l'utilisateur recherché"
            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-babyblue focus:border-transparent">
    </div>

    <div id="researchResults" class="space-y-3"></div>

</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
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
</script>

<?= $this->endSection() ?>