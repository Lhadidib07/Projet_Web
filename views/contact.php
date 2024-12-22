    <style>
        /* Style global */


        .form-container {
            width: 60%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        /* Champs de formulaire */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 20px;
        }

        textarea {
            resize: none;
        }

        /* Bouton d'envoi */
        .submit-btn {
            display: block;
            width: 100%;
            background-color: #5cb85c;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #4cae4c;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .form-container {
                padding: 15px;
            }

            .submit-btn {
                font-size: 14px;
                padding: 8px;
            }
        }

    </style>

<div class="form-container">
    <h1>Contactez-nous</h1>
    <form action="" method="post">
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" id="name" name="name" placeholder="Votre nom" >
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Votre email" >
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" placeholder="Votre message" rows="5" ></textarea>
        </div>
        <button type="submit" class="submit-btn">Envoyer</button>
    </form>
</div>
