<?php

use Cake\Routing\Router;
use Cake\Core\Configure;
?>
<section class="inner_banner shp">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading">
					<h3>Collections</h3>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
if (isset($collection) && !empty($collection)) {
?>
    <section class="collections">
        <div class="container">
            <?php
            if ($PageType == 'Collections') {
            ?>
                <div class="row">
                    <?php
                    foreach ($collection as $collectionData) {
                    ?>
                        <div class="col-lg-2 col-md-3">
                            <div class="clctns">
                                <a href="<?php echo Router::url('/', true) . "collections/" . $collectionData['page_url']; ?>">
                                    <?php
                                    if (isset($collectionData['collection_images']) && !empty($collectionData['collection_images'])) {
                                        $image = WWW_ROOT . 'uploads' . DS . 'collection' . DS . $collectionData['collection_images'][0]['file_path'];
                                        if (file_exists($image)) {
                                            echo $this->Html->image('/uploads/collection/' . $collectionData['collection_images'][0]['file_path'], ['alt' => $collectionData['collection_images'][0]['file_path']]);
                                        }
                                    }
                                    ?>
                                    <h3><?php echo $collectionData['title'] ?></h3>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                </div>
            <?php
            } elseif ($PageType == 'CollectionPage') {
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="heading">
                            <h2><?php echo strtoupper($collection['title']); ?></h2>
                        </div>
                    </div>
                    <br/>
                    <?php
                    if (isset($collection['collection_images']) && !empty($collection['collection_images'])) {
                        $collectionImages = $collection['collection_images'];
                        foreach ($collectionImages as $imagesData) {
                            $imageURL = $this->Url->build('/uploads/collection/' . $imagesData['file_path']);
                    ?>
                            <div class="col-lg-2 col-md-3">
                                <div class="clctns">
                                    <a href="<?php echo $imageURL; ?>" data-fancybox="gallery" data-src="<?php echo $imageURL; ?>">
                                        <?php
                                        $image = WWW_ROOT . 'uploads' . DS . 'collection' . DS . $imagesData['file_path'];
                                        if (file_exists($image)) {
                                            echo $this->Html->image('/uploads/collection/' . $imagesData['file_path'], ['alt' => $imagesData['file_path']]);
                                        }
                                        ?>
                                    </a>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>

                </div>
            <?php
            }
            ?>
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
        Thumbs: false
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