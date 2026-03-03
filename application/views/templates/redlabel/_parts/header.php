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
	<meta property="og:image" content="<?php echo base_url(); ?>assets/img/favicon.webp">
	<link rel="canonical" href="https://houseofstitches.in/">
	<link rel="alternate" hreflang="en" href="https://houseofstitches.in/">
	<link rel="manifest" href="manifest.json">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/gallery/favicon.webp">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/gallery/favicon.webp">
	<link rel="icon" type="image/png" sizes="48x48" href="<?php echo base_url(); ?>assets/gallery/favicon.webp">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/gallery/favicon.webp">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/scss/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/scss/style.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.theme.default.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />

	<script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "Organization",
			"name": "House of Stitches",
			"url": "https://houseofstitches.in",
			"logo": "<?php echo base_url(); ?>assets/img/logo.webp",
			"sameAs": [
				"https://www.facebook.com/houseofstitches",
				"https://www.instagram.com/houseofstitches"
			]
		}
	</script>
	<style>
		.header-nav-link {
			text-decoration: none;
			color: #333;
			font-size: 0.9rem;
			font-weight: 500;
			letter-spacing: 0.05em;
			text-transform: uppercase;
			padding: 4px 0;
			position: relative;
		}
		.header-nav-link::after {
			content: '';
			position: absolute;
			bottom: 0;
			left: 0;
			width: 0;
			height: 1px;
			background: #333;
			transition: width 0.2s;
		}
		.header-nav-link:hover::after { width: 100%; }
		.header-nav-link:hover { color: #333; }
	</style>
</head>

<body>
	<header class="site-header">
		<nav class="navbar bg-white">
			<div class="container-fluid">
				<div class="brand-logo">
					<button class="mobilbtn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu"
						aria-controls="offcanvasMenu" aria-expanded="true"><img src="<?php echo base_url(); ?>assets/gallery/interface.webp"
							alt="menu" class="img-fluid">
					</button>
					<a class="navbar-brand" href="<?php echo base_url(); ?>">
						<img src="<?php echo base_url(); ?>assets/gallery/logo.webp" alt="houseofstitches"
							class="img-fluid d-none d-sm-block">
						<img src="<?php echo base_url(); ?>assets/gallery/hos.webp" alt="houseofstitches"
							class="img-fluid d-block d-sm-none">
					</a>
				</div>
				<ul class="list-unstyled d-none d-lg-flex align-items-center mb-0 gap-3 header-nav">
					<li><a class="header-nav-link" href="<?php echo base_url('home/shop'); ?>">Shop</a></li>
					<li><a class="header-nav-link" href="<?php echo base_url('offer'); ?>">Offers</a></li>
					<li><a class="header-nav-link" href="<?php echo base_url('wishlist'); ?>">wishlist</a></li>
				</ul>
				<ul class="list-unstyled d-flex justify-content-between align-items-center mb-0 gap-4 me-md-3 me-1">
					<?php if (empty($this->session->userdata('logged_user'))) { ?>
						<li class="nav-icon"><a href="<?php echo base_url('register'); ?>"><i class="bi bi-person"></i></a></li>
					<?php } ?>
					<?php if (!empty($this->session->userdata('logged_user'))) { ?>
						<li class="nav-icon" method="GET" action="<?php echo base_url('home/shop'); ?>" id="bigger-search" data-bs-toggle="offcanvas" data-bs-target="#searchOffcanvas"><i class="bi bi-search"></i></li>
						<li class="nav-icon" style="text-shadow: none;"><a href="<?php echo base_url('home/barcode_scan'); ?>"><i class="bi bi-qr-code-scan"></i></a></li>
						<li class="nav-icon"><a href="<?php echo base_url('wishlist'); ?>"><i class="bi bi-heart"></i></a></li>
						<li class="nav-icon position-relative"><a href="<?php echo base_url('shopping-cart'); ?>"><i class="bi bi-bag"></i>
								<span class="wishlistcount">

									<?php print_r(get_cart_count_fast()); ?>
									<?= is_numeric($cartItems) && (int)$cartItems == 1 ? 1 : $sumOfItems ?>
								</span>
							</a>
						</li>
						<li class="nav-icon">
							<a href="javascript:void(0);" onclick="confirmLogout()" style="color: red;">
								<i class="bi bi-box-arrow-right"></i>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</nav>
		<div class="offcanvas offcanvas-start menusidebaar" tabindex="-1" id="offcanvasMenu">
			<div class="offcanvas-header">
				<a type="button" class="cancel-btn" data-bs-dismiss="offcanvas">
					<i class="bi bi-x-lg"></i>
				</a>
				<img src="<?php echo base_url(); ?>assets/gallery/logo.webp" alt="houseofstitches"
					class="img-fluid">
			</div>
			<div class="offcanvas-body">
				<div class="utility">
					<?php if (empty($this->session->userdata('logged_user'))) { ?>
						<a class="u-btn" href="<?php echo base_url('register'); ?>">Shop</a>
						<a class="u-btn" href="<?php echo base_url('register'); ?>">Pre-Booking</a>
					<?php } else { ?>
						<a class="u-btn" href="<?php echo base_url('home/shop'); ?>">Shop</a>
						<a class="u-btn" href="<?php echo base_url('home/prebooking'); ?>">Pre-Booking</a>
					<?php } ?>
				</div>
				<div class="brandsearch">
					<?php
					$cat = !empty($_GET['category']) ? $_GET['category'] : '';
					?>
					<form class="form-horizontal" method="GET" action="<?php echo base_url('home/shop'); ?>" id="bigger-search">
						<input type="hidden" name="category" value="<?= $cat; ?>">
						<input type="hidden" name="in_stock" value="">
						<input type="hidden" name="search_in_title" value="">
						<input type="hidden" name="order_new" value="">
						<input type="hidden" name="order_price" value="">
						<input type="hidden" name="order_procurement" value="">
						<input type="hidden" name="brand_id" value="">
						<input type="hidden" name="search_in_desc" value="">
						<input type="hidden" name="search_in_color" value="">
						<input type="hidden" name="search_in_size" value="">
						<input type="hidden" name="search_in_brand" value="">
						<input type="hidden" name="season" value="">
						<input type="hidden" name="gender" value="">
						<input type="hidden" name="go_filter" value="">
						<input class="form-control" type="search" placeholder="Search" aria-label="Search" id="search_in_title" name="search_in_title">
						<input class="form-control" type="submit" placeholder="Search" aria-label="Search" id="search_submit" name="submit">
					</form>
				</div>
				<ul class="navbar-nav">
					<div class="navsection">
						<details open>
							<summary>OUR BRAND<span class="chev">›</span></summary>
							<div class="brand-intro">
								<div class="tile">
									<div class="brandtitle">Spark</div>
									<div class="chips">
										<a class="chip go-brand" data-brand-desc="T-Shirt" data-brand="spark">T-Shirt</a>
										<a class="chip go-brand" data-brand-desc="Shirt" data-brand="spark">Shirt</a>
										<a class="chip go-brand" data-brand-desc="3 PCS BABA SUIT" data-brand="spark">Three Sets</a>
										<a class="chip go-brand" data-brand-desc="Bottom" data-brand="spark">Bottom</a>
									</div>
								</div>
								<div class="tile">
									<div class="brandtitle">BloomUp</div>
									<div class="chips">
										<a class="chip" href="<?php echo base_url('home/shop'); ?>">Top's</a>
										<a class="chip" href="<?php echo base_url('home/shop'); ?>">Bottoms</a>
										<a class="chip" href="<?php echo base_url('home/shop'); ?>">Sets</a>
										<a class="chip" href="<?php echo base_url('home/shop'); ?>">Dungarees</a>
										<a class="chip" href="<?php echo base_url('home/shop'); ?>">Dresses</a>
									</div>
								</div>
							</div>
							<div class="muted">Clothing That Feels Like Home.</div>
						</details>
					</div>
					<?php if (!empty($this->session->userdata('logged_user'))) { ?>
						<div class="navsection">
							<details>
								<summary><a href="<?php echo base_url('home/account'); ?>">MY ACCOUNT</a><span class="chev">›</span></summary>
								<div class="nav-items">
									<a class="nav-links" href="<?php echo base_url('home/account'); ?>">My Orders</a>
									<a class="nav-links" href="<?php echo base_url('wishlist'); ?>">Wishlist</a>
									<a class="nav-links" href="<?php echo base_url('myaccount'); ?>">Addresses</a>
									<a class="nav-links" href="<?= base_url('home/account'); ?>">Profile</a>
									<a class="nav-links" href="<?php echo base_url('logout'); ?>">Logout</a>
								</div>
							</details>
						</div>
					<?php } else { ?>
						<div class="navsection">
							<details>
								<summary><a href="<?php echo base_url('register'); ?>">MY ACCOUNT</a><span class="chev">›</span></summary>
							</details>
						</div>
					<?php } ?>
					<div class="navsection">
						<details>
							<summary>HELP & SUPPORT <span class="chev">›</span></summary>
							<div class="nav-items">
								<a class="nav-links" href="<?php echo base_url('page/terms-conditions'); ?>">Terms & Conditions</a>
								<a class="nav-links" href="<?php echo base_url('page/privacy-policy'); ?>">Privacy Policy</a>
								<a class="nav-links" href="<?php echo base_url('page/track-order'); ?>">Track Order</a>
								<a class="nav-links" href="<?php echo base_url('page/returns-exchange'); ?>">Returns & Exchanges</a>
								<a class="nav-links" href="<?php echo base_url('page/shipping'); ?>">Shipping Information</a>
								<a class="nav-links" href="<?php echo base_url('page/payment-method'); ?>">Payment Methods</a>
								<a class="nav-links" href="<?php echo base_url('page/gift-cards'); ?>">Gift Cards</a>
							</div>
						</details>
					</div>
					<div class="bottom-cta">
						<a class="btn btn-success w-100 rounded-pill text-center my-2" href="<?php echo base_url('checkout'); ?>">Proceed to Checkout</a>
						<a class="btn_button w-100 rounded-pill text-center py-2 d-block" href="<?php echo base_url('shopping-cart'); ?>">View Cart</a>
					</div>
				</ul>
			</div>
		</div>
		<div class="offcanvas offcanvas-end searchform" tabindex="-1" id="searchOffcanvas">
			<div class="offcanvas-body">
				<div class="d-flex">
					<form class="form-horizontal w-100" method="GET" action="<?php echo base_url('home/shop'); ?>" id="bigger-search">
						<input type="hidden" name="category" value="">
						<input type="hidden" name="in_stock" value="">
						<input type="hidden" name="search_in_title" value="">
						<input type="hidden" name="order_new" value="">
						<input type="hidden" name="order_price" value="">
						<input type="hidden" name="order_procurement" value="">
						<input type="hidden" name="brand_id" value="">
						<input type="hidden" name="search_in_desc" value="">
						<input type="hidden" name="search_in_color" value="">
						<input type="hidden" name="search_in_size" value="">
						<input type="hidden" name="search_in_brand" value="">
						<input class="form-control" type="search" placeholder="Search" aria-label="Search" id="search_in_title" name="search_in_title">
					</form>
					<button type="button" class="btn-close text-reset shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="fw-bold mb-3">POPULAR SEARCHES</div>
				<ul class="list-unstyled">
					<li class="pb-2"><a href="<?php echo base_url('home/shop'); ?>?search_in_title=tshirt" data-search="tshirt">T-SHIRT</a></li>
					<li class="pb-2"><a href="<?php echo base_url('home/shop'); ?>?search_in_title=shirt" data-search="shirt">SHIRT</a></li>
					<li class="pb-2"><a href="<?php echo base_url('home/shop'); ?>?search_in_title=bottom" data-search="bottom">BOTTOM</a></li>
					<li class="pb-2"><a href="<?php echo base_url('home/shop'); ?>?search_in_title=sets" data-search="sets">3 PCS BABA SUIT</a></li>
					<li class="pb-2"><a href="<?php echo base_url('home/shop'); ?>?search_in_title=dresses" data-search="dresses">DUNGREE SET</a></li>
				</ul>
			</div>
		</div>
	</header>
	<main>
		<div class="modal fade rolepopup" id="roleModal1" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<p class="h2_heading mb-0">Select a Role</p>
					<p class="role_text mb-3">Choose the option that best reflects how your business operates.</p>
					<div class="role-card" data-role="agent">
						<strong>Agent</strong>
						<p class="role_text">Represents brands and connects them with partners.</p>
					</div>
					<div class="role-card" data-role="distributor">
						<strong>Distributor</strong>
						<p class="role_text">Supplies products from manufacturers to sales channels.</p>
					</div>
					<div class="role-card" data-role="retailer">
						<strong>Retailer</strong>
						<p class="role_text">Sells products directly to customers.</p>
					</div>
					<div class="role-card" data-role="wholesaler">
						<strong>Wholesaler</strong>
						<p class="role_text">Buys products in volume for retail supply.</p>
					</div>
					<div class="d-flex justify-content-between align-items-center mt-4">
						<button id="cancelBtn" class="btn btn-link">
							Cancel
						</button>
						<button id="continueBtn" class="btn btn-primary" disabled>
							Continue
						</button>
					</div>
				</div>
			</div>
		</div>