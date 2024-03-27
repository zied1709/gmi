<?php
session_start();
//setcookie('username', NULL,-1);
//setcookie('password', NULL,-1);

unset($_SESSION['auth']);
unset($_SESSION['admin']);
if (isset($_SESSION['cart_item'])) {
    unset($_SESSION['cart_item']);
}

$_SESSION['flash']['success'] = "Vous etes maintenant déconnecté";

header('Location: login.php');
