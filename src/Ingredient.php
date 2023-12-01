<?php
class Ingredient {
    //Variable en private car pas appele en dehors de la class et pas besoin du public 
    private $id;
    private $nom;
    private $quantite;
//Constructeur avec $numero, $difficulte, $nbretoiledebloqueniveau, $nombreetoiledispo
    public function __construct($nom) {
        $this->nom = $nom;
        // $this->quantite = $quantite;

    }
//Get afin d'obtenir toutes les valeurs de mes objets au fur et a mesure des besoins
//Les get permettent de recuperer des parametres particuliers dans mes objets
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getQuantite() {
        return $this->quantite;
    }
    public function setId($id){
        $this->id=$id;
    }
}
?>