<?php

use Cake\Routing\Router;
use Cake\Core\Configure;
?>
<section class="main_banner">
    <div class="container-fluid">
        <div class="row">
        </div>
    </div>
</section>
<section class="rg_clng">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">

                </div>
                <?= $this->Form->create(null, ['url' => "javscript:void(0)", 'id' => "contact-us"]) ?>
                <h3>Contact US</h3>
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
                    <?= $this->Form->control('Sign Up', ['type' => 'button', 'class' => 'btn contact-kaouds', 'label' => false, "id" => "contact-kaouds"]) ?>
                </div>
                <?= $this->Form->end() ?>
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