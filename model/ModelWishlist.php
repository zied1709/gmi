<?php
class ModelWishlist
{
    private $uid;
    private $productid;
    private $dateadded;

    public function __construct($uid = null,$productid = null)
    {
        if (!is_null($productid) && !is_null($uid)) {
            $this->productid = $productid;
            $this->uid = $uid;
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
                $sql = "INSERT INTO wishlist(uid, productid) VALUES (?, ?)";
                $params = array($this->uid ,$this->productid);
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

    public static function getAll($db, $code)
    {
        $sql =
            "SELECT w.id, w.productid, w.dateadded, p.name, p.image FROM wishlist w
            INNER JOIN produit p 
            ON w.productid = p.code 
            WHERE w.uid =? 
            ORDER BY w.dateadded DESC";

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
            $req = "DELETE FROM wishlist WHERE id=" . $code;

            $db->execute_query($req);
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }
}
