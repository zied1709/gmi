<?php
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

//supprimer un element de la carte 
if (isset($_SESSION['cart_item']) && isset($_GET['codedelete'])) {
  unset($_SESSION['cart_item'][$_GET['codedelete']]);
}
?>




<?php
if (isset($_GET['clear'])) {
  // Clear the cart
  unset($_SESSION['cart_item']);
  //header('Location: products.php'); // redirect to 'products' page
  //exit;
}

// Checkout work
if (isset($_POST['ordersubmit'])) {
  $userid = $_SESSION['auth'];
  if (isset($_POST['fav']) && in_array('all', $_POST['fav'])) {
    foreach ($_SESSION['cart_item'] as $cartid => $cart) {
      $newquantity = $_POST['quantity' . $cartid];

      $uid = $userid;
      $productid = $cartid;
      $quantity =  $newquantity;

      $oh = new ModelOrderhistory($uid, $productid, $quantity);
      $oh->save($db);
      echo "New record created successfully";
    }

    unset($_SESSION['cart_item']); // Clear the cart session variable
    $conn = null; // Close connection
    header('Location: orderhistory.php'); // redirect to 'order history' page
    exit;
  } else if (isset($_POST['fav'])) {

    foreach ($_POST['fav'] as $k => $cartid) {
      $newquantity = $_POST['quantity' . $cartid];

      $uid = $userid;
      $productid = $cartid;
      $quantity =  $newquantity;

      $oh = new ModelOrderhistory($uid, $productid, $quantity);
      $oh->save($db);
      echo "New record created successfully";
    }

    unset($_SESSION['cart_item']); // Clear the cart session variable
    $conn = null; // Close connection
    header('Location: orderhistory.php'); // redirect to 'order history' page
    exit;
  } else {
    header('Location: cart.php'); // redirect to 'cart' page if no item selected
    exit;
  }
}
require('../inc/header.php');

?>


<head>
  <meta charset="utf-8">
  <title>Cart</title>
  <script src="../js/carte.js" type="text/javascript"></script>
  <link rel="stylesheet" href="../css/cart2.css" />
  <link rel="icon" type="image/png" href="../images/favicon.png" />
</head>

<style>
  .con {
    padding: 5px;
    align-items: center;
  }

  .it {
    padding: 5px;
    display: inline-block;
    vertical-align: middle
  }
</style>

<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Cart</h1>
          <ol class="breadcrumb">
            <li><a href="index.html">Home</a></li>
            <li class="active">cart</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>


