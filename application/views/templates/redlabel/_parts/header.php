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
					<a class="navbar-brand" href="<?php echo base_url(); ?>">
						<img src="<?php echo base_url(); ?>assets/gallery/logo.webp" alt="houseofstitches"
							class="img-fluid d-none d-sm-block">
						<img src="<?php echo base_url(); ?>assets/gallery/hos.webp" alt="houseofstitches"
							class="img-fluid d-block d-sm-none">
					</a>
				</div>
				<ul class="list-unstyled d-none d-lg-flex align-items-center mb-0 gap-3 header-nav">
					<!-- <li><a class="header-nav-link" href="<?php echo base_url('home/shop'); ?>">Shop</a></li> -->
					<!-- <li><a class="header-nav-link" href="<?php echo base_url('offer'); ?>">Offers</a></li> -->
					<!-- <li><a class="header-nav-link" href="<?php echo base_url('wishlist'); ?>">Wishlist</a></li> -->
					<?php if (!empty($this->session->userdata('logged_user'))) { ?>
						<!-- <li><a class="header-nav-link" href="<?php echo base_url('home/account'); ?>">Account</a></li> -->
						<!-- <li><a class="header-nav-link" href="<?php echo base_url('shopping-cart'); ?>">Cart</a></li> -->
					<?php } else { ?>
						<li><a class="header-nav-link" href="<?php echo base_url('register'); ?>">Account</a></li>
					<?php } ?>
				</ul>
				<ul class="list-unstyled d-flex justify-content-between align-items-center mb-0 gap-4 me-md-3 me-1">
					<li class="nav-icon"><a href="<?php echo base_url('home/shop'); ?>" title="Shop"><i class="bi bi-grid"></i></a></li>
					<li class="nav-icon"><a href="<?php echo base_url('offer'); ?>" title="Offers"><i class="bi bi-tag"></i></a></li>
					<?php if (empty($this->session->userdata('logged_user'))) { ?>
						<li class="nav-icon"><a href="<?php echo base_url('register'); ?>"><i class="bi bi-person"></i></a></li>
					<?php } ?>
					<?php if (!empty($this->session->userdata('logged_user'))) { ?>
						<li class="nav-icon" method="GET" action="<?php echo base_url('home/shop'); ?>" id="bigger-search" data-bs-toggle="offcanvas" data-bs-target="#searchOffcanvas"><i class="bi bi-search"></i></li>
						<li class="nav-icon" style="text-shadow: none;"><a href="<?php echo base_url('home/barcode_scan'); ?>"><i class="bi bi-qr-code-scan"></i></a></li>
						<li class="nav-icon"><a href="<?php echo base_url('home/account'); ?>" title="My Account"><i class="bi bi-person-circle"></i></a></li>
						<li class="nav-icon"><a href="<?php echo base_url('wishlist'); ?>"><i class="bi bi-heart"></i></a></li>
						<li class="nav-icon position-relative">
							<a href="javascript:void(0);" id="cartIconBtn" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas">
								<i class="bi bi-bag"></i>
								<span class="wishlistcount" id="cartItemCount"><?php echo count(cart_item()); ?></span>
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
		<!-- Cart Offcanvas -->
	<div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" style="width:380px;max-width:100vw;">
		<div class="offcanvas-header border-bottom px-3 py-3">
			<h6 class="fw-bold mb-0 text-uppercase">Cart (<span id="cartDrawerCount">0</span>)</h6>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
		</div>
		<div class="offcanvas-body p-3" id="cartDrawerBody" style="overflow-y:auto;">
			<div class="text-center py-5 text-muted"><i class="bi bi-bag fs-1"></i><p class="mt-2">Loading...</p></div>
		</div>
		<div class="p-3 border-top" id="cartDrawerFooter" style="display:none;">
			<div class="d-flex justify-content-between fw-bold mb-3">
				<span>TOTAL</span>
				<span id="cartDrawerTotal">₹0</span>
			</div>
			<a href="<?= base_url('checkout') ?>" class="btn btn-dark w-100 rounded-0 mb-2">PROCEED TO CHECKOUT</a>
			<a href="<?= base_url('shopping-cart') ?>" class="btn btn-outline-dark w-100 rounded-0">VIEW FULL CART</a>
		</div>
	</div>
</header>
<script>
(function(){
	var cartOffcanvasEl  = document.getElementById('cartOffcanvas');
	var cartDrawerBody   = document.getElementById('cartDrawerBody');
	var cartDrawerCount  = document.getElementById('cartDrawerCount');
	var cartDrawerTotal  = document.getElementById('cartDrawerTotal');
	var cartDrawerFooter = document.getElementById('cartDrawerFooter');
	var cartItemCount    = document.getElementById('cartItemCount');
	var cartHtmlUrl   = '<?= base_url("home/get_cart_html") ?>';
	var manageCartUrl = '<?= base_url("home/manageShoppingCart") ?>';
	var minusQtyUrl   = '<?= base_url("home/minus_qty") ?>';
	var removeCartUrl = '<?= base_url("home/ajax_remove_cart") ?>';

	function ajaxPost(url, data, cb) {
		var body = Object.keys(data).map(function(k){
			return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
		}).join('&');
		fetch(url, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
				'X-Requested-With': 'XMLHttpRequest'
			},
			body: body
		}).then(cb || function(){}).catch(function(){});
	}

	function refreshCart() {
		fetch(cartHtmlUrl)
			.then(function(r){ return r.json(); })
			.then(function(d){
				cartDrawerBody.innerHTML = d.html;
				var c = parseInt(d.count) || 0;
				if (cartDrawerCount)  cartDrawerCount.innerText  = c;
				if (cartItemCount)    cartItemCount.innerText    = c;
				if (cartDrawerTotal)  cartDrawerTotal.innerText  = '\u20b9' + d.total;
				if (cartDrawerFooter) cartDrawerFooter.style.display = c > 0 ? 'block' : 'none';
			})
			.catch(function(){
				cartDrawerBody.innerHTML = '<p class="text-danger text-center mt-3">Could not load cart.</p>';
			});
	}

	if (cartOffcanvasEl) {
		cartOffcanvasEl.addEventListener('show.bs.offcanvas', refreshCart);
	}

	document.addEventListener('click', function(e){
		var plus   = e.target.closest('.cart-offcanvas-plus');
		var minus  = e.target.closest('.cart-offcanvas-minus');
		var remove = e.target.closest('.cart-offcanvas-remove');

		if (plus) {
			plus.disabled = true;
			ajaxPost(manageCartUrl, {
				article_id: plus.dataset.id,
				action: 'add',
				wsp: plus.dataset.wsp || 0,
				mrp: plus.dataset.mrp || 0
			}, refreshCart);
		}
		if (minus) {
			minus.disabled = true;
			ajaxPost(minusQtyUrl, {product_id: minus.dataset.id}, refreshCart);
		}
		if (remove) {
			remove.disabled = true;
			ajaxPost(removeCartUrl, {cart_id: remove.dataset.cartId}, function(){
				refreshCart();
				var cur = parseInt(cartItemCount && cartItemCount.innerText) || 0;
				if (cartItemCount && cur > 0) cartItemCount.innerText = cur - 1;
			});
		}
	});

	/* refresh badge count after add-to-cart on shop page */
	document.addEventListener('cartItemAdded', function(){
		fetch(cartHtmlUrl)
			.then(function(r){ return r.json(); })
			.then(function(d){ if (cartItemCount) cartItemCount.innerText = parseInt(d.count)||0; });
	});
})();
</script>
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