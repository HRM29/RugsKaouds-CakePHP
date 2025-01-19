<?php

use Cake\Routing\Router;
use Cake\Core\Configure;
?>

<?php
$session = $this->request->getSession();
echo "<pre>session: ";print_r($session->read());echo "</pre>";

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
				} ?>
				<p>Have a coupon? <a href="#">Click here to enter your code</a></p>
				<form action="#">
					<h3>Billing Details</h3>
					<div class="row">
						<div class="col-md-6">
							<div class="form_group">
								<input class="fotm_control" type="text" name="name" value="" placeholder="First Name">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form_group">
								<input class="fotm_control" type="text" name="name" value="" placeholder="Last Name">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<input class="fotm_control" type="text" name="name" value="" placeholder="Company Name (Optional)">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<p>Country / Region</p>
								<strong>United States (US)</strong>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<input class="fotm_control" type="text" name="adrs" value="" placeholder="Address">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<input class="fotm_control" type="text" name="city" value="" placeholder="Town / City">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<select class="fotm_control" name="">
									<option value="0">State</option>
									<option value="1">Alabama</option>
									<option value="2">Alaska</option>
									<option value="3">Arizona</option>
									<option value="4">Arkansas</option>
								</select>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<input class="fotm_control" type="text" name="zipcode" value="" placeholder="Zip Code">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<input class="fotm_control" type="number" name="phone" value="" placeholder="Phone">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form_group">
								<input class="fotm_control" type="email" name="email" value="" placeholder="Email Address">
							</div>
						</div>
						<ul class="rug_checkbox">
							<li class="rug_typ">
								<input name="rug_typ" type="checkbox" value="" id="rug_typ001">
								<label for="rug_typ001" id="rug_typ001">Creat an Account?</label>
							</li>
							<li class="rug_typ">
								<input name="rug_typ" type="checkbox" value="" id="rug_typ002">
								<label for="rug_typ002" id="rug_typ002">Sign me up for the newsletter!</label>
							</li>
							<li class="rug_typ">
								<input name="rug_typ" type="checkbox" value="" id="rug_typ003">
								<label for="rug_typ003" id="rug_typ003">Ship to a different address?</label>
							</li>
						</ul>
						<div class="col-md-12">
							<div class="form_group">
								<textarea class="fotm_control" name="" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
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
							<tbody>
								<tr>
									<th scope="row">2'9"x4'1" Polar Bear White, Nain with Large Medallion Design, 250 KPSI, Wool and Silk, Hand Knotted, Oriental Rug</th>
									<td>$922.28</td>
								</tr>
								<tr>
									<th scope="row">Subtotal</th>
									<td>$922.28</td>
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
									<td>$922.28</td>
								</tr>
							</tbody>
						</table>
						<ul class="rug_radio">
							<li class="rug_typ">
								<input name="rug_typ" type="radio" value="1" id="rug_typ011">
								<label for="rug_typ011" id="rug_typ011">Paypal</label>
							</li>
							<li class="rug_typ">
								<input name="rug_typ" type="radio" value="2" id="rug_typ012">
								<label for="rug_typ012" id="rug_typ012">Debit & Credit Cards</label>
							</li>
						</ul>
						<ul class="rug_checkbox">
							<li class="rug_typ">
								<input name="rug_typ" type="checkbox" value="" id="rug_typ013">
								<label for="rug_typ013" id="rug_typ013">I have read and agree to the website terms and conditions.</label>
							</li>
						</ul>
						<a href="#" class="btn pay"><img src="/Kaouds/img/pay.png" alt="pay"></a>
						<p>Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.</p>
					</div>
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
</script>