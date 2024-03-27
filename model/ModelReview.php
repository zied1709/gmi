<?php
class ModelReview
{
    private $product_id;
    private $name;
    private $content;
    private $rating;

    public function __construct($product_id = null, $name = null, $content = null, $rating = null)
    {
        if (!is_null($product_id) && !is_null($name) && !is_null($content) && !is_null($rating)) {
            $this->product_id = $product_id;
            $this->name = $name;
            $this->content = $content;
            $this->rating = $rating;
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

    public function save($db)
    {
        try {
            $sql ='INSERT INTO reviews (product_id, name, content, rating, submit_date) VALUES (?,?,?,?,NOW())';
            $params = array($this->product_id, $this->name, $this->content, $this->rating);
            $resultat = $db->execute_query($sql, $params);

        } catch (PDOException $e) {
            if ($e->getCode() == 2300) {
                $message = $e->getMessage();
            }
            return false;
        }
        return true;
    }

    public static function getbyProductId($db, $product_id)
    {
        $sql = "SELECT * FROM reviews WHERE product_id = ? ORDER BY submit_date DESC";
        $params = array($product_id);
        $resultat = $db->execute_query($sql, $params);

        if (!$resultat) {
            $erreur = $db->errorInfo();
            echo "Lecture impossible, code", $db->errorCode(), $erreur[2];
        } else {
            return $resultat->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public static function getRating($db, $product_id)
    {
        $sql = "SELECT AVG(rating) AS overall_rating, COUNT(*) AS total_reviews FROM reviews WHERE product_id = ?";
        $params = array($product_id);
        $resultat = $db->execute_query($sql, $params);

        if (!$resultat) {
            $erreur = $db->errorInfo();
            echo "Lecture impossible, code", $db->errorCode(), $erreur[2];
        } else {
            return $resultat->fetch(PDO::FETCH_ASSOC);
        }
    }
}
