<?php

use Cake\Routing\Router;
use Cake\Core\Configure;
?>
<section class="inner_banner shp">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 no_padding">
                <div class="inr_bnr">
                    <?php
                    $image = WWW_ROOT . 'img' . DS . 'conact_us_banner.jpg';
                    if (file_exists($image)) {
                        echo $this->Html->image('/img/' . "conact_us_banner.jpg", ['alt' => "conact_us_banner"]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="rg_clng">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->create(null, ['url' => "javscript:void(0)", 'id' => "contact-us"]) ?>
                <h3>Contact</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <?= $this->Form->control('contact-name', ['placeholder' => 'Your Name*', 'class' => 'fotm_control', "required", 'label' => false]) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <?= $this->Form->control('contact-email', ['placeholder' => 'Your Email*', 'class' => 'fotm_control', 'label' => false, "required"]) ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form_group">
                            <?= $this->Form->control('contact-message', ['placeholder' => 'Message*', 'class' => 'fotm_control', 'label' => false, "required", "type" => "textarea", 'rows' => 5]) ?>
                        </div>
                    </div>
                </div>
                <?= $this->Form->control('g-recaptcha-response', ["type" => "hidden", "class" => "g-recaptcha-response", "id" => false]); ?>
                <?= $this->Form->control('subscribe-type', ["type" => "hidden", 'value' => "contact_us"]) ?>
                <div class="form_group">
                    <?= $this->Form->control('Submit', ['type' => 'button', 'class' => 'btn contact-kaouds', 'label' => false, "id" => "contact-kaouds"]) ?>
                </div>
                <?= $this->Form->end() ?>

                <div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d779.9606479109412!2d-73.41898929498979!3d41.16399106222474!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e81d1fe79dcc0f%3A0x60cd628477e28356!2sKaoud%20Carpets%20%26%20Rugs!5e1!3m2!1sen!2sin!4v1677135407724!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <!-- <a href="https://camzzle.com">look at this web-site</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact area end -->
<script>
    $(".contact-kaouds").on("click", function(event) {
        let isValid = true;

        // Get form values
        let name = $("#contact-name").val().trim();
        let email = $("#contact-email").val().trim();
        let messageInput = $("#contact-message").val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Clear previous error messages
        $(".error").remove();

        // Name validation
        if (name === "") {
            isValid = false;
            $("#contact-name").after('<span class="error" style="color: red;">Name is required.</span>');
        }

        // Email validation
        if (email === "") {
            isValid = false;
            $("#contact-email").after('<span class="error" style="color: red;">Email is required.</span>');
        } else if (!emailRegex.test(email.trim())) {
            isValid = false;
            $("#contact-email").after('<span class="error" style="color: red;">Enter a valid email address.</span>');
        }
        if (messageInput.trim() === '') {
            $("#contact-message").after('<span class="error" style="color: red;">Message is required.</span>');
            messageInput.focus();
            isValid = false;
        } else if (messageInput.length > 1000) {
            $("#contact-message").after('<span class="error" style="color: red;">Message cannot exceed 1000 characters.</span>');
            messageInput.focus();
            isValid = false;
        }
        if (isValid) {
            const newsLetterForm = document.getElementById("contact-us");
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
                            $("#contact-us")[0].reset();
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
</script>