<?php
// Check if the grid variable is set
if (isset($grid)) {
    // Decode the grid data from JSON
    $gridData = json_decode($grid['grid_data']);

    // Ensure that the grid_data is decoded properly
    if ($gridData && isset($gridData->grid) && isset($gridData->words)) {
        // Extract the grid array and words
        $gridArray = $gridData->grid;
        $words = $gridData->words;
    } else {
        // Handle error if grid data is not valid
        $gridArray = [];
        $words = [];
        $errorMessage = "Grid data is not valid.";
    }
} else {
    // Handle case where grid is not set
    $gridArray = [];
    $words = [];
    $errorMessage = "Grid is not set.";
}
?>

<style>

    .container {
        display: flex; /* Use Flexbox for the layout */
        flex-wrap: wrap; /* Allow wrapping to new lines */
        justify-content: center; /* Center the items horizontally */
        gap: 20px; /* Add space between items */
        max-width: 100%; /* Limit the width of the container */
        margin: 0 auto;
    }
    .vertical-clue-container,
    .horizontal-clue-container {
        flex: 1 1 300px; /* Allow these containers to grow and shrink with a minimum width */
        max-width: 400px; /* Minimum width to prevent being too narrow */
        background: #fff; /* Background color for better visibility */
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px; /* Rounded corners */
    }
    .grid-container {
        display: grid;
        justify-content: center;
        align-content: center;
        grid-template-columns: repeat(10, 40px);
        grid-template-rows: repeat(10, 40px);
        gap: 1px;
        flex: 2 1 400px; /* Allow the grid to take more space */
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
    .vertical-clue,
    .horizontal-clue {
        margin: 5px 0;
    }
    @media (max-width: 70px) {
        .container {
            flex-direction: column; /* Stack the items in a column for smaller screens */
        }
    }

</style>

<div class="container">
    <div class="vertical-clue-container">
        <h2>Indices Verticaux</h2>
        <?php if (!empty($words)): ?>
            <?php $i = 0; ?>
            <?php foreach ($words as $word): ?>
                <?php if ($word->direction === 'horizontal'): ?>
                    <div class="vertical-clue">
                        <strong><?php echo ++$i; ?></strong>: <?php echo htmlspecialchars($word->clue); ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="vertical-clue" style="color: red;">Aucun indice vertical disponible.</div>
        <?php endif; ?>
    </div>

    <div class="grid-container">
        <?php if (!empty($gridArray)): ?>
            <?php foreach ($gridArray as $rowIndex => $row): ?>
                <?php foreach ($row as $colIndex => $cell): ?>
                    <input
                            class="grid-item <?php echo $cell === '-' ? 'empty' : ''; ?>"
                            type="text"
                            name="cell_<?php echo $rowIndex; ?>_<?php echo $colIndex; ?>"
                            value="<?php echo $cell === '-' ? '/' : ''; ?>"
                            required
                            maxlength="1"
                    >
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="grid-item" style="grid-column: span 10; text-align: center; color: red;">
                No grid data available.
            </div>
        <?php endif; ?>
    </div>

    <div class="horizontal-clue-container">
        <h2>Indices Horizontaux</h2>
        <?php if (!empty($words)): ?>
            <?php $i = 0; ?>
            <?php foreach ($words as $word): ?>
                <?php if ($word->direction === 'horizontal'): ?>
                    <div class="horizontal-clue">
                        <strong><?php echo ++$i; ?></strong>: <?php echo htmlspecialchars($word->clue); ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="horizontal-clue" style="color: red;">Aucun indice horizontal disponible.</div>
        <?php endif; ?>
    </div>
</div>

<?php if (isset($errorMessage)): ?>
    <div style="color: red; text-align: center;"><?php echo htmlspecialchars($errorMessage); ?></div>
<?php endif; ?>
