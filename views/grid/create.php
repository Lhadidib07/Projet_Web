<style>

    .form-container {
        max-width: 600px;
        margin: 0 auto;
        background: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .form-group {
        margin-bottom: 15px;
    }
    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
    input, textarea, button {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    textarea {
        resize: vertical;
        height: 120px;
    }
    button {
        background-color: #007BFF;
        color: white;
        border: none;
        cursor: pointer;
    }
    button:hover {
        background-color: #0056b3;
    }
    .error {
        color: red;
        font-size: 13px;
        margin-top: 5px;
    }
</style>
<div class="form-container">
    <h2>Créer une Nouvelle Grille</h2>
    <form action="create_grid.php" method="POST">
        <!-- Titre de la grille -->
        <div class="form-group">
            <label for="title">Titre de la Grille <span class="error">*</span></label>
            <input type="text" id="title" name="title" placeholder="Ex: Grille Avancée" required>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description <span class="error">*</span></label>
            <textarea id="description" name="description" placeholder="Décrivez votre grille" required></textarea>
        </div>

        <!-- Nombre de lignes -->
        <div class="form-group">
            <label for="row_size">Nombre de Lignes <span class="error">*</span></label>
            <input type="number" id="row_size" name="row_size" placeholder="Ex: 10" required min="1">
        </div>

        <!-- Nombre de colonnes -->
        <div class="form-group">
            <label for="col_size">Nombre de Colonnes <span class="error">*</span></label>
            <input type="number" id="col_size" name="col_size" placeholder="Ex: 10" required min="1">
        </div>

        <!-- Données JSON -->
        <div class="form-group">
            <label for="grid_data">Données JSON de la Grille <span class="error">*</span></label>
            <textarea id="grid_data" name="grid_data" placeholder='{"grid": [...], "words": [...]}' required></textarea>
        </div>

        <!-- Bouton d'envoi -->
        <div class="form-group">
            <button type="submit">Créer la Grille</button>
        </div>
    </form>
</div>