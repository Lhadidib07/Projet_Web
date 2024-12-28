<?php
if (isset($grid)) {
    // Extraire et décoder les données JSON de `grid_data`
    $gridData = json_decode($grid['grid_data'], true); // Décodage en tableau associatif

    // Vérifier si les données sont valides
    if ($gridData && isset($gridData['grid']) && isset($gridData['Enigmes'])) {
        // Extraire les informations nécessaires
        $gridArray = $gridData['grid'];
        $rowsSize = $grid['rows_size'];
        $colsSize = $grid['cols_size'];
        $enigmes = $gridData['Enigmes'];

        // Extraire les indices horizontaux et verticaux
        $horizontalClues = [];
        $verticalClues = [];

        if (isset($enigmes['Ligne'])) {
            foreach ($enigmes['Ligne'] as $ligne) {
                foreach ($ligne as $key => $clue) {
                    $horizontalClues[] = ["key" => $key, "clue" => $clue];
                }
            }
        }

        if (isset($enigmes['Colonnes'])) {
            foreach ($enigmes['Colonnes'] as $colonne) {
                foreach ($colonne as $key => $clue) {
                    $verticalClues[] = ["key" => $key, "clue" => $clue];
                }
            }
        }
    } else {
        // Gérer le cas où les données ne sont pas valides
        $gridArray = [];
        $rowsSize = 0;
        $colsSize = 0;
        $horizontalClues = [];
        $verticalClues = [];
        $errorMessage = "Les données de la grille ne sont pas valides.";
    }
} else {
    // Gérer le cas où la variable $grid n'est pas définie
    $gridArray = [];
    $rowsSize = 0;
    $colsSize = 0;
    $horizontalClues = [];
    $verticalClues = [];
    $errorMessage = "La grille n'est pas définie.";
}
?>

    <style>
        /* Style dynamique pour la grille */
        .grid-container {
            display: grid;
            justify-content: center;
            align-content: center;
            grid-template-columns: repeat(<?php echo htmlspecialchars($colsSize); ?>, 40px);
            grid-template-rows: repeat(<?php echo htmlspecialchars($rowsSize); ?>, 40px);
            gap: 1px;
            background: #fff; /* Background color for better visibility */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px; /* Rounded corners */
        }
        .grid-item {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border: 1px solid #ddd;
            background-color: #fff;
        }
        .grid-item.empty {
            background-color: black;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(4, 40px); /* Adjust based on your column size */
            grid-template-rows: repeat(4, 40px); /* Adjust based on your row size */
            gap: 1px;
        }

        .grid-item {
            width: 40px; /* Match the width of input fields */
            height: 40px; /* Match the height of input fields */
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            background-color: #fff; /* Background color for normal cells */
        }

        .grid-item.empty {
            background-color: black; /* Color for empty cells */
        }

        .grid-input {
            width: 100%; /* Make input fill the entire div */
            height: 100%; /* Make input fill the entire div */
            border: none; /* Remove default border */
            background: transparent; /* Make background transparent */
            text-align: center; /* Center text */
            font-weight: bold; /* Optional: Make text bold */
            color: black; /* Text color */
            font-size: 18px; /* Font size */
        }

        .grid-input:focus {
            outline: none; /* Remove focus outline */
        }


    </style>

    <div class="container">
        <div class="vertical-clue-container">
            <h2>Indices Verticaux</h2>
            <?php if (!empty($verticalClues)): ?>
                <?php foreach ($verticalClues as $clue): ?>
                    <div class="vertical-clue">
                        <strong><?php echo htmlspecialchars($clue['key']); ?></strong>: <?php echo htmlspecialchars($clue['clue']); ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="vertical-clue" style="color: red;">Aucun indice vertical disponible.</div>
            <?php endif; ?>
        </div>


        <div class="grid-container">
            <?php if (!empty($gridArray)): ?>
                <?php foreach ($gridArray as $rowIndex => $row): ?>
                    <?php foreach ($row as $colIndex => $cell): ?>
                        <div class="grid-item <?php echo trim($cell) === '' ? 'empty' : ''; ?>">
                            <?php if (trim($cell) === ''): ?>
                                <!-- Display a black cell for empty cells -->
                            <?php else: ?>
                                <input
                                        type="text"
                                        name="cell_<?php echo $rowIndex; ?>_<?php echo $colIndex; ?>"
                                        value=""
                                        required
                                        maxlength="1"
                                        class="grid-input" >

                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="grid-item" style="grid-column: span <?php echo htmlspecialchars($colsSize); ?>; text-align: center; color: red;">
                    No grid data available.
                </div>
            <?php endif; ?>
        </div>

        <div class="horizontal-clue-container">
            <h2>Indices Horizontaux</h2>
            <?php if (!empty($horizontalClues)): ?>
                <?php foreach ($horizontalClues as $clue): ?>
                    <div class="horizontal-clue">
                        <strong><?php echo htmlspecialchars($clue['key']); ?></strong>: <?php echo htmlspecialchars($clue['clue']); ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="horizontal-clue" style="color: red;">Aucun indice horizontal disponible.</div>
            <?php endif; ?>
        </div>
        <div>
            <button onclick="checkGrid()">Check Grid</button>
        </div>
    </div>

<?php if (isset($errorMessage)): ?>
    <div style="color: red; text-align: center;"><?php echo htmlspecialchars($errorMessage); ?></div>
<?php endif; ?>

<script>

    function checkGrid() {
        const gridItems = document.querySelectorAll('.grid-item');
        let isGridValid = true;
        let errorMessages = [];

        // Récupérer les données de la grille initiale
        const gridData = <?php echo json_encode($gridArray); ?>;

        // Parcourir chaque cellule de la grille
        gridItems.forEach((gridItem, index) => {
        const input = gridItem.querySelector('input');
        if (input) {
            // Calculer l'indice de la ligne et de la colonne à partir de l'index
            const rowIndex = Math.floor(index / gridData[0].length);
            const colIndex = index % gridData[0].length;

            // Comparer la valeur de l'input avec la valeur attendue
            const expectedValue = gridData[rowIndex][colIndex].trim(); // Valeur attendue
            const actualValue = input.value.trim(); // Valeur saisie

            if (actualValue === '') {
            gridItem.classList.add('empty'); // Ajout de la classe empty si vide
            errorMessages.push(`Cellule vide à la ligne ${rowIndex + 1}, colonne ${colIndex + 1}.`);
            isGridValid = false;
        } else if (actualValue.toLowerCase() !== expectedValue.toLowerCase()) {
            errorMessages.push(`Erreur à la ligne ${rowIndex + 1}, colonne ${colIndex + 1}: attendu "${expectedValue}", trouvé "${actualValue}".`);
            isGridValid = false;
        } else {
            gridItem.classList.remove('empty'); // Supprime la classe empty si c'est correct
        }
        }
        });

        // Afficher le résultat
            if (isGridValid) {
            alert('Félicitations! La grille est correcte!');
        } else {
            alert('Erreur dans la grille:\n' + errorMessages.join('\n'));
        }
    }



</script>
