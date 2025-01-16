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
<section class="ltst_arrvls shop">
	<div class="container">
		<div class="row">
			<?php echo $this->element('front/search_bar'); ?>
			<div class="col-md-8">
				<div class="shp_prdcts">
					<h5 class="rugs-headding"><?= $title ?></h5>
					<div class="row">
						<?php
						if (count($result) > 0) {
							foreach ($result as $data) {
								if (!empty($data['product_images'])) {
									$image_data = $data['product_images'][0];
									$imageURL = $image_data->image;
								}
						?>
								<div class="col-md-6">
									<div class="arrvl_box">
										<a href="<?php echo $this->Url->build(['controller' => 'products', 'action' => 'productView', base64_encode($data->sku_no)]); ?>">
											<div class="product-thumb">

												<?php
												$img_src = Router::url('/', true) . 'uploads/product/';

												$img_name = isset($data->product_images[0]->image) ? $data->product_images[0]->image : '';

												// $img_name = $data->sku_no."a.jpg";
												$img_name_a = substr($data->sku_no, 3) . "a.jpg";

												$sku = $data->sku_no;

												$inFolder = $this->General->__get_picture_folder($sku);


												$filePath =  WWW_ROOT . 'uploads' . DS . 'product' . DS . $inFolder . DS . $img_name;
												$filePath_A =  WWW_ROOT . 'uploads' . DS . 'product' . DS . $inFolder . DS . $img_name_a;
												//echo $filePath ; die(" Check point1");

												$filePath21 =  WWW_ROOT . 'uploads' . DS . 'product' . DS . $inFolder . DS . str_replace('jpg', 'JPG', $img_name);

												$fileUrl = $img_src . $inFolder . "/" . $img_name;
												$fileUrl_A = $img_src . $inFolder . "/" . $img_name_a;

												$fileUr2l = $img_src . $inFolder . "/" . str_replace('jpg', 'JPG', $img_name);

												if ($img_name != '') {
												?>
													<img src="<?php echo $img_name; ?>" alt="<?= $data->title; ?>" width="400" />

												<?php } else { ?>
													<img src="<?php echo Router::url('/', true); ?>img/no-image.png" alt="<?php echo $data->title; ?>" style="height:250px;" />
												<?php
												} ?>
											</div>
										</a>
										<div class="arrvl_text">
											<h3><?php echo $data->style; ?></h3>
											<p><?= $data->title; ?></p>
											<span>$<?php echo number_format($data->selling_price, 2); ?></span>
											<span class="nw_price">$<?php echo number_format($data->everyday_price, 2); ?></span>
											<a class="btn crt_btn" href="#"><i class="bi bi-bag-plus"></i> Add to Cart</a>
										</div>
									</div>
								</div>
						<?php }
						} else {
							echo "No products were found matching your selection.";
							$noRecords = true;
						} ?>
					</div>
					<?php
					if (!$noRecords) {
					?>
						<div class="shop-head shop-head-bottom">
							<h2><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></h2>
							<div class="shop-bottom-section">
								<nav>
									<ul class="pagination justify-content-center">
										<?= $this->Paginator->first(('First')) ?>
										<?= $this->Paginator->prev(('Previous')) ?>
										<?= $this->Paginator->numbers() ?>
										<?= $this->Paginator->next(('Next')) ?>
										<?= $this->Paginator->last(('Last')) ?>
									</ul>
								</nav>
							</div>
						</div>
					<?php
					}
					?>

				</div>
			</div>
		</div>
	</div>
	</div>
</section>
<script>
	$(document).ready(function() {

		var selectd = '<?php echo $title; ?>';
		$("input[name='collections'][value='" + selectd + "'").prop('checked', true);

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

			$(".tag-add").append(newtag);
		});
		// var price_min = $('#price_min').val();
		// var price_max = $('#price_max').val();
		// var typ = 'Price';
		// if(price_min != "" || price_max != ""){
		// 	var newtag = '<a class="filter-tag beige" id="search_beige" style="color: #fff !important;">'+ typ+' '+price_min+'-'+price_max+'</a>';
		// 	$(".tag-add").append(newtag);
		// }
		let specialSize = $("input[name='speceialSize']").val();
		if (specialSize != "") {
			var specialSize_typ = $("input[name='speceialSize']").attr('data_typ');
			var newtag2 = '<a class="filter-tag beige" id="search_beige" style="color: #fff !important;">' + specialSize_typ + ' ' + specialSize.toUpperCase() + '</a>';
			$('.rugs-tab').css('display', 'block');
			$(".tag-add").append(newtag2);
		}


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

	$(window).on('load', function() {
		// Select and loop the container element of the elements you want to equalize
		equalheight();
	});
</script>