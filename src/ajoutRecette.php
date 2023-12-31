<?php
require_once("recetteDAO.php");
require_once("config.php");
require_once("recette.php");

//Récupération des valeurs du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categorie = $_POST['categorie'];
    $id_categorie = $categorie;
    $nom = $_POST['nom'];
    $image = $_POST['image'];
    $difficulte = $_POST['difficulte'];
    $duree = $_POST['duree'];
    $nb_personne = $_POST['nb_personne'];
    $texte = $_POST['texte'];

    $recetteDAO = new RecetteDAO($connexion);

    $nouvelleRecette = new Recette($id_categorie, $nom, $image, $difficulte, $duree, $nb_personne, $texte);
    $success = $recetteDAO->ajouterRecette($nouvelleRecette);
$ingredients = isset($_POST['ingredients']) ? $_POST['ingredients'] : [];
$quantites = isset($_POST['quantites']) ? $_POST['quantites'] : [];

$successRecette = $recetteDAO->ajouterRecette($nouvelleRecette);

$idRecette = $recetteDAO->trouverDernierId();

for ($i = 0; $i < count($ingredients); $i++) {
    $ingredient = $ingredients[$i];
    $quantite = $quantites[$i];

    $successRelation = $recetteDAO->ajouterRelationIngredientRecette($ingredient, $quantite, $idRecette);
}
    if ($success) {
        echo "<p>Recette ajoutée avec succès.</p>";

        $idRecette = $recetteDAO->trouverDernierId();

        // Ajout des ingrédients dans la table ingredient_recette
        if (isset($_POST['ingredients']) && isset($_POST['quantites'])) {
            $ingredients = $_POST['ingredients'];
            $quantites = $_POST['quantites'];

            foreach ($ingredients as $key => $ingredient) {
                $quantite = $quantites[$key];

                $recetteDAO->ajouterRecetteIngredient($idRecette, $ingredient, $quantite);
            }
        }
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
    <link href="Style.css" rel="stylesheet">
    <title>Ajouter une Recette</title>
    <script>
        function ajouterIngredient() {
            var nouvelIngredient = document.createElement("div");

            var nomIngredient = document.createElement("input");
            nomIngredient.type = "text";
            nomIngredient.name = "ingredients[]";
            nomIngredient.placeholder = "Nouvel ingrédient";
            nouvelIngredient.appendChild(nomIngredient);

            var quantiteIngredient = document.createElement("input");
            quantiteIngredient.type = "text";
            quantiteIngredient.name = "quantites[]";
            quantiteIngredient.placeholder = "Quantité";
            nouvelIngredient.appendChild(quantiteIngredient);

            var boutonSupprimer = document.createElement("button");
            boutonSupprimer.type = "button";
            boutonSupprimer.textContent = "Supprimer";
            boutonSupprimer.onclick = function() {
                nouvelIngredient.remove();
            };
            nouvelIngredient.appendChild(boutonSupprimer);

            var listeIngredients = document.getElementById("listeIngredients");
            listeIngredients.appendChild(nouvelIngredient);
        }
    </script>
</head>
<body>
    <div class="case">
    <h1>Ajouter une recette</h1>

    <form method="post" action="">
        <label>Nom de la recette:</label>
        <input type="text" name="nom" required><br>

        <label>Categorie:</label>
        <input type="text" name="categorie" required><br>

        <label>Ingrédients:</label>
        <div id="listeIngredients">
            <div>
                <input type="text" name="ingredients[]" placeholder="Ingrédient 1" required>
                <input type="text" name="quantites[]" placeholder="Quantité 1" required>
                <button type="button" onclick="ajouterIngredient()">Ajouter un ingrédient</button>
            </div>
        </div>

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
    </div>

    <br>
    <a href="index.php">Retour à la liste des recettes</a>
    </br></br>
    <center>
    <img  src="https://img-3.journaldesfemmes.fr/mrK-0E6Jw7lGJUv9Y0mpK5yfCMg=/1500x/smart/0a6c4b8084be4b9d91265bbe65a5ba93/ccmcms-jdf/11437802.png" alt="image_categorie" width=50%></img>
    </center>
</body>
</html