<?php

use Cake\Routing\Router;
use Cake\Core\Configure;
?>

<?php
$leave_a_comment_form = $this->Form->create(null, ['url' => "javscript:void(0)", 'id' => "leave-us-comment"]);
$leave_a_comment_form .= '<div class="row">';
$leave_a_comment_form .= '<div class="col-md-12">
							<h2>Leave a Reply</h2>
							<p>Your email address will not be published. Required fields are marked.</p>
						</div>';
$leave_a_comment_form .= '<div class="col-md-12">
			<div class="form_group">
				' . $this->Form->textarea('contact-comment', ['class' => 'fotm_control', 'placeholder' => 'Comment', 'id' => "contact-comment", 'label' => false]) . '
			</div>
		  </div>';

$leave_a_comment_form .= '<div class="col-md-4">
			<div class="form_group">
				' . $this->Form->control('contact-name', ['class' => 'fotm_control', 'placeholder' => 'Name', 'id' => "contact-name", 'label' => false]) . '
			</div>
		  </div>';

$leave_a_comment_form .= '<div class="col-md-4">
			<div class="form_group">
				' . $this->Form->control('contact-email', ['class' => 'fotm_control', 'placeholder' => 'Email', 'id' => "contact-email", 'label' => false]) . '
			</div>
		  </div>';

$leave_a_comment_form .= '<div class="col-md-4">
			<div class="form_group">
				' . $this->Form->control('contact-website', ['class' => 'fotm_control', 'placeholder' => 'Website', 'id' => "contact-website", 'label' => false]) . '
			</div>
		  </div>';

$leave_a_comment_form .= $this->Form->control('subscribe-type', ['type' => 'hidden', 'value' => 'contact_us']);

$leave_a_comment_form .= $this->Form->control('g-recaptcha-response', ['type' => 'hidden', 'class' => 'g-recaptcha-response', 'id' => false]);

$leave_a_comment_form .= '<div class="form_group">
			' . $this->Form->button(__('Post Comment'), ['class' => 'btn contact-kaouds', 'type' => 'button']) . '
		  </div>';
$leave_a_comment_form .= '</div>';

$leave_a_comment_form .= $this->Form->end();

if (!empty($contentData)) {
	$contentData->content = str_replace('{$leave-a-comment-form}', $leave_a_comment_form, $contentData->content);
	echo $contentData->content;
}

?>

<script>
	$('.mn_slide').owlCarousel({
		loop: true,
		margin: 30,
		nav: true,
		dots: false,
		autoplay: true,
		autoplayTimeout: 5000,
		navText: ['<?php echo $this->Html->image('prev_wht.png', ['alt' => 'prev_wht']); ?>', '<?php echo $this->Html->image('next_wht.png', ['alt' => 'next_wht']); ?>'],
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

	$('.cmunty_slide').owlCarousel({
		loop: true,
		margin: 30,
		nav: true,
		dots: false,
		autoplay: true,
		autoplayTimeout: 5000,
		navText: ['<?php echo $this->Html->image('prev.png', ['alt' => 'prev']); ?>', '<?php echo $this->Html->image('next.png', ['alt' => 'next']); ?>'],
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
	$(".contact-kaouds").on("click", function(event) {
		let isValid = true;

		// Get form values
		let name = $("#contact-name").val().trim();
		let email = $("#contact-email").val().trim();
		let messageInput = $("#contact-comment").val().trim();
		let websiteInput = $("#contact-website").val().trim();
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
			$("#contact-comment").after('<span class="error" style="color: red;">Comment is required.</span>');
			isValid = false;
		} else if (messageInput.length > 1000) {
			$("#contact-comment").after('<span class="error" style="color: red;">Comment cannot exceed 1000 characters.</span>');
			isValid = false;
		}

		if (websiteInput.trim() === '') {
			$("#contact-website").after('<span class="error" style="color: red;">Website is required.</span>');
			isValid = false;
		} else if (websiteInput.length > 1000) {
			$("#contact-website").after('<span class="error" style="color: red;">Website cannot exceed 1000 characters.</span>');
			isValid = false;
		}
		if (isValid) {
			const newsLetterForm = document.getElementById("leave-us-comment");
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
							$("#leave-us-comment")[0].reset();
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