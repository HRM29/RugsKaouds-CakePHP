<?php

use Cake\Routing\Router;
use Cake\Core\Configure;

$session = $this->request->getSession();
$session = $this->request->getSession();
$cardData = $session->read('cart');
if (empty($cardData)) {
	$cart_count = 0;
} else {
	$cart_count = count($cardData);
}
$authUser = $session->read('Auth');
$action = $this->request->getParam('action');
$slug = $this->request->getParam('slug');
$controller = $this->request->getParam('controller');

$aboutUs_Slugs = ['kaoud-carpets-rugs', 'our-brands-inventory', 'community', 'asid'];
$shop_Actions = ['shopping', 'rugs', 'cart', 'checkout', 'productView'];
$services_Actions = ['rugcleaning', 'rugrepair', 'rugappraisal', 'rugsellus'];
?>

<?php echo $this->Html->script(['jquery-3.7.1.min.js']); ?>
<?php echo $this->Html->script(['popper.min.js']); ?>
<?php echo $this->Html->script(['bootstrap.min.js']); ?>
<?php echo $this->Html->script(['jquery.matchHeight-min.js']); ?>
<?php echo $this->Html->script(['owl.carousel.js']); ?>
<?php echo $this->Html->script(['select2.min.js']); ?>
<?php echo $this->Html->script(['owl.carousel.js']); ?>
<?php echo $this->Html->script(['custom.min.js']); ?>
<?php echo $this->Html->script(['search.custom.min.js']); ?>
<?php echo $this->Html->script(['jquery.payform.min.js']); ?>
<?php echo $this->Html->script(['script.js']); ?>
<?php echo $this->Html->script(['sweetalert2.min.js']); ?>
<?php echo $this->Html->script(['fancybox.umd.js']); ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?= CAPTCHA_SITEKEY ?>"></script>

<div class="topbar">
	<div class="container-fluid">
		<div class="row align-items-center announcement">
			<div class="col-md-5">
				<a href="tel:<?php echo Configure::read("App.phone"); ?>">Call Us</a>
				<a href="https://www.google.com/maps/place/Kaoud+Carpets+%26+Rugs/@41.1638658,-73.4211357,17z/data=!3m1!4b1!4m5!3m4!1s0x89e81d1fe79dcc0f:0x60cd628477e28356!8m2!3d41.1638658!4d-73.418947" target="_blank">Visit Us</a>
			</div>
			<div class="col-md-7">
				<p><?php echo Configure::read("App.site-announcement"); ?></p>
			</div>

			<!-- <div class="col-md-7">
			</div>
			<div class="col-md-5">
				<div class="social">
					<ul>
						<li><a href="https://www.facebook.com/profile.php?id=100063498433021#" target="_blank"><i class="bi bi-facebook"></i></a></li>
						<li><a href="https://www.instagram.com/kaoudcarpetandrugs/" target="_blank"><i class="bi bi-instagram"></i></a></li>
						<li><a href="https://x.com/KaoudCarpets?mx=2" target="_blank"><i class="bi bi-twitter-x"></i></a></li>
						<li><a href="https://x.com/KaoudCarpets?mx=2" target="_blank"><i class="bi bi-linkedin"></i></a></li>
						<li><a href="mailto:info@kaouds.com" target="_blank"><i class="bi bi-envelope-fill"></i></a></li>
						<li><a href="tel:203.762.0376" target="_blank"><i class="bi bi-telephone-fill"></i></a></li>
					</ul>
				</div>
			</div> -->
		</div>
	</div>
</div>

