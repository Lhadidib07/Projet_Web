<?php
?>
<style>
    /* Conteneur principal */
    .login-container {
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

    /* Bouton de connexion */
    .login-btn {
        width: 100%;
        background-color: #5cb85c;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .login-btn:hover {
        background-color: #4cae4c;
    }

    /* Lien d'inscription */
    .signup-link {
        margin-top: 15px;
        font-size: 14px;
    }

    .signup-link a {
        color: #5cb85c;
        text-decoration: none;
    }

    .signup-link a:hover {
        text-decoration: underline;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
        .login-container {
            padding: 15px;
        }

        h1 {
            font-size: 20px;
        }

        .login-btn {
            font-size: 14px;
            padding: 8px;
        }
    }
</style>

<div class="login-container">
    <h1>Connexion</h1>
    <form action="#" method="post">
        <div class="form-group">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="email" placeholder="Entrez votre nom d'utilisateur" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
        </div>
        <button type="submit" class="login-btn">Se connecter</button>
        <p class="signup-link">
            Pas encore inscrit ? <a href="register">Créer un compte</a>
        </p>
    </form>
</div>
