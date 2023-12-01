<?php
require_once("recetteDAO.php");
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = isset($_POST['nom']) ? $_POST['nom'] : null;

    if ($nom) {
        $recetteDAO = new RecetteDAO($connexion);

        // Effectuez des requêtes SQL pour mettre à jour les informations de la recette
        // Utilisez les valeurs de $_POST pour obtenir les nouvelles informations du formulaire

        // Redirigez l'utilisateur après la modification
        header("Location: index.php");
        exit();
    } else {
        echo "<p>Nom de recette manquant.</p>";
    }
} else {
    echo "<p>Méthode de requête incorrecte.</p>";
}
?>