<section class="inner_banner shp">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h1>Schedule Rug Repair</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="rg_clng">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h2></h2>
                </div>
                <p>We take rug repair and restoration very seriously. We specialize in the highest quality rug reweaving, re-binding, overcasting, re-fringing, and more. You can trust our family to take great care in making your rugs look like new again! Kindly fill out this form and try to be as descriptive as possible so we may better serve you with your repair needs. <br /><br /> Whether its loose binding or a giant hole, we can help!</p>
                <h3>Schedule Rug Repair Pickup</h3>
                <?= $this->Flash->render('positive_forgot') ?>
                <?php
                echo $this->Form->create(null, ['id' => 'rugRepairForm', 'url' => ['controller' => 'Pages', 'action' => 'rugrepair'], 'type' => 'file']);
                ?>
                <h3>Customer Information</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form_group">
                            <input class="fotm_control" type="text" name="first_name" id="first_name" placeholder="First Name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <input class="fotm_control" type="text" name="last_name" id="last_name" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <input class="fotm_control" type="email" name="email" id="email" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_group">
                            <input class="fotm_control" type="tel" name="phone_number" id="phone_number" placeholder="Phone Number" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form_group">
                            <input class="fotm_control" type="text" name="address_line_1" id="address_line_1" placeholder="Address Line 1" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form_group">
                            <input class="fotm_control" type="text" name="address_line_2" id="address_line_2" placeholder="Address Line 2">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <input class="fotm_control" type="text" name="city" id="city" placeholder="City" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <select class="fotm_control" name="state" id="state" required>
                                <?php
                                foreach ($states as $statekey => $statesData) {
                                    $selected = '';
                                    // 8 Represents --> CT (Connecticut)
                                    if ($statekey == '8') {
                                        $selected = 'selected';
                                    }
                                ?>
                                    <option value="<?php echo $statesData; ?>" <?= $selected ?>><?php echo $statesData; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_group">
                            <input class="fotm_control" type="text" name="zip_code" id="zip_code" placeholder="Zip Code" required>
                        </div>
                    </div>
                </div>
                <div class="pckup_dtls">
                    <h3>Pickup Info Details</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form_group">
                                <input class="fotm_control" type="text" name="preferred_date" id="preferred_date" placeholder="Preferred Date for Pickup" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <input class="fotm_control" type="time" name="preferred_time" id="preferred_time" placeholder="Preferred Time for Pickup" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <input class="fotm_control" type="text" name="alternate_date" id="alternate_date" placeholder="Alternate Date for Pickup" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <input class="fotm_control" type="time" name="alternate_time" id="alternate_time" placeholder="Alternate Time for Pickup" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pckup_dtls">
                    <h3>Rug Information</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="type_rug">
                                <h4>Type of Rug</h4>
                                <ul class="rug_radio">
                                    <li class="rug_typ">
                                        <input name="rug_type" type="radio" value="New Hand Knotted" id="rug_type_new_hand_knotted" required>
                                        <label for="rug_type_new_hand_knotted">New Hand Knotted</label>
                                    </li>
                                    <li class="rug_typ">
                                        <input name="rug_type" type="radio" value="Antique Hand Knotted" id="rug_type_antique_hand_knotted">
                                        <label for="rug_type_antique_hand_knotted">Antique Hand Knotted</label>
                                    </li>
                                    <li class="rug_typ">
                                        <input name="rug_type" type="radio" value="Hand Hooked" id="rug_type_hand_hooked">
                                        <label for="rug_type_hand_hooked">Hand Hooked</label>
                                    </li>
                                    <li class="rug_typ">
                                        <input name="rug_type" type="radio" value="Shag" id="rug_type_shag">
                                        <label for="rug_type_shag">Shag</label>
                                    </li>
                                    <li class="rug_typ">
                                        <input name="rug_type" type="radio" value="Hand Tufted with Backing" id="rug_type_hand_tufted_with_backing">
                                        <label for="rug_type_hand_tufted_with_backing">Hand Tufted with Backing</label>
                                    </li>
                                    <li class="rug_typ">
                                        <input name="rug_type" type="radio" value="Machine Made" id="rug_type_machine_made">
                                        <label for="rug_type_machine_made">Machine Made</label>
                                    </li>
                                    <li class="rug_typ">
                                        <input name="rug_type" type="radio" value="Broadloom - Custom" id="rug_type_broadloom_custom">
                                        <label for="rug_type_broadloom_custom">Broadloom - Custom</label>
                                    </li>
                                    <li class="rug_typ">
                                        <input name="rug_type" type="radio" value="Oriental" id="rug_type_oriental">
                                        <label for="rug_type_oriental">Oriental</label>
                                    </li>
                                    <li class="rug_typ">
                                        <input name="rug_type" type="radio" value="Flatweave" id="rug_type_flatweave">
                                        <label for="rug_type_flatweave">Flatweave</label>
                                    </li>
                                    <li class="rug_typ">
                                        <input name="rug_type" type="radio" value="Other" id="rug_type_other" onfocus="jQuery(this).next('input').focus();">
                                        <input class="small" id="rug_type_other_text" name="rug_type_other_text" type="text" value="Other" aria-label="Other" onfocus="jQuery(this).prev('input')[0].click(); if(jQuery(this).val() == 'Other') { jQuery(this).val(''); }" onblur="if(jQuery(this).val().replace(' ', '') == '') { jQuery(this).val('Other'); }">
                                    </li>
                                </ul>
                                <h4 class="rg_cndtn">Rug Condition Including Major Stains & Any Comments*</h4>
                                <div class="form_group">
                                    <textarea class="fotm_control" name="rug_condition" id="rug_condition" placeholder="Message" required></textarea>
                                </div>
                                <div class="form_group">
                                    <input type="file" class="fotm_control" id="rug_image" name="rug_image">
                                </div>
                                <span>Show us the condition of your rug if you like so we can better assist you.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form_group">
                    <button class="btn" type="submit">Submit</button>
                </div>
                <?= $this->Form->control('g-recaptcha-response', ["type" => "hidden", "class" => "g-recaptcha-response", "id" => false]); ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

</section>
<script>
    document.getElementById('rugRepairForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let isValid = true;
        const requiredFields = ['first_name', 'last_name', 'email', 'phone_number', 'address_line_1', 'city', 'state', 'zip_code', 'preferred_date', 'preferred_time', 'rug_condition'];
        const radioFields = ['rug_type'];
        const fileField = 'rug_image';

        requiredFields.forEach(function(field) {
            const element = document.getElementById(field);
            if (!element.value) {
                isValid = false;
                element.style.borderColor = 'red';
            } else {
                element.style.borderColor = '';
            }
        });

        radioFields.forEach(function(field) {
            const elements = document.getElementsByName(field);
            let isChecked = false;
            for (let i = 0; i < elements.length; i++) {
                if (elements[i].checked) {
                    isChecked = true;
                    break;
                }
            }
            if (!isChecked) {
                isValid = false;
                elements[0].parentNode.style.borderColor = 'red';
            } else {
                elements[0].parentNode.style.borderColor = '';
            }
        });

        if (isValid) {
            this.submit();
        } else {
            const alertBox = document.createElement('div');
            alertBox.className = 'alert alert-danger';
            alertBox.innerText = 'Please fill in all required fields.';
            const form = document.getElementById('rugRepairForm');
            form.insertBefore(alertBox, form.firstChild);
            window.scrollTo(0, form.offsetTop);
        }
    });
    $(document).ready(function() {
        $('#phone_number').on('keypress', function(event) {
            var charCode = (event.which) ? event.which : event.keyCode;
            if (charCode < 48 || charCode > 57) {
                event.preventDefault();
            }
        });
    });

    $('#preferred_date, #alternate_date').on('keydown', function(event) {
        event.preventDefault();
    });

    $('#preferred_date, #alternate_date').on('blur', function() {
        var inputDate = new Date($(this).val());
        var today = new Date();
        today.setHours(0, 0, 0, 0);

        if (inputDate < today) {
            $(this).after('<div class="date-error" style="color: red; margin-top: 5px;">The date cannot be in the past.</div>');
            setTimeout(function() {
                $('.date-error').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 3000);
            $(this).val('');
        }
    });
    $('#preferred_time, #alternate_time').on('blur', function() {
        var timePattern = /^([01]\d|2[0-3]):([0-5]\d)$/;
        var timeValue = $(this).val();

        if (!timePattern.test(timeValue)) {
            $(this).after('<div class="time-error" style="color: red; margin-top: 5px;">Please enter a valid time in HH:MM format.</div>');
            setTimeout(function() {
                $('.time-error').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 3000);
            $(this).val('');
        }
    });
    // $('#rug_image').on('change', function() {
    // 	var file = $(this)[0].files[0];
    // 	var fileType = file['type'];
    // 	var validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];

    // 	if ($.inArray(fileType, validImageTypes) < 0) {
    // 		$(this).after('<div class="image-error" style="color: red; margin-top: 5px;">Please upload a valid image file.</div>');
    // 		setTimeout(function() {
    // 			$('.image-error').fadeOut('slow', function() {
    // 				$(this).remove();
    // 			});
    // 		}, 3000);
    // 		$(this).val('');
    // 	}
    // });
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function() {
        $('#preferred_date, #alternate_date').datepicker({
            format: 'yyyy-mm-dd',
            startDate: new Date(),
            autoclose: true,
            todayHighlight: true,
            templates: {
                leftArrow: '&laquo;',
                rightArrow: '&raquo;'
            },
            beforeShowDay: function(date) {
                var day = date.getDay();
                return [(day != 0 && day != 6), ''];
            },
            clearBtn: true,
            orientation: "bottom auto"
        });
    });
</script>