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
require '..\..\model\ModelCategorie.php';
require '..\..\model\App.php';

$db = App::getDB();
if (isset($_GET['codeedit'])){

	$res = ModelCategorie::getbyCode($db,$_GET['codeedit']);
}
?>

<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Edit categorie</h1>
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
          <li><a class="active"  href="index.php">Categorie</a></li>
		  <li><a href="../order/index.php">Orders</a></li>
		  <li><a href="../user/index.php">Users</a></li>
          <li><a href="../admin/index.php">Admin</a></li>
          <li><a href="../user/profile-details.php">Profile Details</a></li>
        </ul>
		
        <section class="page-wrapper">
			<div class="contact-section">
				<div class="container">
					<div class="row">
						<!-- Contact Form -->
						<div class="contact-form" >

							<form id="contact-form" method="POST" action="index.php" role="form">
								<div class="form-group">
									<label for=""> Categorie Name</label>
									<input type="text" class="form-control" name="name" value="<?=$res->name?>">
								</div>
								
								<div id="cf-submit">
									<input type="submit" id="contact-submit" class="btn btn-transparent" value="Submit">
								</div>
								<!-- pour passer l'id du categorie a editer -->	
								<input type="hidden" name="code" value="<?=$_GET['codeedit']?>" />
	
							</form>
						</div>
						<a href="index.php" class="btn btn-default">back to list</a>

						<!-- ./End Contact Form -->
				
					</div> <!-- end row -->
				</div> <!-- end container -->
			</div>
		</section>
      </div>
    </div>
  </div>
</section>

<?php require '..\..\inc\footer2.php' ?>