<?php
use Cake\Routing\Router;

$session = $this->request->getSession();
$authUser = $session->read('Auth');
?>

<!-- <div class="container-fluid bg-light">
	<div class="row">
		<div class="col-md-12">
			<nav class="navbar navbar-expand-lg navbar-light "> <span class="navbar-brand">Enjoy Free Shipping</span>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
				<div class="collapse navbar-collapse" id="navbarNavDropdown">
					<ul class="navbar-nav">
						<li class="nav-item active"> <a class="nav-link underline" href="<?php echo Router::url('/', true) ?>">Home <span class="sr-only">(current)</span></a> </li>
						<li class="nav-item"> <a class="nav-link underline" href="<?php echo $this->Url->build(['controller' => 'products', 'action' => 'shopping']); ?>">Shop </a> </li>
						<li class="nav-item"> <a class="nav-link underline" href="<?php echo Router::url('/', true) ?>pages/carpet">Carpet</a> </li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle underline" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Rug Cleaning </a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
								<a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/rugcleaning">Rug Cleaning</a>
								<a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/rugrepair">Rug Repair</a>
								<a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/rugappraisal">Rug Appraisal</a>
							</div>
						</li>

					</ul>

					<div class="logo">
						<a href="<?php echo Router::url('/', true) ?>">
							<?= $this->Html->image('logo.png', ['alt' => '', 'width' => '60px']); ?>
						</a>
						<p><a href="<?php echo Router::url('/', true) ?>">GALLERY OF ORIENTAL RUGS</a></p>
					</div>

					<ul class="navbar-nav">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle underline" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Interior design </a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
								<a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/interiordesign">Interior Design</a>
								<a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/pairingpatternsorientalrug">Pairing Patterns</a>
							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle underline" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">About Us</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
								<a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/aboutus">About Us</a>
								<a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/awardwinning">Award Winning</a>
								<a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/businesshighlights">Business Highlights</a>
								<a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/frednasseribio">Fred Nasseri Bio</a>
								<a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/videos">Videos</a>
							</div>
						</li>

						<li class="nav-item"> <a class="nav-link underline" href="<?php echo Router::url('/', true) ?>pages/contactUs">Contact Us</a> </li>
						<ul>


				</div>
			</nav>
		</div>
	</div>
</div> -->
<header id="myHeader">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-md-1">
				<div class="logo">
					<a href="#"><?php echo $this->Html->image('logo.jpg', ['alt' => 'logo']); ?></a>
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
								<li class="nav-item"><a class="nav-link active" href="#">Shop</a></li>
								<li class="nav-item"><a class="nav-link" href="#">Collections</a></li>
								<li class="nav-item"><a class="nav-link" href="#">Services</a></li>
								<li class="nav-item"><a class="nav-link" href="#">Rug Care</a></li>
								<li class="nav-item"><a class="nav-link" href="#">Choosing A Rug</a></li>
								<li class="nav-item"><a class="nav-link" href="#">Faqs</a></li>
								<li class="nav-item"><a class="nav-link" href="#">About</a></li>
								<li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
								<li class="nav-item"><a class="nav-link" href="#">Projects</a></li>
								<li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
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


	$('.arrvls_slide').owlCarousel({
		loop: true,
		margin: 30,
		nav: true,
		dots: false,
		autoplay: true,
		autoplayTimeout: 5000,
		navText: ['<img src="images/prev.png">', '<img src="images/next.png">'],
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 2
			},
			1200: {
				items: 3
			}
		}
	});

	$('.blg_slide').owlCarousel({
		loop: true,
		margin: 30,
		nav: true,
		dots: false,
		autoplay: true,
		autoplayTimeout: 5000,
		navText: ['<img src="images/prev.png">', '<img src="images/next.png">'],
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 2
			},
			1200: {
				items: 3
			}
		}
	});

	$('.tstmnls_slide').owlCarousel({
		loop: true,
		margin: 10,
		nav: true,
		dots: false,
		autoplay: true,
		autoplayTimeout: 5000,
		navText: ['<img src="images/tstmnls_arow_prv.png">', '<img src="images/tstmnls_arow_nxt.png">'],
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 1
			},
			1200: {
				items: 1
			}
		}
	});
</script>