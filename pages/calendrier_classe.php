<?php
require_once '../includes/db.php';
require_once '../includes/header.php';

setlocale(LC_TIME, 'fr_FR.UTF-8');

// Vue choisie : mois/semaine/année (pour plus tard)
$vue = $_GET['vue'] ?? 'mois';

$mois = isset($_GET['mois']) ? (int)$_GET['mois'] : (int)date('m');
$annee = isset($_GET['annee']) ? (int)$_GET['annee'] : (int)date('Y');

$moisFrancais = [
    1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
    5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
    9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
];

$moisActuel = DateTimeImmutable::createFromFormat('!Y-m', "$annee-$mois");
$moisPrecedent = $moisActuel->modify('-1 month');
$moisSuivant = $moisActuel->modify('+1 month');

// Début / Fin du mois
$debutMois = $moisActuel->modify('first day of this month');
$finMois = $moisActuel->modify('last day of this month');

// Liste des jours ouvrés (lundi à vendredi)
$joursOuvres = [];
$jour = $debutMois;
while ($jour <= $finMois) {
    if ((int)$jour->format('N') < 6) {
        $joursOuvres[] = clone $jour;
    }
    $jour = $jour->modify('+1 day');
}

// Cases vides au début si le mois ne commence pas un lundi
$firstDay = $joursOuvres[0];
$offset = (int)$firstDay->format('N') - 1;
?>

<div class="flex gap-6">

    <!-- Colonne gauche : calendrier -->
    <div class="w-2/3">
        <!-- Navigation mois -->
        <div class="flex justify-between items-center mb-6">
            <a href="?mois=<?= $moisPrecedent->format('m') ?>&annee=<?= $moisPrecedent->format('Y') ?>&vue=<?= $vue ?>"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded shadow">
                ← Mois précédent
            </a>

            <h2 class="text-3xl font-bold text-blue-700">
                <?= $moisFrancais[$mois] . ' ' . $annee ?>
            </h2>

            <a href="?mois=<?= $moisSuivant->format('m') ?>&annee=<?= $moisSuivant->format('Y') ?>&vue=<?= $vue ?>"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded shadow">
                Mois suivant →
            </a>
        </div>

        <!-- Boutons de vue (semaine / mois / année) -->
        <div class="flex justify-center mb-4">
            <div class="inline-flex rounded-md shadow-sm" role="group">
                <?php
                function boutonVue($type, $label, $vueActive) {
                    $actif = $type === $vueActive;
                    $classes = $actif
                        ? 'bg-blue-600 text-white'
                        : 'bg-gray-200 hover:bg-gray-300 text-gray-800';
                    return '<a href="?vue=' . $type . '" class="px-4 py-2 text-sm font-medium border border-gray-300 ' . $classes . '">' . $label . '</a>';
                }
                echo boutonVue('semaine', 'Semaine', $vue);
                echo boutonVue('mois', 'Mois', $vue);
                echo boutonVue('annee', 'Année', $vue);
                ?>
            </div>
        </div>

        <!-- En-tête jours -->
        <div class="grid grid-cols-5 text-center font-bold mb-2 text-gray-700 uppercase">
            <div>Lundi</div>
            <div>Mardi</div>
            <div>Mercredi</div>
            <div>Jeudi</div>
            <div>Vendredi</div>
        </div>

        <!-- Grille du mois -->
        <div class="grid grid-cols-5 gap-4">
            <?php
            for ($i = 0; $i < $offset; $i++) {
                echo '<div></div>';
            }
            foreach ($joursOuvres as $jour) {
                echo '<div class="bg-white rounded-xl shadow p-4 border border-gray-200">';
                echo '<div class="text-gray-500 text-sm mb-2">' . $jour->format('d/m/Y') . '</div>';
                echo '<div class="text-gray-400 italic text-sm">Aucun module</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Colonne droite : modules + formulaire -->
    <div class="w-1/3 bg-white rounded-xl shadow p-4 border border-gray-200 h-fit">
        <h3 class="text-xl font-semibold mb-4 text-blue-700">Modules disponibles</h3>
        <?php include '../modules/lister.php'; ?>

        <!-- Formulaire ajout module -->
        <h3 class="text-lg font-semibold mt-6 mb-2 text-blue-700">Ajouter un module</h3>
        <form action="../modules/ajouter.php" method="POST" class="space-y-3">
            <input type="text" name="nom" placeholder="Nom du module" required class="w-full px-3 py-2 border rounded" />
            <input type="number" name="heures_total" placeholder="Heures totales" required class="w-full px-3 py-2 border rounded" />
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Ajouter</button>
        </form>
    </div>

</div>
