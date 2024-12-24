<?php

use Cake\Routing\Router; ?>
<section class="content-header">
	<h1>
		Manage Product Reviews
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Router::url('/', true); ?>admin/AdditionalCharges"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Edit Product Review</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Product Review</h3>
				</div><!-- /.box-header -->

				<?php
				// echo "<pre>data: ";print_r($data);echo "</pre>";
				?>
				<?= $this->Form->create($data, ['type' => 'file']) ?>
				<div class="box-body">
					<div class="form-group row">
						<div class="col-xs-5">
							<label for="normal" class="control-label">Reviewer Image</span></label>
							<div class="controls">
								<?php
								if (!empty($data->reviewer_image)) {
									//echo $data->image;
									$original = WWW_ROOT . '/uploads/reviewers' . DS . $data->reviewer_image;

									if (file_exists($original)) { ?>
										<?php
										echo $this->Html->image('/uploads/reviewers/' . $data->reviewer_image, array('width' => '100px', 'class' => 'img-responsive imgbdr remove_image', 'data' => $data->id, 'atrValue' => 'reviewer_image'));
										echo $this->Html->link('Remove', 'javascript:;', array('data' => $data->id, 'class' => 'remove_image', 'atrValue' => 'reviewer_image'));
										?>
								<?php
									} else {
										echo $this->Form->control('image', ['type' => 'file', 'label' => false]);
									}
								} else {
									echo $this->Form->control('image', array("type" => "file", 'label' => false, 'required' => false, 'id' => 'carImage'));
								}
								?>
							</div>
						</div>
						<div class="col-xs-5">
							<label for="Name">Description</label>
							<?= $this->Form->control('description', ['placeholder' => 'Description', 'label' => false, 'class' => 'form-control', "type" => "textarea", 'required' => true, "value" => $data->review_text]); ?>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-5">
							<label for="Name">Rating</label>
							<?php $options = array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5"); ?>
							<?= $this->Form->control('review-rating', ['options' => $options, 'label' => false, 'class' => 'form-control', "value" => $data->rating]); ?>
						</div>
						<div class="col-xs-5">
							<label for="Password">Status</label>
							<?php $options = array("approved" => "Approved", "rejected" => "Rejected", "pending" => "Pending"); ?>
							<?= $this->Form->control('status', ['options' => $options, 'label' => false, 'class' => 'form-control', 'empty' => 'Select Status', 'required' => true]); ?>
						</div>
					</div>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
				</div>
				<?= $this->Form->end() ?>
			</div><!-- /.box -->
		</div> <!-- /.row -->
	</div> <!-- /.row -->
</section><!-- /.content -->
<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<script>
	function clear_form_elements(jquery_obj) {
		jquery_obj.find(':input').each(function() {
			$(this).timepicker({
				showInputs: false
			});
			/* $(this).timepicker({
				  showInputs: false
			});  */
			switch (this.type) {
				case 'password':
				case 'text':
				case 'number':
				case 'textarea':
				case 'file':
					$(this).attr("value", "");
					break;
				case 'select-one':
					$(this).find("option").each(function() {
						$(this).attr("selected", false);
					});
					break;
				case 'checkbox':
				case 'radio':
					this.checked = false;
			}
		});
	}

	$('.remove_image').on('click', function() {
		var id = $(this).attr('data');
		var FieldName = $(this).attr('atrValue');
		var csrfToken = $("[name='_csrfToken']").val();

		var formData = new FormData();
		formData.append('_csrfToken', csrfToken);
		formData.append('id', id);
		formData.append('FieldName', FieldName);
		if (confirm('Are you sure Remove Reviewer Image?')) {
			$.ajax({
				headers: {
					'X-CSRF-Token': csrfToken
				},
				url: '<?php echo Router::url(['controller' => 'ProductReview', 'action' => 'deleteImg']); ?>',
				type: "POST",
				processData: false,
				contentType: false,
				data: formData,
				success: function(data) {
					location.reload();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.error("AJAX Error:", textStatus, errorThrown);
					console.error("Response:", jqXHR.responseText);
				}
			});
		}
	});
</script>