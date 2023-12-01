<?php
class RecetteDAO {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function ajouterRecette(Recette $recette) {
        // var_dump($recette);
        // if($recette->getNom() == "" || is_string($recette->getIdCategorie()) || $recette->getImage()==""||$recette->getDifficulte()=="" ||$recette->getDuree()==""||is_string($recette->getNbPersonnes())||$recette->getTexte()==""){
        //     throw new InvalidArgumentException("champs invalide");
        // }else if(preg_match('/\s/',$recette->getNom()) ||preg_match('/\s/',$recette->getImage()) || preg_match('/\s/',$recette->getDifficulte()) ||preg_match('/\s/',$recette->getDuree())){
        //     throw new InvalidArgumentException("champs invalide");
        // }else if(preg_match('/[0-9]/',$recette->getNom()) || preg_match('/[0-9]/',$recette->getDifficulte())){
        //     throw new InvalidArgumentException("champs invalide");
        // }
        //Ajout du personnage
        try {
            $requete = $this->bdd->prepare("INSERT INTO recettes (id_categorie, nom, `image`, difficulte, duree, nb_personne, texte) VALUES (?, ?, ?,?,?,?,?)");
            $requete->execute([$recette->getIdCategorie(),$recette->getNom(), $recette->getImage(), $recette->getDifficulte(),$recette->getDuree(),$recette->getNbPersonnes(),$recette->getTexte()]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur d'ajout de recette : " . $e->getMessage();
            return false;
        }

    }

