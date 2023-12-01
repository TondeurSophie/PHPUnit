<?php
require_once("CategorieDAO.php");
require_once("config.php");
require_once("Categorie.php");

//Récupération des valeurs du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id=$_POST['id'];
    $nom = $_POST['nom'];


    $categorieDAO = new CategorieDAO($connexion);

    $nouvelleCategorie = new Categorie($id,$nom);
    $success = $categorieDAO->ajouterCategorie($nouvelleCategorie);


    if ($success) {
        echo "<p>Categorie ajoutée avec succès.</p>";


    } else {
        echo "<p>Erreur lors de l'ajout de la categorie.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Style.css" rel="stylesheet">
    <title>Ajouter une Categorie</title>
    <script>
        function ajouterCategorie() {
            var nouvelCategorie = document.createElement("div");

            var idCategorie = document.createElement("input");
            idCategorie.type = "number";
            idCategorie.name = "categories[]";
            idCategorie.placeholder = "Nouvelle categorie";
            nouvelCategorie.appendChild(idCategorie);

            var nomCategorie = document.createElement("input");
            nomCategorie.type = "text";
            nomCategorie.name = "categories[]";
            nomCategorie.placeholder = "Nouvelle categorie";
            nouvelCategorie.appendChild(nomCategorie);


            var boutonSupprimer = document.createElement("button");
            boutonSupprimer.type = "button";
            boutonSupprimer.textContent = "Supprimer";
            boutonSupprimer.onclick = function() {
                nouvelCategorie.remove();
            };
            nouvelCategorie.appendChild(boutonSupprimer);

            var listeCategorie = document.getElementById("listeCategorie");
            listeCategorie.appendChild(nouvelCategorie);
        }
    </script>
</head>
<body>

    <h1>Ajouter une categorie</h1>

    <form method="post" action="">
        <label>Id de la categorie:</label>
        <input type="number" name="id" required><br>
        </br>
        <label>Nom de la categorie:</label>
        <input type="text" name="nom" required><br>
        </br>
        <button type="submit">Ajouter la categorie</button>
    </form>

    <br>
    <a href="index.php">Retour à la liste des recettes</a>
    <br/><br/>
    <center>
    <img  src="https://www.liebherr-electromenager.fr/liip_cache/default/upload/post/imageepp-jpg.jpeg" alt="image_categorie"></img>
    </center>
</body>
</html