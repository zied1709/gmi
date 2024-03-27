<?php
class ModelUser{
    private $first_name	;
    private $last_name;
    private $image;
    private $email;
    private $password;
    private $telephone;
    private $admin;

    public function __construct($last_name=null, $image=null, $first_name=null, $email=null, $password=null,$telephone=null , $admin=null){
        if (!is_null($last_name) && !is_null($first_name) && !is_null($email) && !is_null($password)) {
            $this->last_name = $last_name;
            $this->image = $image;
            $this->first_name= $first_name; 
            $this->email = $email; 
            $this->password = $password; 
            $this->telephone = $telephone; 
            $this->admin = $admin; 

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

            if($code==null){ //insertion d’un nouveau user
                $sql = "INSERT INTO user(last_name, image, first_name, email , password , telephone , admin) VALUES (?,?,?,?,?,?,?)";
                $params = array($this->last_name, $this->image,$this->first_name, $this->email , $this->password , $this->telephone , $this->admin );
                $resultat = $db->execute_query($sql, $params);
            }

            else{//MAJ d’un user existant

                $sql = "UPDATE user 
                        SET last_name=:last_name, 
                            image=:image, 
                            first_name=:first_name, 
                            email=:email, 
                            password=:password,
                            telephone=:telephone,
                            admin=:admin

                        WHERE id=:id";

                $params = array(
                            'last_name'=>$this->last_name, 
                            'image'=>$this->image, 
                            'first_name'=>$this->first_name, 
                            'email'=>$this->email, 
                            'password'=>$this->password,
                            'telephone'=>$this->telephone,
                            'admin'=>$this->admin,
                            'id'=>$code);

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
                FROM user
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

    public static function getAllAdmin($db){
        $sql = "SELECT *
                FROM user
                WHERE is_deleted = 0 AND admin = 1";

        $resultat = $db->execute_query($sql);

        if(!$resultat) {
            $erreur=$db->errorInfo();
            echo "Lecture impossible, code", $db->errorCode(),$erreur[2];
        }
        
        else{
            return $resultat->fetchAll(PDO::FETCH_OBJ);
        }
    }

    public static function getAllUser($db){
        $sql = "SELECT *
                FROM user
                WHERE is_deleted = 0 AND admin = 0";

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
        $sql = "SELECT * FROM user where id=?";
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

    public static function getNamebyCode($db,$code){
        $sql = "SELECT first_name, last_name FROM user where id=?";
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

    public static function getbyEmail($db,$email){
        $sql = "SELECT id, email, password , admin FROM user WHERE email = ?";
        $params = array($email);
        $resultat = $db->execute_query($sql,$params);

        if(!$resultat) {
            $erreur=$db->errorInfo();
            echo "Lecture impossible, code", $db->errorCode(),$erreur[2];
            return null;
        }

        else{
            return $resultat->fetch(PDO::FETCH_OBJ);
        }
    }

    public static function delete($db, $code){
        try{
            $req = "UPDATE user 
                    SET is_deleted = '1'
                    WHERE id=" .$code;
            $db->execute_query($req);
        }
        catch(PDOException $e ){
            return false;
        }
        return true;
    }

    
}

