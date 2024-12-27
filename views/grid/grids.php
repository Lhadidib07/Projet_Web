<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .grid-container {
        width: 80%;
        max-width: 800px;
        margin: auto;
        background: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .grid-header {
        background-color: #4CAF50;
        color: white;
        text-align: center;
        padding: 10px 20px;
    }

    .grid-item {
        border-bottom: 1px solid #ddd;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .grid-item:last-child {
        border-bottom: none;
    }

    .grid-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
    }

    .grid-description {
        font-size: 0.9rem;
        color: #666;
    }

    .grid-date {
        font-size: 0.8rem;
        color: #999;
        text-align: right;
    }

    .btn {
        padding: 8px 16px;
        color: white;
        background-color: #4CAF50;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .btn:hover {
        background-color: #45a049;
    }

    .btn:active {
        background-color: #3e8e41;
    }
</style>

<div class="grid-container">
    <div class="grid-header">
        <h1>Liste des Grilles</h1>
    </div>
    <?php foreach ($grids as $grid): ?>
        <div class="grid-item">
            <div>
                <div class="grid-title"><?= htmlspecialchars($grid['title']) ?></div>
                <div class="grid-description"><?= htmlspecialchars($grid['description']) ?></div>
            </div>
            <div style="text-align: right;">
                <div class="grid-date">Créé le : <?= htmlspecialchars(date('d/m/Y', strtotime($grid['created_at']))) ?></div>
                <a href="/grids/<?= $grid['id'] ?>" class="btn">Voir</a>
                <a href="/playGrid/<?= $grid['id'] ?>" class="btn">Jouer</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>