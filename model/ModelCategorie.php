<?php
class ModelCategorie{
    private $name;

    public function __construct($name=null){
        if (!is_null($name)) {
            $this->name = $name; 
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

            if($code==null){ //insertion d’un nouveau categorie
                $sql = "INSERT INTO categorie(name) VALUES (?)";
                $params = array($this->name);
                $resultat = $db->execute_query($sql, $params);
            }

            else{//MAJ d’un categorie existant

                $sql = "UPDATE categorie 
                        SET name=:name

                        WHERE code=:code";

                $params = array(
                            'name'=>$this->name, 

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
        $sql = "SELECT * 
                FROM categorie
                WHERE is_deleted = 0";

        $resultat = $db->execute_query($sql);

        if(!$resultat) {
            $erreur=$db->errorInfo();
            echo "Lecture impossible, code", $db->errorCode(),$erreur[2];
        }
        
        else{
            return $resultat->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public static function getbyCode($db,$code){
        $sql = "SELECT * FROM categorie where code=?";
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

    public static function getDistinctName($db){
        $sql = "SELECT DISTINCT(name) , code FROM categorie WHERE is_deleted = '0'";
        $resultat = $db->execute_query($sql);

        if(!$resultat) {
            $erreur=$db->errorInfo();
            echo "Lecture impossible, code", $db->errorCode(),$erreur[2];
        }

        else{
            return $resultat->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public static function getAllCategorie(){
        $sql = "SELECT * 
                FROM categorie
                WHERE is_deleted = 0";        
    }

    public static function delete($db, $code){
        try{
            $req = "UPDATE categorie 
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

