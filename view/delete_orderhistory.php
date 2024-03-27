<?php

require '..\model\App.php';
$db = App::getDB();
require '..\model\ModelOrderhistory.php';
// Empty PHP page that will automatically delete an entry from the Orders History table
session_start();
// Must be logged in to access this page
if (!isset($_SESSION["auth"])) {
    header("location: login.php");
    exit();
}

// Must have an order id to remove
if (!isset($_GET['id'])) {
    header("location: orderhistory.php");
    exit();
} else {
    ModelOrderhistory::delete($db, $_GET['id']);
    header("location: orderhistory.php");
    exit();
}