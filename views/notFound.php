<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        /* Styles globaux */

        /* Conteneur principal */
        .not-found-container {
            justify-content: center;
            align-items: center;
            width: 60%;
            padding: 20px;
            background: #dae3da;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 120px;
            color: #ff6b6b;
            margin: 0;
        }

        p {
            font-size: 18px;
            margin: 20px 0;
        }

        /* Bouton Retour */
        .back-home {
            text-decoration: none;
            background-color: #5cb85c;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .back-home:hover {
            background-color: #4cae4c;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            h1 {
                font-size: 80px;
            }

            p {
                font-size: 16px;
            }

            .back-home {
                font-size: 14px;
                padding: 8px 15px;
            }
        }

    </style>

        <div class="not-found-container">
            <h1>404</h1>
            <p>Oups! La page que vous cherchez n'existe pas.</p>
            <a href="/" class="back-home">Retour à la page d'accueil</a>
        </div>
