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
require '..\..\model\ModelUser.php';

require '..\..\model\App.php';

$db = App::getDB();

if (isset($_GET['codeedit'])) {
	$res = ModelUser::getbyCode($db, $_GET['codeedit']);
}

?>
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Edit user</h1>
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
					<li><a class="active" href="index.php">Admin</a></li>
					<li><a href="profile-details.php">Profile Details</a></li>
				</ul>
				<section class="page-wrapper">
					<div class="contact-section">
						<div class="container">
							<div class="row">
								<!-- Contact Form -->
								<div class="contact-form">
									<form id="contact-form" method="POST" action="index.php" role="form" enctype="multipart/form-data">

										<div class="form-group">
											<label>First name</label>
											<input type="text" placeholder="First name" class="form-control" name="first_name" value="<?= $res->first_name ?>">
										</div>

										<div class="form-group">
											<label>Last name</label>
											<input type="text" placeholder="Last name" class="form-control" name="last_name" value="<?= $res->last_name ?>">
										</div>

										<div class="form-group">
											<label>Email</label>
											<input type="text" placeholder="Email" class="form-control" name="email" value="<?= $res->email ?>">
										</div>

										<div class="form-group">
											<label>Telephone</label>
											<input type="text" placeholder="Telephone" class="form-control" name="telephone" value="<?= $res->telephone ?>">
										</div>

										<div class="form-group">
											<label>User</label>
											<input type="checkbox" name="admin" value="0">
										</div>


										<div class="form-group">
											<input type="hidden" placeholder="Password" class="form-control" name="password" value="<?= $res->password ?>">
										</div>

										<div class="form-group" style="margin-bottom: 0;">
											<label for="file">Picture</label>
											<input type="file" name="image" onchange="previewPictureUser(this)">
											<center>
												<img src="../../uploads/users/<?= $res->image ?>" id="image_user" style="max-width: 150px; margin: 15px;">
											</center>
										</div>

										<!-- pour passer l'id de user à editer -->
										<input type="hidden" name="id" value="<?= $_GET['codeedit'] ?>" />

										<!-- pour passer l'image de user à editer -->
										<input type="hidden" name="img" value="<?= $res->image ?>" />


										<div id="cf-submit">
											<input type="submit" id="contact-submit" class="btn btn-transparent" value="Submit">
										</div>


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
<script type="text/javascript" src="../../js/image_upload.js"></script>