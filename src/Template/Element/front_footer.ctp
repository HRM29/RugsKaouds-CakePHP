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
    <?php
    $image = WWW_ROOT . 'img' . DS . "nwsltr_bg.jpg";
    if (file_exists($image)) {
        $newsletterImg = Router::url('/', true) . 'img/' . "nwsltr_bg.jpg";
    }
    ?>
    <section class="grnt_nws" style="background-image: url( <?= $newsletterImg; ?>);">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 no_padding">
                    <div class="grntee">
                        <div class="heading">
                            <h2>Customer Feedback & Comments</h2>
                        </div>
                        <p>We guarantee our products and services. Our handmade rugs are guaranteed to be made from the finest of materials without any defect. We guarantee that under normal conditions and with proper care, your Kaoud Hand Knotted Carpet will last a lifetime.</p>
                        <p>If for any reason after the sale you are not completely satisfied within 30 days of your purchase, we will gladly take your rug back and exchange it for the rug of your choice.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 no_padding">
                    <div class="nwsltr">
                        <div class="heading">
                            <h2>Newsletter</h2>
                        </div>
                        <?= $this->Form->create(null, ['url' => "javscript:void(0)", 'id' => "subscribe-newsletter"]) ?>
                        <div class="form_group">
                            <?= $this->Form->control('subscriber_name', ['placeholder' => 'Your Name*', 'class' => 'fotm_control', "required", 'label' => false]) ?>
                        </div>
                        <div class="form_group my-1">
                            <?= $this->Form->control('email', ['placeholder' => 'Your Email*', 'class' => 'fotm_control', 'label' => false, "required"]) ?>
                            <?= $this->Form->control('subscribe-type', ["type" => "hidden", 'value' => "newsletter"]) ?>
                        </div>
                        <div class="form_group">
                            <?= $this->Form->control('Sign Up', ['type' => 'button', 'class' => 'btn subscribe-newsletter', 'label' => false, "required"]) ?>
                        </div>
                        <?= $this->Form->control('g-recaptcha-response', ["type" => "hidden", "id" => 'g-recaptcha-response']); ?>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    $(document).ready(function() {
        $(".subscribe-newsletter").on("click", function(event) {
            let isValid = true;

            // Get form values
            let name = $("#subscriber-name").val().trim();
            let email = $("#email").val().trim();

            // Clear previous error messages
            $(".error").remove();

            // Name validation
            if (name === "") {
                isValid = false;
                $("#subscriber-name").after('<span class="error" style="color: red;">Name is required.</span>');
            }

            // Email validation
            if (email === "") {
                isValid = false;
                $("#email").after('<span class="error" style="color: red;">Email is required.</span>');
            } else if (!validateEmail(email)) {
                isValid = false;
                $("#email").after('<span class="error" style="color: red;">Enter a valid email address.</span>');
            }

            if (isValid) {
                const newsLetterForm = document.getElementById("subscribe-newsletter");
                let formData = new FormData(newsLetterForm);
                const csrfToken = $("[name='_csrfToken']").val();

                $.ajax({
                    headers: {
                        'X-CSRF-Token': csrfToken
                    },
                    url: "<?php echo Router::url(['controller' => 'Pages', 'action' => 'subscribeLetter']); ?>", // Form action URL
                    type: "POST", // HTTP method
                    data: formData,
                    processData: false, // Don't process the FormData
                    contentType: false, // Don't set content type
                    success: function(response) {
                        // Handle success response
                        if (response.success) {
                            Swal.fire({
                                title: "Success!",
                                text: response.message,
                                icon: "success",
                                confirmButtonText: "OK",
                                customClass: {
                                    popup: "small-alert", // Apply custom class to the popup
                                },
                            }).then(() => {
                                // Optionally reset the form or redirect
                                $("#subscribe-newsletter")[0].reset();
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error",
                                confirmButtonText: "OK",
                                customClass: {
                                    popup: "small-alert", // Apply custom class to the popup
                                },

                            });
                        }
                    },
                    error: function(xhr) {
                        // Handle error response
                        Swal.fire({
                            title: "An Error Occurred!",
                            text: `Error Code: ${xhr.status}, ${xhr.statusText}`,
                            icon: "error",
                            confirmButtonText: "OK",
                            customClass: {
                                popup: "small-alert", // Apply custom class to the popup
                            },
                        });
                    },
                });
            }
        });

        function validateEmail(email) {
            let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
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