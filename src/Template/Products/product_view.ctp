<?php

use Cake\Routing\Router;
?>
<?php echo $this->Html->script(['jquery.js']); ?>
<?php echo $this->Html->script(['xzoom.min.js']); ?>
<?php echo $this->Html->css(array('front/xzoom.css')); ?>
<section class="inner_banner shp">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 no_padding">
				<div class="inr_bnr"></div>
			</div>
		</div>
	</div>
</section>
<section class="shop_dtls">
	<div class="container">
		<div class="row">
			<div class="col-md-5">
				<span class="zoom">
					<?php
					$img_src = Router::url('/', true) . 'uploads/product/';
					// echo "<pre>";print_r($productDetail);
					$img_name = isset($productDetail->product_images[0]->image) ? $productDetail->product_images[0]->image : '';

					$sku = $productDetail->sku_no;

					$inFolder = $this->General->__get_picture_folder($sku);

					$filePath =  WWW_ROOT . 'uploads' . DS . 'product' . DS . $inFolder . DS . $img_name;
					$filePath21 =  WWW_ROOT . 'uploads' . DS . 'product' . DS . $inFolder . DS . str_replace('jpg', 'JPG', $img_name);

					$fileUrl = $img_name;
					?>
					<img id="xzoom-default" src="<?php echo $fileUrl; ?>" xoriginal="<?php echo $fileUrl; ?>" width="430" height="390" />
				</span>
			</div>
			<div class="col-md-7">
				<div class="dtls_cont">
					<h2><?php echo strtoupper($productDetail->title);  ?></h2>
					<div class="price">
						<span class="old_price">$<?php echo number_format($productDetail->selling_price, 2); ?></span>
						<span class="nw_price">$<?php echo number_format($productDetail->everyday_price, 2); ?></span>
					</div>
					<div class="qnty">
						<div class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
						<input type="number" id="number" class="number" value="0">
						<div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
						<a href="cart.html" class="btn">Add to Cart</a>
					</div>
					<div class="prdct_meta">
						<p><strong>SKU:</strong> <?php echo $productDetail->sku_no; ?></p>
						<p><strong>Categories:</strong> <?php echo $this->General->getCategory($productDetail->category_id); ?></p>
						<!-- <p><strong>Tags:</strong> All Products, Fine Oriental, Traditional</p> -->
					</div>
					<ul class="social">
						<!-- <li><a href="#"><?php echo $this->Html->image('fcbook.png', ['alt' => 'facebook']); ?></a></li> -->
						<li><a href="#"><i class="bi bi-twitter-x"></i></a></li>
						<li><a href="#"><i class="bi bi-envelope"></i></a></li>
						<li><a href="#"><i class="bi bi-pinterest"></i></a></li>
						<li><a href="#"><i class="bi bi-linkedin"></i></a></li>
						<li><a href="#"><?php echo $this->Html->image('tmblr.png', ['alt' => 'tumblr']); ?></a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-12">

				<div class="cart-subtotal-products">
					<span class="social-share pull-right"><!--a href="#"><i class="fa fa-share-alt"></i>Share</a-->
						<?php
						if ($user_id != 0) {
							if (!empty($favouriteData)) { ?>
								<a id="remove_from_favourite" data-value="<?php echo $productDetail->id; ?>" style="cursor:pointer;"><i class="fa fa-heart-o" style="color:#dcbb72;"></i>Remove from favourite</a>
							<?php } else { ?>
								<a id="add_to_favourite" data-value="<?php echo $productDetail->id; ?>" style="cursor:pointer;"><i class="fa fa-heart-o"></i>add to favourite</a>
							<?php }	?>

						<?php } else { ?>
							<a href="<?php echo $this->Url->build(['controller' => 'users', 'action' => 'login']); ?>" style="cursor:pointer;"><i class="fa fa-heart-o"></i>add to favourite</a>

						<?php } ?>
					</span>
				</div>
				<div class="adtnl_infrm">
					<h4>Additional Information</h4>
					<div class="table-responsive infrm">
						<table class="table">
							<tbody>
								<tr>
									<th scope="row"><strong>Weight</strong></th>
									<td>10.23 lbs</td>
								</tr>
								<tr>
									<th scope="row"><strong>Dimensions</strong></th>
									<td><?php echo $productDetail->dimension_1_feet . "'" . $productDetail->dimension_1_inches . '" X ' . $productDetail->dimension_2_feet . "'" . $productDetail->dimension_2_inches . '"'; ?> in</td>
								</tr>
								<tr>
									<th scope="row"><strong>UWCF Sizes</strong></th>
									<td>3X5</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<input type="hidden" id="p_id" value="<?php echo $productDetail->id; ?>">
				<input type="hidden" id="u_id" value="<?php echo $user_id; ?>">
				<div class="pdocut-buton" style="display:none" id="cart-button"><a class="cart-btn" style="cursor: pointer;">Add To Cart</a></div>
				<div class="pdocut-buton" style="display:none" id="go_to_cart"><a href="<?php echo $this->Url->build(['controller' => 'products', 'action' => 'cart']); ?>" class="cart-btn">Go To Cart</a></div>

				<!-- <div class="product-discrip">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Rug Details</a>
						</li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
							<div class="tt-add-info">
								<ul>
									<li class="sku-js">
										<span>Code:</span>
										<span><?php echo $productDetail->sku_no; ?></span>
									</li>
									<li class="sku-js">
										<span>Exact Size:</span>
										<span><?php echo $productDetail->dimension_1_feet . "'" . $productDetail->dimension_1_inches . '" X ' . $productDetail->dimension_2_feet . "'" . $productDetail->dimension_2_inches . '"'; ?></span>
									</li>

									<?php
									$price_sh = $productDetail->selling_price / 2.5;
									$jgor = round($price_sh * 7);
									?>

									<li class="sku-js">
										<span>JGOR:</span>
										<span><?php echo $jgor; ?></span>
									</li>
									<li class="sku-js">
										<span>Shape:</span>
										<span><?php echo $productDetail->available_shape; ?></span>
									</li>
									<li class="sku-js">
										<span>Origin:</span>
										<span><?php echo ucfirst(strtolower($productDetail->overstock_origin)); ?></span>
									</li>
									<li class="availability">
										<span>Foundation:</span>
										<span><?php echo $this->General->getFoundation($productDetail->foundation_id); ?></span>
									</li>
									<li class="availability">
										<span>Pile:</span>
										<span><?php echo $this->General->getPile($productDetail->pile_id); ?></span>
									</li>
									<li class="availability">
										<span>Construction:</span>
										<span><?php echo $productDetail->rug_type; ?></span>
									</li>
									<li class="availability">
										<span>Group Color:</span>
										<span><?php echo $this->General->getColor($productDetail->color_id); ?></span>
									</li>
									<li class="availability">
										<span>Exact Field Color:</span>
										<span><?php echo $productDetail->field_color_exact; ?></span>
									</li>
									<li class="availability">
										<span>Age:</span>
										<span><?php echo $productDetail->age; ?></span>
									</li>
									<li class="availability">
										<span>Border Color:</span>
										<span><?php echo $productDetail->border_color; ?></span>
									</li>
									<li class="availability">
										<span>Rug Style:</span>
										<span><?php echo $productDetail->style; ?></span>
									</li>
									<li class="availability">
										<span>Pattern:</span>
										<span><?php echo $productDetail->pattern; ?></span>
									</li>
									<li class="availability">
										<span>Design:</span>
										<span><?php echo $productDetail->rug_design; ?></span>
									</li>
									<li class="availability">
										<span>Category:</span>
										<span><?php echo $this->General->getCategory($productDetail->category_id); ?></span>
									</li>

									<li class="availability">
										<span>Sale Price:</span>
										<span>$ <?php echo number_format($productDetail->selling_price, 2); ?></span>
									</li>

								</ul>
							</div>
						</div>
					</div>
				</div> -->


			</div>
		</div>
	</div>