    public function supprimerRecette(Recette $recettes) {
        if(is_string($recettes->getId())||$recettes->getNom() == ""){
            throw new InvalidArgumentException("erreur de format des informations");
        }
        echo $recettes->getId();
        try {
            $requete = $this->bdd->prepare("DELETE FROM recettes WHERE nom = ?");
            //Exécution de la requête avec les valeurs de l'objet recette
            $requete->execute([$recettes->getNom()]);
            // $requete->bindParam(":id", $recettes->getId());
            // $requete->execute();
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
        if($id == "" || $nouveauNom == "" || is_string($id) || is_int($nouveauNom)  || preg_match('/[0-9]/',$nouveauNom)){
            throw new InvalidArgumentException("ne correspond pas aux attentes");
        }
        try {
            // var_dump($id);
            $requete = $this->bdd->prepare("UPDATE recettes SET nom = ? WHERE id = ?");
            $requete->execute([$nouveauNom, $id]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur de modification du nom de la recette : " . $e->getMessage();
            return false;
        }
    }

    public function trouverRecettesParId($id) {
        if($id == "" || is_string($id)){
            throw new InvalidArgumentException("Id invalide");
        }
        try {
            //Recherche un personnage en particulier en fonction de l'id
            $requete = $this->bdd->prepare("SELECT * FROM recettes WHERE id = ?");
            $requete->execute([$id]);
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

    public function trouverRecettesParNom($nom) {
        if($nom == "" || is_int($nom)){
            throw new InvalidArgumentException("nom invalide");
        }
        try {
            // Recherche une recette en particulier en fonction du nom
            $requete = $this->bdd->prepare("SELECT * FROM recettes WHERE LOWER(nom) LIKE LOWER(:nom)");
            $requete->execute([':nom' => "%$nom%"]);
            $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
    
            $recettes = [];
            
            foreach ($resultats as $resultat) {
                $recettes[] = new Recette(
                    $resultat['id_categorie'],
                    $resultat['nom'],
                    $resultat['image'],
                    $resultat['difficulte'],
                    $resultat['duree'],
                    $resultat['nb_personne'],
                    $resultat['texte']
                );
            }
    
            return $recettes;
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche de la recette par nom: " . $e->getMessage();
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
        if($id_categorie == "" || is_string($id_categorie)){
            throw new InvalidArgumentException("id_categorie invalide");
        }
        try {
            //Recherche les recettes en fonction de la categorie
            $requete = $this->bdd->prepare("SELECT * FROM recettes WHERE id_categorie = ?");
            $requete->execute([$id_categorie]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);

            if ($resultat) {
                return new Recette($resultat['id_categorie'], $resultat['nom'], $resultat['image'], $resultat['difficulte'],$resultat['duree'], $resultat['nb_personne'], $resultat['texte'],);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche des recettes par la categorie : " . $e->getMessage();
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

    public function trouverRecettesCategorie($categorieNom) {
    
        try {
            $requete = $this->bdd->prepare("
                SELECT id, nom, image, difficulte, duree, nb_personne, texte
                FROM recettes
                WHERE id_categorie = (
                    SELECT id
                    FROM categories
                    WHERE nom = ?
                )
            ");
            $requete->execute([$categorieNom]);
            $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
    
            $recettes = [];
            foreach ($resultats as $resultat) {
                $recettes[] = new Recette(
                    $resultat['id'],
                    $resultat['nom'],
                    $resultat['image'],
                    $resultat['difficulte'],
                    $resultat['duree'],
                    $resultat['nb_personne'],
                    $resultat['texte']
                );
            }
    
            return $recettes;
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche de recettes par catégorie: " . $e->getMessage();
            return [];
        }
    }

    

    public function ajouterRecetteIngredient($idRecette, $idIngredient, $quantite) {
        try {
            $requete = $this->bdd->prepare("INSERT INTO recette_ingredient (id_recette, id_ingredient, quantite) VALUES (?, ?, ?)");
            $requete->execute([$idRecette, $idIngredient, $quantite]);
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de la relation recette-ingredient: " . $e->getMessage();
        }
    }
    public function trouverDernierId() {
        try {
            $requete = $this->bdd->prepare("SELECT MAX(id) AS dernier_id FROM recettes");
            $requete->execute();
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);
    
            if ($resultat && isset($resultat['dernier_id'])) {
                return $resultat['dernier_id'];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du dernier ID : " . $e->getMessage();
            return null;
        }
    }

    public function ajouterRelationIngredientRecette($nomIngredient, $quantite, $idRecette) {
        try {
            // Récupérer l'ID de l'ingrédient s'il existe
            $idIngredient = $this->trouverIdIngredientParNom($nomIngredient);
    
            if ($idIngredient === null) {
                // Si l'ingrédient n'existe pas, ajoutez-le à la table des ingrédients
                $idIngredient = $this->ajouterIngredient($nomIngredient);
                if ($idIngredient === null) {
                    // Gérez l'erreur selon vos besoins
                    return false;
                }
            }
    
            $requete = $this->bdd->prepare("INSERT INTO recette_ingredient (id_ingredient, id_recette, quantite) VALUES (?, ?, ?)");
            $requete->execute([$idIngredient, $idRecette, $quantite]);
    
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de la relation recette-ingredient: " . $e->getMessage();
            return false;
        }
    }
    
    public function ajouterIngredient($nomIngredient) {
        try {
            $requete = $this->bdd->prepare("INSERT INTO ingredients (nom) VALUES (?)");
            $requete->execute([$nomIngredient]);
    
            return $this->bdd->lastInsertId();
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'ingrédient: " . $e->getMessage();
            return null;
        }
    }
    
    public function trouverIdIngredientParNom($nomIngredient) {
        try {
            $requete = $this->bdd->prepare("SELECT id FROM ingredients WHERE nom = ?");
            $requete->execute([$nomIngredient]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);
    
            return ($resultat && isset($resultat['id'])) ? $resultat['id'] : null;
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche de l'ID de l'ingrédient: " . $e->getMessage();
            return null;
        }
    }

    public function getIngredientsRecette($nom_recette) {
        try {
            $requete = $this->bdd->prepare("
                SELECT i.nom, ri.quantite
                FROM ingredients i
                JOIN recette_ingredient ri ON i.id = ri.id_ingredient
                JOIN recettes r ON r.id = ri.id_recette
                WHERE r.nom = ?
            ");
            $requete->execute([$nom_recette]);
            $resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

            $ingredients = [];
            foreach ($resultats as $resultat) {
                $ingredients[] = $resultat['nom'] . ' (' . $resultat['quantite'] . ')';
            }

            return $ingredients;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des ingrédients de la recette : " . $e->getMessage();
            return [];
        }
    }
}
?>