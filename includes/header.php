<?php
// header.php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Planning</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Gestion Planning</h1>
            <nav>
                <button id="toggleButton" class="px-4 py-2 bg-blue-600 text-white rounded shadow-xl hover:bg-blue-700">Calendrier Classe</button>
            </nav>
        </div>
    </header>
    <main class="container mx-auto p-4">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const button = document.getElementById('toggleButton');
            const currentPath = window.location.pathname;

            // Déterminez la page actuelle et définissez le texte du bouton en conséquence
            if (currentPath.includes('calendrier_classe.php')) {
                button.textContent = 'Calendrier Formateur';
                button.addEventListener('click', function() {
                    window.location.href = '../pages/calendrier_formateur.php';
                });
            } else if (currentPath.includes('calendrier_formateur.php')) {
                button.textContent = 'Calendrier Classe';
                button.addEventListener('click', function() {
                    window.location.href = '../pages/calendrier_classe.php';
                });
            }
        });
    </script>
</body>
</html>
