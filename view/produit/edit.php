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
require '..\..\model\ModelProduit.php';
require '..\..\model\App.php';
require '..\..\model\ModelCategorie.php';

$db = App::getDB();

if (isset($_GET['codeedit'])) {
	$res = ModelProduit::getbyCode($db, $_GET['codeedit']);
}
?>

<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Edit product</h1>
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
					<li><a class="active" href="index.php">Products</a></li>
					<li><a href="../categorie/index.php">Categorie</a></li>
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
								<div class="contact-form">
									<form method="POST" action="index.php" role="form" enctype="multipart/form-data">

										<div class="form-group">
											<label for="">Product Name</label>
											<input type="text" value="<?= $res->name ?>" class="form-control" name="name">
										</div>

										<div class="form-group">
											<label for="">Product Description</label>
											<input type="text" value="<?= $res->description ?>" class="form-control" name="description">
										</div>

										<div class="form-group">
											<label for="">Product Price</label>
											<input type="text" value="<?= $res->price ?>" class="form-control" name="price">
										</div>

										<div class="form-group">
											<label for="">Product Categorie</label>
											<br>
											<select class="form-control" name="code_categorie">
												<?php
												$rows = ModelCategorie::getAll($db);

												foreach ($rows as $row) {
													if ($res->code_categorie == $row->code) {
												?>
														<option value=<?= $row->code ?> selected><?= $row->name ?></option>
													<?php
													} else {
													?>
														<option value=<?= $row->code ?>><?= $row->name ?></option>
												<?php
													}
												}
												?>
											</select>
										</div>

										<div class="form-group" style="margin-bottom: 0;">
											<label for="file">Product Picture</label>
											<input type="file" name="image" onchange="previewPicture(this)">
											<center>
												<img src="../../uploads/produits/<?= $_GET['codeedit'] ?>_<?= $res->name ?>/<?= $res->image ?>" alt="" id="image" style="max-width: 150px; margin: 15px;">
											</center>
										</div>


										<div class="form-group" style="margin-bottom: 0;">
											<label for="file">Product Picture 2</label>
											<input type="file" name="image2" onchange="previewPicture2(this)">
											<center>
												<img src="../../uploads/produits/<?= $_GET['codeedit'] ?>_<?= $res->name ?>/<?= $res->image2 ?>" alt="" id="image2" style="max-width: 150px; margin: 15px;">
											</center>
										</div>

										<div class="form-group" style="margin-bottom: 0;">
											<label for="file">Product Picture 3</label>
											<input type="file" name="image3" onchange="previewPicture3(this)">
											<center>
												<img src="../../uploads/produits/<?= $_GET['codeedit'] ?>_<?= $res->name ?>/<?= $res->image3 ?>" alt="" id="image3" style="max-width: 150px; margin: 15px;">
											</center>
										</div>

										<div class="form-group" style="margin-bottom: 0;">
											<label for="file">Product Picture 4</label>
											<input type="file" name="image4" onchange="previewPicture4(this)">
											<center>
												<img src="../../uploads/produits/<?= $_GET['codeedit'] ?>_<?= $res->name ?>/<?= $res->image4 ?>" alt="" id="image4" style="max-width: 150px; margin: 15px;">
											</center>
										</div>

										<!-- pour passer l'id du produit à editer -->
										<input type="hidden" name="code" value="<?= $_GET['codeedit'] ?>" />

										<!-- pour passer l'ancien nom du produit à editer -->
										<input type="hidden" name="name2" value="<?= $res->name2 ?>" />

										<!-- pour passer l'image du produit 1 à editer -->
										<input type="hidden" name="img" value="<?= $res->image ?>" />

										<!-- pour passer l'image du produit 2 à editer -->
										<input type="hidden" name="img2" value="<?= $res->image2 ?>" />

										<!-- pour passer l'image du produit 3 à editer -->
										<input type="hidden" name="img3" value="<?= $res->image3 ?>" />

										<!-- pour passer l'image du produit 4 à editer -->
										<input type="hidden" name="img4" value="<?= $res->image4 ?>" />




										<div id="cf-submit">
											<input type="submit" id="contact-submit" class="btn btn-transparent" value="Submit">
										</div>

									</form>
								</div>
								<!-- ./End Contact Form -->
								<a href="index.php" class="btn btn-default">back to list</a>


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