<header id="myHeader">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-md-2">
				<div class="logo" style="padding: 5px 0;">
					<a href="/Kaouds/">
						<!--?php echo $this->Html->image('logo.jpg', ['alt' => 'logo']); ?-->
						<img src="<?php echo LOGO_URL; ?>" alt="logo">
						<img class="mbl" src="img/mbl_logo.jpg?ver=1" alt="logo">
					</a>
				</div>
			</div>
			<div class="col-md-10">
				<div class="menus">
					<nav class="navbar navbar-expand-lg navbar-light">
						<button class="navbar-toggler" type="button" onclick="sdbr_open()">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse" id="mySidebar">
							<ul class="navbar-nav me-auto mb-2 mb-lg-0">
								<button onclick="sdbr_close()" class="close">&times;</button>
								<li class="nav-item"><a class="nav-link <?= in_array($action, $shop_Actions) ? 'active'  : ''; ?>" href="<?php echo Router::url('/', true) ?>shop">Shop</a></li>
								<!--li class="nav-item"><a class="nav-link <?= $action == 'collectionMenu' ? 'active'  : ''; ?>" href="<?php echo Router::url('/', true) ?>collections">Collections</a></li-->
								<?php
								if (isset($collectionCategoriesData) && !empty($collectionCategoriesData)) {
								?>
									<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Collections</a>
										<div class="dropdown-menu mega" aria-labelledby="navbarDropdown">
											<div class="container">
												<div class="row">
													<?php
													foreach ($collectionCategoriesData as $parentKey => $parendData) {
													?>
														<div class="col-md-2 no_padding">
															<h4><?php echo $parendData['ParentName']; ?></h4>
															<?php
															if (isset($parendData['SubCategory']) && !empty($parendData['SubCategory'])) {
															?>
																<ul class="nav flex-column">
																	<?php
																	foreach ($parendData['SubCategory'] as $subCategoryKey => $subCategoryValue) {
																	?>
																		<li class="nav-item"> <a class="nav-link" href="<?php echo Router::url('/', true) . "collections/" . $subCategoryValue['SubCategorySlug']; ?>"><?php echo $subCategoryValue['SubCategoryName'] ?></a> </li>
																	<?php
																	}
																	?>
																</ul>
															<?php
															}
															?>
														</div>
													<?php
													}
													?>

												</div>
											</div>
										</div>
									</li>
								<?php
								}
								?>

								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle <?= in_array($action, $services_Actions) ? 'active'  : ''; ?>" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Services</a>
									<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
										<li><a class="dropdown-item" href="<?php echo Router::url('/', true) ?>rug-cleaning-form">Schedule Rug Cleaning</a></li>
										<li><a class="dropdown-item" href="<?php echo Router::url('/', true) ?>schedule-pickup-for-rug-repair">Schedule Rug Repair</a></li>
										<li><a class="dropdown-item" href="<?php echo Router::url('/', true) ?>schedule-insurance-appraisal">Schedule Appraisal</a></li>
										<li><a class="dropdown-item" href="<?php echo Router::url('/', true) ?>schedule-sell-us">Schedule Sell Us</a></li>
									</ul>
								</li>
								<li class="nav-item"><a class="nav-link <?= $slug == 'rug-care' ? 'active'  : ''; ?>" href="<?php echo Router::url('/', true) ?>rug-care">Rug Care</a></li>
								<li class="nav-item"><a class="nav-link <?= $slug == 'choosing-a-rug' ? 'active'  : ''; ?>" href="<?php echo Router::url('/', true) ?>choosing-a-rug">Choosing A Rug</a></li>
								<li class="nav-item"><a class="nav-link <?= $slug == 'FAQS' || $slug == 'faqs' ? 'active'  : ''; ?>" href="<?php echo Router::url('/', true) ?>faqs">Faqs</a></li>
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle <?= in_array($slug, $aboutUs_Slugs) ? 'active'  : ''; ?>" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">About</a>
									<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
										<li><a class="dropdown-item" href="<?php echo Router::url('/', true) ?>about-us/kaoud-carpets-rugs">Kaoud Carpets & Rugs</a></li>
										<li><a class="dropdown-item" href="<?php echo Router::url('/', true) ?>about-us/our-brands-inventory">Our Brands & Inventory</a></li>
										<li><a class="dropdown-item" href="<?php echo Router::url('/', true) ?>about-us/community">Community</a></li>
										<?php /* ?>	<li><a class="dropdown-item" href="<?php echo Router::url('/', true) ?>about-us/asid">Asid</a></li>	<?php */ ?>
									</ul>
								</li>
								<li class="nav-item"><a class="nav-link" href="<?php echo Router::url('/', true) ?>blog">Latest News</a></li>
								<li class="nav-item"><a class="nav-link <?= $action == 'projects' ? 'active'  : ''; ?>" href="<?php echo Router::url('/', true) ?>completed-projects">Inspiration</a></li>
								<li class="nav-item"><a class="nav-link <?= $action == 'contactUs' ? 'active'  : ''; ?>" href="<?php echo Router::url('/', true) ?>contact">Contact</a></li>
							</ul>
						</div>
						<div class="srch_icon">
							<ul>
								<li><a href="<?php echo Router::url('/', true) ?>shop" class="btn">Shop Now</a></li>
								<li><a href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'myAccountRedirect']); ?>"><i class="bi bi-person-fill"></i></a></li>
								<li><a href="<?php echo Router::url('/', true); ?>users/wishlist"><i class="bi bi-heart-fill"></i></a></li>
								<li><a href="<?php echo $this->Url->build(['controller' => 'Products', 'action' => 'cart']); ?>"><i class="bi bi-cart-fill"></i><span><?= $cart_count; ?></span></a></li>
							</ul>
						</div>
						<div class="search">
							<form>
								<input type="text" type="text" id="searchInput" class="search-bar" placeholder="Search products..." autocomplete="off" />
								<div class="search-results" id="searchResults"></div>
								<button class="search-btn" type="button"><i class="bi bi-search"></i></button>
							</form>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- Search Bar (Initially Hidden) -->