<?php if (isset($_SESSION['cart_item'])) : ?>
  <div class="page-wrapper">
    <div class="cart shopping">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <div class="block">
              <div class="product-list shopping-cart-wrapper">
                <table class="table is-fullwidth shopping-cart">
                  <thead id="thead-cart">
                    <tr>
                      <li style="display:none"><input type="checkbox" name="fav[]" id="all" onclick="checkTest1(this),checkTest2()" />Select All</li>
                      <th>Picture</th>
                      <th>Name</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Total Price</th>
                      <th>Select</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody id="info warp">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                      <?php foreach ($_SESSION['cart_item'] as $cartid => $cart) {

                        echo '<tr class="cart-item">';

                        echo '<td><img width="80" img src="../uploads/produits/' . $cartid . '_' . $cart['name'] . "/" . $cart['image'] . '" alt="" /></td>';

                        echo '<td>';
                        echo '<div class="product-info">';
                        echo '<a href="products.php?code=' . $cartid . '">' . $cart['name'] . '</a>';
                        echo '</div>';
                        echo '</td>';

                        echo '<td>' . $cart['price'] . '</td>';

                        echo '<td>';
                        echo '<input onblur="myFunction(' . $cartid . ',' . 0 . ')" id="' . $cartid . '" class="input is-primary cart-item-qty" style="width:38px" type="number" min="1" value="' . $cart['quantity'] . '" data-price="' . $cart['price'] . '" name="quantity' . $cartid . '">';
                        echo '</td>';


                        $total = $cart['price'] * $cart['quantity'];
                        echo '<td class="cart-item-total">' . $total . '</td>';

                        echo '<td>';
                        echo '<input type="checkbox" class="cart-item-check" checked name="fav[]" value="' . $cartid . '" onclick="checkTest2()" />';
                        echo '</td>';

                        echo '<td>';
                        echo '<a href="cart.php?codedelete=' . $cartid . '" class="button is-small">Remove</a>';
                        echo '</td>';
                        echo '</tr>';
                      }  ?>
                  </tbody>
                </table>

              </div>

            </div>
            <br />

            <div class="timer" id="notification" style="text-align: center;">
              Please place your order in <span class="time" id="time">01:00</span> or your cart will be emptied!
            </div>

            <hr id="hr-cart" style="border-top: 1px solid;margin-bottom:0;">
            <li style="display:none"><input type="checkbox" name="fav[]" value="all" onclick="checkTest1(this),checkTest2()" />Select All</li>

            <div>
              <ul class="balance_ul2" style="float: none;" id="info warp">
                <li>Subtotal:&nbsp; <span class="totals-value" id="cart-subtotal"> 0 TND</span></li>
                <li>Tax (5%):&nbsp; <span class="totals-value" id="cart-tax"> 0 TND</span></li>
                <li>Shipping:&nbsp; <span class="totals-value" id="cart-shipping"> 0 TND</span></li>
                <li>Grand Total:&nbsp; <span class="totals-value" id="cart-total"> 0 TND</span></li>
              </ul>
            </div>

            <!-- <div class="totals">
              <div class="totals-item">
                <label>Subtotal</label>
                <div class="totals-value" id="cart-subtotal">￥0</div>
              </div>
              <div class="totals-item">
                <label>Tax (5%)</label>
                <div class="totals-value" id="cart-tax">￥0</div>
              </div>
              <div class="totals-item">
                <label>Shipping</label>
                <div class="totals-value" id="cart-shipping">￥0</div>
              </div>
              <div class="totals-item totals-item-total">
                <label>Grand Total</label>
                <div class="totals-value" id="cart-total">￥0</div>
              </div>
            </div> -->

            <br><br><br>
            <div id="check-cart">
              <input class="btn btn-main pull-right" type="submit" name="ordersubmit" onclick="myFunction(0,1);placeorder();" value="Check out">
              <a href="cart.php?clear=true" class="btn btn-main pull-left">Empty your cart !</a>
            </div>
            </form>


          </div>
        </div>
      </div>
    </div>
  </div>
  </div>


<?php else : ?>
  <section class="empty-cart">
    <div class="container page-wrapper" style="padding-bottom: 105px;">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="block text-center">
            <i class="tf-ion-ios-cart-outline"></i>
            <h2 class="text-center">Your cart is currently empty.</h2>
            <p>Go Fast Fill Your Cart . Have A Nice Shopping ! </p>
            <a href="products.php" class="btn btn-main mt-20">Return to shop</a>
          </div>
        </div>
      </div>
  </section>
<?php endif; ?>


<?php
include('../inc/footer.php');
?>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
<script src="../js/script-cart.js"></script>


<script>
  function myFunction(y, test) {
    if (test == 0) {
      let x = document.getElementById(y);
      // Creating a cookie after the document is ready
      $(document).ready(function() {
        createCookie(y, x.value, "10");
      });

    } else {
      for (let i = 1; i < $cookie['nbprod']; i++) {
        createCookie(i, 100);
      }
    }
  }

  // Function to create the cookie
  function createCookie(name, value, days) {
    var expires;

    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = "; expires=" + date.toGMTString();
      document.cookie = escape(name) + "=" +
        escape(value) + expires + "; path=/";
    } else {
      document.cookie = i + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      // for (let i = 1; i < 50; i++) {
      //   document.cookie = i + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      // }
      // document.cookie = "1=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    }
  }
</script>