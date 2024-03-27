<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['auth'])) {
  $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
  header('Location: login.php');
}
?>

<?php
require '..\inc\header.php';
require '..\model\ModelUser.php';

require('..\model\App.php');

$db = App::getDB();

if (isset($_SESSION['auth'])) {
  $res = ModelUser::getbyCode($db, $_SESSION['auth']);
}
?>
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="../css/userprofile.css">

<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Account</h1>
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

        <div class="dashboard-wrapper dashboard-user-profile">
          <div class="media">
            <div class="pull-left text-center" href="#!">
              <img class="media-object user-img" src="../uploads/users/<?= $res->image ?>" alt="Image">

            </div>
            <div class="media-body">
              <ul class="user-profile-list">

                <li><span>First Name:</span> <?php echo $res->first_name ?></li>
                <li><span>Last Name:</span> <?php echo $res->last_name ?></li>
                <li><span>Email:</span> <?php echo $res->email ?> </li>
                <li><span>Phone:</span> <?php echo $res->telephone ?></li>


              </ul>
            </div>
          </div>
        </div>

        <div class="dashboard-wrapper dashboard-user-profile">
          <div class="media">
            <div class="media-body">
            <div class="options" style="padding-top: 10px;"> 
        <a href="orderhistory.php">
            <div class="card1" style="margin-bottom:10px;">
                    <div class="orderhistory">
                        <br>
                        <h4><b>Order History</b></h4>
                        <br>
                        <p>View or return your recent purchases</p>
                    </div>
            </div>
        </a>

        <a href="wishlist.php">
            <div class="card2" style="margin-bottom:10px;">
                    <div class="wishlist">
                        <br>
                        <h4><b>Wishlist</b></h4>
                        <br>
                        <p>View your wishlist</p>
                    </div>
            </div>
        </a>
    </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>




<?php require '..\inc\footer.php' ?>