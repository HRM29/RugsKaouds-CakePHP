<?php

use Cake\Routing\Router; ?>
<section class="footer">
    <!-- <div class="container">
        <div class="row">
            <div class="show-mob top-bar-socials"> <a target="_blank" href="https://www.facebook.com/GalleryOfOrientalRugs"><i class="fa fa-facebook"></i></a> <a target="_blank" href="https://www.instagram.com/galleryoforientalrugsnc"><i class="fa fa-instagram"></i></a>
            </div>
            <div class="col-sm-8">
                <ul class="footer-links">
                    <li><a href="<?php echo Router::url('/', true) ?>pages/faq">FAQs</a></li>
                    <li><a href="<?php echo Router::url('/', true) ?>pages/returns">Returns</a></li>
                    <li><a href="<?php echo Router::url('/', true) ?>pages/termsofuse">Terms Of Uses</a></li>
                    <li><a href="<?php echo Router::url('/', true) ?>pages/privacypolicy">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-sm-4 copyright-footer">
                <p>&copy;2024 Gallery of Oriental Rugs</p>
            </div>
        </div>
    </div> -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="ftr_menus">
                        <ul>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Our Stores</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Faqs</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="cpyrght">
                        <p>Copyright 2024 © Kaoud Carpets & Rugs</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</section>
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

    function refreshToken() {
        grecaptcha.execute("<?= CAPTCHA_SITEKEY ?>", {
            action: 'submit'
        }).then(function(token) {
            document.getElementById('g-recaptcha-response').value = token;
        });
    }
    grecaptcha.ready(function() {
        refreshToken();
        setInterval(refreshToken, 120000);
    });
</script>