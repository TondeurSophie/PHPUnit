<?php
include("config.php");
include("recette.php");
include("recetteDAO.php");
include("details_recette.php");

$recetteDAO = new RecetteDAO($connexion);
//Lister les recettes
$recettes = $recetteDAO->listerRecettesAccueil();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Recettes</title>
</head>
<body>

    <h1>Liste des Recettes</h1>

    <?php
    //Affichage des recettes
    if (!empty($recettes)) {
        foreach ($recettes as $recette) {
            echo "<div>";
            
            // Utilisez un lien pour rediriger vers la page de détails avec le nom de la recette en tant que paramètre
            echo "<a href='details_recette.php?nom=" . urlencode($recette['nom']) . "'>";
            echo "<p>Nom : " . $recette['nom'] . "</p>";
            echo "</a>";
            
            if (!empty($recette['image'])) {
                echo "<img src='" . $recette['image'] . "' alt='Image de la recette'>";
            }
            
            echo "<p>Difficulté : " . $recette['difficulte'] . "</p>";
            echo "</div>";
            echo "<hr>";
        }
    } else {
        //Si pas de recettes de trouvées
        echo "<p>Aucune recette trouvé.</p>";
    }
    ?>

</body>
</html>