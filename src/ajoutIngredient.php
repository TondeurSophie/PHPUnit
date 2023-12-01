<?php
require_once("IngredientDAO.php");
require_once("config.php");
require_once("Ingredient.php");

//Récupération des valeurs du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];


    $ingredientDAO = new IngredientDAO($connexion);

    $nouvelleIngredient = new Ingredient($nom);
    $success = $ingredientDAO->ajouterIngredient($nouvelleIngredient);


    if ($success) {
        echo "<p>Ingredient ajoutée avec succès.</p>";


    } else {
        echo "<p>Erreur lors de l'ajout de la Ingredient.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Style.css" rel="stylesheet">
    <title>Ajouter une Ingredient</title>
    <script>
        // fonction permettant de relier le front et le back par rapport aux valeurs entré par l'utilisateur
        function ajouterIngredient() {
            var nouvelIngredient = document.createElement("div");

            var nomIngredient = document.createElement("input");
            nomIngredient.type = "text";
            nomIngredient.name = "Ingredients[]";
            nomIngredient.placeholder = "Nouvelle Ingredient";
            nouvelIngredient.appendChild(nomIngredient);


            var boutonSupprimer = document.createElement("button");
            boutonSupprimer.type = "button";
            boutonSupprimer.textContent = "Supprimer";
            boutonSupprimer.onclick = function() {
                nouvelIngredient.remove();
            };
            nouvelIngredient.appendChild(boutonSupprimer);

            var listeIngredient = document.getElementById("listeIngredient");
            listeIngredient.appendChild(nouvelIngredient);
        }
    </script>
</head>
<body>
        <div class="case">
    <h1>Ajouter une Ingredient</h1>
<!-- Affichage des input dans le front -->
    <form method="post" action="">
        <label>Nom de la Ingredient:</label>
        <input type="text" name="nom" required><br>
        </br>
        <button type="submit">Ajouter la Ingredient</button>
    </form>
    </div>
    <br>
    <a href="index.php">Retour à la liste des recettes</a>
    <br/><br/>
    <center>
    <img  src="https://st2.depositphotos.com/3889193/7173/i/450/depositphotos_71738921-stock-photo-online-cooking-app-with-kitchen.jpg" alt="image_categorie"></img>
    </center>
</body>
</html