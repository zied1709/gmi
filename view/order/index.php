<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if ($_SESSION['admin'] == 0) {
  $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
  header('Location: ..\login.php');
}
?>


<?php
require '..\..\inc\header2.php';
require '..\..\model\App.php';

$db = App::getDB();
require '..\util.php';
?>

<?php
// delete order 
if (isset($_GET['deletedcode'])) {
  try {
    // Order history display
    $conn = new PDO("mysql:host=localhost;dbname=gmi", 'root', '');
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Prepared statement to fetch the order history for the user
    // update order 
    $sql = "UPDATE order_history 
            SET is_deleted=?
  
            WHERE id=?";

    $stm = $conn->prepare($sql);
    $stm->execute([1, $_GET['deletedcode']]);
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die(); // Kill the page if database is not working
  }
  $conn = null; // Close connection  
}
?>

<?php
try {
  // Order history display
  $conn = new PDO("mysql:host=localhost;dbname=gmi", 'root', '');
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // Prepared statement to fetch the order history for the user
  // update order 
  if (isset($_POST['status'])) {
    $sql = "UPDATE order_history 
          SET status=?

          WHERE id=?";

    $stm = $conn->prepare($sql);
    $stm->execute([$_POST['status'], $_POST['id']]);
  }
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  die(); // Kill the page if database is not working
}
$conn = null; // Close connection
?>

<?php
try {
  // Order history display
  $conn = new PDO("mysql:host=localhost;dbname=gmi", 'root', '');
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // Prepared statement to fetch the order history for the user
  $stmt = $conn->prepare("SELECT oh.id, oh.status ,oh.quantity, oh.purchasedate, oh.productid, p.name, p.price ,p.image as img, u.first_name, u.image, u.last_name FROM order_history oh"
    . " INNER JOIN user u ON oh.uid = u.id INNER JOIN produit p ON oh.productid = p.code WHERE oh.is_deleted = 0 ORDER BY oh.purchasedate DESC");
  $stmt->execute();
  $ctr = 1;
  // set the resulting array to associative
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  die(); // Kill the page if database is not working
}
$conn = null; // Close connection
?>



<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Dashboard</h1>
          <ol class="breadcrumb">
            <li><a href="index.html">Home</a></li>
            <li class="active">my account</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="user-dashboard page-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <ul class="list-inline dashboard-menu text-center">
          <li><a href="../produit/index.php">Products</a></li>
          <li><a href="../categorie/index.php">Categorie</a></li>
          <li><a class="active" href="index.php">Orders</a></li>
          <li><a href="../user/index.php">Users</a></li>
          <li><a href="../admin/index.php">Admin</a></li>
          <li><a href="../user/profile-details.php">Profile Details</a></li>
        </ul>
        <div class="dashboard-wrapper user-dashboard">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Client</th>
                  <th>Image</th>
                  <th>Product</th>
                  <th>Image</th>
                  <th>Date</th>
                  <th>Price</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;
                foreach ($stmt->fetchAll() as $display) {
                  $i+=1;
                  if ($display['status'] == "Pending") {
                    $label = "warning";
                  } elseif ($display['status'] == "On Hold") {
                    $label = "info";
                  } elseif ($display['status'] == "Canceled") {
                    $label = "danger";
                  } elseif ($display['status'] == "Completed") {
                    $label = "success";
                  } elseif ($display['status'] == "Processing") {
                    $label = "primary";
                  }
                ?>
                  <tr scope="row">
                    <td><?= $i ?></td>
                    <td><?= $display['first_name']; ?> <?= $display['last_name']; ?></td>
                    <td><img src="../../uploads/users/<?= $display['image']; ?>" style="width:60px;height:60px;"></td>
                    <td><?= $display['name']; ?></td>
                    <td><img src="../../uploads/produits/<?= $display['productid'] ?>_<?= $display['name'] ?>/<?= $display['img'] ?>" style="width:60px;height:60px;"></td>
                    <td><?= $display['purchasedate']; ?></td>
                    <td><?= $display['price']; ?></td>
                    <td><span class="label label-<?= $label; ?>"><?= $display['status']; ?></span></td>

                    <td>
                      <div class="btn-group" role="group">
                        <button onclick="window.location.href = 'edit.php?codeedit=<?= $display['id'] ?>';" type="button" class="btn btn-default"><i class="tf-pencil2" aria-hidden="true"></i></button>
                        <button onclick="window.location.href = 'index.php?deletedcode=<?= $display['id'] ?>';" type="button" class="btn btn-default"><i class="tf-ion-close" aria-hidden="true"></i></button>
                      </div>
                    </td>
                  </tr>
                <?php

                } ?>
              </tbody>
            </table>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require '..\..\inc\footer2.php' ?>