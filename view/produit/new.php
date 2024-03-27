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
require '..\..\model\App.php';
require '..\..\model\ModelCategorie.php';


$db = App::getDB();
?>

<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Create new product</h1>
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
		  <li><a class="active"  href="index.php">Products</a></li>
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
						<div class="contact-form" >
							<form method="POST" action="index.php" enctype="multipart/form-data">
							
								<div class="form-group">
									<label for="">Product Name</label>
									<input type="text" placeholder="Name" class="form-control" name="name" id="name">
								</div>
								
								<div class="form-group">
									<label for="">Product Description</label>
									<textarea rows="6" placeholder="Description" class="form-control" name="description"></textarea>	
								</div>
								
								<div class="form-group">
									<label for="">Product Price</label>
									<input type="text" placeholder="Price" class="form-control" name="price">
								</div>
								<div class="form-group" style="margin-bottom: 0;">
									<label for="">Product Categorie</label>
									<br>
									<select class="form-control" name="code_categorie">
										<?php
										$rows = ModelCategorie::getAll($db);


										foreach ($rows as $row) {
										?>
											<option value=<?= $row->code ?>><?= $row->name ?></option>
										<?php
										}
										?>


									</select>
								</div>

								<center>
									<img src="#" alt="" style="max-width: 150px; margin: 15px;" >
								</center>
								
								<div class="form-group" style="margin-bottom: 0;">
									<label for="file">Product Picture</label>
									<input type="file" name="image" onchange="previewPicture(this)">
									<center>
										<img src="#" alt="" id="image" style="max-width: 150px; margin: 15px;" >
									</center>
								</div>
								

								<div class="form-group" style="margin-bottom: 0;">
									<label for="file">Product Picture 2</label>
									<input type="file" name="image2" onchange="previewPicture2(this)">
									<center>
										<img src="#" alt="" id="image2" style="max-width: 150px; margin: 15px;" >
									</center>
								</div>
								

								<div class="form-group" style="margin-bottom: 0;">
									<label for="file">Product Picture 3</label>
									<input type="file" name="image3" onchange="previewPicture3(this)">
									<center>
										<img src="#" alt="" id="image3" style="max-width: 150px; margin: 15px;" >
									</center>
								</div>

								<div class="form-group" style="margin-bottom: 0;">
									<label for="file">Product Picture 4</label>
									<input type="file" name="image4" onchange="previewPicture4(this)">
									<center>
										<img src="#" alt="" id="image4" style="max-width: 150px; margin: 15px;" >
									</center>
								</div>

								
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
