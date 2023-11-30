<?php

// include("config.php");
// include("recette.php");
require_once("recetteDAO.php");
require_once("config.php");
require_once("recette.php");

//Récuperation du nom de la recette de l'URL
$nom_recette = isset($_GET['nom']) ? $_GET['nom'] : null;
$recetteDAO = new RecetteDAO($connexion);

//Récupération en fonction du nom récupéré plus-haut pour afficher toutes les informations sur les recettes
$details_recette_data = $recetteDAO->getAffichageDetailsRecette($nom_recette);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Recette</title>
</head>
<body>

    <?php
//Verification que un résultat a été trouvé pour notre requête
    if ($details_recette_data !== false) {
        //Objet Recette
        $details_recette = new Recette(
            $details_recette_data['id_categorie'],
            $details_recette_data['nom'],
            $details_recette_data['image'],
            $details_recette_data['difficulte'],
            $details_recette_data['duree'],
            $details_recette_data['nb_personne'],
            $details_recette_data['texte']
        );
        //Affichage HTML en récupérant pour l'objet
        echo "<h1>Détails de la recette</h1>";
        echo "<p>Nom : " . $details_recette->getNom() . "</p>";
        echo "<img src='" . $details_recette->getImage() . "' alt='Image de la recette'>";
        echo "<p>Difficulté : " . $details_recette->getDifficulte() . "</p>";
        echo "<p>Durée : " . $details_recette->getDuree() . "</p>";
        echo "<p>Nombre de personnes : " . $details_recette->getNbPersonnes() . "</p>";
        echo "<p>Description : " . $details_recette->getTexte() . "</p>";
        //Boutton pour reve,ir en arrière
        echo "<button onclick='history.go(-1);'>Retour</button>";

    } else {
        //Si aucune recette trouvée message d'erreur
        echo "<p>Recette non trouvée.</p>";
    }
    ?>

</body>
</html>