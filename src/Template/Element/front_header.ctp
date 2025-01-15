<?php

use Cake\Routing\Router;

$session = $this->request->getSession();
$authUser = $session->read('Auth');
$action = $this->request->getParam('action');
$controller = $this->request->getParam('controller');
?>

<?php echo $this->Html->script(['jquery-3.7.1.min.js']); ?>
<?php echo $this->Html->script(['popper.min.js']); ?>
<?php echo $this->Html->script(['bootstrap.min.js']); ?>
<?php echo $this->Html->script(['jquery.matchHeight-min.js']); ?>
<?php echo $this->Html->script(['owl.carousel.js']); ?>
<?php echo $this->Html->script(['bootstrap.bundle.min.js']); ?>
<?php echo $this->Html->script(['select2.min.js']); ?>
<?php echo $this->Html->script(['owl.carousel.js']); ?>
<?php echo $this->Html->script(['custom.min.js']); ?>
<?php echo $this->Html->script(['search.custom.min.js']); ?>
<?php echo $this->Html->script(['jquery.payform.min.js']); ?>
<?php echo $this->Html->script(['script.js']); ?>
<?php echo $this->Html->script(['sweetalert2.min.js']); ?>
<?php echo $this->Html->script(['fancybox.umd.js']); ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?= CAPTCHA_SITEKEY ?>"></script>

<header id="myHeader">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-md-1">
				<div class="logo">
					<a href="/Kaouds/"><?php echo $this->Html->image('logo.jpg', ['alt' => 'logo']); ?></a>
				</div>
			</div>
			<div class="col-md-11">
				<div class="menus">
					<nav class="navbar navbar-expand-lg navbar-light">
						<button class="navbar-toggler" type="button" onclick="sdbr_open()">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse" id="mySidebar">
							<ul class="navbar-nav me-auto mb-2 mb-lg-0">
								<button onclick="sdbr_close()" class="close">&times;</button>
								<li class="nav-item"><a class="nav-link <?= $action; ?> <?= $action == 'shopping' || $action == 'rugs' ? 'active'  : ''; ?>" href="<?php echo Router::url('/', true) ?>shop">Shop</a></li>
								<li class="nav-item"><a class="nav-link <?= $action == 'collectionMenu' ? 'active'  : ''; ?>" href="<?php echo Router::url('/', true) ?>collections">Collections</a></li>
								<li class="nav-item"><a class="nav-link" href="#">Services</a></li>
								<li class="nav-item"><a class="nav-link" href="#">Rug Care</a></li>
								<li class="nav-item"><a class="nav-link" href="#">Choosing A Rug</a></li>
								<li class="nav-item"><a class="nav-link" href="#">Faqs</a></li>
								<li class="nav-item"><a class="nav-link" href="#">About</a></li>
								<li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
								<li class="nav-item"><a class="nav-link" href="#">Projects</a></li>
								<li class="nav-item"><a class="nav-link <?= $action == 'contactUs' ? 'active'  : ''; ?>" href="<?php echo Router::url('/', true) ?>contact">Contact</a></li>
							</ul>
						</div>
						<div class="srch_icon">
							<ul>
								<li><a href="#"><i class="bi bi-search"></i></a></li>
								<li><a href="#"><i class="bi bi-cart-fill"></i><span>0</span></a></li>
							</ul>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</div>
</header>
<script>
	document.getElementById('search-details').addEventListener('keyup', function(event) {
		if (event.code === 'Enter') {
			event.preventDefault();
			document.querySelector('form').submit();
		}
	});
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
</script>