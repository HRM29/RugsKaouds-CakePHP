<?php

use Cake\Routing\Router;
use Cake\Core\Configure;

$session = $this->request->getSession();
$authUser = $session->read('Auth');
$action = $this->request->getParam('action');
$slug = $this->request->getParam('slug');
$controller = $this->request->getParam('controller');
?>
<section class="footer">
    <?php
    $footer_image = WWW_ROOT . '/uploads/header_footer' . DS . $footerData->background_image;
    if (file_exists($footer_image)) {
        $footerImg = Router::url('/', true) . 'media/view/footer-file/' . $footerData->background_image;
    }
    ?>
    <section class="grnt_nws" style="background-image: url(<?= $footerImg; ?>);">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5 col-md-12">
                    <div class="grntee">
                        <div class="heading">
                            <h2><?php echo $footerData->heading; ?></h2>
                        </div>
                        <p><?php echo $footerData->description; ?></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="grntee lctn">
                        <div class="heading">
                            <h2>Store Location</h2>
                        </div>
                        <a href="https://www.google.com/maps/place/Kaoud+Carpets+%26+Rugs/@41.1638658,-73.4211357,17z/data=!3m1!4b1!4m5!3m4!1s0x89e81d1fe79dcc0f:0x60cd628477e28356!8m2!3d41.1638658!4d-73.418947">
                            <p><i class="bi bi-geo-alt-fill"></i> <?php echo Configure::read("App.Address"); ?></p>
                        </a>
                        <a href="tel:<?php echo Configure::read("App.phone"); ?>">
                            <p><i class="bi bi-telephone-fill"></i> <?php echo Configure::read("App.phone"); ?></p>
                        </a>
                        <p class="announcement"><i class="bi bi-alarm-fill"></i> Monday to Saturday: 9:30am to 5:30pm</p>
                        <p class="announcement"><i class="bi bi-alarm-fill"></i> Sunday: 12pm to 4pm</p>
                    </div>
                </div>
				<div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="grntee scl">
                        <div class="heading">
                            <h2>Social Links</h2>
                        </div>
						<ul>
							<li><a href="https://www.facebook.com/people/Kaoud-Carpets-Rugs/100063498433021/"><i class="bi bi-facebook" target="_blank"></i> Facebook</a></li>
							<li><a href="https://www.instagram.com/kaoudcarpetandrugs/"><i class="bi bi-instagram" target="_blank"></i> Instagram</a></li>
							<li><a href="https://x.com/i/flow/login?redirect_after_login=%2FKaoudCarpets" target="_blank"><i class="bi bi-twitter-x"></i> Twitter</a></li>
							<li><a href="https://www.linkedin.com/in/fred-kaoud-jr-8a98238/?original_referer=https%3A%2F%2Fkaouds.com%2F" target="_blank"><i class="bi bi-linkedin"></i> Linkedin</a></li>
						</ul>
						<div class="heading mt-5">
                            <a href="https://www.bbb.org/us/ct/wilton/profile/carpet-and-rugs/kaoud-carpets-rugs-0111-87015755/#sealclick" target="_blank" rel="nofollow"><img src="https://seal-ct.bbb.org/seals/blue-seal-200-42-whitetxt-bbb-87015755.png" style="border: 0;" alt="Kaoud Carpets & Rugs BBB Business Review" /></a>
                        </div>
					</div>
				</div>	
            </div>
        </div>
    </section>
    <footer>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="ftr_menus">
                        <ul>
                            <li><a class="<?= $action; ?>" href="<?php echo Router::url('/', true) ?>about-us">About</a></li>
                            <li><a href="<?php echo Router::url('/', true) ?>our-stores">Our Stores</a></li>
                            <li><a href="<?php echo Router::url('/', true) ?>blog">Latest News</a></li>
                            <li><a href="<?php echo Router::url('/', true) ?>faqs">Faqs</a></li>
                            <li><a href="<?php echo Router::url('/', true) ?>privacy-policy">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="cpyrght">
                        <p>Copyright <?= date('Y') ?> © Kaoud Carpets & Rugs</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</section>
<div id="loadingModal" class="modal-overlay">
    <div class="loader"></div>
</div>
<script>
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

    function refreshToken() {
        grecaptcha.execute("<?= CAPTCHA_SITEKEY ?>", {
            action: 'submit'
        }).then(function(token) {
            console.log('Token refreshed at:', new Date().toLocaleTimeString());
            document.querySelectorAll('.g-recaptcha-response').forEach(element => {
                element.value = token;
            });
        });
    }
    grecaptcha.ready(function() {
        refreshToken();
        setInterval(refreshToken, 60000);
    });
</script>