</section>

<?php echo $this->Html->script(['setup.js']); ?>
<script type="text/javascript">
	$(document).ready(function() {
		checkCartButton();

		$('#cart-button').click(function() {

			var product_id = $('#p_id').val();
			//var csrfToken = $("[name='_csrfToken']").val();
			var csrfToken = <?php echo json_encode($this->request->getParam('_csrfToken')) ?>;
			var url = '<?php echo $this->Url->build(['controller' => 'products', 'action' => 'addToCart']); ?>';
			$.ajax({
				type: 'POST',
				data: {
					product_id: product_id,
					_csrfToken: csrfToken
				},
				url: url,
				success: function(data) {
					//console.log(data); 
					//cartdata();
					window.location.replace('<?php echo $this->Url->build(['controller' => 'products', 'action' => 'cart']); ?>');
					//checkCartButton();
				}
			});
		});

		function checkCartButton() {
			var csrfToken = <?php echo json_encode($this->request->getParam('_csrfToken')) ?>;

			var url = '<?php echo $this->Url->build(['controller' => 'products', 'action' => 'checkCartButton']); ?>';
			var pr_id = $("#p_id").val();
			$.ajax({
				type: 'POST',
				data: {
					pr_id: pr_id,
					_csrfToken: csrfToken
				},
				url: url,
				success: function(result) {
					if (result == 0) {
						$("#cart-button").show();
						$("#go_to_cart").hide();
					} else {
						$("#cart-button").hide();
						$("#go_to_cart").show();
					}
				}
			});

		}
		$('#add_to_favourite').click(function() {
			var csrfToken = <?php echo json_encode($this->request->getParam('_csrfToken')) ?>;

			var url = '<?php echo $this->Url->build(['controller' => 'products', 'action' => 'addToFaviourite']); ?>';
			var product_id = $('#add_to_favourite').attr('data-value');
			var u_id = $('#u_id').val();
			var sku = "<?php echo $productDetail->sku_no; ?>";
			$.ajax({
				type: 'POST',
				data: {
					product_id: product_id,
					user_id: u_id,
					sku: sku,
					_csrfToken: csrfToken
				},
				url: url,
				success: function(result) {
					if (result == 1) {
						location.reload();
					}
				}
			});
		})
		$('#remove_from_favourite').click(function() {
			var csrfToken = <?php echo json_encode($this->request->getParam('_csrfToken')) ?>;

			var url = '<?php echo $this->Url->build(['controller' => 'products', 'action' => 'removeFromFaviourite']); ?>';
			var product_id = $('#removeFromFaviourite').attr('data-value');
			var u_id = $('#u_id').val();
			var sku = "<?php echo $productDetail->sku_no; ?>";
			$.ajax({
				type: 'POST',
				data: {
					product_id: product_id,
					user_id: u_id,
					sku: sku,
					_csrfToken: csrfToken
				},
				url: url,
				success: function(result) {
					if (result == 1) {
						location.reload();
					}
				}
			});
		})
	});
</script>