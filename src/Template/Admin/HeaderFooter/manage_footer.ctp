<?php

use Cake\Routing\Router; ?>
<section class="content-header">
	<h1>
		Manage Footer
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Router::url('/', true); ?>admin/Banners"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Manage Footer</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Manage Footer</h3>
				</div><!-- /.box-header -->
				<?= $this->Flash->render('positive') ?>
				<?= $this->Form->create($footer, ['type' => 'file']) ?>
				<div class="box-body">
					<div class="form-group row">
						<div class="col-xs-5">
							<label for="Name">Heading</label>
							<?= $this->Form->control('heading', ['placeholder' => 'Heading', 'label' => false, 'class' => 'form-control', 'required' => true]); ?>
						</div>
						<div class="col-xs-5">
							<label class="control-label info-details"> Backgound Image </label>
							<div class="">
								<?php
								if (!empty($footer->background_image)) {
									$original = WWW_ROOT . '/uploads/header_footer' . DS . $footer->background_image;

									if (file_exists($original)) { ?>
										<?php
										echo $this->Html->image(Router::url('/', true).'admin/admin-media/admin-view/footer-file/' . $footer->background_image, array('width' => '100px', 'class' => 'img-responsive imgbdr remove_image', 'data' => $footer->id, 'atrValue' => 'background_image'));
										echo $this->Html->link('Remove', 'javascript:;', array('data' => $footer->id, 'class' => 'remove_image', 'atrValue' => 'image'));
										?>
								<?php
									} else {
										echo $this->Form->control('background_image', ['type' => 'file', 'label' => false, 'required' => true, 'id' => 'background_image']);
									}
								} else {
									echo $this->Form->control('background_image', array("type" => "file", 'label' => false, 'required' => true, 'id' => 'background_image'));
								}
								?></br>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="Name">Description</label>
						<?= $this->Form->control('description', ['placeholder' => 'Description', 'label' => false, 'class' => 'form-control ckeditor', "type" => "textarea", 'required' => true]); ?>
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
	$('.remove_image').on('click', function() {
		var id = $(this).attr('data');
		var FieldName = $(this).attr('atrValue');
		var csrfToken = $("[name='_csrfToken']").val();

		var formData = new FormData();
		formData.append('_csrfToken', csrfToken);
		formData.append('id', id);
		formData.append('FieldName', FieldName);
		if (confirm('Are you sure Remove Footer Image?')) {
			$.ajax({
				headers: {
					'X-CSRF-Token': csrfToken
				},
				url: '<?php echo Router::url(['controller' => 'HeaderFooter', 'action' => 'deleteImg']); ?>',
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