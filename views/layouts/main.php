<?php
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mots Croisée</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body >
<header class="navbar">
    <div class="logo">los Gridos</div>
    <nav class="nav-links" id="navLinks">
        <ul>
            <li><a href="/">Home</a></li>
            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'admin'): ?>
                <li><a href="/users">Utilisateurs</a></li>
            <?php endif; ?>
            <li><a href="/grids">Grilles</a></li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a ONCLICK=logout()>Logout</a></li>
            <?php else : ?>
                <li><a href="/login">Login</a></li>
                <li><a href="/register">Register</a></li>
            <?php endif; ?>

        </ul>
    </nav>
    <div class="burger" onclick="toggleMenu()">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>

    </div>
</header>

<main style="justify-content: center; align-items: center; display: flex;  min-height: 94vh">
    <?php if (isset($notification)): ?>
        <div  <?= $notification['type']; ?>">

            <?php echo $notification['message'];   htmlspecialchars($notification['message']); ?>
            <?php $notification['message']; ?>
        </div>
    <?php endif; ?>
    <div id="notification" class="notification hidden ">
        <p id="notification-message">You have a new reply!</p>
    </div>
   {{content}}
</main>


<script>
    function toggleMenu() {
        const navLinks = document.getElementById('navLinks');
        navLinks.classList.toggle('active');
    }

    function logout() {
        fetch('/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                csrf_token: <?= json_encode($_SESSION['csrf_token'] ?? '') ?>
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
                showNotification(data.message);
                // Redirect to the login page or home page
                setTimeout(() => {
                    window.location.href = '/login';
                }, 1500);
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred. Please try again later.');
            });
    }

    function showNotification(message) {
        const notification = document.getElementById('notification');
        const messageElement = document.getElementById('notification-message');

        // Mettre à jour le message
        messageElement.textContent = message;

        // Afficher la notification
        notification.classList.remove('hidden');
        notification.classList.add('visible');

        // Masquer automatiquement après 5 secondes (optionnel)
        setTimeout(() => {
            hideNotification();
        }, 5000);
    }

    function hideNotification() {
        const notification = document.getElementById('notification');
        notification.classList.remove('visible');
        notification.classList.add('hidden');
    }
</script>
</body>
</html>
