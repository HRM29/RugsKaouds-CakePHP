<?php

use Cake\Routing\Router; ?>

<?php //echo $this->Html->css(array('../plugins/timepicker/css/bootstrap-timepicker.min.css')) 
?>
<script>
	/* $(".timepicker").timepicker({
          showInputs: false
    });  */
</script>

<section class="content-header">
	<h1>
		Manage Banners
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Router::url('/', true); ?>admin/AdditionalCharges"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Edit Banner</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Banner</h3>
				</div><!-- /.box-header -->
				<?= $this->Form->create($data, ['type' => 'file']) ?>
				<div class="box-body">
					<div class="form-group row">
						<div class="col-xs-5">
							<label for="Name">Title</label>
							<?= $this->Form->control('title', ['placeholder' => 'Title', 'label' => false, 'class' => 'form-control']); ?>
						</div>
						<div class="col-xs-5">
							<label for="normal" class="control-label">Image</span></label>
							<div class="controls">
								<?php
								if (!empty($data->image)) {
									//echo $data->image;
									$original = WWW_ROOT . '/uploads/banner' . DS . $data->image;

									if (file_exists($original)) { ?>
										<?php
										echo $this->Html->image('/uploads/banner/' . $data->image, array('width' => '100px', 'class' => 'img-responsive imgbdr remove_image', 'data' => $data->id, 'atrValue' => 'image'));
										echo $this->Html->link('Remove', 'javascript:;', array('data' => $data->id, 'class' => 'remove_image', 'atrValue' => 'image'));
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
					</div>
					<div class="form-group">
						<div class="row" style="margin-bottom: 15px;">
							<div class="col-xs-5">
								<label for="Name">Link</label>
								<?= $this->Form->control('banner-link', ['placeholder' => 'Link', 'label' => false, 'class' => 'form-control', 'value' => $data->link, "required" => false]); ?>
							</div>
							<div class="col-xs-5">
								<label for="Name">Link Name</label>
								<?= $this->Form->control('banner-link-name', ['placeholder' => 'Link Name', 'label' => false, 'class' => 'form-control', 'value' => $data->link_name, "required" => false]); ?>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-5">
								<label for="Password">Block Type</label>
								<?php $options = array("1" => "Block 1", "2" => "Block 2", "3" => "Block 3", "4" => "Block 4", "5" => "Block 5"); ?>
								<?= $this->Form->control('block_type', ['options' => $options, 'label' => false, 'class' => 'form-control', 'value' => $data->block_type]); ?>
							</div>
							<div class="col-xs-5">
								<label for="Password">Status</label>
								<?php $options = array(Active => "Active", Inactive => "Inactive"); ?>
								<?= $this->Form->control('status', ['options' => $options, 'label' => false, 'class' => 'form-control', 'empty' => 'Select Status']); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="Name">Description</label>
						<?= $this->Form->control('description', ['placeholder' => 'Description', 'label' => false, 'class' => 'form-control ckeditor', 'max-length' => '255']); ?>
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
		if (confirm('Are you sure Remove Banner Image?')) {
			$.ajax({
				headers: {
					'X-CSRF-Token': csrfToken
				},
				url: '<?php echo Router::url(['controller' => 'Banners', 'action' => 'deleteImg']); ?>',
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