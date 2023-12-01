<?php
include("config.php");
include("recette.php");
include("recetteDAO.php");
include("details_recette.php");

$recetteDAO = new RecetteDAO($connexion);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $recherche = isset($_GET['search']) ? $_GET['search'] : '';
    $selectedCategorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';

    $categories = $recetteDAO->trouverRecettesCategorie($selectedCategorie);

    $recettes = empty($recherche) ? $recetteDAO->listerRecettesAccueil() : $recetteDAO->trouverRecettesParNom($recherche);
}
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

    <form action="" method="get">
        <label for="search">Rechercher par nom :</label>
        <input type="text" id="search" name="search" value="<?= htmlspecialchars($recherche) ?>">

        <label for="categorie">Catégorie :</label>
        <select id="categorie" name="categorie">
            <option value="" <?= ($selectedCategorie === '') ? 'selected' : '' ?>>entree</option>
            <?php foreach ($categories as $categorie) : ?>
                <option value="<?= htmlspecialchars($categorie) ?>" <?= ($selectedCategorie === $categorie) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($categorie) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Rechercher</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        //Affichage des recettes
        if (!empty($recettes)) {
            foreach ($recettes as $recette) {
                echo "<div>";

                echo "<a href='details_recette.php?nom=" . urlencode($recette->getNom()) . "'>";
                echo "<p>Nom : " . $recette->getNom() . "</p>";
                echo "</a>";

                if (!empty($recette->getImage())) {
                    echo "<img src='" . $recette->getImage() . "' alt='Image de la recette'>";
                }

                echo "<p>Difficulté : " . $recette->getDifficulte() . "</p>";
                echo "</div>";
                echo "<hr>";
            }
        } else {
            echo "<p>Aucune recette trouvée.</p>";
        }
    }
    ?>

</body>
</html>