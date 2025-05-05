<?php
require_once '../includes/db.php';
require_once '../includes/header.php';

// Récupération des classes pour la liste déroulante
$classes = $pdo->query("SELECT id, nom FROM classes")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1 class="text-2xl font-bold mb-4">Ajouter un module</h1>

<form action="ajouter_post.php" method="post" class="space-y-4 max-w-lg">
    <div>
        <label for="nom" class="block font-medium">Nom du module</label>
        <input type="text" name="nom" id="nom" required class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label for="classe_id" class="block font-medium">Classe</label>
        <select name="classe_id" id="classe_id" required class="w-full border rounded px-3 py-2">
            <?php foreach ($classes as $classe): ?>
                <option value="<?= $classe['id'] ?>"><?= htmlspecialchars($classe['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="heures_total" class="block font-medium">Total d'heures</label>
        <input type="number" name="heures_total" id="heures_total" min="1" required class="w-full border rounded px-3 py-2">
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Ajouter</button>
</form>

<?php require_once '../includes/footer.php'; ?>
