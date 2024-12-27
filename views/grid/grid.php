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
                <?php foreach ($gridArray as $row): ?>
                    <?php foreach ($row as $cell): ?>
                        <div class="grid-item <?php echo trim($cell) === '' ? 'empty' : ''; ?>">
                            <?php echo htmlspecialchars($cell); ?>
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

<?php if (isset($errorMessage)): ?>
    <div style="color: red; text-align: center;"><?php echo htmlspecialchars($errorMessage); ?></div>
<?php endif; ?>