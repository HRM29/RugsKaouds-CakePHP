<?php

use Cake\Routing\Router; ?>
<section class="content-header">
	<h1>
		Manage Media Upload
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Router::url('/', true); ?>admin/Banners"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Add Media</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Add Media</h3>
				</div><!-- /.box-header -->
				<?php if (!empty($mediaUrl)): ?>
					<div class="alert alert-success mt-3">
						File uploaded successfully! <br>
						<a href="<?= $mediaUrl ?>" target="_blank"><?= $mediaUrl ?></a>
					</div>
				<?php endif; ?>
				<?= $this->Form->create(null, ['type' => 'file']) ?>
				<div class="box-body">
					<div class="form-group row">
						<div class="col-xs-5">
							<label class="control-label info-details"> Media </label>
							<div class="">
								<?php echo $this->Form->control('media-file', array("type" => "file", 'label' => false, 'required' => true, 'id' => 'carImage', 'multiple' => false)); ?></br>
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
<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<script type="text/javascript">
	function clear_form_elements(jquery_obj) {

		jquery_obj.find(':input').each(function() {

			//$(this).timepicker();
			$(this).timepicker({
				showInputs: false
			});

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
</script>