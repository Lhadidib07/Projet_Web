<style>
        .form-container {
            width: 70%;
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

        /* Nouveau style pour aligner les labels et inputs horizontalement */
        .clue-input {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .clue-input label {
            margin-right: 10px; /* Espace entre le label et l'input */
            flex-shrink: 0; /* Empêche le label de rétrécir */
            font-weight: normal; /* Style normal pour les labels d'indices */
            min-width: 100px; /* Largeur minimale des labels pour un alignement propre */
        }

        .clue-input input {
            flex-grow: 1; /* Permet à l'input de s'étendre pour remplir l'espace */
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        table {
            margin: 0 auto; /* Centre la table horizontalement */
            border-collapse: collapse; /* Améliore l'apparence des bordures */
        }

        table td {
            border: 1px solid #ddd; /* Ajoute des bordures aux cellules */
            padding: 5px; /* Espace à l'intérieur des cellules */
            text-align: center; /* Centre le contenu des cellules */
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <div class="form-container">
        <h2>Créer une Nouvelle Grille</h2>
        <form id="createGridForm" onsubmit="addGrile(event)">
            <!-- Étape 1 -->
            <div id="step1" class="form-step">
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

                <!-- Bouton pour passer à l'étape 2 -->
                <div class="form-group">
                    <button type="button" onclick="showStep(2)">Suivant</button>
                </div>
            </div>

            <!-- Étape 2 -->
            <div id="step2" class="form-step" style="display:none;">
                <!-- Grille -->
                <div id="gridContainer"></div>

                <!-- Énigmes des lignes -->
                <div id="rowCluesContainer">
                    <h3>Énigmes des Lignes</h3>
                </div>

                <!-- Énigmes des colonnes -->
                <div id="colCluesContainer">
                    <h3>Énigmes des Colonnes</h3>
                </div>

                <input type="hidden" id="gridData" name="gridData">

                <!-- Bouton pour revenir à l'étape 1 -->
                <div class="form-group">
                    <button type="button" onclick="showStep(1)">Précédent</button>
                </div>

                <!-- Bouton d'envoi -->
                <div class="form-group">
                    <button type="submit">Créer la Grille</button>
                </div>
            </div>
        </form>
    </div>

<script>
    
    function showStep(step) {
        if (step === 2) {
            const rowSize = document.getElementById('row_size').value;
            const colSize = document.getElementById('col_size').value;
            generateGrid(rowSize, colSize);
        }
        document.getElementById('step1').style.display = (step === 1) ? 'block' : 'none';
        document.getElementById('step2').style.display = (step === 2) ? 'block' : 'none';
    }

    function generateGrid(rows, cols) {
        const gridContainer = document.getElementById('gridContainer');
        const rowCluesContainer = document.getElementById('rowCluesContainer');
        const colCluesContainer = document.getElementById('colCluesContainer');
        
        gridContainer.innerHTML = ''; // Clear previous grid
        rowCluesContainer.innerHTML = ''; // Clear previous row clues
        colCluesContainer.innerHTML = ''; // Clear previous column clues

        const table = document.createElement('table');
        for (let i = 0; i < rows; i++) {
            const tr = document.createElement('tr');
            for (let j = 0; j < cols; j++) {
                const td = document.createElement('td');
                const input = document.createElement('input');
                input.type = 'text';
                input.name = `grid[${i}][${j}]`;
                td.appendChild(input);
                tr.appendChild(td);
            }
            table.appendChild(tr);
        }
        gridContainer.appendChild(table);

        // Generate row clues inputs
        for (let i = 0; i < rows; i++) {
            const div = document.createElement('div');
            div.className = 'clue-input';
            const label = document.createElement('label');
            label.textContent = `ligne ${i + 1}: `;
            const input = document.createElement('input');
            input.type = 'text';
            input.name = `row_clues[${i}]`;
            div.appendChild(label);
            div.appendChild(input);
            rowCluesContainer.appendChild(div);
        }

        // Generate column clues inputs
        for (let j = 0; j < cols; j++) {
            const div = document.createElement('div');
            div.className = 'clue-input';
            const label = document.createElement('label');
            label.textContent = `colonne ${j + 1}: `;
            const input = document.createElement('input');
            input.type = 'text';
            input.name = `col_clues[${j}]`;
            div.appendChild(label);
            div.appendChild(input);
            colCluesContainer.appendChild(div);
        }
    }

    function prepareGridData() {
        const rows = document.getElementById('row_size').value;
        const cols = document.getElementById('col_size').value;
        const grid = [];
        const rowClues = [];
        const colClues = [];

        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        for (let i = 0; i < rows; i++) {
            const row = [];
            for (let j = 0; j < cols; j++) {
                const cell = document.querySelector(`input[name="grid[${i}][${j}]"]`).value;
                row.push(escapeHtml(cell));
            }
            grid.push(row);
        }

        for (let i = 0; i < rows; i++) {
            const clue = document.querySelector(`input[name="row_clues[${i}]"]`).value;
            rowClues.push({ [`ligne ${i + 1}`]: escapeHtml(clue) });
        }

        for (let j = 0; j < cols; j++) {
            const clue = document.querySelector(`input[name="col_clues[${j}]"]`).value;
            colClues.push({ [`colonne ${j + 1}`]: escapeHtml(clue) });
        }

        const gridData = {
            grid: grid,
            Enigmes: {
                Ligne: rowClues,
                Colonnes: colClues
            }
        };

        document.getElementById('gridData').value = JSON.stringify(gridData);
    }

    function addGrile(event) {
        event.preventDefault();

        prepareGridData();

        if (!validateFormData()) {
            return;
        }
        fetch('/grid/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                csrf_token: <?= json_encode($_SESSION['csrf_token'] ?? '') ?>,
                title: document.getElementById('title').value,
                description: document.getElementById('description').value,
                row_size: document.getElementById('row_size').value,
                col_size: document.getElementById('col_size').value,
                gridData: JSON.parse(document.getElementById('gridData').value)
            })
        })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text) });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
                showNotification(data.message);
                setTimeout(() => {
                    window.location.href = '/grids';
                }, 1500);
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred. Please try again later iciiii .');
            });
    }

    function validateFormData() {
    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;
    const rowSize = document.getElementById('row_size').value;
    const colSize = document.getElementById('col_size').value;
    const gridData = JSON.parse(document.getElementById('gridData').value);

    if (!title || !description || !rowSize || !colSize) {
        showNotification('Tous les champs obligatoires doivent être remplis.');
        return false;
    }

    if (!Array.isArray(gridData.grid) || gridData.grid.length === 0) {
        showNotification('La grille doit être remplie.');
        return false;
    }

    for (let i = 0; i < gridData.grid.length; i++) {
        if (!Array.isArray(gridData.grid[i]) || gridData.grid[i].length !== parseInt(colSize)) {
            showNotification(`La ligne ${i + 1} de la grille est invalide.`);
            return false;
        }
    }

    if (!Array.isArray(gridData.Enigmes.Ligne) || gridData.Enigmes.Ligne.length !== parseInt(rowSize)) {
        showNotification('Les indices des lignes sont invalides.');
        return false;
    }

    if (!Array.isArray(gridData.Enigmes.Colonnes) || gridData.Enigmes.Colonnes.length !== parseInt(colSize)) {
        showNotification('Les indices des colonnes sont invalides.');
        return false;
    }
    //console.log(gridData);
    return true;
}
    
</script>