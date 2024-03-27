<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Must be logged in to access this page
if (!isset($_SESSION["auth"])) {
    header("location: login.php");
    exit();
}
?>

<?php
require '..\model\App.php';
$db = App::getDB();
require '..\model\ModelWishlist.php';
include('../inc/header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Wishlist</title>
    <link rel="stylesheet" href="../css/wishlist.css">
    <link rel="icon" type="image/png" href="../images/favicon.png" />
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-1">
                <h1>Wishlist</h1>
            </div>
        </div>
    </div>

    <div class="history">
        <?php
            $rows = ModelWishlist::getAll($db,$_SESSION['auth']);
            $ctr = 1;
            // Display each product
            foreach ($rows as $display) {
                echo '<div class="card" style="width: 58%;">';
                echo '<div class="item' . $ctr . '">';
                echo '<table>';
                echo '<tr>';
                echo '<td colspan="2" style="margin-top: 10px;margin-bottom: 10px;float: right!important;margin-left: 20px; font-size: small;">Date: ' . $display["dateadded"] . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td rowspan="2"><a href="products.php?code=' . $display["productid"] . '"><img style="margin-left: 16px;" src="../uploads/produits/' . $display["productid"] . '_' . $display["name"] . "/" . $display['image'] . '" height="140px" width="150px""/></a></td>';
                
                
                echo '<td class="buttontd" rowspan="2">';
                echo '<a class="button" href="delete_wishlist.php?id=' . $display["id"] . '">Delete</a>';
                echo '</td>';

                echo '<td><a style="font-size: medium;" href="products.php?code=' . $display["productid"] . '">' . $display["name"] . '</a></td>';
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
include ('../inc/footer.php');
?>