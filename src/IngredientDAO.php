<?php
include("Ingredient.php");
include("config.php");

class IngredientDAO {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function ajouterIngredient(Ingredient $ingredients) {
        if($ingredients->getNom() == "" || is_string($ingredients->getId())||is_int($ingredients->getNom())||preg_match('/[0-9]/',$ingredients->getNom())){
            throw new InvalidArgumentException("nom invalide");
        }else{
        //Ajout d'une categorie
        try {
            $requete = $this->bdd->prepare("INSERT INTO ingredients (nom) VALUES (?)");
            $requete->execute([$ingredients->getNom()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur d'ajout de ingredient : " . $e->getMessage();
            return false;
        }
        }
    }

    public function supprimerIngredient(Ingredient $ingredients) {
        if(is_string($ingredients->getId())||$ingredients->getNom() == ""||preg_match('/[0-9]/',$ingredients->getNom())){
            throw new InvalidArgumentException("erreur de format des informations");
        }
        // var_dump($ingredients);
        try {
            $requete = $this->bdd->prepare("DELETE FROM ingredients WHERE id = ?");
            //Execution de la requete avec les valeurs de l'objet categories
            $requete->execute([$ingredients->getId()]);
            //Retourne vrai en cas de succes
            return true;
        } catch (PDOException $e) {
            //En cas d'erreur, affiche du message d'erreur
            echo "Erreur de suppression de l'ingredient': " . $e->getMessage();
            //Retourne faux en cas d'echec
            return false;
        }
    }

    public function modifierNomIngredient($id, $nouveauNom) {
        if($id =="" || $nouveauNom ==""|| is_string($id) || is_int($nouveauNom) || preg_match('/[0-9]/',$nouveauNom)){
            throw new InvalidArgumentException("ne correspond pas aux attentes");
        }
        try {
            $requete = $this->bdd->prepare("UPDATE ingredients SET nom = ? WHERE id = ?");
            $requete->execute([$nouveauNom, $id]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur de modification du nom de l'ingredient : " . $e->getMessage();
            return false;
        }
    }

    public function listerIngredient() {
        //Liste des categories en selectionnant toute la table
        try {
            $requete = $this->bdd->prepare("SELECT * FROM ingredients");
            $requete->execute();
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de recuperation des ingredient: " . $e->getMessage();
            return [];
        }
    }

    public function trouverIngredientParId($id) {
        if($id == "" || is_string($id)){
            throw new InvalidArgumentException("Id invalide");
        }
        try {
            //Recherche un personnage en particulier en fonction de l'id
            $requete = $this->bdd->prepare("SELECT * FROM ingredients WHERE id = ?");
            $requete->execute([$id]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);

            if ($resultat) {
                return new Ingredient($resultat['id'], $resultat['nom']);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche de la recette par ID: " . $e->getMessage();
            return null;
        }
    }

}



?>