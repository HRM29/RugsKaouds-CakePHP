<?php

use Cake\Routing\Router;
use Cake\Core\Configure;
?>

<?php
$session = $this->request->getSession();
$action = $this->request->getParam('action');
$controller = $this->request->getParam('controller');
$authUser = $session->read('Auth');

$squareJsUrl = "https://js.squareupsandbox.com/v2/paymentform";
$appID = "sandbox-sq0idb-oVE_8fXmElchrJT-NV-RkA";
$locationId = "84FXVDJJ8VXK2";
if (Configure::read('App.PaypalAccountMode') == Configure::read('Paypal.mode.live')) {
	$squareJsUrl = "https://js.squareup.com/v2/paymentform";
	$appID = "sq0idp-ADsOz8H5WYn9bsF5MTGPAg";
	$locationId = "FX8EDKJKAWSAM";
}
?>

<section class="inner_banner shp">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading">
					<h3>Cart</h3>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="cart">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="table-responsive crt_tbl">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th scope="col">Product</th>
								<th scope="col">Product Name</th>
								<th scope="col">Price</th>
								<th scope="col" class="qty">Quantity</th>
								<th scope="col" class="sbttl">Subtotal</th>
								<th scope="col">Edit</th>
							</tr>
						</thead>
						<?= $this->Form->create(null, ['url' => "javscript:void(0)", 'id' => "cart-data-list"]) ?>
						<tbody>
							<?php
							if (!empty($cardData)) {
								$total_quanty = 0;
								$total_price = 0;
								foreach ($cardData as $item) {
									$total_quanty += $item['product_qty'];
									$subtotal = $total_price += round($item['everyday_price'] * $item['product_qty'], 2);
								}
								$discount_price = 0;
								if ($session->check('coupon')) {
									$couponData = $session->read('coupon');
									$discount = $couponData['discount_value'];
									$discount_type = $couponData['discount_type'];
									$discount_price = $couponData['cart_discount'];
									$couponCode = $couponData['code'];
									$total_price = $total_price - $discount_price;
								}
							}

							if (!empty($cardData)) {
								foreach ($cardData as $key => $data) {
									$sku = $data['sku_no'];
									$res =  $this->General->getProductImages($data['id']);
									$img_name = isset($res[0]->image) ? $res[0]->image : '';
							?>
									<tr>
										<th scope="row"><img src="<?php echo $img_name; ?>" alt="crt_prdct" width="70" height="90"></th>
										<td><?php echo $data['title'] ?></td>
										<td>$<?= number_format($data['everyday_price'], 2); ?></td>
										<td>
											<div class="qnty">
												<!-- <div class="value-button" id="decrease" disabled value="Decrease Value">-</div> -->
												<input type="number" name="<?= $data['id']; ?>_qnty" class="number" id="<?= $data['id']; ?>_number" value="<?= $data['product_qty']; ?>" readonly />
												<!-- <div class="value-button" id="increase" disabled value="Increase Value">+</div> -->
											</div>
										</td>
										<td class="sbttl">$<?= number_format(($data['everyday_price'] * $data['product_qty']), 2); ?></td>
										<td><a href="#" class="remove-cart delete" data1="<?= $data['id']; ?>"><img src="/Kaouds/img/dlt.png" alt="dlt"></a></td>
									</tr>
								<?php }
							} else { ?>
								<h4 style="text-align:center;margin-top: 20px;">Cart is empty !!</h4>
							<?php } ?>
						</tbody>
						<?= $this->Form->end() ?>
					</table>
					<div class="btns">
						<a href="<?php echo Router::url('/', true) ?>shop" class="btn">Continue Shopping</a>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="table-responsive crt_sbttl">
					<div class="cupn">
						<h3><img src="/Kaouds/img/cpn1.png" alt="coupon"> Coupon</h3>
						<div class="coupon-input-wrapper">
							<input class="fotm_control" type="text" name="coupon-code" value="<?= $couponCode; ?>" placeholder="Coupon Code">
							<?php if ($session->check('coupon')): ?>
								<a href="javascript:void(0);" class="remove" id="remove-coupon">&times;</a>
							<?php else: ?>
								<a href="javascript:void(0);" class="btn aply" id="apply-coupon-btn">Apply Coupon</a>
							<?php endif; ?>
						</div>
					</div>
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Cart Total</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">Subtotal</th>
								<td>$<?= number_format($subtotal, 2); ?></td>
							</tr>
							<tr>
								<th scope="row">Shipping</th>
								<td>Free Shipping</td>
							</tr>
							<tr>
								<th scope="row">Tax</th>
								<td>$0.00</td>
							</tr>
							<?php
							if ($discount_price > 0) {
							?>
								<tr>
									<th scope="row">Discount<?= $discount_type == 'percentage' ? ' ' . $discount . ' ' . '%' : ''; ?></th>
									<td>$<?= number_format($discount_price, 2); ?></td>
								</tr>
							<?php
							}
							?>
							<tr>
								<th scope="row">Total</th>
								<td>$<?= number_format($total_price, 2); ?></td>
							</tr>
						</tbody>
					</table>
					<div class="pymnt">
						<ul>
							<li><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 32">
									<path d="M10.781 7.688c-0.251-1.283-1.219-1.688-2.344-1.688h-8.376l-0.061 0.405c5.749 1.469 10.469 4.595 12.595 10.501l-1.813-9.219zM13.125 19.688l-0.531-2.781c-1.096-2.907-3.752-5.594-6.752-6.813l4.219 15.939h5.469l8.157-20.032h-5.501l-5.062 13.688zM27.72 26.061l3.248-20.061h-5.187l-3.251 20.061h5.189zM41.875 5.656c-5.125 0-8.717 2.72-8.749 6.624-0.032 2.877 2.563 4.469 4.531 5.439 2.032 0.968 2.688 1.624 2.688 2.499 0 1.344-1.624 1.939-3.093 1.939-2.093 0-3.219-0.251-4.875-1.032l-0.688-0.344-0.719 4.499c1.219 0.563 3.437 1.064 5.781 1.064 5.437 0.032 8.97-2.688 9.032-6.843 0-2.282-1.405-4-4.376-5.439-1.811-0.904-2.904-1.563-2.904-2.499 0-0.843 0.936-1.72 2.968-1.72 1.688-0.029 2.936 0.314 3.875 0.752l0.469 0.248 0.717-4.344c-1.032-0.406-2.656-0.844-4.656-0.844zM55.813 6c-1.251 0-2.189 0.376-2.72 1.688l-7.688 18.374h5.437c0.877-2.467 1.096-3 1.096-3 0.592 0 5.875 0 6.624 0 0 0 0.157 0.688 0.624 3h4.813l-4.187-20.061h-4zM53.405 18.938c0 0 0.437-1.157 2.064-5.594-0.032 0.032 0.437-1.157 0.688-1.907l0.374 1.72c0.968 4.781 1.189 5.781 1.189 5.781-0.813 0-3.283 0-4.315 0z"></path>
								</svg></li>
							<li><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 32">
									<path d="M35.255 12.078h-2.396c-0.229 0-0.444 0.114-0.572 0.303l-3.306 4.868-1.4-4.678c-0.088-0.292-0.358-0.493-0.663-0.493h-2.355c-0.284 0-0.485 0.28-0.393 0.548l2.638 7.745-2.481 3.501c-0.195 0.275 0.002 0.655 0.339 0.655h2.394c0.227 0 0.439-0.111 0.569-0.297l7.968-11.501c0.191-0.275-0.006-0.652-0.341-0.652zM19.237 16.718c-0.23 1.362-1.311 2.276-2.691 2.276-0.691 0-1.245-0.223-1.601-0.644-0.353-0.417-0.485-1.012-0.374-1.674 0.214-1.35 1.313-2.294 2.671-2.294 0.677 0 1.227 0.225 1.589 0.65 0.365 0.428 0.509 1.027 0.404 1.686zM22.559 12.078h-2.384c-0.204 0-0.378 0.148-0.41 0.351l-0.104 0.666-0.166-0.241c-0.517-0.749-1.667-1-2.817-1-2.634 0-4.883 1.996-5.321 4.796-0.228 1.396 0.095 2.731 0.888 3.662 0.727 0.856 1.765 1.212 3.002 1.212 2.123 0 3.3-1.363 3.3-1.363l-0.106 0.662c-0.040 0.252 0.155 0.479 0.41 0.479h2.147c0.341 0 0.63-0.247 0.684-0.584l1.289-8.161c0.040-0.251-0.155-0.479-0.41-0.479zM8.254 12.135c-0.272 1.787-1.636 1.787-2.957 1.787h-0.751l0.527-3.336c0.031-0.202 0.205-0.35 0.41-0.35h0.345c0.899 0 1.747 0 2.185 0.511 0.262 0.307 0.341 0.761 0.242 1.388zM7.68 7.473h-4.979c-0.341 0-0.63 0.248-0.684 0.584l-2.013 12.765c-0.040 0.252 0.155 0.479 0.41 0.479h2.378c0.34 0 0.63-0.248 0.683-0.584l0.543-3.444c0.053-0.337 0.343-0.584 0.683-0.584h1.575c3.279 0 5.172-1.587 5.666-4.732 0.223-1.375 0.009-2.456-0.635-3.212-0.707-0.832-1.962-1.272-3.628-1.272zM60.876 7.823l-2.043 12.998c-0.040 0.252 0.155 0.479 0.41 0.479h2.055c0.34 0 0.63-0.248 0.683-0.584l2.015-12.765c0.040-0.252-0.155-0.479-0.41-0.479h-2.299c-0.205 0.001-0.379 0.148-0.41 0.351zM54.744 16.718c-0.23 1.362-1.311 2.276-2.691 2.276-0.691 0-1.245-0.223-1.601-0.644-0.353-0.417-0.485-1.012-0.374-1.674 0.214-1.35 1.313-2.294 2.671-2.294 0.677 0 1.227 0.225 1.589 0.65 0.365 0.428 0.509 1.027 0.404 1.686zM58.066 12.078h-2.384c-0.204 0-0.378 0.148-0.41 0.351l-0.104 0.666-0.167-0.241c-0.516-0.749-1.667-1-2.816-1-2.634 0-4.883 1.996-5.321 4.796-0.228 1.396 0.095 2.731 0.888 3.662 0.727 0.856 1.765 1.212 3.002 1.212 2.123 0 3.3-1.363 3.3-1.363l-0.106 0.662c-0.040 0.252 0.155 0.479 0.41 0.479h2.147c0.341 0 0.63-0.247 0.684-0.584l1.289-8.161c0.040-0.252-0.156-0.479-0.41-0.479zM43.761 12.135c-0.272 1.787-1.636 1.787-2.957 1.787h-0.751l0.527-3.336c0.031-0.202 0.205-0.35 0.41-0.35h0.345c0.899 0 1.747 0 2.185 0.511 0.261 0.307 0.34 0.761 0.241 1.388zM43.187 7.473h-4.979c-0.341 0-0.63 0.248-0.684 0.584l-2.013 12.765c-0.040 0.252 0.156 0.479 0.41 0.479h2.554c0.238 0 0.441-0.173 0.478-0.408l0.572-3.619c0.053-0.337 0.343-0.584 0.683-0.584h1.575c3.279 0 5.172-1.587 5.666-4.732 0.223-1.375 0.009-2.456-0.635-3.212-0.707-0.832-1.962-1.272-3.627-1.272z"></path>
								</svg></li>
							<li><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 32">
									<path d="M42.667-0c-4.099 0-7.836 1.543-10.667 4.077-2.831-2.534-6.568-4.077-10.667-4.077-8.836 0-16 7.163-16 16s7.164 16 16 16c4.099 0 7.835-1.543 10.667-4.077 2.831 2.534 6.568 4.077 10.667 4.077 8.837 0 16-7.163 16-16s-7.163-16-16-16zM11.934 19.828l0.924-5.809-2.112 5.809h-1.188v-5.809l-1.056 5.809h-1.584l1.32-7.657h2.376v4.753l1.716-4.753h2.508l-1.32 7.657h-1.585zM19.327 18.244c-0.088 0.528-0.178 0.924-0.264 1.188v0.396h-1.32v-0.66c-0.353 0.528-0.924 0.792-1.716 0.792-0.442 0-0.792-0.132-1.056-0.396-0.264-0.351-0.396-0.792-0.396-1.32 0-0.792 0.218-1.364 0.66-1.716 0.614-0.44 1.364-0.66 2.244-0.66h0.66v-0.396c0-0.351-0.353-0.528-1.056-0.528-0.442 0-1.012 0.088-1.716 0.264 0.086-0.351 0.175-0.792 0.264-1.32 0.703-0.264 1.32-0.396 1.848-0.396 1.496 0 2.244 0.616 2.244 1.848 0 0.353-0.046 0.749-0.132 1.188-0.089 0.616-0.179 1.188-0.264 1.716zM24.079 15.076c-0.264-0.086-0.66-0.132-1.188-0.132s-0.792 0.177-0.792 0.528c0 0.177 0.044 0.31 0.132 0.396l0.528 0.264c0.792 0.442 1.188 1.012 1.188 1.716 0 1.409-0.838 2.112-2.508 2.112-0.792 0-1.366-0.044-1.716-0.132 0.086-0.351 0.175-0.836 0.264-1.452 0.703 0.177 1.188 0.264 1.452 0.264 0.614 0 0.924-0.175 0.924-0.528 0-0.175-0.046-0.308-0.132-0.396-0.178-0.175-0.396-0.308-0.66-0.396-0.792-0.351-1.188-0.924-1.188-1.716 0-1.407 0.792-2.112 2.376-2.112 0.792 0 1.32 0.045 1.584 0.132l-0.265 1.451zM27.512 15.208h-0.924c0 0.442-0.046 0.838-0.132 1.188 0 0.088-0.022 0.264-0.066 0.528-0.046 0.264-0.112 0.442-0.198 0.528v0.528c0 0.353 0.175 0.528 0.528 0.528 0.175 0 0.35-0.044 0.528-0.132l-0.264 1.452c-0.264 0.088-0.66 0.132-1.188 0.132-0.881 0-1.32-0.44-1.32-1.32 0-0.528 0.086-1.099 0.264-1.716l0.66-4.225h1.584l-0.132 0.924h0.792l-0.132 1.585zM32.66 17.32h-3.3c0 0.442 0.086 0.749 0.264 0.924 0.264 0.264 0.66 0.396 1.188 0.396s1.1-0.175 1.716-0.528l-0.264 1.584c-0.442 0.177-1.012 0.264-1.716 0.264-1.848 0-2.772-0.924-2.772-2.773 0-1.142 0.264-2.024 0.792-2.64 0.528-0.703 1.188-1.056 1.98-1.056 0.703 0 1.274 0.22 1.716 0.66 0.35 0.353 0.528 0.881 0.528 1.584 0.001 0.617-0.046 1.145-0.132 1.585zM35.3 16.132c-0.264 0.97-0.484 2.201-0.66 3.697h-1.716l0.132-0.396c0.35-2.463 0.614-4.4 0.792-5.809h1.584l-0.132 0.924c0.264-0.44 0.528-0.703 0.792-0.792 0.264-0.264 0.528-0.308 0.792-0.132-0.088 0.088-0.31 0.706-0.66 1.848-0.353-0.086-0.661 0.132-0.925 0.66zM41.241 19.697c-0.353 0.177-0.838 0.264-1.452 0.264-0.881 0-1.584-0.308-2.112-0.924-0.528-0.528-0.792-1.32-0.792-2.376 0-1.32 0.35-2.42 1.056-3.3 0.614-0.879 1.496-1.32 2.64-1.32 0.44 0 1.056 0.132 1.848 0.396l-0.264 1.584c-0.528-0.264-1.012-0.396-1.452-0.396-0.707 0-1.235 0.264-1.584 0.792-0.353 0.442-0.528 1.144-0.528 2.112 0 0.616 0.132 1.056 0.396 1.32 0.264 0.353 0.614 0.528 1.056 0.528 0.44 0 0.924-0.132 1.452-0.396l-0.264 1.717zM47.115 15.868c-0.046 0.264-0.066 0.484-0.066 0.66-0.088 0.442-0.178 1.035-0.264 1.782-0.088 0.749-0.178 1.254-0.264 1.518h-1.32v-0.66c-0.353 0.528-0.924 0.792-1.716 0.792-0.442 0-0.792-0.132-1.056-0.396-0.264-0.351-0.396-0.792-0.396-1.32 0-0.792 0.218-1.364 0.66-1.716 0.614-0.44 1.32-0.66 2.112-0.66h0.66c0.086-0.086 0.132-0.218 0.132-0.396 0-0.351-0.353-0.528-1.056-0.528-0.442 0-1.012 0.088-1.716 0.264 0-0.351 0.086-0.792 0.264-1.32 0.703-0.264 1.32-0.396 1.848-0.396 1.496 0 2.245 0.616 2.245 1.848 0.001 0.089-0.021 0.264-0.065 0.529zM49.69 16.132c-0.178 0.528-0.396 1.762-0.66 3.697h-1.716l0.132-0.396c0.35-1.935 0.614-3.872 0.792-5.809h1.584c0 0.353-0.046 0.66-0.132 0.924 0.264-0.44 0.528-0.703 0.792-0.792 0.35-0.175 0.614-0.218 0.792-0.132-0.353 0.442-0.574 1.056-0.66 1.848-0.353-0.086-0.66 0.132-0.925 0.66zM54.178 19.828l0.132-0.528c-0.353 0.442-0.838 0.66-1.452 0.66-0.707 0-1.188-0.218-1.452-0.66-0.442-0.614-0.66-1.232-0.66-1.848 0-1.142 0.308-2.067 0.924-2.773 0.44-0.703 1.056-1.056 1.848-1.056 0.528 0 1.056 0.264 1.584 0.792l0.264-2.244h1.716l-1.32 7.657h-1.585zM16.159 17.98c0 0.442 0.175 0.66 0.528 0.66 0.35 0 0.614-0.132 0.792-0.396 0.264-0.264 0.396-0.66 0.396-1.188h-0.397c-0.881 0-1.32 0.31-1.32 0.924zM31.076 15.076c-0.088 0-0.178-0.043-0.264-0.132h-0.264c-0.528 0-0.881 0.353-1.056 1.056h1.848v-0.396l-0.132-0.264c-0.001-0.086-0.047-0.175-0.133-0.264zM43.617 17.98c0 0.442 0.175 0.66 0.528 0.66 0.35 0 0.614-0.132 0.792-0.396 0.264-0.264 0.396-0.66 0.396-1.188h-0.396c-0.881 0-1.32 0.31-1.32 0.924zM53.782 15.076c-0.353 0-0.66 0.22-0.924 0.66-0.178 0.264-0.264 0.749-0.264 1.452 0 0.792 0.264 1.188 0.792 1.188 0.35 0 0.66-0.175 0.924-0.528 0.264-0.351 0.396-0.879 0.396-1.584-0.001-0.792-0.311-1.188-0.925-1.188z"></path>
								</svg></li>
							<li><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 32">
									<path d="M2.909 32v-17.111h2.803l0.631-1.54h1.389l0.631 1.54h5.505v-1.162l0.48 1.162h2.853l0.506-1.187v1.187h13.661v-2.5l0.253-0.026c0.227 0 0.252 0.177 0.252 0.354v2.172h7.046v-0.58c1.642 0.858 3.889 0.58 5.606 0.58l0.631-1.54h1.414l0.631 1.54h5.733v-1.464l0.858 1.464h4.596v-9.546h-4.544v1.111l-0.631-1.111h-4.672v1.111l-0.581-1.111h-6.288c-0.934 0-1.919 0.101-2.753 0.556v-0.556h-4.344v0.556c-0.505-0.454-1.187-0.556-1.843-0.556h-15.859l-1.085 2.449-1.086-2.449h-5v1.111l-0.556-1.111h-4.267l-1.97 4.52v-9.864h58.182v17.111h-3.030c-0.707 0-1.464 0.126-2.045 0.556v-0.556h-4.47c-0.631 0-1.49 0.1-1.97 0.556v-0.556h-7.98v0.556c-0.605-0.429-1.49-0.556-2.197-0.556h-5.278v0.556c-0.53-0.505-1.616-0.556-2.298-0.556h-5.909l-1.363 1.464-1.263-1.464h-8.813v9.546h8.66l1.389-1.49 1.313 1.49h5.328v-2.248h0.53c0.758 0 1.54-0.025 2.273-0.328v2.576h4.394v-2.5h0.202c0.252 0 0.303 0.026 0.303 0.303v2.197h13.358c0.733 0 1.642-0.152 2.222-0.606v0.606h4.243c0.808 0 1.667-0.076 2.399-0.429v5.773h-58.181zM20.561 13.525h-1.667v-5.354l-2.374 5.354h-1.439l-2.373-5.354v5.354h-3.334l-0.631-1.515h-3.41l-0.631 1.515h-1.768l2.929-6.843h2.424l2.778 6.49v-6.49h2.677l2.147 4.646 1.944-4.646h2.727v6.843zM8.162 10.596l-1.137-2.727-1.111 2.727h2.248zM29.727 23.020v2.298h-3.182l-2.020-2.273-2.096 2.273h-6.465v-6.843h6.565l2.020 2.248 2.071-2.248h5.227c1.541 0 2.753 0.531 2.753 2.248 0 2.752-3.005 2.298-4.874 2.298zM23.464 21.883l-1.768-1.995h-4.116v1.238h3.586v1.389h-3.586v1.364h4.015l1.868-1.995zM27.252 13.525h-5.48v-6.843h5.48v1.439h-3.839v1.238h3.738v1.389h-3.738v1.364h3.839v1.414zM28.086 24.687v-5.48l-2.5 2.702 2.5 2.778zM33.793 10.369c0.934 0.328 1.086 0.909 1.086 1.818v1.339h-1.642c-0.026-1.464 0.353-2.475-1.464-2.475h-1.768v2.475h-1.616v-6.844l3.864 0.026c1.313 0 2.701 0.202 2.701 1.818 0 0.783-0.429 1.54-1.162 1.843zM31.848 19.889h-2.121v1.743h2.096c0.581 0 1.035-0.278 1.035-0.909 0-0.606-0.454-0.833-1.010-0.833zM32.075 8.121h-2.070v1.516h2.045c0.556 0 1.086-0.126 1.086-0.783 0-0.632-0.556-0.733-1.061-0.733zM40.788 22.136c0.909 0.328 1.086 0.934 1.086 1.818v1.364h-1.642v-1.137c0-1.162-0.379-1.364-1.464-1.364h-1.743v2.5h-1.642v-6.843h3.889c1.288 0 2.677 0.228 2.677 1.844 0 0.757-0.404 1.515-1.162 1.818zM37.555 13.525h-1.667v-6.843h1.667v6.843zM39.096 19.889h-2.071v1.541h2.045c0.556 0 1.085-0.126 1.085-0.808 0-0.631-0.555-0.732-1.060-0.732zM56.924 13.525h-2.323l-3.081-5.126v5.126h-3.334l-0.657-1.515h-3.384l-0.631 1.515h-1.894c-2.248 0-3.258-1.162-3.258-3.359 0-2.298 1.035-3.485 3.359-3.485h1.591v1.491c-1.717-0.026-3.283-0.404-3.283 1.944 0 1.162 0.278 1.97 1.591 1.97h0.732l2.323-5.379h2.45l2.753 6.465v-6.465h2.5l2.879 4.747v-4.747h1.667v6.818zM48.313 25.318h-5.455v-6.843h5.455v1.414h-3.813v1.238h3.738v1.389h-3.738v1.364l3.813 0.025v1.414zM46.975 10.596l-1.111-2.727-1.137 2.727h2.248zM52.48 25.318h-3.182v-1.464h3.182c0.404 0 0.858-0.101 0.858-0.631 0-1.464-4.217 0.556-4.217-2.702 0-1.389 1.060-2.045 2.323-2.045h3.283v1.439h-3.005c-0.429 0-0.909 0.076-0.909 0.631 0 1.49 4.243-0.682 4.243 2.601 0.001 1.615-1.111 2.172-2.575 2.172zM61.091 24.434c-0.48 0.707-1.414 0.884-2.222 0.884h-3.157v-1.464h3.157c0.404 0 0.833-0.126 0.833-0.631 0-1.439-4.217 0.556-4.217-2.702 0-1.389 1.086-2.045 2.349-2.045h3.258v1.439h-2.98c-0.454 0-0.909 0.076-0.909 0.631 0 1.212 2.854-0.025 3.889 1.338v2.55z"></path>
								</svg></li>
						</ul>
					</div>
					<div class="btns">
						<a href="<?php echo Router::url('/', true) ?>products/checkout" class="btn chk">Proceed to Checkout</a>
						<!-- <a href="#" class="btn pay"><img src="/Kaouds/img/pay.png" alt="pay"></a> -->
					</div>
					<?php
					if (!empty($authUser['User']['id'])) {
					?>
						<?php echo $this->Form->hidden('user_id', ['value' => $authUser['User']['id']]); ?>
					<?php } ?>
					<?php
					if ($discount_price > 0) {
						echo $this->Form->hidden('discount-price', ['value' => $discount_price]);
					}
					echo $this->Form->hidden('subtotal', ['value' => $subtotal]);
					?>
					<?php echo $this->Form->hidden('total_price', ['value' => $total_price]); ?>
					<?php echo $this->Form->hidden('total_qty', ['value' => $total_quanty]); ?>
					<?php echo $this->Form->hidden('checkout_option', ['value' => 0, 'id' => 'checkout_option']); ?>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
	// Create and initialize a payment form object
	const paymentForm = new SqPaymentForm({
		// Initialize the payment form elements 
		applicationId: '<?php echo $appID; ?>',
		locationId: '<?php echo $locationId; ?>',
		inputClass: 'sq-input',
		autoBuild: false,
		// Customize the CSS for SqPaymentForm iframe elements
		inputStyles: [{
			fontSize: '16px',
			lineHeight: '24px',
			padding: '16px',
			placeholderColor: '#999',
			//backgroundColor: 'transparent',
		}],
		// Initialize the credit card placeholders
		cardNumber: {
			elementId: 'sq-card-number',
			placeholder: '9999 9999 9999 9999'
		},
		cvv: {
			elementId: 'sq-cvv',
			placeholder: 'CVV'
		},
		expirationDate: {
			elementId: 'sq-expiration-date',
			placeholder: 'MM/YY'
		},
		postalCode: {
			elementId: 'sq-postal-code',
			placeholder: 'Postal'
		},
		// SqPaymentForm callback functions
		callbacks: {
			/*
			 * callback function: cardNonceResponseReceived
			 * Triggered when: SqPaymentForm completes a card nonce request
			 */
			cardNonceResponseReceived: function(errors, nonce, cardData) {
				if (errors) {
					// Log errors from nonce generation to the browser developer console.
					console.error('Encountered errors:');
					var err = '';
					errors.forEach(function(error) {
						console.error('  ' + error.message);
						err += error.message;
					});
					alert('Encountered errors: ' + err);
					$('.squBtn').attr('disabled', false);
					$("div#divLoading").removeClass('show');
					return;
				}
				//alert(`The generated nonce is:\n${nonce}`);

				document.getElementById('card-nonce').value = nonce;
				var csrfToken = $("[name='_csrfToken']").val();
				var datax = $("#form_paypal").serializeArray();
				fetch('checkoutnew', {
						method: 'POST',
						headers: {
							'Accept': 'application/json',
							'Content-Type': 'application/json',
							'X-CSRF-Token': csrfToken
						},
						body: JSON.stringify({
							nonce: nonce,
							note: '<?php echo $orederSumm; ?>',
							_csrfToken: csrfToken,
							datax: datax
						})
					})
					.catch(function(err) {
						alert('Network error: ' + err);
						$('.squBtn').attr('disabled', false);
						$("div#divLoading").removeClass('show');
					})
					.then(function(response) {
						if (!response.ok) {
							return response.text().then(function(errorInfo) {
								Promise.reject(errorInfo)
							});
						}
						return response.text();
					})
					.then(function(data) {
						var respone = JSON.parse(data);
						var status = respone.status;
						console.log(respone);
						if (status == 'Success') {

							var redirect_url = $('#redirect_url').val();

							window.location = redirect_url;
						} else {
							var msg = respone.data;
							alert(msg);
							$('.squBtn').attr('disabled', false);
							$("div#divLoading").removeClass('show');
						}



						//alert('Payment complete successfully!');
					})
					.catch(function(err) {
						console.error(err);
						console.log(err);
						alert('Payment failed to complete!');
						$('.squBtn').attr('disabled', false);
						$("div#divLoading").removeClass('show');
					});

			}
		}
	});


	function onGetCardNonce(event) {
		// Don't submit the form until SqPaymentForm returns with a nonce
		event.preventDefault();
		$("div#divLoading").addClass('show');
		// Request a nonce from the SqPaymentForm object
		paymentForm.requestCardNonce();
		$('.squBtn').attr('disabled', true);
	}

	//BUILD THE FORM
	$(window).load(function() {
		//paymentForm.build(); 
	});
