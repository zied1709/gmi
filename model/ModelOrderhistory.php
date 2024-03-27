<?php
class ModelOrderhistory
{
    private $uid;
    private $productid;
    private $quantity;

    public function __construct($uid = null, $productid = null, $quantity = null)
    {
        if (!is_null($productid) && !is_null($uid)) {
            $this->productid = $productid;
            $this->uid = $uid;
            $this->quantity = $quantity;
        }
    }

    public function __get($attr)
    {
        if (!isset($this->attr))
            return "";
        else return ($this->attr);
    }

    public function __set($attr, $value)
    {
        $this->attr = $value;
    }

    public function save($db, $code = null)
    {
        try {

            if ($code == null) { //insertion d’un nouveau user
                $sql = "INSERT INTO order_history (uid, productid, quantity) VALUES (?, ?, ?)";
                $params = array($this->uid, $this->productid, $this->quantity);
                $resultat = $db->execute_query($sql, $params);
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 2300) {
                $message = $e->getMessage();
            }
            return false;
        }
        return true;
    }

    public static function getProductbyCode($db, $code)
    {
        $sql = "SELECT name, price, image FROM produit WHERE code=" . $code;

        $resultat = $db->execute_query($sql);

        if (!$resultat) {
            $erreur = $db->errorInfo();
            echo "Lecture impossible, code", $db->errorCode(), $erreur[2];
        } else {
            return $resultat->fetch(PDO::FETCH_ASSOC);
        }
    }



    public static function getAll($db, $code)
    {
        $sql ="SELECT oh.id, oh.quantity, oh.purchasedate, oh.productid, p.name, p.image 
               FROM order_history oh
               INNER JOIN produit p 
               ON oh.productid = p.code 
               WHERE oh.uid =? 
               ORDER BY oh.purchasedate DESC";

        $params = array($code);
        $resultat = $db->execute_query($sql, $params);

        if (!$resultat) {
            $erreur = $db->errorInfo();
            echo "Lecture impossible, code", $db->errorCode(), $erreur[2];
        } else {
            return $resultat->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public static function delete($db, $code)
    {
        try {
            $req = "DELETE FROM order_history WHERE id=" . $code;

            $db->execute_query($req);
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }
}
