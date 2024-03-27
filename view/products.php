<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '..\model\App.php';
$db = App::getDB();
require '..\model\ModelProduit.php';
require '..\model\ModelWishlist.php';
require '..\model\ModelOrderhistory.php';
require '..\model\ModelCategorie.php';



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
        $uid = $_SESSION['auth'];
        $productid = $_GET['code'];

        $w = new ModelWishlist($uid, $productid);
        $w->save($db);

        header('Location: wishlist.php'); // redirect to 'wishlist' page

    } else if (isset($_POST['quantity'])) {
        // Prepared statement to fetch the cart info needed for the session
        $cart_array = ModelOrderhistory::getProductbyCode($db, $_GET['code']);

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

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <script src="../js/ajax/jquery-1.10.2.min.js"></script>
    <script src="../js/ajax/jquery-ui.js"></script>
    <script src="../js/ajax/bootstrap.min.js"></script>
    <link href="../css/ajax/jquery-uiii.css" rel="stylesheet">
    <!-- Custom CSS -->

    <link rel="stylesheet" href="../css/reviewss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>


</head>
<style>
    #loading {
        text-align: center;
        background: url('images/ajax/loader2.gif') no-repeat center;
        height: 150px;
    }
</style>

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

        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <br />
                <br />
                <div class="col-md-3">
                    <div class="list-group">
                        <h3>Price</h3>
                        <input type="hidden" id="hidden_minimum_price" value="0" />
                        <input type="hidden" id="hidden_maximum_price" value="4000" />
                        <p id="price_show">0 - 6000</p>
                        <div id="price_range"></div>
                    </div>
                    <div class="list-group">
                        <h3>Categorie</h3>
                        <div style="height: max-content; overflow-y: auto; overflow-x: hidden;">
                            <?php


                            $result = ModelCategorie::getDistinctName($db);
                            foreach ($result as $row) {
                            ?>
                                <div class="list-group-item checkbox">
                                    <label><input type="checkbox" class="common_selector categorie" value="<?php echo $row['code']; ?>"> <?php echo $row['name']; ?></label>
                                </div>
                            <?php
                            }

                            ?>
                        </div>
                    </div>


                </div>

                <div class="col-md-9">
                    <h2 class="title">Featured Products</h2>
                    <div class="row">


                        <div class="col-4 row filter_data">
                        </div>

                    </div>
                </div>

            </div>

        </div>

        <br><br><br>
    <?php else : ?>
        <link rel="stylesheet" href="../css/products.css">

        <div class="small-container details">
            <div class="row">
                <?php
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
                    echo '<img src="../uploads/produits/' . $res->code . '_' . $res->name . "/" . $res->image . '" width="100%" id="ProductImg"/>';
                    echo '<div class="small-img-row">';
                    echo '<div class="small-img-col">';
                    echo '<img src="../uploads/produits/' . $res->code . '_' . $res->name . "/" . $res->image . '" width="95%" class="small-img"/>';
                    echo '</div>';

                    echo '<div class="small-img-col">';
                    echo '<img src="../uploads/produits/' . $res->code . '_' . $res->name . "/" . $res->image2 . '" width="95%" class="small-img"/>';
                    echo '</div>';

                    echo '<div class="small-img-col">';
                    echo '<img src="../uploads/produits/' . $res->code . '_' . $res->name . "/" . $res->image3 . '" width="95%" class="small-img"/>';
                    echo '</div>';

                    echo '<div class="small-img-col">';
                    echo '<img src="../uploads/produits/' . $res->code . '_' . $res->name . "/" . $res->image4 . '" width="95%" class="small-img"/>';
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

<script>
    $(document).ready(function() {

        filter_data();

        function filter_data() {
            $('.filter_data').html('<div id="loading" style="" ></div>');
            var action = 'fetch_data';
            var minimum_price = $('#hidden_minimum_price').val();
            var maximum_price = $('#hidden_maximum_price').val();
            var categorie = get_filter('categorie');
            $.ajax({
                url: "fetch_data.php",
                method: "POST",
                data: {
                    action: action,
                    minimum_price: minimum_price,
                    maximum_price: maximum_price,
                    categorie: categorie
                },
                success: function(data) {
                    $('.filter_data').html(data);
                }
            });
        }

        function get_filter(class_name) {
            var filter = [];
            $('.' + class_name + ':checked').each(function() {
                filter.push($(this).val());
            });
            return filter;
        }

        $('.common_selector').click(function() {
            filter_data();
        });

        $('#price_range').slider({
            range: true,
            min: 0,
            max: 6000,
            values: [0, 6000],
            step: 20,
            stop: function(event, ui) {
                $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
                $('#hidden_minimum_price').val(ui.values[0]);
                $('#hidden_maximum_price').val(ui.values[1]);
                filter_data();
            }
        });

    });
</script>

<!---------- footer ---------->
<?php require '..\inc\footer.php'; ?>