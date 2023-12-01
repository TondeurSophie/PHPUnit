<?php
require_once("recetteDAO.php");
require_once("config.php");
require_once("recette.php");

$nom = isset($_GET['nom']) ? $_GET['nom'] : null;
if ($nom) {
    $recetteDAO = new RecetteDAO($connexion);

    $details_recette_data = $recetteDAO->trouverRecettesParNom($nom);
    print_r($details_recette_data);
    if ($details_recette_data !== false) {
        $details_recette = new Recette(
            $details_recette_data['id_categorie'],
            $details_recette_data['nom'],
            $details_recette_data['image'],
            $details_recette_data['difficulte'],
            $details_recette_data['duree'],
            $details_recette_data['nb_personne'],
            $details_recette_data['texte']
        );
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Style.css" rel="stylesheet">
    <title>Modifier une Recette</title>
</head>
<body>
    <h1>Modifier la Recette</h1>
    <form method="get" action="traitementModificationRecette.php">
    <input type="hidden" name="id_categorie" value="<?= $details_recette->getIdCategorie() ?>">
<input type="hidden" name="nom" value="<?= $details_recette->getNom() ?>">
<input type="hidden" name="image" value="<?= $details_recette->getImage() ?>">
<input type="hidden" name="difficulte" value="<?= $details_recette->getDifficulte() ?>">
<input type="hidden" name="duree" value="<?= $details_recette->getDuree() ?>">
<input type="hidden" name="nb_personne" value="<?= $details_recette->getNbPersonnes() ?>">
<input type="hidden" name="texte" value="<?= $details_recette->getTexte() ?>">

        <button type="submit">Enregistrer les Modifications</button>
    </form>
</body>
</html>

<?php
    } else {
        echo "<p>Recette non trouvée.</p>";
    }
} else {
    echo "<p>Nom de recette manquant.</p>";
}
?>