<!-- <div class="search-container" id="searchContainer">
	<input type="text" id="searchInput" class="search-bar" placeholder="Search products..." autocomplete="off">
</div> -->
<script>
	if (document.getElementById('search-details')) {
		document.getElementById('search-details').addEventListener('keyup', function(event) {
			if (event.code === 'Enter') {
				event.preventDefault();
				document.querySelector('form').submit();
			}
		});
	}
	window.onscroll = function() {
		myFunction()
	};

	var header = document.getElementById("myHeader");
	var sticky = header.offsetTop;

	function myFunction() {
		if (window.pageYOffset > sticky) {
			header.classList.add("sticky");
		} else {
			header.classList.remove("sticky");
		}
	}

	function sdbr_open() {
		document.getElementById("mySidebar").style.display = "block";
	}

	function sdbr_close() {
		document.getElementById("mySidebar").style.display = "none";
	}

	if ($(".srvc_box_txt p").length != 0) {
		$(".srvc_box_txt p").matchHeight({
			byrow: false,
		});
	}

	if ($(".arrvl_text").length != 0) {
		$(".arrvl_text").matchHeight({
			byrow: false,
		});
	}

	if ($(".rvw_box p").length != 0) {
		$(".rvw_box p").matchHeight({
			byrow: false,
		});
	}

	if ($(".blg_text p").length != 0) {
		$(".blg_text p").matchHeight({
			byrow: false,
		});
	}
	// Show the loading modal
	function showLoadingModal() {
		document.getElementById('loadingModal').style.display = 'flex';
	}

	// Hide the loading modal
	function hideLoadingModal() {
		document.getElementById('loadingModal').style.display = 'none';
	}

	// document.getElementById("toggleSearch").addEventListener("click", function() {
	// 	let searchContainer = document.getElementById("searchContainer");

	// 	if (searchContainer.style.display === "block") {
	// 		searchContainer.style.display = "none";
	// 	} else {
	// 		searchContainer.style.display = "block";
	// 		document.getElementById("searchInput").focus(); // Auto-focus on input
	// 	}
	// });

	// // Close search bar when clicking outside
	// document.addEventListener("click", function(event) {
	// 	let searchContainer = document.getElementById("searchContainer");
	// 	let toggleButton = document.getElementById("toggleSearch");

	// 	if (!searchContainer.contains(event.target) && !toggleButton.contains(event.target)) {
	// 		searchContainer.style.display = "none";
	// 	}
	// });

	function debounce(func, wait) {
		let timeout;
		return function(...args) {
			const context = this;
			clearTimeout(timeout);
			timeout = setTimeout(() => func.apply(context, args), wait);
		};
	}

	function performSearch(query) {
		let searchResults = document.getElementById("searchResults");
		var csrfToken = <?php echo json_encode($this->request->getParam('_csrfToken')) ?>;
		$.ajax({
			headers: {
				'X-CSRF-Token': csrfToken
			},
			url: '<?php echo $this->Url->build(['controller' => 'Products', 'action' => 'searchProductByNameOrSku']); ?>', // Replace with your controller and action
			type: 'POST',
			dataType: 'json',
			data: {
				search_term: query
			},
			success: function(response) {
				if (response.status === 1 && response.data.length > 0) {
					searchResults.innerHTML = response.data.map(item =>
						`<div class="result-item" onclick="selectResult('${item.sku_no}')">
                            ${item.title} - <span style="color: #881C06;">${item.sku_no}</span>
                        </div>`
					).join("");
				} else {
					searchResults.innerHTML = `<div class="result-item">No results found</div>`;
					searchResults.style.display = "block";
				}
				searchResults.style.position = 'absolute';
				searchResults.style.display = 'block';
				searchResults.style.zIndex = '10';
			},
			error: function() {
				searchResults.innerHTML = `<div class="result-item">Error retrieving results</div>`;
				searchResults.style.display = "block";
			}
		});
	}

	function selectResult(SKUID) {
		const PRODUCT_URL = '<?php echo $this->Url->build(['controller' => 'Products', 'action' => 'productView']); ?>' + '/' + btoa(SKUID);
		window.location.href = PRODUCT_URL;
	}

	document.getElementById("searchInput").addEventListener("input", debounce(function() {
		let query = this.value.trim();
		if (query) {
			performSearch(query);
		} else {
			document.getElementById("searchResults").style.display = "none";
		}
	}, 300));

	document.querySelector(".search-btn").addEventListener("click", debounce(function() {
		let query = document.getElementById("searchInput").value.trim();
		if (query) {
			performSearch(query);
		} else {
			document.getElementById("searchResults").style.display = "none";
		}
	}, 300));
</script>