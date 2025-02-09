<?php

use Cake\Routing\Router;
?>
<?php echo $this->Html->script(['xzoom.min.js']); ?>
<?php echo $this->Html->css(array('front/xzoom.css')); ?>
<section class="shop_dtls">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb bg-light p-3 rounded">
						<li class="breadcrumb-item"><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'home']); ?>">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page"><a href="<?php echo Router::url('/', true) ?>shop"><?= !empty($title) ? $title : 'All Products'; ?></a></li>
					</ol>
				</nav>
			</div>
			<div class="col-md-5">
				<span class="zoom">
					<?php
					$img_src = Router::url('/', true) . 'uploads/product/';
					$img_name = isset($productDetail->product_images[0]->image) ? $productDetail->product_images[0]->image : '';
					$img_Type = isset($productDetail->product_images[0]->image_type) ? $productDetail->product_images[0]->image_type : 'Single';

					$sku = $productDetail->sku_no;

					$inFolder = $this->General->__get_picture_folder($sku);

					$filePath =  WWW_ROOT . 'uploads' . DS . 'product' . DS . $inFolder . DS . $img_name;
					$filePath21 =  WWW_ROOT . 'uploads' . DS . 'product' . DS . $inFolder . DS . str_replace('jpg', 'jpg', $img_name);

					$fileUrl = $img_name;
					?>
					<img id="xzoom-default" src="<?php echo $img_Type == 'Link' ? $fileUrl : $filePath21; ?>" xoriginal="<?php echo $fileUrl; ?>" width="430" height="390" />
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
						<div class="value-button" id="decrease" disabled value="Decrease Value">-</div>
						<input type="number" id="number" class="number" value="1" readonly>
						<div class="value-button" id="increase" disabled value="Increase Value">+</div>
						<a class="btn crt_btn cart-button main_product" data-id=<?php echo $productDetail->id; ?> href="javascript:void(0);"><i class="bi bi-bag-plus"></i> Add to Cart</a>
						<a style="display:none" id="go_to_cart" href="<?php echo $this->Url->build(['controller' => 'products', 'action' => 'cart']); ?>" class="btn pdocut-buton">Go To Cart</a>
						<span class="social-share">
							<?php
							if ($user_id != 0) {
								if (!empty($favouriteData)) { ?>
									<a id="remove_from_favourite" data-value="<?php echo $productDetail->id; ?>" style="cursor:pointer;"><i class="fa fa-heart" style="color:#881C06;"></i></a>
								<?php } else { ?>
									<a id="add_to_favourite" data-value="<?php echo $productDetail->id; ?>" style="cursor:pointer;"><i class="fa fa-heart-o"></i></a>
								<?php }	?>

							<?php } else { ?>
								<a href="<?php echo $this->Url->build(['controller' => 'users', 'action' => 'login']); ?>" style="cursor:pointer;"><i class="fa fa-heart-o"></i></a>
							<?php } ?>
						</span>
					</div>
					<div class="prdct_meta">
						<p><strong>SKU:</strong> <?php echo $productDetail->sku_no; ?></p>
						<p><strong>Categories:</strong> <?php echo $this->General->getCategory($productDetail->category_id); ?></p>
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
			</div>
		</div>
	</div>
</section>
<?php echo $this->element('front/related_products'); ?>
<?php echo $this->Html->script(['setup.js']); ?>
<script type="text/javascript">
	$(document).ready(function() {
		checkCartButton();

		$('.cart-button').click(function() {

			var product_id = $(this).attr('data-id');
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
					window.location.replace('<?php echo $this->Url->build(['controller' => 'products', 'action' => 'cart']); ?>');
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
						$(".main_product").show();
						$("#go_to_cart").hide();
					} else {
						$(".main_product").hide();
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