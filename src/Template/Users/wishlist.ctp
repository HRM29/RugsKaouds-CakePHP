<?php

use Cake\Routing\Router; ?>
<?php
$session = $this->request->getSession();
$action = $this->request->getParam('action');
$controller = $this->request->getParam('controller');
$authUser = $session->read('Auth');
?>
<section class="inner_banner shp">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="heading">
					<h3>Wishlist</h3>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="dshbrd">
	<div class="container-fluid">
		<div class="row">
			<?php echo $this->element('front/account_menu'); ?>
			<div class="col-md-9 no_padding">
				<div class="tab-content" id="v-pills-tabContent">
					<div class="tab-pane fade show active" id="v-pills-seven" role="tabpanel" aria-labelledby="v-pills-seven-tab">
						<div class="table-responsive crt_tbl">
							<h3 class="card-header">Wishlist <span class="float-right">(<?= count($favouritesDatas); ?> item)</span></h3>
							<div class="message alert alert-success success-section-wishlist" onclick="this.classList.add('hidden');" style="display:none;">

							</div>
							<table class="table table-bordered">
								<thead>
									<tr>
										<th scope="col">Product Image</th>
										<th scope="col">Product Name</th>
										<th scope="col">Unit Price</th>
										<th scope="col">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (!empty($favouritesDatas)) {
										foreach ($favouritesDatas as $key => $data) {
									?>
											<tr>
												<td>
													<?php
													$img_src = 'https://shrugs.com/rug_pictures/';

													$img_no = str_replace("GOR", " ", $data->sku_no);
													$img_name = "sh" . $img_no / 7;
													$inFolder = $this->General->__get_picture_folder($img_name);


													$imgName =  $img_name . " 001.jpg";

													$fileUrl = $img_src . "overstock_rugs/" . $inFolder . "/" . $imgName;
													$thumb_imgName =  	$img_name . " 001.jpg";
													$thumbArr = explode('_', $pimg['ProductImage']['image']);
													$fileUrlThumb = $img_src . $inFolder . '/thumbs/thumb_' . $thumb_imgName;
													if ($this->General->remote_file_exists($fileUrl)) {
													?>
														<img src="<?php echo $fileUrl; ?>" alt="<?php echo $data->title; ?>" class="img-fluid" width="70" height="90">
														<?php
													}

													if ($this->General->remote_file_exists($fileUrl) == "") {
														$Imagesdata =  $this->General->getProductImages($data['id']);
														foreach ($Imagesdata as $images) {
														?>
															<img src="<?php echo $images['image']; ?>" alt="<?php echo $images['title']; ?>" class="img-fluid" width="70" height="90">
													<?php
															break;
														}
														$i = '';
													}
													?>
												</td>
												<td>
													<p><a href="<?php echo $this->Url->build(['controller' => 'products', 'action' => 'productView', base64_encode($data['sku_no'])]); ?>"><?= $data['title']; ?></a></p>
												</td>
												<td>
													<p class="offer-price mb-0"><span class="regular-price">$<?= $data['everyday_price']; ?></span></p>
												</td>
												<td>
													<?php
													if (!in_array($data['id'], $cartItems)) {
													?>
														<div class="pdocut-buton-wishlist cart-button btn" id="cart-button" data1="<?= $data['id']; ?>"><a class="cart-btn" style="cursor: pointer;">Add To Cart</a></div>
													<?php
													} ?>
													<a class="float-right remove-cart delete btn" data1="<?= $data->id; ?>" style="cursor: pointer;">Remove</a>
												</td>
											</tr>
										<?php }
									} else { ?>
										<tr>
											<td colspan="4">
												<h4 style="text-align:center;margin-top: 20px;">No item in your wishlist !!</h4>
											</td>
										</tr>
									<?php } ?>
								</tbody>
								<div class="cart-btn"></div>

							</table>
						</div>
					</div>
				</div>
			</div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
	$('.cart-button').click(function() {
		showLoadingModal();
		var product_id = $(this).attr('data1');
		var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
		var url = '<?php echo $this->Url->build(['controller' => 'products', 'action' => 'addToCart']); ?>';
		$.ajax({
			type: 'POST',
			data: {
				product_id: product_id,
				_csrfToken: csrfToken
			},
			url: url,
			success: function(data) {

				$('.success-section-wishlist').css('display', 'block');
				$('.success-section-wishlist').html('Product added to cart successfully.');
				$('html, body').animate({
					scrollTop: $("#v-pills-tabContent").offset().top
				}, 500);
				hideLoadingModal();
				window.setTimeout(function() {
					location.reload()
				}, 1000);
			}
		});
	});
	$('.delete').click(function() {
		showLoadingModal();
		var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
		var id = $(this).attr("data1");

		var url = '<?php echo $this->Url->build(['controller' => 'users', 'action' => 'deleteWishlistItem']); ?>';
		$.ajax({
			type: 'POST',
			url: url,
			data: {
				_csrfToken: csrfToken,
				id: id
			},
			success: function(result) {
				//cartdata();	
				hideLoadingModal();
				$('.success-section-wishlist').css('display', 'block');
				$('.success-section-wishlist').html('Product removed from Wishlist.');
				$('html, body').animate({
					scrollTop: $("#v-pills-tabContent").offset().top
				}, 500);
				hideLoadingModal();
				window.setTimeout(function() {
					location.reload()
				}, 1000);
			}

		});
	});
</script>