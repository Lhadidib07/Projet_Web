<link rel="stylesheet" href="/css/userManagement.css">
    <div style="width:100%">
        <div class="grid-item">
            <button class="btn" onclick="openModal()">Ajouter un utilisateur</button>
        </div>

        <table>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr data-id="<?= $user['id'] ?>">
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td>
                        <form action="/deleteUser" method="post" onsubmit="submitForm(event)">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Modal pour ajouter un utilisateur -->
        <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <form action="/addUser" method="post" onsubmit="addUser(event)">
                    <label for="name">Nom</label>
                    <input type="text" name="name" id="name" placeholder="nom" required>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="email" required>
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" placeholder="mot de passe" required>
                    <label for="confirmPassword">Confirmez le mot de passe</label>
                    <input type="password" id="$confirmPassword" name="confirmPassword" placeholder="Confirmez mot de passe" >
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <button  type="submit">Ajouter</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function submitForm(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const url = form.action;
            const method = form.method;
            const xhr = new XMLHttpRequest();
            xhr.open(method, url);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        showNotification(response.message);
                        deleteFromDom(response.id);
                    } else {
                        showNotification(response.message);
                    }
                } else {
                    showNotification('Une erreur est survenue');
                }
            };
            xhr.send(formData);
        }

        function deleteFromDom(id) {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            if (row) {
                row.remove();
            } else {
                console.error(`Element with data-id="${id}" not found.`);
            }
        }

        function addToDom(user) {
            const table = document.querySelector('table');
            const row = table.insertRow();
            row.dataset.id = user.id;
            row.innerHTML = `
                <td>${user.id}</td>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>
                    <form action="/deleteUser" method="post" onsubmit="submitForm(event)">
                        <input type="hidden" name="id" value="${user.id}">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </td>
            `;
        }
       
        function openModal() {
            const modal = document.getElementById('modal');
            modal.style.display = 'flex';
        }

        function closeModal() {
            const modal = document.getElementById('modal');
            modal.style.display = 'none';
        }

        function addUser(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const url = form.action;
            const method = form.method;
            const xhr = new XMLHttpRequest();
            xhr.open(method, url);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    closeModal();
                    if (response.status === 'success') {
                        showNotification(response.message);
                        addToDom(response.user);
                    } else {
                        showNotification(response.message);
                    }

                } else {
                    closeModal();
                    showNotification('Une erreur est survenue');
                }
            };
            xhr.send(formData);
        }

        // Fermer le modal si on clique en dehors de la boîte de dialogue
        window.onclick = function(event) {
            const modal = document.getElementById('modal');
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>
