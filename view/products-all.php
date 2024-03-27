<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require('..\model\App.php');
$db = App::getDB();
require '..\model\ModelProduit.php';


// Vider la carte si le temps est passer
if (isset($_SESSION['cart_item']) && isset($_COOKIE['empty'])) {
    if ($_COOKIE['empty'] == 1) {
      unset($_SESSION['cart_item']);
      setcookie('empty', 0, time() + (86400 * 30), "/"); // 86400 = 1 day
    }
  }
?>

<?php
// conserver la valeur de quantite dans un session
if (isset($_SESSION['cart_item'])) {
  
  foreach ($_SESSION['cart_item'] as $cartid => $cart) {

    if (isset($_COOKIE[$cartid])) {
      $_SESSION['cart_item'][$cartid]['quantity'] = $_COOKIE[$cartid];
    }
  }
}
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";


// Add to cart work
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['code']) && isset($_SESSION["auth"])) {
    if (isset($_POST['wishadded'])) {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=gmi", 'root', '');
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = $conn->prepare('INSERT INTO wishlist (uid, productid) VALUES (?, ?)');
            $sql->execute([$_SESSION['auth'], $_GET['code']]);
            echo "New record created successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die(); // Kill the page if database is not working
        }
        $conn = null; // Close connection
        header('Location: wishlist.php'); // redirect to 'wishlist' page
        exit;
    } else if (isset($_POST['quantity'])) {
        $conn = new PDO("mysql:host=$servername;dbname=gmi", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Prepared statement to fetch the cart info needed for the session
        $stmt = $conn->prepare("SELECT name, price, image FROM produit WHERE code=" . $_GET['code']);
        $stmt->execute();
        $cart_array = $stmt->fetch();

        // Item array hold the DB fields
        $item_array = [
            'name' => $cart_array['name'],
            'price' => $cart_array['price'],
            'image' => $cart_array['image'],
            'quantity' => $_POST['quantity']
        ];

        // If there is a cart_item session variable
        if (!empty($_SESSION["cart_item"])) {
            // Check if there's a preexisting one for the item (adds to the quantity)
            if (in_array($_GET['code'], array_keys($_SESSION["cart_item"]))) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    // If a matching id is found, add to quantity
                    if ($_GET['code'] == $k) {
                        if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                            $_SESSION["cart_item"][$k]["quantity"] = 0;
                        }
                        $_SESSION["cart_item"][$k]["quantity"] += $item_array["quantity"];
                    }
                }
            } else {
                $_SESSION["cart_item"][$_GET['code']] = $item_array; // Add the new item to the cart
            }
        } else {
            $_SESSION["cart_item"][$_GET['code']] = $item_array; // Add the new item to the cart
        }

        // Cart item added to session, go to cart page.
        header("Location: cart.php");
        exit;
    } else {
        header("Location: products.php");
        exit;
    }
}
require '..\inc\header.php';

?>




<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="reviews.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>

</head>


