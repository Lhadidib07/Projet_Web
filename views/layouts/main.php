<?php
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mots Croisée</title>
    <style>

        /* Reset and Basic Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: #fff;
            padding: 0.5rem 1rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-links ul {
            list-style: none;
            display: flex;
            gap: 1rem;
        }

        .nav-links ul li a {
            text-decoration: none;
            color: #fff;
            padding: 0.5rem 1rem;
            transition: background 0.3s ease;
        }

        .nav-links ul li a:hover {
            background-color: #575757;
            border-radius: 5px;
        }

        .burger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
        }

        .burger .line {
            width: 25px;
            height: 3px;
            background-color: #fff;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                position: absolute;
                top: 60px;
                right: 0;
                background-color: #333;
                width: 200px;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }

            .nav-links ul {
                flex-direction: column;
                align-items: flex-start;
                padding: 0;
            }

            .nav-links ul li {
                width: 100%;
            }

            .nav-links ul li a {
                display: block;
                width: 100%;
                padding: 1rem;
            }

            .nav-links.active {
                max-height: 350px; /* Ajuste cette valeur si nécessaire */
            }

            .burger {
                display: flex;
            }

            /* Animation du menu burger */
            .burger.active .line:nth-child(1) {
                transform: rotate(45deg) translate(5px, 5px);
            }

            .burger.active .line:nth-child(2) {
                opacity: 0;
            }

            .burger.active .line:nth-child(3) {
                transform: rotate(-45deg) translate(5px, -5px);
            }
        }

        main {
            padding: 1rem;
            text-align: center;
        }

        section {
            margin: 2rem 0;
            padding: 2rem;
            background-color: #f4f4f4;
            border-radius: 5px;
        }
        .notification {
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: #007BFF;
            color: white;
            padding: 1rem;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .notification.hidden {
            transform: translateY(-20px);
            opacity: 0;
            pointer-events: none;
        }

        .notification.visible {
            transform: translateY(0);
            opacity: 1;
        }

    </style>
</head>
<body >
<header class="navbar">
    <div class="logo">MyLogo</div>
    <nav class="nav-links" id="navLinks">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/grids">grilles</a></li>
            <li><a href="/contact">Contact</a></li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a ONCLICK=logout()>Logout</a></li>
                <li><a href="/profile">Profile</a></li>
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
