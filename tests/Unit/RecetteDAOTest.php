<?php

use PHPUnit\Framework\TestCase;

// require_once ("./src/Categorie.php");
require_once ("./src/recetteDAO.php");

class RecetteDAOTest extends TestCase{
    private $pdo;
    private $recette;

    //pour BDD
    protected function setUp(): void{
        $this->configureBDD();
        $this->recette = new RecetteDAO($this->pdo);
    }

    private function configureBDD(): void{
        $this->pdo = new PDO(
            sprintf(
                'mysql:host=%s;port=%s;dbname=%s',
                getenv('DB_HOST'),
                getenv('DB_PORT'),
                getenv('DB_DATABASE')
            ),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD')
        );

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    
    /**
     * @dataProvider Provider
     */
    public function testRecettes($fonction,$expected,$id,$id_categorie,$nom, $image, $difficulte, $duree, $nb_personne, $texte){
        if($fonction == "trouverParId"){
            if($id == "" || is_string($id)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("Id invalide");
            }
            $recettes=$this->recette->trouverRecettesParId($id);

            $this->assertInstanceOf(Recette::class,$recettes);
            $this->assertEquals($expected,$id);
        }
        if($fonction == "trouverParNom"){
            if($nom == "" || is_int($nom)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("nom invalide");
            }
            $recettes=$this->recette->trouverRecettesParNom($nom);
            var_dump(gettype($recettes));
            $this->assertInstanceOf(Recette::class,$recettes);
            $this->assertEquals($expected,$nom);
        }
        if($fonction == "trouverParCategorie"){
            if($id_categorie == "" || is_string($id_categorie)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("id_categorie invalide");
            }
            $recettes=$this->recette->trouverRecettesParCategorie($id_categorie);

            $this->assertInstanceOf(Recette::class,$recettes);
            $this->assertEquals($expected,$id_categorie);
        }
        else if($fonction == "ajouter"){
            $recettes=new Recette($id_categorie,$nom, $image, $difficulte, $duree, $nb_personne, $texte);
            // var_dump($recettes);
            if($nom == "" || is_string($id_categorie)  || $image==""||$difficulte=="" ||$duree==""||is_string($nb_personne)||$texte==""){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("champs invalide");
                throw new InvalidArgumentException("champs invalide");
            }
            else if(preg_match('/\s/',$recettes->getNom()) ||preg_match('/\s/',$recettes->getImage()) || preg_match('/\s/',$recettes->getDifficulte()) ||preg_match('/\s/',$recettes->getDuree()) ){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("champs invalide");
            }
            else if(preg_match('/[0-9]/',$recettes->getNom()) || preg_match('/[0-9]/',$recettes->getDifficulte())){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("champs invalide");
            }
            $this->recette->ajouterRecette($recettes);
            $stmt = $this->pdo->prepare("SELECT * FROM recettes WHERE nom = :nom");
            $stmt->bindParam(":nom",$nom);
            $recettes=$stmt->fetch(PDO::FETCH_ASSOC);
            $this->assertEquals($expected,$nom);
        }
        else if($fonction == "supprimer"){
             if(is_string($id)||$nom == ""){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("erreur de format des informations");
                throw new InvalidArgumentException("erreur de format des informations");
            }
            $recettes=new Recette($id_categorie,$nom, $image, $difficulte, $duree, $nb_personne, $texte);
            $recettes->setNom($nom);
            var_dump($recettes);
            $this->recette->supprimerRecette($recettes);
            $stmt = $this->pdo->prepare("SELECT * FROM recettes WHERE nom = :nom");
            $stmt->bindParam(":nom",$nom);
            $recettes=$stmt->fetch(PDO::FETCH_ASSOC);
            $this->assertFalse($recettes);
            
        }
        else if($fonction == "modifier"){
            if($id == "" || $nom == "" || is_string($id) || is_int($nom) || preg_match('/[0-9]/',$nom)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("ne correspond pas aux attentes");
            }
            $this->recette->modifierNomRecette($id,$nom);
            $stmt=$this->pdo->prepare("SELECT * FROM recettes WHERE id = :id");
            $stmt->bindParam(":id",$id);
            $recettes=$stmt->fetch(PDO::FETCH_ASSOC);
            // var_dump($recettes);
            $this->assertEquals($expected,$nom);
        }
        
    }

    public static function Provider(){
        return[
            ["trouverParId",1,1,"","","","","","",""],
            ["trouverParId","","","","","","","","",""],
            ["trouverParId",1,"1","","","","","","",""],
            ["trouverParId","","bonjour","","","","","","",""],
            ["trouverParId","1",1,"","","","","","",""],

            ["trouverParNom","Salade de fruits","",3,"Salade de fruits","","","","",""],
            ["trouverParNom","","","","","","","","",""],
            ["trouverParNom","","","bonjour","","","","","",""],
            ["trouverParNom",1,3,"",1,"","","","",""],

            ["trouverParCategorie",1,"",1,"","","","","",""],
            ["trouverParCategorie","1","","1","","","","","",""],
            ["trouverParCategorie","bonjour","","bonjour","","","","","",""],
            ["trouverParCategorie","1","","1","","","","","",""],


            // ["ajouter","coucou","",3,"coucou","img","Facile","10min",7,"sdfgh."],
            ["ajouter"," ","",3," "," "," "," ",7,"sdfgh."],
            ["ajouter","","","","","","","","",""],
            ["ajouter","123","",3,"123","img","3","10min",7,"sdfgh."],
            

            ["supprimer","",6,"","coucou","img","Facile","10min",7,"sdfgh."],
            ["supprimer","","","","","","","","",""],
            // ["supprimer","","29",""],
            // ["supprimer","",29,"qsdfrgt"],

            ["modifier","test",4,3,"test","img","Facile","10min",7,"sdfgh."],
            ["modifier","","","","","","","","",""],
            ["modifier","test bis",4,3,"test bis","","","","",""],
            ["modifier","test","4","3","test","","","","",""],
            ["modifier","123",4,3,"123","","","","",""],
        ];
    }


}


?>