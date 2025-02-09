<?php

use Cake\Routing\Router;
use Cake\Core\Configure;
?>
<section class="inner_banner shp">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading">
					<h1></h1>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
if (isset($projects) && !empty($projects)) {
?>
    <section class="collections">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Completed Projects</h2>
                        <p>Feel free to browse through our recently completed projects. We hope they inspire you to allow us the opportunity to start one for you today!</p>
                    </div>
                </div>
                <br />
                <?php
                foreach ($projects as $projectsimages) {
                    $imageURL = $this->Url->build('/uploads/projects/' . $projectsimages['image_url']);
                ?>
                    <div class="col-md-2">
                        <div class="clctns">
                            <a href="<?php echo $imageURL; ?>" data-fancybox="gallery" data-src="<?php echo $imageURL; ?>" data-caption="<?= $projectsimages['label']; ?>">
                                <?php
                                $image = WWW_ROOT . 'uploads' . DS . 'projects' . DS . $projectsimages['image_url'];
                                if (file_exists($image)) {
                                    echo $this->Html->image('/uploads/projects/' . $projectsimages['image_url'], ['alt' => $projectsimages['image_url']]);
                                }
                                ?>
                                <h3><?= $projectsimages['label']; ?></h3>
                            </a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
<?php
}
?>

<!-- contact area end -->
<script>
    Fancybox.bind('[data-fancybox]', {
        Toolbar: {
            display: {
                left: [],
                middle: ["prev", "infobar", "next"],
                right: ["close"],
            }
        },
        animationEffect: "zoom",
        Thumbs: false,
        caption: (fancybox, slide) => {
          const caption = slide.caption || "";
          return `${caption}`;
        },
    });
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