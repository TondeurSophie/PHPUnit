<?php

require_once("recetteDAO.php");
require_once("config.php");
require_once("Recette.php");
// require_once("Style.css");

//Récupération du nom de la recette de l'URL
$nom_recette = isset($_GET['nom']) ? $_GET['nom'] : null;
$recetteDAO = new RecetteDAO($connexion);

//Récupération en fonction du nom récupéré plus-haut pour afficher toutes les informations sur les recettes
$details_recette_data = $recetteDAO->getAffichageDetailsRecette($nom_recette);
// var_dump($details_recette_data);
//Vérification que un résultat a été trouvé pour notre requête
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

    //Boutton pour revenir en arrière
    echo "<button onclick='history.go(-1);'>Retour</button>";

    //Bouton pour supprimer la recette
    echo "<a href='supprimerRecette.php?nom=" . urlencode($details_recette->getNom()) . "'>Supprimer cette recette</a>";    // Si aucune recette trouvée message d'erreur
    echo "<p>Recette non trouvée.</p>";
}else{
    $recettes = $recetteDAO->listerRecettesAccueil();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <link href="Style.css" rel="stylesheet">

    <title>Cook Book Web</title>
</head>
<body>
    <img  src="https://c8.alamy.com/compfr/f4j1ty/des-legumes-frais-prets-a-preparer-la-salade-regime-alimentaire-sain-de-l-espace-pour-l-arriere-plan-concept-texte-f4j1ty.jpg" alt="image" width="100%" height="15%"></img>
    <center><h1 class="titre">Cook Book Web</h1></center>
    <h2>Liste des Recettes</h2>
    <p >
    <?php
    //Affichage des recettes
    if (!empty($recettes)) {
        foreach ($recettes as $recette) {
            echo "<div className='liste'>";
            
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
    
}


?>
</p>