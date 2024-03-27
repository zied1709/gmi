<?php
//include ('navbar.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Must be logged in to access this page
if (!isset($_SESSION["auth"])) {
    header("location: login.php");
    exit();
}
require '..\model\App.php';
$db = App::getDB();
require '..\model\ModelOrderhistory.php';
require "../inc/header.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Order History</title>
    <link rel="stylesheet" href="../css/orderhistory.css">
    <link rel="icon" type="image/png" href="../images/favicon.png" />
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-1">
                <h1>Order History</h1>
            </div>
        </div>
    </div>

    <div class="history">
        <?php

        $rows = ModelOrderhistory::getAll($db, $_SESSION['auth']);

        $ctr = 1;

        // Display each product
        foreach ($rows as $display) {
            echo '<div class="card" style="width: 58%;">';
            echo '<div class="item' . $ctr . '">';
            echo '<table>';
            echo '<tr>';
            echo '<td colspan="2" style="margin-top: 10px;margin-bottom: 10px;float: right!important;margin-left: 20px; font-size: small;">Date: ' . $display["purchasedate"] . '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td rowspan="2"><a href="products.php?code=' . $display["productid"] . '"><img style="margin-left: 16px;" src="../uploads/produits/' . $display["productid"] . '_' . $display["name"] . "/" . $display['image'] . '" height="140px" width="150px""/></a></td>';
            echo '<td><a style="font-size: large;" href="products.php?code=' . $display["productid"] . '">' . $display["name"] . '</a></td>';
            echo '<td class="buttontd" rowspan="2">';
            echo '<a class="button" href="delete_orderhistory.php?id=' . $display["id"] . '">Delete</a>';
            echo '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td style="font-size: larger;" >Quantity: ' . $display["quantity"] . '</td>';
            echo '</tr>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
            $ctr++;
        }

        ?>
    </div>
</body>

</html>

<?php
include('../inc/footer.php');
?>