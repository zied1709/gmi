<?php 
if(session_status()== PHP_SESSION_NONE){
    session_start();
}
?>

<?php 
require '..\inc\header.php';
?>


<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Register</h1>
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
        
        <section class="page-wrapper" style="padding:0px !important;">
			<div class="contact-section">
				<div class="container">
					<div class="row">
						<!-- Contact Form -->
						<div class="contact-form" >
							<form method="POST" action="login.php" enctype="multipart/form-data">
							
								<div class="form-group">
									<label for="">First name</label>
									<input type="text" placeholder="First name" class="form-control" name="first_name">
								</div>
								
								<div class="form-group">
									<label for="">Last name</label>
									<input type="text" placeholder="Last name" class="form-control" name="last_name">
								</div>
								
								<div class="form-group">
									<label for="">Email</label>
									<input type="email" placeholder="Email" class="form-control" name="email">
								</div>

								<div class="form-group">
									<label for="">Telephone</label>
									<input type="text" placeholder="Telephone" class="form-control" name="telephone">
								</div>
								
								<div class="form-group">
									<label for="">Password</label>
									<input type="password" placeholder="Password" class="form-control" name="password">
								</div>
								
								<div class="form-group" style="margin-bottom: 0;">
									<label for="file">Picture</label>
									<input type="file" name="image" onchange="previewPictureUser(this)">
									<center>
										<img src="#" alt="" id="image_user" style="max-width: 150px; margin: 15px;" >
									</center>
								</div>

								<!-- pour passer l'id de user à editer -->	
								<input type="hidden" name="register" value="register" />	


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

<?php require '..\inc\footer.php' ?>
<script type="text/javascript" src="../js/image_upload.js"></script>
