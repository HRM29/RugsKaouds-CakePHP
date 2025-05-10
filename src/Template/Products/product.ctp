<?php

use Cake\Routing\Router;
?>
<?php echo $this->Html->script(['xzoom.min.js']); ?>
<?php echo $this->Html->css(array('front/xzoom.css')); ?>
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
<section class="shop_dtls">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-7">
				<div class="dtls_cont">
					<h1>Sorry, this product is not available</h1>
					<p>Unfortunately, the product you're looking for is currently out of stock or no longer available.</p>
					<p>We apologize for the inconvenience. Please check back later or explore other products.</p>
					<a href="<?php echo Router::url('/', true) ?>shop" class="btn">Continue Shopping</a>
				</div>
			</div>
		</div>
	</div>
</section>