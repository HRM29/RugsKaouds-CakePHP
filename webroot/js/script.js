$(function() {

    var cardNumber = $('#creditcard-number');
    var cardNumberField = $('#card-number-field');
    var CVV = $("#creditcard-code");
    var mastercard = $("#mastercard");
    var confirmButton = $('#continue_to_card');
    var visa = $("#visa");

    // Use the payform library to format and validate
    // the payment fields.
	
    cardNumber.payform('formatCardNumber');
    CVV.payform('formatCardCVC');


    cardNumber.keyup(function() {

        visa.removeClass('transparent');
        mastercard.removeClass('transparent');

        if ($.payform.validateCardNumber(cardNumber.val()) == false) {
            cardNumberField.addClass('has-error');
        } else {
            cardNumberField.removeClass('has-error');
            cardNumberField.addClass('has-success');
        }

        if ($.payform.parseCardType(cardNumber.val()) == 'visa') {
            mastercard.addClass('transparent');
        } else if ($.payform.parseCardType(cardNumber.val()) == 'mastercard') {
            visa.addClass('transparent');
        }
    });

    confirmButton.click(function(e) {
		if(cardNumber.val() === ""){
			$('#creditcard-number').css('border','1px solid red');
			$('html, body').animate({scrollTop: $("#creditcard-number").offset().top}, 500);
			return false;
		}else{
			$('#creditcard-number').css('border','1px solid #ced4da');
		}
		if(CVV.val() === ""){
			$('#creditcard-code').css('border','1px solid red');
			$('html, body').animate({scrollTop: $("#creditcard-code").offset().top}, 500);
			return false;
		}else{
			$('#creditcard-code').css('border','1px solid #ced4da');
		}
        e.preventDefault();
		
        var isCardValid = $.payform.validateCardNumber(cardNumber.val());
        var isCvvValid = $.payform.validateCardCVC(CVV.val());
		
		var submit_url = $('#submit_url').val();
		var redirect_url = $('#redirect_url').val();
        if (!isCardValid) {
            alert("Wrong card number");
        } else if (!isCvvValid) {
            alert("Wrong CVV");
        } else {
			$("#continue_to_card").attr("disabled", true);
			$("#continue_to_card").text("PLACING ORDER......");
			$("div#divLoading").addClass('show');
			var form = $(this);
		
			$.ajax({
			type: 'post',
			url:  submit_url,
			data: $('#form_paypal').serialize(),
			success: function (result) {
				if(result == 'success'){
					$("div#divLoading").removeClass('show');
					window.location.replace(redirect_url);
				}else{
					$('.alert-danger').css('display','block');
					$('.alert-danger').html('Please check your credit card details!');
					$("#continue_to_card").removeAttr("disabled", true);
					$("#continue_to_card").text("Place Order");
					$("div#divLoading").removeClass('show');
					setTimeout(function() {
						$("#alert-danger").hide('blind', {}, 500)
					}, 5000);
				}
			}
			}); 
		
			/* 
		   $("#continue_to_card").text("PLACING ORDER......");
           $("#form_paypal").submit(); */
        }
    });
});

