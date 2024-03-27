<!DOCTYPE html>
<html lang="en">

<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title>GMI</title>

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Construction Html5 Template">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
	<meta name="author" content="Themefisher">
	<meta name="generator" content="Themefisher Constra HTML Template v1.0">

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="../../images/icon.jpg" />

	<!-- Themefisher Icon font -->
	<link rel="stylesheet" href="../../plugins/themefisher-font/style.css">
	<!-- bootstrap.min css -->
	<link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css">

	<!-- Animate css -->
	<link rel="stylesheet" href="../../plugins/animate/animate.css">
	<!-- Slick Carousel -->
	<link rel="stylesheet" href="../../plugins/slick/slick.css">
	<link rel="stylesheet" href="../../plugins/slick/slick-theme.css">

	<!-- Main Stylesheet -->
	<link rel="stylesheet" href="../../css/style.css">

</head>

<body id="body">

	<!-- Start Top Header Bar -->
	<section class="top-header">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-xs-12 col-sm-4">
					<div class="contact-number">
						<i class="tf-ion-ios-telephone"></i>
						<span>+216 26 875 198</span>
					</div>
				</div>
				<div class="col-md-4 col-xs-12 col-sm-4">
					<!-- Site Logo -->
					<div class="logo text-center">
						<a href="../products.php">
							<!-- replace logo here -->
							<svg width="135px" height="29px" viewBox="0 0 155 29" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
								<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" font-size="40" font-family="AustinBold, Austin" font-weight="bold">
									<g id="Group" transform="translate(-108.000000, -297.000000)" fill="#000000">
										<text id="AVIATO">
											<tspan x="108.94" y="325">GMI</tspan>
										</text>
									</g>
								</g>
							</svg>
						</a>
					</div>
				</div>
				<div class="col-md-4 col-xs-12 col-sm-4">
					<?php
					//include ('navbar.php');
					if (session_status() == PHP_SESSION_NONE) {
						session_start();
					}
					?>
					<!-- if cart est vide -->
					<?php if (!isset($_SESSION['cart_item'])) : ?>
						<?php
						echo '<!-- Cart -->';
						echo '<ul class="top-menu text-right list-inline">';
						echo '<li class=" cart-nav">';
						echo '<a href="../cart.php"><i class="tf-ion-android-cart"></i>Cart</a>';
						echo '<div class="dropdown-menu cart-dropdown">';
						?>
					<?php endif ?>
					<?php if (isset($_SESSION['cart_item'])) : ?>
						<?php
						echo '<!-- Cart -->';
						echo '<ul class="top-menu text-right list-inline">';
						echo '<li class="dropdown cart-nav dropdown-slide">';
						echo '<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i class="tf-ion-android-cart"></i>Cart</a>';
						echo '<div class="dropdown-menu cart-dropdown">';
						$total = 0;
						foreach ($_SESSION['cart_item'] as $cartid => $cart) {
							$trueprice = $cart['price'] * $cart['quantity'];
							$total += $trueprice;

							// <!-- Cart Item -->
							echo '<div class="media">';
							echo '<a class="pull-left" href="../../products.php?code=' . $cartid . '">';
							echo '<img class="media-object" src="../../uploads/produits/' . $cartid . '_' . $cart['name'] . "/" . $cart['image'] . '" alt="image"/>';
							echo '</a>';

							echo '<div class="media-body">';
							echo '<h4 class="media-heading"><a href="../../products.php?code=' . $cartid . '">' . $cart['name'] . '</a></h4>';
							echo '<div class="cart-price">';
							echo '<span>' . $cart['quantity'] . ' x</span>';
							echo '<span>' . $cart['price'] . '</span>';
							echo '</div>';
							echo '<h5><strong>' . $trueprice . '</strong></h5>';
							echo '</div>';

							echo '</div>'; //<!-- / Cart Item -->
						}

						echo '<div class="cart-summary">';
						echo '<span>Total</span>';
						echo '<span class="total-price">' . $total . ' TND </span>';
						echo '</div>';

						echo '<ul class="text-center cart-buttons">';
						echo '<li><a href="../cart.php" class="btn btn-small">View Cart</a></li>';
						echo '</ul>';
						echo '</div>';

						echo '</li>'; //<!-- / Cart -->
						?>

					<?php endif; ?>

					</li><!-- / Cart -->

					<!-- Search 
					<li class="dropdown search dropdown-slide">
						<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i class="tf-ion-ios-search-strong"></i> Search</a>
						<ul class="dropdown-menu search-dropdown">
							<li>
								<form action="post"><input type="search" class="form-control" placeholder="Search..."></form>
							</li>
						</ul>
					</li>< / Search -->

					</ul><!-- / .nav .navbar-nav .navbar-right -->
				</div>
			</div>
		</div>
	</section><!-- End Top Header Bar -->


	<!-- Main Menu Section -->
	<section class="menu">
		<nav class="navbar navigation">
			<div class="container">
				<div class="navbar-header">
					<h2 class="menu-title">Main Menu</h2>
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>

				</div><!-- / .navbar-header -->

				<!-- Navbar Links -->
				<div id="navbar" class="navbar-collapse collapse text-center">
					<ul class="nav navbar-nav">


						<!-- Shop -->
						<li class="dropdown ">
							<a href="../products.php">Products</a>
						</li><!-- / Shop -->

						<!-- About us -->
						<li class="dropdown ">
							<a href="../about.php">About Us</a>
						</li><!-- / About us -->



						<?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) :; ?>

							<!-- Dashboard -->
							<li class="dropdown ">
								<a href="index.php">Dashboard</a>
							</li><!-- / Dashboard -->

							<!-- User_Profile -->
							<li class="dropdown ">
								<a href="../user_profile.php">Account</a>
							</li><!-- / User_Profile -->

							<!-- Logout -->
							<li class="dropdown ">
								<a href="../logout.php">Logout</a>
							</li><!-- / Logout -->

						<?php else :; ?>

							<!-- Login -->
							<li class="dropdown ">
								<a href="../login.php">Login</a>
							</li><!-- / Login -->

						<?php endif ?>



					</ul><!-- / .nav .navbar-nav -->

				</div>
				<!--/.navbar-collapse -->
			</div><!-- / .container -->
		</nav>
	</section>