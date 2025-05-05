<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $classe_id = $_POST['classe_id'] ?? null;
    $heures_total = $_POST['heures_total'] ?? null;

    if ($nom && $classe_id && $heures_total) {
        $stmt = $pdo->prepare("INSERT INTO modules (nom, classe_id, heures_total) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $classe_id, $heures_total]);

        // Redirection vers la page principale : calendrier classe
        header('Location: ../pages/calendrier_classe.php?ajout=ok');
        exit;
    } else {
        echo "Tous les champs sont requis.";
    }
} else {
    echo "Requête non autorisée.";
}
