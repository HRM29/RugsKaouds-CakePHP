<section class="inner_banner shp">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h1>Sell Us Your Rugs</h1>
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
                <h3></h3>
                <?= $this->Flash->render('positive_forgot') ?>
                <?php
                echo $this->Form->create(null, ['id' => 'rugSellForm', 'url' => ['controller' => 'Pages', 'action' => 'rugsellus'], 'type' => 'file']);
                ?>
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
                    <div class="col-md-12">
                        <div class="type_rug">
                            <h4 class="rg_cndtn"></h4>
                            <div class="form_group">
                                <input type="file" name="rug_image" class="fotm_control" id="rug_image" multiple accept="image/*">
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
    document.getElementById('rugAppraisalForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let isValid = true;
        const requiredFields = ['first_name', 'last_name', 'email', 'phone_number', 'address_line_1', 'city', 'state', 'zip_code'];
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

        const fileElement = document.getElementById(fileField);
        if (fileElement.files.length === 0) {
            isValid = false;
            fileElement.style.borderColor = 'red';
        } else {
            fileElement.style.borderColor = '';
        }

        if (isValid) {
            this.submit();
        } else {
            const alertBox = document.createElement('div');
            alertBox.className = 'alert alert-danger';
            alertBox.innerText = 'Please fill in all required fields.';
            alertBox.setAttribute('onclick', "this.classList.add('hidden')");
            const form = document.getElementById('rugAppraisalForm');
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
    $('#preferred_date, #alternate_date, #appraisal_date').on('keydown', function(event) {
        event.preventDefault();
    });

    $('#preferred_date, #alternate_date, #appraisal_date').on('blur', function() {
        var inputDate = new Date($(this).val());
        var today = new Date();
        today.setHours(0, 0, 0, 0);

        if (inputDate < today) {
            $(this).after('<div class="date-error" style="color: red; margin-top: 5px;" >The date cannot be in the past.</div>');
            setTimeout(function() {
                $('.date-error').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 3000);
            $(this).val('');
        }
    });
    $('#rug_image').on('change', function() {
        var file = $(this)[0].files[0];
        var fileType = file['type'];
        var validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];

        if ($.inArray(fileType, validImageTypes) < 0) {
            $(this).after('<div class="image-error" style="color: red; margin-top: 5px;" onclick="this.classList.add(\'hidden\')">Please upload a valid image file.</div>');
            setTimeout(function() {
                $('.image-error').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 3000);
            $(this).val('');
        }
    });
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function() {
        $('#preferred_date, #alternate_date, #appraisal_date').datepicker({
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