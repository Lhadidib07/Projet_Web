<style>


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
        <div class="grid-item" id="grid-<?= $grid['id'] ?>" >
            <div>
                <div class="grid-title"><?= htmlspecialchars($grid['title']) ?></div>
                <div class="grid-description"><?= htmlspecialchars($grid['description']) ?></div>
            </div>
            <div style="text-align: right;">
                <div class="grid-date">Créé le : <?= htmlspecialchars(date('d/m/Y', strtotime($grid['created_at']))) ?></div>
                <a href="/playGrid/<?= $grid['id'] ?>" class="btn">Jouer</a>
                <?php if(isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'admin'): ?>
                    <a href="/grids/<?= $grid['id'] ?>" class="btn">Voir</a>
                    <form id="deleteForm" action="/grids/delete" method="POST" style="display:inline;" onsubmit="submitForm(event)">
                        <input type="hidden" name="id" value="<?= $grid['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <button type="submit" class="btn" style="background-color: #f44336;">Supprimer</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if(isset($_SESSION['user_id'])): ?>
        <div class="grid-item">
            <a href="/grid/create" class="btn">Créer une grille</a>
        </div>
    <?php endif; ?>
</div>

<script>

    function submitForm(event) {
        event.preventDefault(); // Empêche la soumission par défaut du formulaire

        const form = event.target; // Récupère le formulaire à partir de l'événement
        const formData = new FormData(form); // Crée un objet FormData avec les données du formulaire
        const data = {}; // Initialise un objet vide pour stocker les données

        // Itère sur chaque paire clé-valeur de FormData et les ajoute à l'objet data
        formData.forEach((value, key) => {
            data[key] = value;
        });
        console.log(data);
        id = data.id;

        fetch('/grids/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log(data);
                deleteFromDom(data.id);
                showNotification(data.message);
            } else {
                console.error(data);
                deleteFromDom(id);
                showNotification(data.message);
            }
        })
        .catch(error => {
            showNotification('Une erreur est survenue ici ');
        });
    }
   


    function deleteFromDom(id) {
        console.log(`Suppression de l'élément avec l'ID: grid-${id}`); // Ajout d'une instruction de débogage
        const gridItem = document.getElementById(`grid-${id}`);
        if (gridItem) {
            gridItem.remove();
        } else {
            console.error(`Élément avec l'ID grid-${id} non trouvé`); // Ajout d'une instruction de débogage
        }
    }
</script>