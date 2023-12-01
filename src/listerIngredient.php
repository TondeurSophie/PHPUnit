<?php
require_once("IngredientDAO.php");
require_once("config.php");
require_once("Ingredient.php");

$ingredientDAO = new IngredientDAO($connexion);
$ingredients = $ingredientDAO->listerIngredient();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Style.css" rel="stylesheet">
    <title>Liste des Ingredients</title>

</head>
<body>

    <h1>Liste des Ingredients</h1>

    <?php
        //Affichage des categories
        if (!empty($ingredients)) {
            foreach ($ingredients as $ingredient) {
                echo "<div '>";
                
                // liste des ingredients
                echo "<p>Nom : " . $ingredient['nom'] . "</p>";
                echo "</a>";
                
                echo "</div>";
                echo "<hr>";
            }
        } else {
            //Si pas de ingredients de trouvées
            echo "<p>Aucune ingredient trouvé.</p>";
        }
    ?>

    <br>
    <a href="index.php">Retour à la liste des recettes</a>
    <br/><br/>
    <!-- <center> -->
    <!-- <img  src="https://www.liebherr-electromenager.fr/liip_cache/default/upload/post/imageepp-jpg.jpeg" alt="image_categorie"></img> -->
    <!-- </center> -->
    
</body>
</html>