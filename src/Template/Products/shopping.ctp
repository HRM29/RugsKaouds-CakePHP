<?php

use Cake\Routing\Router;
use Cake\Core\Configure; ?>
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
<section class="ltst_arrvls shop">
	<div class="container">
		<div class="row">
			<?php echo $this->element('front/search_bar'); ?>
			<div class="col-md-8">
				<div class="shp_prdcts">
					<div class="row">
						<?php
						if (!empty($ProductData)) {
							foreach ($ProductData as $data) {
								if (!empty($data['product_images'])) {
									$image_data = $data['product_images'][0];
									$imageURL = $image_data->image;
								}
						?>
								<div class="col-md-6">
									<div class="arrvl_box">
										<?php
										echo $this->Html->image($imageURL, ['alt' => $data->title, "width" => 249, "height" => 296]);
										?>
										<div class="arrvl_text">
											<h3><?= $data->style; ?></h3>
											<p><?= $data->title; ?></p>
											<span>$<?php echo number_format($data->selling_price, 2); ?></span>
											<span class="nw_price">$<?php echo number_format($data->everyday_price, 2); ?></span>
											<a class="btn crt_btn" href="#"><i class="bi bi-bag-plus"></i> Add to Cart</a>
										</div>
									</div>
								</div>
						<?php
							}
						}
						?>
					</div>
					<div class="shop-head shop-head-bottom">
						<h2>
							<?= $this->Paginator->counter([
								'format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')
							]) ?>
						</h2>
						<div class="shop-bottom-section">
							<nav>
								<ul class="pagination justify-content-center">
									<?= $this->Paginator->first(__('First')) ?>
									<?= $this->Paginator->prev(__('Previous')) ?>
									<?= $this->Paginator->numbers() ?>
									<?= $this->Paginator->next(__('Next')) ?>
									<?= $this->Paginator->last(__('Last')) ?>
								</ul>
							</nav>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
</section>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.4.3.min.js"></script>
<script>
	$(document).ready(function() {
		$('.recent_view_product').click(function() {
			var productId = $(this).attr('data-id');
			$.ajax({
				url: '<?php echo $this->Url->build(['controller' => 'products', 'action' => 'updateRecentView']); ?>',
				type: 'POST',
				data: {
					product_id: productId
				},
				success: function(data) {
					console.log(data);
					// return false
				}

			});
		});
	});

	$(document).ready(function() {
		$('input[class="filtercheckbox"]:checked').each(function() {
			var val = $(this).attr('data_val');
			var typ = $(this).attr('data_typ');
			//alert(typ);
			//var newtag = '<div class="filter-tag beige" id="search_beige">'+ typ+' '+val.toUpperCase()+'</div>';
			var newtag = '<a class="filter-tag beige" id="search_beige" style="color: #fff !important;">' + typ + ' ' + val.toUpperCase() + '</a>';
			if (newtag != "") {
				$('.rugs-tab').css('display', 'block');
			}
			$(".tag-add").append(newtag);
		});
	});
</script>
<script>
	equalheight = function() {
		$('.product-detail').each(function() {

			// Cache the highest
			var highestBox = 0;

			// Select and loop the elements you want to equalise
			$('.product-thumb', this).each(function() {

				// If this box is higher than the cached highest then store it
				if ($(this).height() > highestBox) {
					highestBox = $(this).height();
				}

			});

			// Set the height of all those children to whichever was highest 
			$('.product-thumb', this).height(highestBox);

		});
	}

	$(window).load(function() {

		// Select and loop the container element of the elements you want to equalise
		equalheight();

	});
</script>