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
				' . $this->Form->textarea('comment', ['class' => 'fotm_control', 'placeholder' => 'Comment']) . '
			</div>
		  </div>';

$leave_a_comment_form .= '<div class="col-md-4">
			<div class="form_group">
				' . $this->Form->control('name', ['class' => 'fotm_control', 'placeholder' => 'Name']) . '
			</div>
		  </div>';

$leave_a_comment_form .= '<div class="col-md-4">
			<div class="form_group">
				' . $this->Form->control('email', ['class' => 'fotm_control', 'placeholder' => 'Email']) . '
			</div>
		  </div>';

$leave_a_comment_form .= '<div class="col-md-4">
			<div class="form_group">
				' . $this->Form->control('website', ['class' => 'fotm_control', 'placeholder' => 'Website']) . '
			</div>
		  </div>';

$leave_a_comment_form .= $this->Form->control('g-recaptcha-response', ['type' => 'hidden', 'class' => 'g-recaptcha-response', 'id' => false]);

$leave_a_comment_form .= '<div class="form_group">
			' . $this->Form->button(__('Post Comment'), ['class' => 'btn','type' => 'button']) . '
		  </div>';
$leave_a_comment_form .= '</div>';

$leave_a_comment_form .= $this->Form->end();

if (!empty($contentData)) {
	$contentData->content = str_replace('{$leave-a-comment-form}', $leave_a_comment_form, $contentData->content);
	echo $contentData->content;
}

?>
<!-- breadcrumb area start -->
<!--div class="breadcrumb-area">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="breadcrumb-wrap">
						<nav aria-label="breadcrumb">
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.html">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page"><?php // $page; 
																						?></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div-->
<!-- breadcrumb area end -->

<!-- about wrapper start -->
<div class="about-us-wrapper pt-4">
	<div class="container">
		<div class="row">
			<!-- About Text Start -->
			<div class="col-lg-12">
				<div class="about-text-wrap">

				</div>
			</div>
			<!-- About Text End -->
			<!-- About Image Start -->
			<!--div class="col-lg-5 ml-auto">
					<div class="about-image-wrap mt-md-26 mt-sm-26">
						<img src="<?php // SITE_URL.'/front/img/about/about.jpg' 
									?>" alt="About" />
					</div>
				</div-->
			<!-- About Image End -->
		</div>
	</div>
</div>
<!-- about wrapper end -->

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
</script>