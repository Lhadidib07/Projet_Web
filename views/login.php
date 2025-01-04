
<link rel="stylesheet" href="/css/login.css">

<div class="login-container">
    <h1>Connexion</h1>
    <form action="#" method="post">
        <div class="form-group">
            <label for="username">Email</label>
            <input type="email" id="username" name="email" placeholder="Entrez votre email" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe"  minlength="8" required>
        </div>
        <button type="submit" class="login-btn">Se connecter</button>
        <p class="signup-link">
            Pas encore inscrit ? <a href="register">Créer un compte</a>
        </p>
    </form>
</div>
