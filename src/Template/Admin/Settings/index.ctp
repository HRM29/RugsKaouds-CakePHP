<?php

use Cake\Routing\Router;
use Cake\Core\Configure;
?>
<section class="content-header">
	<h1>
		<?= __('Settings') ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"><?= __('Settings') ?></li>
	</ol>
	<?= $this->Flash->render('positive') ?>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?= __('Settings') ?></h3>
				</div><!-- /.box-header -->
				<h4 class="updatemsg"></h4>
				<?= $this->Form->create('') ?>
				<div class="box-body">
					<?php
					foreach ($data->toArray() as $settingdata) {
						$clickfunction = '';
						$type = $settingdata->type;
						if ($type == "number") {
							$clickfunction = 'onkeypress="return isNumberKey(event)"';
							$type = 'text';
						}

						if ($type == "email") {
							$clickfunction = 'onchange="return emailsonly(event)"';
							$type = 'email';
						}

						$options = '';
						if ($settingdata->slug == "PaypalAccountMode") {
							$options = array(Configure::read("Paypal.mode.sandbox") => __("sandbox", true), Configure::read("Paypal.mode.live") => __("live", true));
						}
					?>
						<div class="input-group">
							<label for="<?php echo $settingdata->slug; ?>"><?php echo $settingdata->title; ?></label>

							<?php if ($options != '') { ?>
								<?= $this->Form->control($settingdata->slug, [
									'type' => $type,
									'label' => false,
									'class' => "form-control $settingdata->slug",
									'maxlength' => $settingdata->maxlength,
									'value' => $settingdata->value,
									'id' => $settingdata->slug,
									'options' => $options,
									'type' => 'select',
									'templates' => [
										'inputContainer' => '{{content}}'
									],
								]); ?>

							<?php } else { ?>
								<?= $this->Form->control($settingdata->slug, [
									'type' => $type,
									'label' => false,
									'class' => "form-control $settingdata->slug",
									'maxlength' => $settingdata->maxlength,
									'value' => $settingdata->value,
									'id' => $settingdata->slug,
									'templates' => [
										'inputContainer' => '{{content}}'
									],
								]); ?>
							<?php } ?>
							<span class="input-group-btn">
								<button attr-key="<?php echo $type; ?>" attr-data="<?php echo $settingdata->slug; ?>" attr-id="<?php echo $settingdata->id; ?>" class="btn btn-success updateconfig" type="button">Update</button>
							</span>
						</div>
					<?php
					}
					?>
				</div><!-- /.box-body -->
				<?= $this->Form->end() ?>
			</div><!-- /.box -->
		</div> <!-- /.row -->
	</div> <!-- /.row -->
</section><!-- /.content -->

<style>
	.imgloader {
		display: none;
	}

	.updatemsg {
		color: green;
	}

	.input-group-addon,
	.input-group-btn {
		width: 1%;
		white-space: nowrap;
		vertical-align: bottom;
	}
</style>

<script>
	$(function() {
		$('.updateconfig').click(function() {
			var atrdata = $(this).attr('attr-data');
			var inputval = $('.' + atrdata).val();
			if (inputval != "") {
				$(this).next('.imgloader').show();
				var id = $(this).attr('attr-id');
				var type = $(this).attr('attr-key');
				//var valthis = $(this).closest('div').find('.input').val();

				var valthis = $('.' + atrdata).val();

				if (type == 'email') {
					if (emailsonly(valthis)) {
						update(id, inputval);
						$(this).closest('div').find('.input').css('border-color', '');
					} else {
						$('.imgloader').hide();
						$(this).closest('div').find('.input').focus();
						$(this).closest('div').find('.input').css('border-color', 'red');
						alert('Please enter valid email');
						return false;
					}
				} else {
					update(id, inputval);
				}


			} else {
				$('.' + atrdata).css('border-color', 'red');
			}


		});
	});

	function update(id, inputval) {
		var url = '<?php echo Router::url('/', true) . 'admin/settings/update'; ?>';
		var url = '<?php echo Router::url(['controller' => 'Settings', 'action' => 'update']); ?>';
		var csrfToken = $("[name='_csrfToken']").val();
		$.ajax({
			headers: {
				'X-CSRF-Token': csrfToken
			},
			type: 'POST',
			data: {
				_csrfToken: csrfToken,
				id: id,
				inputval: inputval
			},
			url: url,
			success: function(data) {
				$('.imgloader').hide();
				$('.updatemsg').addClass('message alert alert-success');
				$('.updatemsg').html(data);
				$('.updatemsg').show();

				setTimeout(function() {
					$('.updatemsg').hide();
				}, 3000);
				//location.reload(1);
			}

		});

	}

	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : evt.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;

		return true;
	}

	/* function numbersonly(e){
	            var unicode=e.charCode? e.charCode : e.keyCode
	            if (unicode!=8){ 
	                    if (unicode<48||unicode>57)
	                    return false 
	            }
	    } */
	function emailsonly(email) {
		var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);

		return pattern.test(email);
	}
</script>