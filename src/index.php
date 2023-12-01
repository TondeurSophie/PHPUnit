<?php
include("config.php");
include("recette.php");
include("recetteDAO.php");
include("details_recette.php");

$recetteDAO = new RecetteDAO($connexion);
$recherche = isset($_GET['search']) ? $_GET['search'] : '';

$recettes = empty($recherche) ? $recetteDAO->listerRecettesAccueil() : $recetteDAO->trouverRecettesParNom($recherche);

// echo "<pre>";
// print_r($recettes);
// echo "</pre>";
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

    <form action="" method="get">
        <label for="search">Rechercher par nom :</label>
        <input type="text" id="search" name="search" value="<?= htmlspecialchars($recherche) ?>">
        <button type="submit">Rechercher</button>
    </form>

    <?php
    // echo("Coucou");
    // Affichage des recettes
    if (!empty($recettes)) {
        foreach ($recettes as $recette) {
            echo "<div>";
            
            // Utiliser un lien pour rediriger vers la page de détails avec le nom de la recette en tant que paramètre
            echo "<a href='details_recette.php?nom=" . urlencode($recette->getNom()) . "'>";
            echo "<p>Nom : " . $recette->getNom() . "</p>";
            echo "</a>";
            
            if (!empty($recette->getImage())) {
                echo "<img src='" . $recette->getImage() . "' alt='Image de la recette'>";
            }
            
            echo "<p>Difficulté : " . $recette->getDifficulte() . "</p>";
            echo "</div>";
            echo "<hr>";
        }
    } else {
        // Si aucune recette trouvée
        echo "<p>Aucune recette trouvée.</p>";
    }
    ?>

</body>
</html>