<?php
require_once("recetteDAO.php");
require_once("config.php");
require_once("recette.php");
//Récuperation des valeurs du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categorie=$_POST['categorie'];
    $id_categorie=$categorie;
    $nom = $_POST['nom'];
    $image = $_POST['image'];
    $difficulte = $_POST['difficulte'];
    $duree = $_POST['duree'];
    $nb_personne = $_POST['nb_personne'];
    $texte = $_POST['texte'];

    $recetteDAO = new RecetteDAO($connexion);
    $nouvelleRecette=new Recette($id_categorie,$nom, $image, $difficulte, $duree, $nb_personne, $texte);
    $success = $recetteDAO->ajouterRecette($nouvelleRecette);

    if ($success) {
        echo "<p>Recette ajoutée avec succès.</p>";
    } else {
        echo "<p>Erreur lors de l'ajout de la recette.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Recette</title>
</head>
<body>

    <h1>Ajouter une recette</h1>
<!-- Formulaire a remplir pour ajouter une recette (tous les champs sont obligatoires) -->
    <form method="post" action="">
        <label>Nom de la recette:</label>
        <input type="text" name="nom" required><br>

        <label>Categorie:</label>
        <input type="text" name="categorie" required><br>

        <label>Image (URL):</label>
        <input type="text" name="image" required><br>

        <label>Difficulté:</label>
        <input type="text" name="difficulte" required><br>

        <label>Durée:</label>
        <input type="text" name="duree" required><br>

        <label>Nombre de personnes:</label>
        <input type="number" name="nb_personne" required><br>

        <label>Description:</label>
        <textarea name="texte" required></textarea><br>

        <button type="submit">Ajouter la recette</button>
    </form>

    <br>
    <a href="index.php">Retour à la liste des recettes</a>

</body>
</html>