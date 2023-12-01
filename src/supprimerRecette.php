<?php
require_once("recetteDAO.php");
require_once("recette.php");
require_once("config.php");
//Récuperation dans l'URL du nom transmis
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $nom = isset($_GET['nom']) ? $_GET['nom'] : null;

    if ($nom !== null) {
        $recetteDAO = new RecetteDAO($connexion);
        //Récupération des valeurs pour les stocker dans un objet
        $details_recette_data = $recetteDAO->getAffichageDetailsRecette($nom);

        if ($details_recette_data !== false) {
            $recette = new Recette(
                $details_recette_data['id_categorie'],
                $details_recette_data['nom'],
                $details_recette_data['image'],
                $details_recette_data['difficulte'],
                $details_recette_data['duree'],
                $details_recette_data['nb_personne'],
                $details_recette_data['texte']
            );

            $success = $recetteDAO->supprimerRecette($recette);

            if ($success) {
                echo "<p>Recette supprimée avec succès.</p>";
                header("refresh:2;url=http://localhost/ProjetUnitaire/src/index.php");
            } else {
                echo "<p>Erreur lors de la suppression de la recette.</p>";
            }
        } else {
            echo "<p>Recette non trouvée.</p>";
        }
    } else {
        echo "<p>Nom de recette manquant.</p>";
    }
} else {
    echo "<p>Méthode de requête incorrecte.</p>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Style.css" rel="stylesheet">
    <title>Ajouter une Recette</title>
</head>