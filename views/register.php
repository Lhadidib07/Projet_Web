<?php
?>
<style>
    .register-container {
        max-width: 400px;
        width: 100%;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    h1 {
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
    }

    /* Champs de formulaire */
    .form-group {
        margin-bottom: 15px;
        text-align: left;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: #555;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }

    /* Bouton d'inscription */
    .register-btn {
        width: 100%;
        background-color: #007bff;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .register-btn:hover {
        background-color: #0056b3;
    }

    /* Lien de connexion */
    .login-link {
        margin-top: 15px;
        font-size: 14px;
    }

    .login-link a {
        color: #007bff;
        text-decoration: none;
    }

    .login-link a:hover {
        text-decoration: underline;
    }

    .is-invalid {
        border-color: red;
    }
    /* Responsiveness */
    @media (max-width: 768px) {
        .register-container {
            padding: 15px;
        }

        h1 {
            font-size: 20px;
        }

        .register-btn {
            font-size: 14px;
            padding: 8px;
        }

        .is-invalid {
            border-color: red;
        }
    }
</style>

<div class="register-container">
        <h1>Créer un compte</h1>

        <form action="#" method="post">

            <div class="form-group">
                <label for="name">Nom complet</label>
                <input type="text" id="name" name="name" placeholder="Entrez votre nom complet" value="<?= $model->name ?>" style="<?= $model->hasError('name') ? 'border-color: red;' : '' ?>">
                <div style="color: red; margin-left: 15px">
                    <?= $model->getFirstError('name') ? $model->getFirstError('name') : '' ?>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input class="is-invalid" type="email" id="email" name="email" placeholder="Entrez votre email" >
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Créez un mot de passe" >
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirmez le mot de passe</label>
                <input type="password" id="$confirmPassword" name="confirmPassword" placeholder="Confirmez votre mot de passe" >
            </div>
            <button type="submit" class="register-btn">S'inscrire</button>
            <p class="login-link">
                Vous avez déjà un compte ? <a href="login">Connectez-vous</a>
            </p>
        </form>
    </div>