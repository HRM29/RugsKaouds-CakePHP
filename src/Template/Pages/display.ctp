<?php 
use Cake\Routing\Router;
use Cake\Core\Configure;
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
								<li class="breadcrumb-item active" aria-current="page"><?php // $page; ?></li>
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
						<?php if(!empty($contentData)){echo $contentData->content;} ?>
					</div>
				</div>
				<!-- About Text End -->
				<!-- About Image Start -->
				<!--div class="col-lg-5 ml-auto">
					<div class="about-image-wrap mt-md-26 mt-sm-26">
						<img src="<?php // SITE_URL.'/front/img/about/about.jpg' ?>" alt="About" />
					</div>
				</div-->
				<!-- About Image End -->
			</div>
		</div>
	</div>
	<!-- about wrapper end -->