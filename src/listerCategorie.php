<?php
require_once("CategorieDAO.php");
require_once("config.php");
require_once("Categorie.php");

$categorieDAO = new CategorieDAO($connexion);
$categories = $categorieDAO->listerCategorie();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Style.css" rel="stylesheet">
    <title>Liste des Categories</title>

</head>
<body>

    <h1>Liste des Categories</h1>

    <?php
        //Affichage des categories
        if (!empty($categories)) {
            foreach ($categories as $categorie) {
                echo "<div '>";
                
                // liste des categories
                echo "<p>Nom : " . $categorie['nom'] . "</p>";
                echo "</a>";
                echo "<a href='supprimerCategorie.php?id=" . urlencode($categorie['id']) . "'>Supprimer cette categorie</a>";
                echo "</div>";
                echo "<hr>";
            }
        } else {
            //Si pas de categories de trouvées
            echo "<p>Aucune categorie trouvé.</p>";
        }
    ?>

    <br>
    <a href="index.php">Retour à la liste des recettes</a>
    <br/><br/>
    
    
</body>
</html>