</script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<script>
	$(":input").inputmask();

	$('.delete').click(function() {
		showLoadingModal();
		var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
		var id = $(this).attr("data1");

		var url = '<?php echo $this->Url->build(['controller' => 'products', 'action' => 'deleteCart']); ?>';
		$.ajax({
			type: 'POST',
			url: url,
			data: {
				_csrfToken: csrfToken,
				id: id
			},
			success: function(result) {
				location.reload();
			}

		});
	});
	$(".same_as_billing").on("change", function() {
		if (this.checked) {
			$("[name='delivery_first_name']").val($("[name='billing_first_name']").val());
			$("[name='delivery_last_name']").val($("[name='billing_last_name']").val());
			$("[name='delivery_phone']").val($("[name='billing_phone']").val());
			$("[name='delivery_email']").val($("[name='billing_email']").val());
			$("[name='delivery_country']").val($("[name='billing_country']").val());
			$("[name='delivery_city']").val($("[name='billing_city']").val());
			$("[name='delivery_zip']").val($("[name='billing_zip']").val());
			$("[name='delivery_state']").val($("[name='billing_state']").val());
			$("[name='delivery_street_address']").val($("[name='billing_street_address']").val());
		} else {
			$("[name='delivery_first_name']").val('');
			$("[name='delivery_last_name']").val('');
			$("[name='delivery_phone']").val('');
			$("[name='delivery_email']").val('');
			$("[name='delivery_country']").val('');
			$("[name='delivery_city']").val('');
			$("[name='delivery_zip']").val('');
			$("[name='delivery_state']").val('');
			$("[name='delivery_street_address']").val('');
		}
	});
	$("#continue_for_guest").click(function() {

		var checkout_method = $("input[name='checkoutOption']:checked").val();
		if (checkout_method == 'Guest') {
			$("#delivery_address").attr("data-target", "#collapseTwo");
			$("#checkout_option").val(1);
			$('#collapseTwo').addClass("show");
			$('#collapseOne').removeClass("show");
			$('#collapseThree').removeClass("show");
		}
	});
	$("#continue_to_address").click(function() {
		/////////billing form validation start////////////	 
		if ($('#billing-first-name').val() == "") {
			$('#billing-first-name').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#billing-first-name").offset().top
			}, 500);
			return false;
		} else {
			$('#billing-first-name').css('border', '1px solid #ced4da');
		}
		if ($('#billing-last-name').val() == "") {
			$('#billing-last-name').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#billing-last-name").offset().top
			}, 500);
			return false;
		} else {
			$('#billing-last-name').css('border', '1px solid #ced4da');
		}


		if ($('#billing-email').val() == "") {
			$('#billing-email').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#billing-last-name").offset().top
			}, 500);
			return false;
		} else if ($('#billing-email').val() != "") {
			var str = $('#billing-email').val();
			var patt = new RegExp("@");
			var res = patt.test(str);
			if (res == false) {
				$('#billing-email').css('border', '1px solid red');
				$('html, body').animate({
					scrollTop: $("#billing-email").offset().top
				}, 500);
				return false;
			} else {
				$('#billing-email').css('border', '1px solid #ced4da');
			}
		} else {
			$('#billing-email').css('border', '1px solid #ced4da');
		}
		if ($('#billing-phone').val() == "") {
			$('#billing-phone').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#billing-phone").offset().top
			}, 500);
			return false;
		} else {
			$('#billing-phone').css('border', '1px solid #ced4da');
		}
		if ($('#billing-country').val() == "") {
			$('#billing-country').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#billing-country").offset().top
			}, 500);
			return false;
		} else {
			$('#billing-country').css('border', '1px solid #ced4da');
		}
		if ($('#billing-city').val() == "") {
			$('#billing-city').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#billing-city").offset().top
			}, 500);
			return false;
		} else {
			$('#billing-city').css('border', '1px solid #ced4da');
		}
		if ($('#billing-zip').val() == "") {
			$('#billing-zip').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#billing-zip").offset().top
			}, 500);
			return false;
		} else {
			$('#billing-zip').css('border', '1px solid #ced4da');
		}
		if ($('#billing-state').val() == "") {
			$('#billing-state').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#billing-state").offset().top
			}, 500);
			return false;
		} else {
			$('#billing-state').css('border', '1px solid #ced4da');
		}
		if ($('#billing-street-address').val() == "") {
			$('#billing-street-address').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#billing-street-address").offset().top
			}, 500);
			return false;
		} else {
			$('#billing-street-address').css('border', '1px solid #ced4da');
		}
		/////////billing form validation end////////////
		/////////delivery form validation start////////////	 
		if ($('#delivery-first-name').val() == "") {
			$('#delivery-first-name').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#delivery-first-name").offset().top
			}, 500);
			return false;
		} else {
			$('#delivery-first-name').css('border', '1px solid #ced4da');
		}
		if ($('#delivery-last-name').val() == "") {
			$('#delivery-last-name').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#delivery-last-name").offset().top
			}, 500);
			return false;
		} else {
			$('#delivery-last-name').css('border', '1px solid #ced4da');
		}


		if ($('#delivery-email').val() == "") {
			$('#delivery-email').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#delivery-email").offset().top
			}, 500);
			return false;
		} else if ($('#delivery-email').val() != "") {
			var str = $('#delivery-email').val();
			var patt = new RegExp("@");
			var res = patt.test(str);
			if (res == false) {
				$('#delivery-email').css('border', '1px solid red');
				$('html, body').animate({
					scrollTop: $("#delivery-email").offset().top
				}, 500);
				return false;
			} else {
				$('#delivery-email').css('border', '1px solid #ced4da');
			}
		} else {
			$('#delivery-email').css('border', '1px solid #ced4da');
		}
		if ($('#delivery-phone').val() == "") {
			$('#delivery-phone').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#delivery-phone").offset().top
			}, 500);
			return false;
		} else {
			$('#delivery-phone').css('border', '1px solid #ced4da');
		}
		if ($('#delivery-country').val() == "") {
			$('#delivery-country').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#delivery-country").offset().top
			}, 500);
			return false;
		} else {
			$('#delivery-country').css('border', '1px solid #ced4da');
		}
		if ($('#delivery-city').val() == "") {
			$('#delivery-city').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#delivery-city").offset().top
			}, 500);
			return false;
		} else {
			$('#delivery-city').css('border', '1px solid #ced4da');
		}
		if ($('#delivery-zip').val() == "") {
			$('#delivery-zip').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#delivery-zip").offset().top
			}, 500);
			return false;
		} else {
			$('#delivery-zip').css('border', '1px solid #ced4da');
		}
		if ($('#delivery-state').val() == "") {
			$('#delivery-state').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#delivery-state").offset().top
			}, 500);
			return false;
		} else {
			$('#delivery-state').css('border', '1px solid #ced4da');
		}
		if ($('#delivery-street-address').val() == "") {
			$('#delivery-street-address').css('border', '1px solid red');
			$('html, body').animate({
				scrollTop: $("#delivery-street-address").offset().top
			}, 500);
			return false;
		} else {
			$('#delivery-street-address').css('border', '1px solid #ced4da');
		}
		/////////delivery form validation end////////////
		if ($("#same_as_billing").is(":checked")) {

			if ($("#cr_password").val() == '') {
				$('#cr_password').css('border', '1px solid red');

				return false;
			}
			if ($("#cr_cf_password").val() == '') {
				$('#cr_cf_password').css('border', '1px solid red');
				return false;
			}
			if ($("#cr_cf_password").val() != $("#cr_password").val()) {
				alert("Your password and confirmation password do not match.");
				return false;
			}
		}

		$("#credit_card_details").attr("data-target", "#collapseFour");
		$('#collapseTwo').removeClass("show");
		$('#collapseOne').removeClass("show");
		$('#collapseThree').removeClass("show");
		$('#collapseFour').addClass("show");

		paymentForm.build();
	});


	$(document).ready(function() {

		if ($(".alert-danger").length) {
			$("#collapseFour").removeClass("show");
		}

		$("#checkoutoption-guest").click(function() {
			var radioValue = $("#checkoutoption-guest").val();
			if (radioValue == 'Guest') {

				$('.continue_for_guest').css("display", "block");
				$('#login-form').css("display", "none");
			}
		});
		$("#checkoutoption-login").click(function() {
			var radioValue = $("#checkoutoption-login").val();
			if (radioValue == 'Login') {
				$('#delivery_address').removeAttr('data-target', '#collapseTwo');
				$('.continue_for_guest').css("display", "none");
				$('#login-form').css("display", "block");
			}
		});
	});

	function increaseValue(id) {
		var value = parseInt(document.getElementById(id + '_number').value, 10);
		value = isNaN(value) ? 0 : value;
		value++;
		document.querySelector('.update-cart').disabled = false;
		document.getElementById(id + '_number').value = value;
	}

	function decreaseValue(id) {
		var value = parseInt(document.getElementById(id + '_number').value, 10);
		value = isNaN(value) ? 0 : value;
		value--;
		if (value < 1) {
			value = 1;
			document.querySelector('.update-cart').disabled = false;
		} else {
			document.querySelector('.update-cart').disabled = false;
		}
		document.getElementById(id + '_number').value = value;
	}
	$('.update-cart').click(function() {
		showLoadingModal();
		var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
		var url = '<?php echo $this->Url->build(['controller' => 'products', 'action' => 'updateCart']); ?>';
		const cartDataForm = document.getElementById("cart-data-list");
		let formData = new FormData(cartDataForm);
		$.ajax({
			headers: {
				'X-CSRF-Token': csrfToken
			},
			type: 'POST',
			url: url,
			processData: false,
			contentType: false,
			data: formData,
			success: function(result) {
				location.reload();
			}

		});
	});

	function applyCoupon() {
		var couponCode = $("input[name='coupon-code']").val().trim();
		if (couponCode === "") {
			$("input[name='coupon-code']").css('border', '2px solid red').focus();
			$(".coupon-error").remove(); // Remove any existing error message
			$("input[name='coupon-code']").after('<div class="coupon-error" style="color: red; margin-top: -5px;margin-bottom: 15px">Coupon code cannot be empty.</div>');
			return;
		} else {
			$("input[name='coupon-code']").css('border', '');
			$(".coupon-error").remove(); // Remove error message if any
		}

		showLoadingModal();
		var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
		var url = '<?php echo $this->Url->build(['controller' => 'Products', 'action' => 'applyCoupon']); ?>';
		$.ajax({
			headers: {
				'X-CSRF-Token': csrfToken
			},
			type: 'POST',
			url: url,
			data: {
				coupon_code: couponCode
			},
			success: function(result) {
				hideLoadingModal();
				result = JSON.parse(result);

				if (result.status) {
					Swal.fire({
						title: "Success!",
						text: "Coupon applied successfully!",
						icon: "success",
						confirmButtonText: "OK",
						customClass: {
							popup: "small-alert", // Apply custom class to the popup
						},
					}).then(() => {
						location.reload();
					});
				} else {
					Swal.fire({
						title: "Error!",
						text: "Invalid coupon code.",
						icon: "error",
						confirmButtonText: "OK",
						customClass: {
							popup: "small-alert", // Apply custom class to the popup
						},

					});
				}
			},
			error: function() {
				hideLoadingModal();
				alert("An error occurred while applying the coupon. Please try again.");
			}
		});
	}

	$('#apply-coupon-btn').click(applyCoupon);

	function removeCoupon() {
		var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
		var url = '<?php echo $this->Url->build(['controller' => 'Products', 'action' => 'removeCoupon']); ?>';
		$.ajax({
			headers: {
				'X-CSRF-Token': csrfToken
			},
			type: 'POST',
			url: url,
			success: function(result) {
				location.reload();
			},
			error: function() {
				alert("An error occurred while removing the coupon. Please try again.");
			}
		});
	}

	$('#remove-coupon').click(removeCoupon);
</script>