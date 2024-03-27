<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>

<?php require '..\inc\header.php'; ?>

<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">About Us</h1>
					<ol class="breadcrumb">
						<li><a href="products.php">Home</a></li>
						<li class="active">about us</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="about section">
	<div class="container">
		<div class="row">
			<div class="col-md-5">
				<img class="img-responsive" style="border-radius: 40px;" src="../images/about/about.jpg">
			</div>
			<div class="col-md-6">
				<br><br><br>
				<h2 class="mt-40">About Our Shop</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius enim, accusantium repellat ex autem numquam iure officiis facere vitae itaque.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam qui vel cupiditate exercitationem, ea fuga est velit nulla culpa modi quis iste tempora non, suscipit repellendus labore voluptatem dicta amet?</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nam qui vel cupiditate exercitationem, ea fuga est velit nulla culpa modi quis iste tempora non, suscipit repellendus labore voluptatem dicta amet?</p>
				<p style="text-align:end ;"><a href="https://docs.google.com/presentation/d/1YTf1WNyg1qfebJL35Ci6hax0X5kaIobujtXBpOUEY3w/edit#slide=id.g1b9ddd36088_0_844" class="btn btn-main mt-20" target="_blank">To Demo</a></p>

			</div>

		</div>
	</div>

</section>

<section class="team-members ">
	<div class="container">
		<div class="row">
			<div class="title">
				<h2>Founder</h2>
			</div>
		</div>
		<div class="team-member text-center">
			<img class="img-circle" style="width: 40%;" src="../images/team/zied.jpeg">
			<br>
			<h4>Zied DAMMAK</h4>
		</div>

		<br><br><br><br>

		<div class="team-member text-center">
			<img class="img-circle" style="width: 40%;" src="../images/team/oussema.jpeg">
			<br>
			<h4>Oussema TAYARI</h4>
		</div>
		
	</div>
</section>

<br><br><br>
<?php require '..\inc\footer.php'; ?>