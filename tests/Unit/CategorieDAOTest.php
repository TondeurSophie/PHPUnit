<?php

use PHPUnit\Framework\TestCase;

// require_once ("./src/Categorie.php");
require_once ("./src/CategorieDAO.php");

class CategorieDAOTest extends TestCase{
    private $pdo;
    private $categorie;

    //pour BDD
    protected function setUp(): void{
        $this->configureBDD();
        $this->categorie = new CategorieDAO($this->pdo);
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
    public function testCategories($fonction,$expected,$id,$nom){
        if($fonction == "trouver"){
            if($id == "" || is_string($id)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("Id invalide");
            }
            $categories=$this->categorie->trouverCategorieParId($id);

            $this->assertInstanceOf(Categorie::class,$categories);
            $this->assertEquals($expected,$id);
        }
        else if($fonction == "ajouter"){
            $categories=new Categorie($id,$nom);
            if($nom == "" || is_int($nom) || preg_match('/\s/',$nom) || preg_match('/[0-9]/',$nom)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("nom invalide");
                throw new InvalidArgumentException("nom invalide");
            }
            $this->categorie->ajouterCategorie($categories);
            $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE nom = :nom");
            $stmt->bindParam(":nom",$nom);
            $categories=$stmt->fetch(PDO::FETCH_ASSOC);
            // var_dump($categories);
            $this->assertEquals($expected,$nom);
        }
        else if($fonction == "supprimer"){
            if(is_string($id)||$nom != ""){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("erreur de format des informations");
            }
            $categories=new Categorie($id,$nom);
            $this->categorie->supprimerCategorie($categories);
            $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = :id");
            $stmt->bindParam(":id",$id);
            $categories=$stmt->fetch(PDO::FETCH_ASSOC);
            // var_dump($categories);
            $this->assertFalse($categories);
            
        }
        else if($fonction == "modifier"){
            if($id == "" || $nom == "" || is_string($id) || is_int($nom) ||preg_match('/\s/',$nom) || preg_match('/[0-9]/',$nom)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("ne correspond pas aux attentes");
            }
            $this->categorie->modifierCategorie($id,$nom);
            $stmt=$this->pdo->prepare("SELECT * FROM categories WHERE id = :id");
            $stmt->bindParam(":id",$id);
            $categories=$stmt->fetch(PDO::FETCH_ASSOC);
            // var_dump($categories);
            $this->assertEquals($expected,$nom);
        }
        
    }

    public static function Provider(){
        return[
            ["trouver",1,1,""],
            ["trouver","","",""],
            ["trouver",1,"bonjour",""],
            ["trouver","","bonjour",""],
            ["trouver","1",1,""],

            // ["ajouter","coucou","","coucou"],
            ["ajouter",1,"",1],
            ["ajouter","","",""],
            ["ajouter"," ",""," "],
            ["ajouter"," dv fg ",""," dv fg "],
            ["ajouter","13","","13"],

            ["supprimer","",29,""],
            ["supprimer","","",""],
            ["supprimer","","29",""],
            ["supprimer","",29,"qsdfrgt"],

            ["modifier","test",26,"test"],
            ["modifier","","",""],
            ["modifier","","1",""],
            ["modifier","",1,2],
            ["modifier"," ",1," "],
            ["modifier","1234",1,"1234"],
        ];
    }


}


?>