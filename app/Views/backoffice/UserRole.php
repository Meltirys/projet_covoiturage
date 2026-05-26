<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<h1>Modifier le rôle d'un utilisateur</h1>
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
    //The select template that contains all the roles
    let userRoleSelect = document.createElement('select')
    userRoleSelect.name = "new_role"

    //Creating the select form of the role. We will clone him for each instance of user created.
    document.addEventListener('DOMContentLoaded', () => {
        fetch('/getAllPermissions/')
            .then((r) => {
                if (r.ok) {
                    return r.json()
                }
            })
            .then(datas => {
                //Creating the select
                if (datas) {
                    datas.forEach((elem) => {
                        userRoleSelect.add(new Option(elem['label'], elem['level']))
                    })

                    let searchInput = document.querySelector("#searchUser")

                    //Creating the listener on text input
                    searchInput.addEventListener("input", () => {
                        //Only fetches when there are more than two characters entered
                        if (searchInput.value.length > 2) {
                            fetch('/searchUserWP/' + searchInput.value)
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
                }

            })
            .catch(e => console.log(e))


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
                let select = userRoleSelect.cloneNode(true)

                let suppressionButton = document.createElement('button')

                //Filling up the content
                userName.textContent = element['name']
                userMail.textContent = element['email']
                select.value = element['level']
                suppressionButton.textContent = "Modifier le rôle"

                //Setting up the form
                suppressionForm.appendChild(select)
                suppressionForm.appendChild(csrfToken)
                suppressionForm.appendChild(suppressionButton)
                suppressionForm.method = "POST"
                suppressionForm.action = "user/updateRole/" + element['id_user']
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

                researchResult.appendChild(userDiv)


            });
        }
    })
</script>

<?= $this->endSection() ?>