<?php

use Cake\Routing\Router; ?>
<section class="content-header">
	<h1>
		CMS Pages
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Router::url('/', true); ?>js/users"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Edit Page</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Page</h3>
				</div><!-- /.box-header -->
				<?= $this->Form->create($data, ['type' => 'file']) ?>
				<div class="box-body">
					<div class="form-group">
						<label for="Name">Page Title</label>
						<?= $this->Form->control('title', ['placeholder' => 'Page Title', 'label' => false, 'class' => 'form-control']); ?>
					</div>
					<div class="form-group">
						<label for="Last Name">Meta Title</label>
						<?= $this->Form->control('meta_title', ['placeholder' => 'Meta Title', 'label' => false, 'class' => 'form-control']); ?>
					</div>
					<div class="form-group">
						<label for="Email">Meta Key</label>
						<?= $this->Form->control('meta_key', ['placeholder' => 'Meta Key', 'label' => false, 'class' => 'form-control']); ?>
					</div>
					<div class="form-group">
						<label for="Password">Meta Description</label>
						<?= $this->Form->control('meta_descritption', ['placeholder' => 'Meta Description', 'label' => false, 'class' => 'form-control']); ?>
					</div>

					<div class="form-group">
						<label for="Password">Content</label>
						<?= $this->Form->control('content', ['placeholder' => 'Content', 'label' => false, 'class' => 'form-control ckeditor']); ?>
					</div>

					<div class="form-group">
						<label for="Password">Status</label>
						<?php $options = array(Active => "Active", Inactive => "Inactive"); ?>
						<?= $this->Form->control('status', ['options' => $options, 'label' => false, 'class' => 'form-control', 'empty' => 'Select Status']); ?>
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
<?php echo $this->Html->script('ckeditor/ckeditor.js?ver=0.12'); ?>
<script>
	CKEDITOR.replace('content', {
		height: 300,
		filebrowserBrowseUrl: "<?= $this->Url->build('/js/ckfinder/ckfinder.html'); ?>",
		filebrowserImageBrowseUrl: "<?= $this->Url->build('/js/ckfinder/ckfinder.html?type=Images'); ?>",
		allowedContent: true, // Allow <p>, <span> with any attributes, and <a> with href and title
		extraAllowedContent: 'span(style);', // Allow inline style attribute in <span>
		disallowedContent: '' // Ensure nothing is explicitly disallowed

	});
</script>