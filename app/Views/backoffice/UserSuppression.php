<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1>Supprimer un utilisateur</h1>
<?php if (session()->getFlashdata('success')): ?>
    <p class="text-xs text-green-600 mb-3"><?= session()->getFlashdata('success') ?></p>
<?php endif ?>
<?php if (session()->getFlashdata('error')): ?>
    <p class="text-xs text-red-500 mb-3"><?= session()->getFlashdata('error') ?></p>
<?php endif ?>
<div>
    <label for="searchUser">Rechercher un utilisateur</label>
    <input type="text" id="searchUser" placeholder="Entrez le nom de l'utilisateur recherché">
</div>

<div id="researchResults">

</div>

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
            suppressionButton.textContent = "Supprimer"

            //Setting up the form
            suppressionForm.appendChild(csrfToken)
            suppressionForm.appendChild(suppressionButton)
            suppressionForm.method = "POST"
            suppressionForm.action = "user/delete/" + element['id_user']
            suppressionButton.type = "sumbit"
            //CSRF token
            csrfToken.type = "hidden"
            csrfToken.name = document.querySelector('meta[name="csrf-name"]').content
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').content

            //Adding the styles


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