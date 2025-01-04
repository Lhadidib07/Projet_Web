<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <style>
        /* Style général pour le tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-family: Arial, sans-serif;
        }

        /* Style pour les en-têtes de tableau */
        th {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            text-align: left;
        }

        /* Style pour les cellules de tableau */
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        tr > th {
            text-align: center;
        }

        /* Style pour les lignes du tableau au survol */
        tr:hover {
            background-color: #f5f5f5;
        }

        /* Style pour le bouton "Ajouter un utilisateur" */
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
            cursor: pointer;
            border: none;
        }

        .btn:hover {
            background-color: #45a049;
        }

        /* Style pour le bouton "Supprimer" */
        button[type="submit"] {
            background-color: #f44336;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #d32f2f;
        }

        /* Style pour les notifications */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            border-radius: 5px;
            color: white;
            background-color: #4CAF50;
            display: none;
        }

        .notification.error {
            background-color: #f44336;
        }

        /* Animation pour les notifications */
        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }

        .notification.show {
            display: block;
            animation: slideIn 0.5s ease-out;
        }

        /* Style pour le modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .modal-content .close {
            float: right;
            font-size: 24px;
            cursor: pointer;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
        }

        .modal-content label {
            margin-bottom: 5px;
        }

        .modal-content input {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .modal-content button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
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
                    console.log(response);
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
                    showNotification('Une erreur est survenue', 'error');
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
</body>
</html>