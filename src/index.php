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
    <title>Liste des Recettes</title>
</head>
<body>

    <h1>Liste des Recettes</h1>

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