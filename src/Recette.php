<?php
//Creation de la class personnage
class Recette {
    //Variable en private car pas appele en dehors de la class et pas besoin du public 
    private $id;
    private $id_categorie;
    private $nom;
    private $image;
    private $difficulte;
    private $duree;
    private $nb_personnes;
    private $texte;
//Constructeur avec $nom, $niveau, $etoile de defini
    public function __construct($id_categorie,$nom, $image, $difficulte, $duree, $nb_personne, $texte) {
        $this->id_categorie = $id_categorie;
        $this->nom = $nom;
        $this->image = $image;
        $this->difficulte = $difficulte;
        $this->duree = $duree;
        $this->nb_personnes = $nb_personne;
        $this->texte = $texte;
    }
//Get afin d'obtenir toutes les valeurs de mes objets au fur et a mesure des besoins
    public function getId() {
        return $this->id;
    }
    public function getIdCategorie() {
        return $this->id_categorie;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getImage() {
        return $this->image;
    }

    public function getDifficulte() {
        return $this->difficulte;
    }
    public function getDuree() {
        return $this->duree;
    }
    public function getNbPersonnes() {
        return $this->nb_personnes;
    }
    public function getTexte() {
        return $this->texte;
    }

    public function setId($id){
        $this->id=$id;
    }
    public function setNom($nom){
        $this->nom=$nom;
    }
}

?>