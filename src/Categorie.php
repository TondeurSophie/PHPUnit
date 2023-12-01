<?php
class Categorie {
    //Variable en private car pas appele en dehors de la class et pas besoin du public 
    private $id;
    private $nom;
   
//Constructeur avec $numero, $difficulte, $nbretoiledebloqueniveau, $nombreetoiledispo
    public function __construct($id,$nom) {
        $this->id = $id;
        $this->nom = $nom;
    }
//Get afin d'obtenir toutes les valeurs de mes objets au fur et a mesure des besoins
//Les get permettent de recuperer des parametres particuliers dans mes objets
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

}
?>