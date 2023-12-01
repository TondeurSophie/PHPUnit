<?php

require_once("recetteDAO.php");
require_once("config.php");
require_once("recette.php");

// Récupération du nom de la recette de l'URL
$nom_recette = isset($_GET['nom']) ? $_GET['nom'] : null;
$recetteDAO = new RecetteDAO($connexion);

// Récupération en fonction du nom récupéré plus-haut pour afficher toutes les informations sur les recettes
$details_recette_data = $recetteDAO->getAffichageDetailsRecette($nom_recette);

// Vérification que un résultat a été trouvé pour notre requête
if ($details_recette_data !== false) {
    // Objet Recette
    $details_recette = new Recette(
        $details_recette_data['id_categorie'],
        $details_recette_data['nom'],
        $details_recette_data['image'],
        $details_recette_data['difficulte'],
        $details_recette_data['duree'],
        $details_recette_data['nb_personne'],
        $details_recette_data['texte']
    );

    // Affichage HTML en récupérant pour l'objet
    echo "<h1>Détails de la recette</h1>";
    echo "<p>Nom : " . $details_recette->getNom() . "</p>";
    echo "<img src='" . $details_recette->getImage() . "' alt='Image de la recette'>";
    echo "<p>Difficulté : " . $details_recette->getDifficulte() . "</p>";
    echo "<p>Durée : " . $details_recette->getDuree() . "</p>";
    echo "<p>Nombre de personnes : " . $details_recette->getNbPersonnes() . "</p>";
    echo "<p>Description : " . $details_recette->getTexte() . "</p>";

    // Afficher la liste des ingrédients associés à la recette
    $ingredients_recette = $recetteDAO->getIngredientsRecette($details_recette->getNom());
    if (!empty($ingredients_recette)) {
        echo "<h2>Ingrédients :</h2>";
        echo "<ul>";
        foreach ($ingredients_recette as $ingredient) {
            echo "<li>$ingredient</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun ingrédient associé à cette recette.</p>";
    }

    // Boutton pour revenir en arrière
    echo "<button onclick='history.go(-1);'>Retour</button>";

    // Bouton pour supprimer la recette
    echo "<a href='supprimerRecette.php?nom=" . urlencode($details_recette->getNom()) . "'>Supprimer cette recette</a>";
} else {
    // Si aucune recette trouvée message d'erreur
    echo "<p>Recette non trouvée.</p>";
}
?>