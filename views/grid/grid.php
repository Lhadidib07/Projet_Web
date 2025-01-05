<?php
if (isset($grid)) {
    $jsonString = trim($grid['grid_data'], '"');
    $jsonString = stripslashes($jsonString);
    $gridData = json_decode($jsonString, true);

    
    // Vérifier si les données sont valides
    if ($gridData && isset($gridData['grid']) && isset($gridData['Enigmes'])) {
        // Extraire les informations nécessaires
        $gridArray = $gridData['grid'];
        $rowsSize = count($gridArray); // Taille des lignes
        $colsSize = count($gridArray[0]); // Taille des colonnes
        $enigmes = $gridData['Enigmes'];

        // Extraire les indices horizontaux et verticaux
        $horizontalClues = [];
        $verticalClues = [];

        // Récupérer les indices horizontaux
        if (isset($enigmes['Ligne']) && is_array($enigmes['Ligne'])) {
            foreach ($enigmes['Ligne'] as $ligne) {
                if (is_array($ligne)) {
                    foreach ($ligne as $key => $clue) {
                        $horizontalClues[] = ["key" => $key, "clue" => $clue];
                    }
                }
            }
        }

        // Récupérer les indices verticaux
        if (isset($enigmes['Colonnes']) && is_array($enigmes['Colonnes'])) {
            foreach ($enigmes['Colonnes'] as $colonne) {
                if (is_array($colonne)) {
                    foreach ($colonne as $key => $clue) {
                        $verticalClues[] = ["key" => $key, "clue" => $clue];
                    }
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
    <link rel="stylesheet" href="/css/grid.css">
    <!-- Affichage des erreurs -->
    <?php if (isset($errorMessage)): ?>
        <div style="color: red; text-align: center;"><?= htmlspecialchars($errorMessage) ?></div>
    <?php else:?>

    <div class="container">
        <!-- Indices Verticaux -->
        <div class="vertical-clue-container">
            <h2>Indices Verticaux</h2>
            <?php if (!empty($verticalClues)): ?>
                <?php foreach ($verticalClues as $clue): ?>
                    <div class="vertical-clue">
                        <strong><?= htmlspecialchars($clue['key']) ?></strong>: <?= htmlspecialchars($clue['clue']) ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="vertical-clue" style="color: red;">Aucun indice vertical disponible.</div>
            <?php endif; ?>
        </div>

        <!-- Grille de Mots Croisés -->
        <div class="grid-container">
            <?php if (!empty($gridArray)): ?>
                <?php foreach ($gridArray as $row): ?>
                    <?php foreach ($row as $cell): ?>
                        <div class="grid-item <?= trim($cell) === '' ? 'empty' : '' ?>">
                            <?= htmlspecialchars($cell) ?>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="grid-item" style="grid-column: span <?= htmlspecialchars($colsSize) ?>; text-align: center; color: red;">
                    No grid data available.
                </div>
            <?php endif; ?>
        </div>

        <!-- Indices Horizontaux -->
        <div class="horizontal-clue-container">
            <h2>Indices Horizontaux</h2>
            <?php if (!empty($horizontalClues)): ?>
                <?php foreach ($horizontalClues as $clue): ?>
                    <div class="horizontal-clue">
                        <strong><?= htmlspecialchars($clue['key']) ?></strong>: <?= htmlspecialchars($clue['clue']) ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="horizontal-clue" style="color: red;">Aucun indice horizontal disponible.</div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

    
