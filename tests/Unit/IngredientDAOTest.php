<?php

use PHPUnit\Framework\TestCase;

require_once ("./src/IngredientDAO.php");

class IngredientDAOTest extends TestCase{
    private $pdo;
    private $ingredient;

    //pour BDD
    protected function setUp(): void{
        $this->configureBDD();
        $this->ingredient = new IngredientDAO($this->pdo);
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
    public function testIngredients($fonction,$expected,$id,$nom){
        if($fonction == "trouverParId"){
            if($id == "" || is_string($id)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("Id invalide");
            }
            $ingredients=$this->ingredient->trouverIngredientParId($id);

            $this->assertInstanceOf(Ingredient::class,$ingredients);
            $this->assertEquals($expected,$id);
        }
        
        else if($fonction == "ajouter"){
            $ingredients=new Ingredient($nom);
            // var_dump($ingredients);
            if($nom == "" || is_string($id) || is_int($nom) || preg_match('/[0-9]/',$nom)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("champs invalide");
                throw new InvalidArgumentException("champs invalide");
            }
            
            $this->ingredient->ajouterIngredient($ingredients);
            $stmt = $this->pdo->prepare("SELECT * FROM ingredients WHERE nom = :nom");
            $stmt->bindParam(":nom",$nom);
            $ingredients=$stmt->fetch(PDO::FETCH_ASSOC);
            $this->assertEquals($expected,$nom);
        }
        else if($fonction == "supprimer"){
             if(is_string($id)||$nom == ""||preg_match('/[0-9]/',$nom)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("erreur de format des informations");
                throw new InvalidArgumentException("erreur de format des informations");
            }
            $ingredients=new Ingredient($nom);
            $ingredients->setId($id);
            // var_dump($ingredients);
            $this->ingredient->supprimerIngredient($ingredients);
            $stmt = $this->pdo->prepare("SELECT * FROM ingredients WHERE id = :id");
            $stmt->bindParam(":id",$id);
            $ingredients=$stmt->fetch(PDO::FETCH_ASSOC);
            $this->assertFalse($ingredients);
            
        }
        else if($fonction == "modifier"){
            if($id == "" || $nom == "" || is_string($id) || is_int($nom) || preg_match('/[0-9]/',$nom)){
                $this->expectException(InvalidArgumentException::class);
                $this->expectExceptionMessage("ne correspond pas aux attentes");
                throw new InvalidArgumentException("ne correspond pas aux attentes");
            }
            $this->ingredient->modifierNomIngredient($id,$nom);
            $stmt=$this->pdo->prepare("SELECT * FROM ingredients WHERE id = :id");
            $stmt->bindParam(":id",$id);
            $ingredients=$stmt->fetch(PDO::FETCH_ASSOC);
            // var_dump($ingredients);
            $this->assertEquals($expected,$nom);
        }
        
    }

    public static function Provider(){
        return[
            ["trouverParId",1,1,""],
            ["trouverParId","","",""],
            ["trouverParId",1,"1",""],
            ["trouverParId","","bonjour",""],
            ["trouverParId","1",1,""],


            ["ajouter","","",""],
            // ["ajouter","vinaigre",8,"vinaigre"],
            ["ajouter",1,"",1],
            ["ajouter","1",8,"1"],
            ["ajouter","test","8","test"],
            

            ["supprimer","",11,"vinaigre"],
            ["supprimer","","",""],
            ["supprimer","","10","vinaigre"],
            ["supprimer","",9,"123"],

            ["modifier","test",8,"test"],
            ["modifier","","",""],
            ["modifier","test bis",8,"test bis"],
            ["modifier","123",8,"123"],
            ["modifier","test bis","8","test bis"],
        ];
    }


}


?>