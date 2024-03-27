<?php
require_once('../model/ModelCategorie.php'); // chargement du modèle
require '..\model\App.php';
$db = App::getDB();

class ControllerProduit
{
    public static function getAll()
    {
        $produits = ModelCategorie::getAllCategorie();
    }
}
