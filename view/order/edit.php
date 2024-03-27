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
?>

<?php
try {
  // Order history display
  $conn = new PDO("mysql:host=localhost;dbname=gmi", 'root', '');
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // Prepared statement to fetch the order history for the user
  $stmt = $conn->prepare("SELECT status FROM order_history WHERE  id=?");
  $stmt->execute([$_GET['codeedit']]);
  $ctr = 1;
  // set the resulting array to associative
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $value = $stmt->fetch();
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
					<li><a class="active" href="index.php">Orders</a></li>
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
									<form id="contact-form" method="POST" action="index.php" role="form" enctype="multipart/form-data">
										<div class="form-group">

											<label>Choose a status:</label>
											<select class="form-control" name="status">
												<?php if($value['status']=="Pending"): ?>
													<option selected value="Pending">Pending</option>
													<option value="On Hold">On Hold</option>													
													<option value="Processing">Processing</option>
													<option value="Completed">Completed</option>
													<option value="Canceled">Canceled</option>

												<?php elseif ($value['status']=="On Hold"): ?>
													<option value="Pending">Pending</option>
													<option selected value="On Hold">On Hold</option>													
													<option value="Processing">Processing</option>
													<option value="Completed">Completed</option>
													<option value="Canceled">Canceled</option>
												
												<?php elseif ($value['status']=="Processing"): ?>
													<option value="Pending">Pending</option>
													<option value="On Hold">On Hold</option>													
													<option selected value="Processing">Processing</option>
													<option value="Completed">Completed</option>
													<option value="Canceled">Canceled</option>
												
												<?php elseif ($value['status']=="Completed"): ?>
													<option value="Pending">Pending</option>
													<option value="On Hold">On Hold</option>													
													<option value="Processing">Processing</option>
													<option selected value="Completed">Completed</option>
													<option value="Canceled">Canceled</option>
												
												<?php elseif ($value['status']=="Canceled"): ?>
													<option value="Pending">Pending</option>
													<option value="On Hold">On Hold</option>													
													<option value="Processing">Processing</option>
													<option value="Completed">Completed</option>
													<option selected value="Canceled">Canceled</option>
												<?php endif ?>
											</select>
										</div>

										<!-- pour passer l'id du produit à editer -->
										<input type="hidden" name="id" value="<?= $_GET['codeedit'] ?>" />


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