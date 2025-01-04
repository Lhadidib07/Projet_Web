<link rel="stylesheet" href="/css/register.css">

<div class="register-container">
        <h1>Créer un compte</h1>

        <form action="#" method="post" onsubmit="submitFormRegister(event)" >

            <div class="form-group">
                <label for="name">Nom complet</label>
                <input required type="text" id="name" name="name" placeholder="Entrez votre nom complet" value="<?= $model->name ?>" style="<?= $model->hasError('name') ? 'border-color: red;' : '' ?>">
                <div style="color: red; margin-left: 15px">
                    <?= $model->getFirstError('name') ? $model->getFirstError('name') : '' ?>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input required class="is-invalid" type="email" id="email" name="email" placeholder="Entrez votre email" value="<?= $model->email ?>" style="<?= $model->hasError('email') ? 'border-color: red;' : '' ?>">
                <div style="color: red; margin-left: 15px">
                    <?= $model->getFirstError('email') ? $model->getFirstError('email') : '' ?>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Créez un mot de passe"  minlength="8" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirmez le mot de passe</label>
                <input type="password" id="$confirmPassword" name="confirmPassword" placeholder="Confirmez votre mot de passe"  minlength="8" required>
            </div>
            <button type="submit" class="register-btn">S'inscrire</button>
            <p class="login-link">
                Vous avez déjà un compte ? <a href="login">Connectez-vous</a>
            </p>
        </form>
    </div>

    <SCript>
        function submitFormRegister(event){ 
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
                        setTimeout(() => {
                            window.location.href = '/login';
                        }, 1500);
                    } else {
                        showNotification(response.message);
                    }
                } else {
                    showNotification('Une erreur est survenue');
                }
            };
            xhr.send(formData);
        }
    </SCript>