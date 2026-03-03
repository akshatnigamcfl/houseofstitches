<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="House of Stitches">
	<meta name="copyright" content="© House of Stitches">
	<meta name="robots" content="index, follow">
	<meta name="theme-color" content="#ffffff">
	<meta property="og:type" content="website">
	<meta property="og:title"
		content="House of Stitches – Premium Wholesale Kidswear Supplier | Quality Clothing for Ages 6–15">
	<meta property="og:description"
		content="House of Stitches supplies premium bulk kidswear for ages 6–15. Trusted wholesale clothing partner in India offering quality fabrics, trendy designs, and reliable delivery.">
	<meta property="og:site_name" content="House of Stitches">
	<meta property="og:url" content="https://houseofstitches.in/">
	<meta property="og:image" content="https://houseofstitches.in/assets/img/favicon.jpg">
	<link rel="canonical" href="https://houseofstitches.in/">
	<link rel="alternate" hreflang="en" href="https://houseofstitches.in/">
	<link rel="manifest" href="manifest.json">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/gallery/favicon.png">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/gallery/favicon.png">
	<link rel="icon" type="image/png" sizes="48x48" href="assets/gallery/favicon.png">
	<link rel="apple-touch-icon" sizes="180x180" href="assets/gallery/favicon.png">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/hos/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/hos/scss/style.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

	<script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "Organization",
			"name": "House of Stitches",
			"url": "https://houseofstitches.in",
			"logo": "https://houseofstitches.in/assets/img/logo.png",
			"sameAs": [
				"https://www.facebook.com/houseofstitches",
				"https://www.instagram.com/houseofstitches"
			]
		}
	</script>
</head>

