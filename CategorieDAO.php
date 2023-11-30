<?php
include("Categorie.php");
include("config.php");

class CategorieDAO {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function ajouterCategorie(Categorie $categories) {
        if($categories->getNom() == ""|| is_int($categories->getNom())||preg_match('/\s/',$categories->getNom())|| preg_match('/[0-9]/',$categories->getNom())){
            throw new InvalidArgumentException("nom invalide");
        }else{
        //Ajout d'une categorie
        try {
            $requete = $this->bdd->prepare("INSERT INTO categories (nom) VALUES (?)");
            $requete->execute([$categories->getNom()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur d'ajout de categorie : " . $e->getMessage();
            return false;
        }
        }
    }

    public function supprimerCategorie(Categorie $categories) {
        if(is_string($categories->getId())||$categories->getNom() != ""){
            throw new InvalidArgumentException("erreur de format des informations");
        }
        try {
            $requete = $this->bdd->prepare("DELETE FROM categories WHERE id = ?");
            //Execution de la requete avec les valeurs de l'objet categories
            $requete->execute([$categories->getId()]);
            // var_dump($categories);

            //Retourne vrai en cas de succes
            return true;
        } catch (PDOException $e) {
            //En cas d'erreur, affiche du message d'erreur
            echo "Erreur de suppression de la categorie: " . $e->getMessage();
            //Retourne faux en cas d'echec
            return false;
        }
    }

    public function modifierCategorie($id, $nouveauNom) {
        if($id =="" || $nouveauNom ==""|| is_string($id) || is_int($nouveauNom) ||preg_match('/\s/',$nouveauNom) || preg_match('/[0-9]/',$nouveauNom)){
            throw new InvalidArgumentException("ne correspond pas aux attentes");
        }
        try {
            $requete = $this->bdd->prepare("UPDATE categories SET nom = ? WHERE id = ?");
            $requete->execute([$nouveauNom, $id]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur de modification du nom de la categorie : " . $e->getMessage();
            return false;
        }
    }

    public function listerCategorie() {
        //Liste des categories en selectionnant toute la table
        try {
            $requete = $this->bdd->prepare("SELECT * FROM categories");
            $requete->execute();
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de recuperation des categories: " . $e->getMessage();
            return [];
        }
    }

    public function trouverCategorieParId($id) {
        if($id == ""|| is_string($id)){
            throw new InvalidArgumentException("Id invalide");
        }else{
        try {
            //Recherche un personnage en particulier en fonction de l'id
            $requete = $this->bdd->prepare("SELECT * FROM categories WHERE id = ?");
            $requete->execute([$id]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);

            if ($resultat) {
                return new Categorie($resultat['id'], $resultat['nom']);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche de la categorie par ID: " . $e->getMessage();
            return null;
        }
        }
    }
}

//Tests dans la console : 

// $DAO = new CategorieDAO($connexion);

// $categorie=new Categories(1,"entree");
// $DAO->ajouterCategorie($categorie);
// $categorie=$DAO->modifierCategorie(5,"test");
// $DAO->supprimerCategorie($categorie);

// $categories = $DAO->listerCategorie();
// $categories=$DAO->trouverCategorieParId(1);
// if ($categories){
//     foreach($categories as $e){
//         echo "Id : ".$e['id']."\n";
//         echo 'Nom : '.$e['nom']."\n";
//         echo "_ _ _ _ _ _ _ _ _ _ _ _ _ _\n";
//     }
// }

?>