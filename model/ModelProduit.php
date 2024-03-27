<?php
class ModelProduit{
    private $name;
    private $description;
    private $price;
    private $categorie;
    private $image;
    private $image2;
    private $image3;
    private $image4;
    private $name2;


    public function __construct($name=null, $price=null, $image=null, $categorie=null, $description=null, $image2=null, $image3=null, $image4=null){
        if (!is_null($name) && !is_null($price) && !is_null($image) && !is_null($categorie) && !is_null($description)) {
            $this->name = $name; 
            $this->price = $price;
            $this->image = $image;
            $this->categorie = $categorie;
            $this->description = $description; 
            $this->image2 = $image2; 
            $this->image3 = $image3; 
            $this->image4 = $image4;
            $this->name2 = $name;
        }
    }
    
    public function __get($attr){
        if (!isset($this->attr))
            return "";
        else return ($this->attr);
    }
    
    public function __set($attr,$value) {
        $this->attr = $value; 
    }

    public function save($db,$code=null){
        try{

            if($code==null){ //insertion d’un nouveau produit
                $sql = "INSERT INTO produit(name, price, image, code_categorie , description , image2 , image3 , image4 , name2 ) VALUES (?,?,?,?,?,?,?,?,?)";
                $params = array($this->name,$this->price, $this->image, $this->categorie , $this->description , $this->image2 , $this->image3 , $this->image4 , $this->name2);
                $resultat = $db->execute_query($sql, $params);
            }

            else{//MAJ d’un produit existant

                $sql = "UPDATE produit 
                        SET name=:name, 
                            price=:price, 
                            image=:image, 
                            code_categorie=:categorie,
                            description=:description, 
                            image2=:image2, 
                            image3=:image3, 
                            image4=:image4,
                            name2=:name2

                        WHERE code=:code";

                $params = array(
                            'name'=>$this->name, 
                            'price'=>$this->price, 
                            'image'=>$this->image, 
                            'categorie'=>$this->categorie, 
                            'description'=>$this->description, 
                            'image2'=>$this->image2, 
                            'image3'=>$this->image3, 
                            'image4'=>$this->image4,
                            'name2'=>$this->name2,  

                            'code'=>$code
                        );

                $resultat = $db->execute_query($sql,$params);
            }

        }catch(PDOException $e ){
            if ($e->getCode() == 2300){
                $message=$e->getMessage();
            }
            return false;
        }
        return true;
    }

    public static function getAll($db){
        $sql = "SELECT produit.code, produit.name, produit.price, produit.image, produit.description, produit.is_deleted , categorie.name as categorie
                FROM produit
                LEFT JOIN categorie
                ON code_categorie = categorie.code
                WHERE produit.is_deleted = 0
                ORDER BY code desc";
                
        $resultat = $db->execute_query($sql);

        if(!$resultat) {
            $erreur=$db->errorInfo();
            echo "Lecture impossible, code", $db->errorCode(),$erreur[2];
        }
        
        else{
            return $resultat->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public static function getCategoriebyCode($db, $code){
        $sql = "SELECT produit.code, categorie.name as categorie
                FROM produit
                LEFT JOIN categorie
                ON code_categorie = categorie.code
                where produit.code=?";
        $params = array($code);
        $resultat = $db->execute_query($sql,$params);

        if(!$resultat) {
            $erreur=$db->errorInfo();
            echo "Lecture impossible, code", $db->errorCode(),$erreur[2];
        }
        
        else{
            return $resultat->fetch(PDO::FETCH_OBJ);
        }
    }

    public static function product_get_last($db) {
        $sql = 'select * from produit order by code desc limit 1';
    
        $resultat = $db->execute_query($sql);
    
        return $resultat->fetch(PDO::FETCH_OBJ);
    }

    public static function getbyCode($db,$code){
        $sql = "SELECT * FROM produit where code=?";
        $params = array($code);
        $resultat = $db->execute_query($sql,$params);

        if(!$resultat) {
            $erreur=$db->errorInfo();
            echo "Lecture impossible, code", $db->errorCode(),$erreur[2];
        }

        else{
            return $resultat->fetch(PDO::FETCH_OBJ);
        }
    }

    public static function getImagebyCode($db,$code){
        $sql = "SELECT image FROM produit where code=?";
        $params = array($code);
        $resultat = $db->execute_query($sql,$params);

        if(!$resultat) {
            $erreur=$db->errorInfo();
            echo "Lecture impossible, code", $db->errorCode(),$erreur[2];
        }

        else{
            return $resultat->fetch(PDO::FETCH_OBJ);
        }
    }

    public static function delete($db, $code){
        try{
            $req = "UPDATE produit 
                    SET is_deleted = '1'
                    WHERE code=" .$code;
            $db->execute_query($req);
        }
        catch(PDOException $e ){
            return false;
        }
        return true;
    }

    
}

