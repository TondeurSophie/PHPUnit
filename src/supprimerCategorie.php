<?php
require_once("CategorieDAO.php");
require_once("Categorie.php");
require_once("config.php");

//Récuperation dans l'URL du nom transmis
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $nom = isset($_GET['nom']) ? $_GET['nom'] : null;
    if ($id !== null) {
        $categorieDAO = new CategorieDAO($connexion);
        //Récupération des valeurs pour les stocker dans un objet
        $categorie_data = $categorieDAO->trouverCategorieParId(intval($id));
        // var_dump($categorie_data);
        if ($categorie_data !== false) {
            // $cate = new Categorie(
            //     $categorie_data['id'],
            //     $categorie_data['nom'],
            // );
            $success = $categorieDAO->supprimerCategorie($categorie_data);
            if ($success) {
                echo "<p>Categorie supprimée avec succès.</p>";
                header("refresh:2;url=http://localhost/PHPUnit/BDD/Examen/PHPUnit/src/index.php");
            } else {
                echo "<p>Erreur lors de la suppression de la categorie.</p>";
            }
        } else {
            echo "<p>Categorie non trouvée.</p>";
        }
    } else {
        echo "<p>Nom de Categorie manquant.</p>";
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
    <title>Categories</title>
</head>