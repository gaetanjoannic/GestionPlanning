<?php
require_once '../includes/db.php';

$modules = $pdo->query("SELECT * FROM modules ORDER BY nom ASC")->fetchAll();

if (count($modules) === 0) {
    echo '<p class="text-gray-500 italic">Aucun module enregistré.</p>';
} else {
    echo '<ul class="space-y-2">';
    foreach ($modules as $module) {
        echo '<li class="flex items-center justify-between bg-gray-100 px-3 py-2 rounded shadow">';
        echo '<span class="text-gray-800">' . htmlspecialchars($module['nom']) . ' (' . $module['heures_total'] . 'h)</span>';
        echo '<form method="POST" action="../modules/supprimer.php" onsubmit="return confirm(\'Supprimer ce module ?\')">';
        echo '<input type="hidden" name="id" value="' . (int)$module['id'] . '">';
        echo '<button type="submit" class="text-red-500 font-bold hover:text-red-700 ml-2">❌</button>';
        echo '</form>';
        echo '</li>';
    }
    echo '</ul>';
}
?>
