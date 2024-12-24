<?php

use Cake\Routing\Router; ?>
<section class="content-header">
	<h1>
		Manage Product Reviews
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Router::url('/', true); ?>admin/ProductReview"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Add Product Review</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Add Product Review</h3>
				</div><!-- /.box-header -->
				<?= $this->Form->create($data, ['type' => 'file']) ?>
				<div class="box-body">
					<div class="form-group row">
						<div class="col-xs-5">
							<label class="control-label info-details">Reviewer Image </label>
							<div class="">
								<?php echo $this->Form->control('image', array("type" => "file", 'label' => false, 'required' => false, 'id' => 'carImage')); ?></br>
							</div>
						</div>
						<div class="col-xs-5">
							<label for="Name">Description</label>
							<?= $this->Form->control('description', ['placeholder' => 'Description', 'label' => false, 'class' => 'form-control', "type" => "textarea", 'required' => true]); ?>
						</div>
					</div>
					<div class="form-group row">

						<div class="col-xs-5">
							<label for="Name">Rating</label>
							<?php $options = array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5"); ?>
							<?= $this->Form->control('review-rating', ['options' => $options, 'label' => false, 'class' => 'form-control']); ?>
						</div>
						<div class="col-xs-5">
							<label for="Password">Status</label>
							<?php $options = array("approved" => "Approved", "rejected" => "Rejected", "pending" => "Pending"); ?>
							<?= $this->Form->control('status', ['options' => $options, 'label' => false, 'class' => 'form-control', 'empty' => 'Select Status']); ?>
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