<body>
	<header>
		<nav class="navbar bg-white">
			<div class="container-fluid">
				<button class="mobilbtn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu"
					aria-controls="offcanvasMenu" aria-expanded="true"><img src="<?php echo base_url(); ?>assets/hos/gallery/interface.png"
						alt="menu" class="img-fluid">
				</button>
				<a class="navbar-brand me-auto ms-2" href="index.php"><img src="<?php echo base_url(); ?>assets/hos/gallery/logo.png"
						alt="houseofstitches" class="img-fluid"></a>
				<div class="d-flex justify-content-lg-evenly align-items-center user_details">
					<form class="d-flex search-form" role="search">
						<input class="form-control d-lg-block d-none" type="search" placeholder="Search"
							aria-label="Search">
					</form>
					<?php    

					    //echo '<pre>'; print_r($this->session->all_userdata());
					?>
					<ul class="d-flex list-unstyled gap-lg-4 gap-2 mb-0" role="search">
					    <?php
					     if(empty($this->session->userdata('logged_user'))){
					    ?>
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="register">LOG IN</a>
							<i class="bi bi-person-lines-fill nav-icon"></i>
						</li>
						<?php }else{ ?>
						  <!-- <li class="nav-item">
							 <a class="nav-link" aria-current="page" href="register">LOG OUT</a>
							 <i class="bi bi-person-lines-fill nav-icon"></i>
						  </li>-->
					    <?php } ?>
						<li class="nav-item whatsapp-chat">
							<a class="nav-link" aria-current="page" href="help"><i class="bi bi-whatsapp"></i> Chat</a>
							<i class="bi bi-whatsapp nav-icon"></i>
						</li>
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="cart.php">Shopping bag [0]</a>
							<i class="bi bi-bag-fill nav-icon"></i>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu">
			<div class="offcanvas-header">
				<button type="button" class="ms-0 mobilbtn" data-bs-dismiss="offcanvas"><img
						src="<?php echo base_url(); ?>assets/hos/gallery/cancel.png" alt="close" class="cancel-btn img-fluid"></button>
			</div>
			<div class="offcanvas-body">
				<div class="utility">
					<a class="u-btn" href="<?php echo base_url('home/account'); ?>">Account</a>
					<a class="u-btn" href="<?php echo base_url('home/wishlist'); ?>">Wishlist</a>
					<a class="u-btn" href="<?php echo base_url('shopping-cart'); ?>">Cart <span class="badge">2</span></a>
				</div>
				<div class="brandsearch">
					<input type="search" placeholder="Search products, brands, categories…" aria-label="Search">
				</div>
				<ul class="navbar-nav">
					<div class="navsection">
						<details>
						<?php
					     if(!empty($this->session->userdata('logged_user'))){
					    ?>
							<summary><a href="<?php echo base_url(); ?>home/shop">SHOP</a> <span class="chev">›</span></summary>
					<?php }else{ ?>
							<summary><a href="<?php echo base_url(); ?>register">SHOP</a> <span class="chev">›</span></summary>
					<?php } ?>
							<div class="nav-items">
								<a class="nav-links" href="/new">New Arrivals</a>
								<a class="nav-links" href="/bestsellers">Best Sellers</a>
								<a class="nav-links" href="/sale">Sale</a>
								<a class="nav-links" href="/collections">Collections</a>
							</div>
						</details>
					</div>

					<div class="navsection">
						<details>
							<summary>BOYS <span class="chev">›</span></summary>
							<div class="brand-intro">
								<div class="tile">
									<div class="brandtitle">Spark</div>
									<div class="chips">
										<a class="chip" href="/boys/spark/tshirt">T-Shirt</a>
										<a class="chip" href="/boys/spark/bottom">Shirt</a>
										<a class="chip" href="/boys/spark/bottom">Three Sets</a>
										<a class="chip" href="/boys/spark/bottom">Two sets</a>
										<a class="chip" href="/boys/spark/bottom">Bottom</a>
									</div>
								</div>
								<div class="tile">
									<div class="brandtitle">BloomUp</div>
									<div class="chips">
										<a class="chip" href="/boys/bloomup/tshirt">T-Shirt</a>
										<a class="chip" href="/boys/bloomup/bottom">Bottom</a>
										<a class="chip" href="/boys/bloomup/sets">Sets</a>
									</div>
								</div>
								<div class="tile">
									<div class="brandtitle">Basic</div>
									<div class="chips">
										<a class="chip" href="/boys/bloomup/tshirt">T-Shirt</a>
										<a class="chip" href="/boys/bloomup/bottom">Bottoms</a>
									</div>
								</div>
							</div>
							<div class="muted">Essentials & new drops.</div>
						</details>
					</div>

					<div class="navsection">
						<details>
							<summary>GIRLS <span class="chev">›</span></summary>
							<div class="brand-intro">
								<div class="tile">
									<div class="brandtitle">Button Noses</div>
									<div class="chips">
										<a class="chip" href="/boys/spark/top">Top's</a>
										<a class="chip" href="/boys/spark/bottom">Bottom</a>
									</div>
								</div>
								<div class="tile">
									<div class="brandtitle">BloomUp</div>
									<div class="chips">
										<a class="chip" href="/boys/bloomup/top">Top's</a>
										<a class="chip" href="/boys/bloomup/bottom">Bottoms</a>
										<a class="chip" href="/boys/bloomup/sets">Sets</a>
										<a class="chip" href="/boys/bloomup/dungarees">Dungarees</a>
										<a class="chip" href="/boys/bloomup/dresses">Dresses</a>
									</div>
								</div>
							</div>
						</details>
					</div>

					<div class="navsection">
						<details>
							<summary>ALL BRANDS <span class="chev">›</span></summary>
							<div class="nav-items">
								<a class="nav-links" href="/brand/spark">Spark</a>
								<a class="nav-links" href="/brand/bloomup">BloomUp</a>
								<a class="nav-links" href="/brand/button-noses">Button Noses</a>
								<a class="nav-links" href="/brand/button-noses">Basic</a>
								<a class="nav-links" href="/brand/button-noses">Sucasa</a>
							</div>
						</details>
					</div>

					<div class="navsection">
						<details>
							<summary>SHOP BY <span class="chev">›</span></summary>
							<div class="nav-items">
								<a class="nav-links" href="/size-guide">Size Guide</a>
								<a class="nav-links" href="/shop/size/0-24">Size 06–24 Month</a>
								<a class="nav-links" href="/shop/size/2-5">Size 2–5 Years</a>
								<a class="nav-links" href="/shop/size/6-16">Size 6-16 Years</a>
								<a class="nav-links" href="/shop/price/under-699">Under ₹699</a>
								<a class="nav-links" href="/shop/price/999-1999">699-to above</a>
							</div>
						</details>
					</div>
					<div class="navsection">
						<details>
							<summary>INFO <span class="chev">›</span></summary>
							<div class="nav-items">
								<a class="nav-links" href="about.php">About</a>
								<a class="nav-links" href="shop.php">Shop</a>
								<a class="nav-links" href="faq.php">FAQs</a>
								<a class="nav-links" href="contact.php">Contact Us</a>
							</div>
						</details>
					</div>
					<div class="navsection">
						<details>
							<summary><a href="account.php">MY ACCOUNT</a><span class="chev">›</span></summary>
							<div class="nav-items">
								<a class="nav-links" href="register">Sign In / Register</a>
								<a class="nav-links" href="/account/orders.php">My Orders</a>
								<a class="nav-links" href="<?php echo base_url('home/wishlist'); ?>">Wishlist</a>
								<a class="nav-links" href="/account/addresses">Addresses</a>
								<a class="nav-links" href="<?php echo base_url('home/account'); ?>">Profile</a>
							</div>
						</details>
					</div>
					<div class="navsection">
						<details>
							<summary>HELP & SUPPORT <span class="chev">›</span></summary>
							<div class="nav-items">
								<a class="nav-links" href="terms-conditions.php">Terms & Conditions</a>
								<a class="nav-links" href="privacy-policy.php">Privacy Policy</a>
								<a class="nav-links" href="track-order.php">Track Order</a>
								<a class="nav-links" href="returns-exchange.php">Returns & Exchanges</a>
								<a class="nav-links" href="shipping.php">Shipping Information</a>
								<a class="nav-links" href="payment-method.php">Payment Methods</a>
								<a class="nav-links" href="gift-cards.php">Gift Cards</a>
							</div>
						</details>
					</div>
					<div class="bottom-cta">
						<a class="btn btn-success w-100 rounded-pill text-center my-2" href="/checkout">Proceed to
							Checkout</a>
						<a class="btn_button w-100 rounded-pill text-center py-2 d-block" href="/cart">View Cart</a>
					</div>
				</ul>
			</div>
		</div>
	</header>
	<main>