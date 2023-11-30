<?php
class RecetteDAO {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function ajouterRecette(Recette $recette) {
        //Ajout du personnage
        try {
            $requete = $this->bdd->prepare("INSERT INTO recettes (id_categorie, nom, `image`, difficulte, duree, nb_personne, texte) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $requete->execute([$recette->getIdCategorie(),$recette->getNom(), $recette->getImage(), $recette->getDifficulte(),$recette->getDuree(),$recette->getNbPersonnes(),$recette->getTexte()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur d'ajout de recette : " . $e->getMessage();
            return false;
        }

    }

    public function supprimerRecette(Recette $recettes) {
        try {
            $requete = $this->bdd->prepare("DELETE FROM recettes WHERE id = ?");
            //Exécution de la requête avec les valeurs de l'objet recette
            $requete->execute([$recettes->getId()]);
            //Retourne vrai en cas de succès
            return true;
        } catch (PDOException $e) {
            //En cas d'erreur, affiche du message d'erreur
            echo "Erreur de suppression de la recette: " . $e->getMessage();
            //Retourne faux en cas d'échec
            return false;
        }
    }

    public function modifierNomRecette($id, $nouveauNom) {
        try {
            $requete = $this->bdd->prepare("UPDATE recettes SET nom = ? WHERE id = ?");
            $requete->execute([$nouveauNom, $id]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur de modification du nom de la recette : " . $e->getMessage();
            return false;
        }
    }

    public function trouverRecettesParId($id) {
        try {
            //Recherche un personnage en particulier en fonction de l'id
            $requete = $this->bdd->prepare("SELECT * FROM recettes WHERE id = ?");
            $requete->execute([$id]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);

            if ($resultat) {
                return new Recette($resultat['id_categorie'], $resultat['nom'], $resultat['image'], $resultat['difficulte'],$resultat['duree'], $resultat['nb_personnes'], $resultat['texte'],);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche de la recette par ID: " . $e->getMessage();
            return null;
        }
    }

    public function trouverRecettesParNom($nom) {
        try {
            //Recherche un recette en particulier en fonction du nom
            $requete = $this->bdd->prepare("SELECT * FROM recettes WHERE nom = ?");
            $requete->execute([$nom]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);

            if ($resultat) {
                return new Recette($resultat['id_categorie'], $resultat['nom'], $resultat['image'], $resultat['difficulte'],$resultat['duree'], $resultat['nb_personne'], $resultat['texte'],);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche de la recette par ID: " . $e->getMessage();
            return null;
        }
    }
    public function getAffichageDetailsRecette($nom) {
        try {
            $query = "SELECT * FROM recettes WHERE nom = :nom";
            $stmt = $this->bdd->prepare($query);
            $stmt->bindParam(':nom', $nom);
            $stmt->execute();
            
            // Utilisez fetch pour obtenir un tableau associatif des données de la recette
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gérer les erreurs de requête SQL ici
            return false;
        }
    }

    // public function trouverRecettesParIngredient($ingredient) {
    //     try {
    //         //Recherche un personnage en particulier en fonction de l'ingredient
    //         $requete = $this->bdd->prepare("SELECT * FROM recettes WHERE nom = ?");
    //         $requete->execute([$ingredient]);
    //         $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    //         if ($resultat) {
    //             return new Recette($resultat['id_categorie'], $resultat['nom'], $resultat['image'], $resultat['difficulte'],$resultat['duree'], $resultat['nb_personnes'], $resultat['texte'],);
    //         } else {
    //             return null;
    //         }
    //     } catch (PDOException $e) {
    //         echo "Erreur lors de la recherche de la recette par ID: " . $e->getMessage();
    //         return null;
    //     }
    // }
    public function trouverRecettesParCategorie($id_categorie) {
        try {
            //Recherche les recettes en fonction de la catégorie
            $requete = $this->bdd->prepare("SELECT * FROM recettes WHERE id_categorie = ?");
            $requete->execute([$id_categorie]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);

            if ($resultat) {
                return new Recette($resultat['id_categorie'], $resultat['nom'], $resultat['image'], $resultat['difficulte'],$resultat['duree'], $resultat['nb_personnes'], $resultat['texte'],);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche des recettes par la catégorie : " . $e->getMessage();
            return null;
        }
    }

    public function listerRecettes() {
        //Liste des personnage en selectionnant toute la table
        try {
            $requete = $this->bdd->prepare("SELECT * FROM recettes");
            $requete->execute();
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des recettes: " . $e->getMessage();
            return [];
        }
    }

    public function listerRecettesAccueil() {
        //Liste des personnage en selectionnant toute la table
        try {
            $requete = $this->bdd->prepare("SELECT nom, `image`, difficulte FROM recettes");
            $requete->execute();
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur de récupération des recettes: " . $e->getMessage();
            return [];
        }
    }
}
?>