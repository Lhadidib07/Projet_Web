<?php
if (isset($grid)) {
    // Extraire et décoder les données JSON de `grid_data`
    $gridData = json_decode($grid['grid_data'], true); // Décodage en tableau associatif

    // Vérifier si les données sont valides
    if ($gridData && isset($gridData['grid']) && isset($gridData['Enigmes'])) {
        // Extraire les informations nécessaires
        $gridArray = $gridData['grid'];
        $rowsSize = count($gridArray); // Taille des lignes
        $colsSize = $rowsSize > 0 ? count($gridArray[0]) : 0; // Taille des colonnes
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
        gap: 2px;
        background: #f0f0f0; /* Background color for better visibility */
        padding: 20px;
        border: 2px solid #ccc;
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    }
</style>
<link rel="stylesheet" href="/css/playGrid.css">
<?php if (isset($errorMessage)): ?>
    <div style="color: red; text-align: center;"><?php echo htmlspecialchars($errorMessage); ?></div>
<?php else: ?>

<div>
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
                    <?php foreach ($row as $colIndex => $cellValue): ?>
                        <div class="grid-item <?php echo trim($cellValue) === '' ? 'empty' : ''; ?>">
                            <?php if (trim($cellValue) !== ''): ?>
                                <input
                                    type="text"
                                    name="cell_<?php echo $rowIndex; ?>_<?php echo $colIndex; ?>"
                                    id="cell-<?php echo $rowIndex; ?>-<?php echo $colIndex; ?>"
                                    value=""
                                    required
                                    maxlength="1"
                                    class="grid-input"
                                    onkeydown="handleKeyDown(event)"
                                >
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
    </div>

    <div class="button-container">
        <button onclick="checkGrid()">Check Grid</button>
        <button onclick="resetGrid()">Reset Grid</button>
    </div>
</div>

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
           // gridItem.classList.add('empty'); // Ajout de la classe empty si vide
            //errorMessages.push(`Cellule vide à la ligne ${rowIndex + 1}, colonne ${colIndex + 1}.`);
            isGridValid = false;
        } else if (actualValue.toLowerCase() !== expectedValue.toLowerCase()) {
            //errorMessages.push(`Erreur à la ligne ${rowIndex + 1}, colonne ${colIndex + 1}: attendu "${expectedValue}", trouvé "${actualValue}".`);
            isGridValid = false;
        } else {
            //gridItem.classList.remove('empty'); // Supprime la classe empty si c'est correct
        }
        }
        });

        // Afficher le résultat
            if (isGridValid) {
            showNotification('Félicitations! La grille est correcte!');
        } else {
            showNotification('la grille n est pas valide ');
        }
    }

    
    const rowsSize = <?php echo $rowsSize; ?>;
    const colsSize = <?php echo $colsSize; ?>;

    function handleKeyDown(event) {
        const id = event.target.id;
        const [_, row, col] = id.split('-').map(Number);
        console.log(row, col, event.key);
    
        function focusCell(newRow, newCol) {
            document.getElementById(`cell-${newRow}-${newCol}`).focus();
        }
    
        switch (event.key) {
            case 'ArrowUp':
                if (row > 0) {
                    focusCell(row - 1, col);
                }
                break;
            case 'ArrowDown':
                if (row < rowsSize - 1) {
                    focusCell(row + 1, col);
                }
                break;
            case 'ArrowLeft':
                if (col > 0) {
                    focusCell(row, col - 1);
                }
                break;
            case 'ArrowRight':
                if (col < colsSize - 1) {
                    focusCell(row, col + 1);
                }
                break;
        }
    }



</script>
