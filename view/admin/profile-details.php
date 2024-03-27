<?php 
if(session_status()== PHP_SESSION_NONE){
    session_start();
}
if ($_SESSION['admin'] == 0) {
  $_SESSION['flash']['danger']="Vous n'avez pas le droit d'accéder à cette page";
  header('Location: ..\login.php');
}
?>

<?php 
require '..\..\inc\header2.php';
require '..\..\model\ModelUser.php';

require '..\..\model\App.php';

$db = App::getDB();

if (isset($_SESSION['auth'])){
	$res = ModelUser::getbyCode($db,$_SESSION['auth']);
}
?>

<?php if(!isset($_GET['code'])) : ?>

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
          <li><a href="../order/index.php">Orders</a></li>
          <li><a href="../user/index.php">Users</a></li>
          <li><a href="index.php">Admin</a></li>
          <li><a class="active"  href="profile-details.php">Profile Details</a></li>
        </ul>
        <div class="dashboard-wrapper dashboard-user-profile">
          <div class="media">
            <div class="pull-left text-center" href="#!">
              <img class="media-object user-img" src="../../uploads/users/<?=$res->image?>" alt="Image">

            </div>
            <div class="media-body">
              <ul class="user-profile-list">

                <li><span>First Name:</span> <?php echo $res->first_name ?></li>
                <li><span>Last Name:</span> <?php echo $res->last_name ?></li>
                <li><span>Email:</span> <?php echo $res->email ?> </li>
                <li><span>Phone:</span>26875198</li>


              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php else : ?>
  <?php $resultat = ModelUser::getbyCode($db,$_GET['code']); ?>


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
          <li><a href="index_user.php">Users</a></li>
          <li><a href="../user/index.php">Admin</a></li>
          <li><a class="active"  href="profile-details.php">Profile Details</a></li>
        </ul>
        <div class="dashboard-wrapper dashboard-user-profile">
          <div class="media">
            <div class="pull-left text-center" href="#!">
              <img class="media-object user-img" src="../../uploads/users/<?=$resultat->image?>" alt="Image">

            </div>
            <div class="media-body">
              <ul class="user-profile-list">

                <li><span>First Name:</span> <?php echo $resultat->first_name ?></li>
                <li><span>Last Name:</span> <?php echo $resultat->last_name ?></li>
                <li><span>Email:</span> <?php echo $resultat->email ?> </li>
                <li><span>Phone:</span> <?php echo $resultat->telephone ?></li>


              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<?php endif; ?>


<?php require '..\..\inc\footer2.php' ?>