<body>
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <h1 class="page-name">Products</h1>
                        <ol class="breadcrumb">
                            <li><a href="">Home</a></li>
                            <li class="active">Products</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if (!isset($_GET['code'])) : ?>
        <!--Listed Products-->

        <!--First Row-->

        <div class="small-container">
            <h2 class="title">Featured Products</h2>
            <div class="row">
                <?php
                try {

                    $rows = ModelProduit::getAll($db);

                    // Display each product
                    foreach ($rows as $row) {
                        echo '<div class="col-4">';
                        echo "<a href='products.php?code=" . $row->code . "'>";
                        echo '<img src="uploads/produits/' . $row->code . '_' . $row->name . "/" . $row->image . '">';
                        echo '</a>';
                        echo '<h4>' . $row->name . '</h4>';
                        echo '<p>' . $row->price . ' TND</p>';
                        echo '</div>';
                    }
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                    die(); // Kill the page if database is not working
                }
                $conn = null; // Close connection
                ?>
            </div>
        </div>


    <?php else : ?>

        <div class="small-container details">
            <div class="row">
                <?php
                try {
                    // Product display
                    $res = ModelProduit::getbyCode($db, $_GET['code']);
                    $categorie = ModelProduit::getCategoriebyCode($db, $_GET['code']);


                    // If product not found, go to general product page
                    if (empty($res)) {
                        header("Location: products.php");
                        exit;
                    } else {
                        // Display the product info
                        echo '<div class="col-2">';
                        echo '<img src="uploads/produits/' . $res->code . '_' . $res->name . "/" . $res->image . '" width="100%" id="ProductImg"/>';
                        echo '<div class="small-img-row">';
                        echo '<div class="small-img-col">';
                        echo '<img src="uploads/produits/' . $res->code . '_' . $res->name . "/" . $res->image . '" width="95%" class="small-img"/>';
                        echo '</div>';

                        echo '<div class="small-img-col">';
                        echo '<img src="uploads/produits/' . $res->code . '_' . $res->name . "/" . $res->image2 . '" width="95%" class="small-img"/>';
                        echo '</div>';

                        echo '<div class="small-img-col">';
                        echo '<img src="uploads/produits/' . $res->code . '_' . $res->name . "/" . $res->image3 . '" width="95%" class="small-img"/>';
                        echo '</div>';

                        echo '<div class="small-img-col">';
                        echo '<img src="uploads/produits/' . $res->code . '_' . $res->name . "/" . $res->image4 . '" width="95%" class="small-img"/>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                        echo '<div class="col-2">';
                        echo '<form method="post" action="products.php?action=add&code=' . $_GET['code'] . '">';
                        echo '<p><a href="products.php">Home</a> / ' . $categorie->categorie . '</p>';
                        echo '<h1>' . $res->name . '</h1>';
                        echo '<h4>' . $res->price . ' TND </h4>';
                        if (isset($_SESSION['auth'])) {
                            echo '<input type="number" name="quantity" value="1">';
                            echo '<input type="submit" name="cartadded" id="button" value="Add to Cart">';
                            echo '<input type="submit" name="wishadded" id="button" value="Add to Wishlist">';
                            echo '<h3>Product Details</h3>';
                            echo '<br/>';
                            echo '<p>' . $res->description . '</p>';
                            echo '</form>';
                            echo '</div>';
                        } else {
                            echo '</form>';
                            echo '<input type="number" name="quantity" value="1">';
                            echo '<a href="login.php"><input type="submit" name="cartadded" id="button" value="Add to Cart"></a>';
                            echo '<a href="login.php"><input type="submit" name="cartadded" id="button" value="Add to Wishlist"></a>';
                            echo '<h3>Product Details</h3>';
                            echo '<br/>';
                            echo '<p>' . $res->description . '</p>';
                            echo '</div>';
                        }
                    }
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                    die(); // Kill the page if database is not working
                }
                $conn = null; // Close connection
                ?>
            </div>
        </div>

        <!-------------js for gallery------------->

        <script>
            var ProductImg = document.getElementById("ProductImg");
            var SmallImg = document.getElementsByClassName("small-img");
            SmallImg[0].onclick = function() {
                ProductImg.src = SmallImg[0].src;
            }
            SmallImg[1].onclick = function() {
                ProductImg.src = SmallImg[1].src;
            }
            SmallImg[2].onclick = function() {
                ProductImg.src = SmallImg[2].src;
            }
            SmallImg[3].onclick = function() {
                ProductImg.src = SmallImg[3].src;
            }
        </script>

        <h2 class="title">Reviews</h2>

        <div class="content home" style="margin-left: 15%; margin-bottom : 5%;">
            <?php if (!isset($_SESSION['auth'])) : ?>
                <button class="comment" onclick="window.location.href = 'login.php';">Login to comment !</button> <br><br>
            <?php endif ?>

            <p style="color:black;">Check out the reviews for the product below.</p>
            <div class="reviews"></div>

            <script>
                <?php
                echo 'const reviews_product_code = ' . $_GET['code'] . ';';
                ?>
                fetch("reviews.php?product_code=" + reviews_product_code).then(response => response.text()).then(data => {
                    document.querySelector(".reviews").innerHTML = data;
                    document.querySelector(".reviews .write_review_btn").onclick = event => {
                        event.preventDefault();
                        document.querySelector(".reviews .write_review").style.display = 'block';
                        document.querySelector(".reviews .write_review input[name='name']").focus();
                    };
                    document.querySelector(".reviews .write_review form").onsubmit = event => {
                        event.preventDefault();
                        fetch("reviews.php?product_code=" + reviews_product_code, {
                            method: 'POST',
                            body: new FormData(document.querySelector(".reviews .write_review form"))
                        }).then(response => response.text()).then(data => {
                            document.querySelector(".reviews .write_review").innerHTML = data;
                        });
                    };
                });
            </script>
        </div>
        </div>
    <?php endif; ?>



</body>

</html>

<!---------- footer ---------->
<?php require 'inc\footer.php'; ?>