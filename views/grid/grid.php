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
        gap: 2px;
        background: #f0f0f0; /* Background color for better visibility */
        padding: 20px;
        border: 2px solid #ccc;
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
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
        transition: background-color 0.3s; /* Smooth transition for background color */
    }

    .grid-item.empty {
        background-color: #000; /* Color for empty cells */
    }

    .grid-input {
        width: 100%; /* Make input fill the entire div */
        height: 100%; /* Make input fill the entire div */
        border: none; /* Remove default border */
        background: transparent; /* Make background transparent */
        text-align: center; /* Center text */
        font-weight: bold; /* Optional: Make text bold */
        color: #333; /* Text color */
        font-size: 18px; /* Font size */
        transition: background-color 0.3s, color 0.3s; /* Smooth transition for background and text color */
    }

    .grid-input:focus {
        outline: none; /* Remove focus outline */
        background-color: #e0e0e0; /* Highlight background color on focus */
        color: #000; /* Text color on focus */
    }
    
        .vertical-clue-container, .horizontal-clue-container {
        margin: 20px;
        padding: 10px;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        box-sizing: border-box; /* Include padding and border in element's total width and height */
        flex: 1 1 calc(33.333% - 40px); /* Flex item with 1/3 width minus margin */
    }

    .vertical-clue, .horizontal-clue {
        margin: 5px 0;
        font-size: 16px;
        color: #555;
    }

    .vertical-clue strong, .horizontal-clue strong {
        color: #333;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: flex-start;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    }
  
    .button-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    button {
        padding: 10px 20px;
        font-size: 16px;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s; /* Smooth transition for background color */
        margin-left: 15px;
    }

    button:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }

    @media (max-width: 768px) {
        .vertical-clue-container, .horizontal-clue-container {
            flex: 1 1 100%; /* Full width on small screens */
        }
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