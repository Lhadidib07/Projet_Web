<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Layout</title>
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


    </style>
</head>
<body >
<header class="navbar">
    <div class="logo">MyLogo</div>
    <nav class="nav-links" id="navLinks">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/about">About</a></li>
            <li><a href="/contact">Contact</a></li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="/logout">Logout</a></li>
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
   {{content}}
</main>

<script>
    function toggleMenu() {
        const navLinks = document.getElementById('navLinks');
        navLinks.classList.toggle('active');
    }
</script>
</body>
</html>
