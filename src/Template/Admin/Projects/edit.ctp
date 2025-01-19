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
		Manage Projects
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Router::url('/', true); ?>admin/projects/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Edit Project</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Project</h3>
				</div><!-- /.box-header -->
				<?= $this->Form->create($data, ['type' => 'file']) ?>
				<div class="box-body">
					<div class="form-group row">
						<div class="col-xs-5">
							<label for="Name">Label</label>
							<?= $this->Form->control('title', ['placeholder' => 'Label', 'label' => false, 'class' => 'form-control', "value" => $data->label]); ?>
						</div>
						<div class="col-xs-5">
							<label for="normal" class="control-label">Image</span></label>
							<div class="controls">
								<?php
								if (!empty($data->image_url)) {
									//echo $data->image;
									$original = WWW_ROOT . '/uploads/projects' . DS . $data->image_url;

									if (file_exists($original)) { ?>
										<?php
										echo $this->Html->image('/uploads/projects/' . $data->image_url, array('width' => '100px', 'class' => 'img-responsive imgbdr remove_image', 'data' => $data->id, 'atrValue' => 'image_url'));
										echo $this->Html->link('Remove', 'javascript:;', array('data' => $data->id, 'class' => 'remove_image', 'atrValue' => 'image_url'));
										?>
								<?php
									} else {
										echo $this->Form->control('image', ['type' => 'file', 'label' => false, 'required' => true]);
									}
								} else {
									echo $this->Form->control('image', array("type" => "file", 'label' => false, 'required' => true, 'id' => 'carImage'));
								}
								?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-5">
								<label for="Password">Status</label>
								<?php $options = array("active" => "Active", "inactive" => "Inactive"); ?>
								<?= $this->Form->control('status', ['options' => $options, 'label' => false, 'class' => 'form-control', 'empty' => 'Select Status']); ?>
							</div>
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
				url: '<?php echo Router::url(['controller' => 'Projects', 'action' => 'deleteImg']); ?>',
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