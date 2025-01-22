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
<script type="text/javascript" src="<?php echo $squareJsUrl; ?>">
</script>
<?php echo $this->Html->css(array('front/sq-payment-form')); ?>
<section class="inner_banner shp">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 no_padding">
				<div class="inr_bnr">
					<?php
					$image = WWW_ROOT . 'img' . DS . 'Rug-Rolls-scaled.jpg';
					if (file_exists($image)) {
						echo $this->Html->image('/img/' . "Rug-Rolls-scaled.jpg", ['alt' => "Rug-Rolls-scaled"]);
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="rg_clng chkout">
	<div class="container">
		<div class="row">
			<div class="col-md-7">
				<?php
				if (empty($authUser['User']['id'])) {
				?>
					<p>Returning customer? <a href="<?php echo $this->Url->build(['controller' => 'User', 'action' => 'login']); ?>">Click here to login</a></p>
				<?php
				} else {
					echo "<p>Welcome, " . $authUser['User']['first_name'] . " " . $authUser['User']['last_name'] . "</p>";
				} ?>
				<p>Have a coupon? <a href="#">Click here to enter your code</a></p>
				<div id="alert-message" class="alert alert-danger alert-dismissible" role="alert" style="display: none;">
					<span id="alert-text"></span>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				<form action="#" name="form_paypal" id="form_paypal">
					<h3>Billing Details</h3>
					<div class="row">
						<div class="col-md-6">
							<div class="form_group">
								<input class="fotm_control" type="text" name="billing-first-name" value="<?= $userData->first_name ?>" placeholder="First Name">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form_group">
								<input class="fotm_control" type="text" name="billing-last-name" value="<?= $userData->last_name ?>" placeholder="Last Name">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<input class="fotm_control" type="text" name="billing-company-name" value="<?= $userData->user_detail->company ?>" placeholder="Company Name (Optional)">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<p>Country / Region</p>
								<strong>United States (US)</strong>
								<input type="hidden" name="billing-country-code" value="US">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<input class="fotm_control" type="text" name="billing-address-name" value="<?= $userData->user_detail->address ?>" placeholder="Address">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<input class="fotm_control" type="text" name="billing-city-name" value="<?= $userData->user_detail->city ?>" placeholder="Town / City">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<select class="fotm_control" name="billing-states-name">
									<?php
									foreach ($states as $statekey => $statesData) {
										if (isset($userData->user_detail->state) && $userData->user_detail->state == $statekey) {
											$selected = 'selected';
										} else {
											$selected = '';
										}
									?>
										<option value="<?php echo $statekey; ?>" <?= $selected ?>><?php echo $statesData; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<input class="fotm_control" type="text" name="billing-zipcode" value="<?= $userData->user_detail->postal_code ?>" placeholder="Zip Code">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<input class="fotm_control" type="number" name="billing-phone" value="<?= $userData->phone ?>" placeholder="Phone">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<input class="fotm_control billing-email" type="email" name="billing-email" value="<?= $userData->email ?>" placeholder="Email Address" onblur="checkEmail()">
							</div>
						</div>
						<ul class="rug_checkbox">
							<?php
							if (empty($authUser['User']['id'])) {
							?>
								<li class="rug_typ">
									<input type="checkbox" value="" id="create_account">
									<input name="create_account" type="checkbox" value="" class="create_account">
									<label for="rug_typ001" id="rug_typ001">Creat an Account?</label>
								</li>
							<?php } ?>

							<?php
							if (isset($newsletterData) && !empty($newsletterData)) {
								$hide_newsletter = '';
								$checked_val = '0';
								if (in_array($userData->email, $newsletterData)) {
									$checked = 'checked';
									$hide_newsletter = 'style="display:none;"';
									$checked_val = '1';
								} else {
									$checked = '';
								}
							} else {
								$checked = '';
							}
							?>
							<li class="rug_typ" <?= $hide_newsletter; ?>>
								<input name="rug_typ" type="checkbox" value="" <?= $checked; ?> id="rug_typ002" onchange="toggleNewsletterCheckbox()">
								<input type="hidden" name="sign-up-newsletter" value="<?= $checked_val; ?>" class="sign-up-newsletter">
								<label for="rug_typ002" id="rug_typ002">Sign me up for the newsletter!</label>
							</li>
							<li class="rug_typ">
								<input  type="checkbox" value="0" id="ship-to-different">
								<input type="hidden" name="ship-to-different" value="0" class="ship-to-different">
								<label for="rug_typ003" id="rug_typ003">Ship to a different address?</label>
							</li>
						</ul>
						<div class="col-md-6 ship-to-different" style="display: none;">
							<div class="form_group">
								<input class="fotm_control" type="text" name="delivery-first-name" value="" placeholder="First Name">
							</div>
						</div>
						<div class="col-md-6 ship-to-different" style="display: none;" >
							<div class="form_group">
								<input class="fotm_control" type="text" name="delivery-last-name" value="" placeholder="Last Name">
							</div>
						</div>
						<div class="col-md-12 ship-to-different" style="display: none;">
							<div class="form_group">
								<input class="fotm_control" type="text" name="delivery-company-name" value="" placeholder="Company Name (Optional)">
							</div>
						</div>
						<div class="col-md-12 ship-to-different" style="display: none;">
							<div class="form_group">
								<p>Country / Region</p>
								<strong>United States (US)</strong>
								<input type="hidden" name="delivery-country-code" value="US">
							</div>
						</div>
						<div class="col-md-12 ship-to-different" style="display: none;">
							<div class="form_group">
								<input class="fotm_control" type="text" name="delivery-address-name" value="" placeholder="Address">
							</div>
						</div>
						<div class="col-md-12 ship-to-different" style="display: none;">
							<div class="form_group">
								<input class="fotm_control" type="text" name="delivery-city-name" value="" placeholder="Town / City">
							</div>
						</div>
						<div class="col-md-12 ship-to-different" style="display: none;">
							<div class="form_group">
								<select class="fotm_control" name="delivery-states-name">
									<?php
									foreach ($states as $statekey => $statesData) {
										if (isset($userData->user_detail->state) && $userData->user_detail->state == $statekey) {
											$selected = 'selected';
										} else {
											$selected = '';
										}
									?>
										<option value="<?php echo $statekey; ?>" <?= $selected ?>><?php echo $statesData; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-12 ship-to-different" style="display: none;">
							<div class="form_group">
								<input class="fotm_control" type="text" name="delivery-zipcode" value="" placeholder="Zip Code">
							</div>
						</div>
						<div class="col-md-12 ship-to-different" style="display: none;">
							<div class="form_group">
								<input class="fotm_control" type="number" name="billing-phone" value="" placeholder="Phone">
							</div>
						</div>
						<div class="col-md-12 ship-to-different" style="display: none;">
							<div class="form_group">
								<input class="fotm_control delivery-email" type="email" name="delivery-email" value="" placeholder="Email Address" onblur="checkEmail()">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<textarea class="fotm_control" name="shipping-delivery-note" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-5">
				<div class="chkout_ordr">
					<h3>Your Order</h3>
					<div class="table-responsive crt_sbttl">
						<table class="table">
							<thead>
								<tr>
									<th scope="col">Product</th>
									<th scope="col">Subtotal</th>
								</tr>
							</thead>
							<?= $this->Form->create(null, ['url' => "javscript:void(0)", 'id' => "payment-details"]); ?>
							<tbody>
								<?php
								if (!empty($cardData)) {
									$total_quanty = 0;
									$total_price = 0;
									foreach ($cardData as $item) {
										$total_quanty += $item['product_qty'];
										$total_price += round($item['everyday_price'] * $item['product_qty'], 2);
									}
								}
								if (!empty($cardData)) {
									foreach ($cardData as $key => $data) {
								?>
										<tr>
											<th scope="row"><?php echo $data['title'] ?></th>
											<td>$<?= number_format(($data['everyday_price'] * $data['product_qty']), 2); ?></td>
										</tr>
								<?php
									}
								}
								?>
								<tr>
									<th scope="row">Subtotal</th>
									<td>$<?= number_format($total_price, 2); ?></td>
								</tr>
								<tr>
									<th scope="row">Shipping</th>
									<td>Free Shipping</td>
								</tr>
								<tr>
									<th scope="row">Tax</th>
									<td>$0.00</td>
								</tr>
								<tr>
									<th scope="row">Total</th>
									<td>$<?= number_format($total_price, 2); ?></td>
								</tr>
								<?php
								if (!empty($authUser['User']['id'])) {
								?>
									<?php echo $this->Form->hidden('user_id', ['value' => $authUser['User']['id']]); ?>
								<?php } ?>
								<?php echo $this->Form->hidden('total_price', ['value' => $total_price]); ?>
								<?php echo $this->Form->hidden('total_qty', ['value' => $total_quanty]); ?>
								<?php echo $this->Form->hidden('checkout_option', ['value' => 0, 'id' => 'checkout_option']); ?>
							</tbody>
							<?= $this->Form->end(); ?>
						</table>
						<ul class="rug_radio">
							<li class="rug_typ">
								<input name="payment-option" type="radio" value="1" id="payment-paypal">
								<label for="rug_typ011" id="rug_typ011">Paypal</label>
							</li>
							<li class="rug_typ">
								<input name="payment-option" type="radio" value="2" id="payment-cards">
								<label for="rug_typ012" id="rug_typ012">Debit & Credit Cards</label>
							</li>
						</ul>
						<ul class="rug_checkbox">
							<li class="rug_typ">
								<input name="payment-terms-conditions" type="checkbox" value="" id="terms-conditions">
								<label for="rug_typ013" id="rug_typ013">I have read and agree to the website terms and conditions.</label>
							</li>
						</ul>
						<a href="javascript:void(0);" class="btn pay payment-1" style="display: none;"><img src="/Kaouds/img/pay.png" alt="pay"></a>
						<a href="javascript:void(0);" class="btn pay payment-2" style="display: none;"><strong>Place Order</strong></a>
						<p>Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.</p>
					</div>
				</div>
			</div>
			<input type="hidden" id="redirect_url" value="<?php echo Router::url('/', true)."payments/success"; ?>">
		</div>
	</div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
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

	function checkEmail() {
		var emailInput = document.querySelector('.billing-email').value;
		var userEmail = '<?= $userData->email ?>';
		var newsletterCheckbox = document.querySelector('input[id="rug_typ002"]').parentElement;

		if (emailInput !== userEmail) {
			newsletterCheckbox.style.display = 'block';
		} else {
			newsletterCheckbox.style.display = 'none';
		}
	}

	function toggleNewsletterCheckbox() {
		const newsletterCheckbox = document.getElementById('rug_typ002');
		const newsletterInput = document.querySelector('.sign-up-newsletter');
		newsletterCheckbox.addEventListener('change', function() {
			if (this.checked) {
				this.value = '1';
				newsletterInput.value = '1';
			} else {
				this.value = '0';
				newsletterInput.value = '0';
			}
		});
	}
	function toggleShipToDiffAddressCheckbox() {
		const shipDiffAddCheckbox = document.getElementById('ship-to-different');
		const shipDiffAddInput = document.querySelector('.ship-to-different');
		shipDiffAddCheckbox.addEventListener('change', function() {
			if (this.checked) {
				this.value = '1';
				shipDiffAddInput.value = '1';
			} else {
				this.value = '0';
				shipDiffAddInput.value = '0';
			}
		});
	}
	function updateCheckoutOption() {
		const paymentOptions = document.querySelectorAll('input[name="payment-option"]');
		const checkoutOptionInput = document.getElementById('checkout_option');

		paymentOptions.forEach(option => {
			option.addEventListener('change', function() {
				if (this.value === '1') {
					document.querySelector('.payment-1').style.display = 'block';
					document.querySelector('.payment-1').classList.add('pay-now');
					document.querySelector('.payment-2').style.display = 'none';
					document.querySelector('.payment-2').classList.remove('pay-now');
				} else {
					document.querySelector('.payment-1').style.display = 'none';
					document.querySelector('.payment-1').classList.remove('pay-now');
					document.querySelector('.payment-2').style.display = 'block';
					document.querySelector('.payment-2').classList.add('pay-now');
				}
				checkoutOptionInput.value = this.value;
			});
		});
	}

	updateCheckoutOption();
	toggleNewsletterCheckbox();
	toggleShipToDiffAddressCheckbox();

	function sendEncryptedData() {
		const csrfToken = $("[name='_csrfToken']").val();
		const formDataPaypal = new FormData(document.getElementById("form_paypal"));
		const formDataPayment = new FormData(document.getElementById("payment-details"));

		// Combine both FormData objects
		for (let [key, value] of formDataPayment.entries()) {
			formDataPaypal.append(key, value);
		}
		// Convert FormData to JSON object
		let data = {};
		formDataPaypal.forEach((value, key) => {
			data[key] = value;
		});

		// Validation
		const requiredFields = [
			'billing-first-name', 'billing-last-name', 'billing-address-name', 'billing-city-name', 'billing-states-name', 'billing-zipcode', 'billing-phone', 'billing-email'
		];
		let isValid = true;
		requiredFields.forEach(field => {
			const fieldElement = document.querySelector(`[name="${field}"]`);
			if (!data[field] || data[field].trim() === '') {
				isValid = false;
				fieldElement.style.border = '1px solid red';
				if (isValid === false) {
					fieldElement.focus();
				}
			} else {
				fieldElement.style.border = '1px solid #ced4da';
			}
		});
		// Validate delivery address if "Ship to a different address" is checked
		if (data['ship-to-different'] === '1') {
			const deliveryFields = [
				'delivery-first-name', 'delivery-last-name', 'delivery-address-name', 'delivery-city-name', 'delivery-states-name', 'delivery-zipcode', 'delivery-phone', 'delivery-email'
			];
			deliveryFields.forEach(field => {
				const fieldElement = document.querySelector(`[name="${field}"]`);
				if (!data[field] || data[field].trim() === '') {
					isValid = false;
					fieldElement.style.border = '1px solid red';
					if (isValid === false) {
						fieldElement.focus();
					}
				} else {
					fieldElement.style.border = '1px solid #ced4da';
				}
			});
		}

		// Validate terms and conditions
		const termsConditions = document.querySelector('[name="payment-terms-conditions"]');
		if (!termsConditions.checked) {
			isValid = false;
			termsConditions.nextElementSibling.style.color = 'red';
		} else {
			termsConditions.nextElementSibling.style.color = 'inherit';
		}

		if (!isValid) {
			showAlert('Please fill in all required fields and agree to the terms and conditions.');
			return;
		}
		showLoadingModal();
		fetch('<?php echo $this->Url->build(['controller' => 'Products', 'action' => 'checkoutnew']); ?>', {
				method: 'POST',
				headers: {
					'X-CSRF-Token': csrfToken,
					'Content-Type': 'application/json'
				},
				body: JSON.stringify(data)
			})
			.then(response => response.json())
			.then(data => {
				if (data.status === 'Success') {
					var redirect_url = $('#redirect_url').val();

					window.location = redirect_url;
				} else {
					hideLoadingModal();
					Swal.fire({
						title: "Error!",
						text: data.message,
						icon: "error",
						confirmButtonText: "OK",
						customClass: {
							popup: "small-alert", // class name for the popup container
						},

					});
				}
			})
			.catch(error => {
				console.error('Error:', error);
				Swal.fire({
					title: "Error!",
					text: 'An error occurred while processing your request.',
					icon: "error",
					confirmButtonText: "OK",
					customClass: {
						popup: "small-alert", // class name for the popup container
					},

				});
			});
	}

	document.querySelectorAll('.pay-now').forEach(element => {
		element.addEventListener('click', function(event) {
			event.preventDefault();
			sendEncryptedData();
		});
	});

	const observer = new MutationObserver(function(mutations) {
		mutations.forEach(function(mutation) {
			if (mutation.attributeName === 'class') {
				const target = mutation.target;
				if (target.classList.contains('pay-now')) {
					target.addEventListener('click', function(event) {
						event.preventDefault();
						sendEncryptedData();
					});
				}
			}
		});
	});

	document.querySelectorAll('.btn').forEach(element => {
		observer.observe(element, {
			attributes: true
		});
	});

	function showAlert(message) {
		const alertMessage = document.getElementById('alert-message');
		const alertText = document.getElementById('alert-text');
		alertText.textContent = message;
		alertMessage.style.display = 'block';
	}

	function hideAlert() {
		const alertMessage = document.getElementById('alert-message');
		alertMessage.style.display = 'none';
	}
</script>