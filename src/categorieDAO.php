<?php
include("recette.php");
class RecetteDAO {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function ajouterCategorie(Categories $categories) {
        //Ajout d'une categorie
        try {
            $requete = $this->bdd->prepare("INSERT INTO categories (nom) VALUES (?, ?)");
            $requete->execute([$categories->getNom()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur d'ajout de categorie : " . $e->getMessage();
            return false;
        }

    }

    public function supprimerCategorie(Categories $categories) {
        try {
            $requete = $this->bdd->prepare("DELETE FROM categories WHERE id = ?");
            //Exécution de la requête avec les valeurs de l'objet categories
            $requete->execute([$categories->getId()]);
            //Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            //En cas d'erreur, affiche du message d'erreur
            echo "Erreur de suppression de la categorie: " . $e->getMessage();
            //Retourne faux en cas d'échec
            return false;
        }
    }

    public function modifierCategorie($id, $nouveauNom) {
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
        //Liste des personnage en selectionnant toute la table
        try {
            $requete = $this->bdd->prepare("SELECT * FROM categories");
            $requete->execute();
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des categories: " . $e->getMessage();
            return [];
        }
    }
}
?>