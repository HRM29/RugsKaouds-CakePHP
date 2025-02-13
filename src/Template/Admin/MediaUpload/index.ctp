<?php

use Cake\Core\Configure; ?>
<?php

use Cake\Routing\Router; ?>
<section class="content-header">
	<h1>
		Manage Media Upload
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Media List</li>
	</ol>
	<?= $this->Flash->render('positive') ?>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Search Media</h3>
				</div>
				<?php echo $this->Form->create($data, array(
					'class' => 'form-horizontal form-label-left',
					'id' => 'demo-form2',
					'inputDefaults' => array(
						'label' => false,
						'div' => false,
						'novalidate' => true
					)
				));
				?>
				<div class="box-body">
					<div class="col-sm-3">
						<label for="Fund">Media Title</label>
						<?= $this->Form->control('title', ['placeholder' => 'Media Title', 'label' => false, 'class' => 'form-control', 'value' => isset($fileNameFilter) ? $fileNameFilter : '', 'required' => false]); ?>
					</div>
					<div class="col-sm-3">
						<label for="status">Media Type</label>
						<?php
						$status = ['jpg' => "JPG", 'jpeg' => "JPEG", 'png' => "PNG", 'gif' => "GIF", 'pdf' => "PDF"];
						echo $this->Form->control('media_type', ['options' => $status, 'label' => false, 'class' => 'form-control', 'value' => isset($filter) ? $filter : '', 'empty' => 'Select Media Type']);
						?>
					</div>
					<div class="col-sm-3">
						<label for="button">&nbsp;</label><br>
						<button type="submit" class="btn btn-primary">Search</button>&nbsp;
						<a href="<?= Router::url('/', true) . '/admin/MediaUpload/clearSearch'; ?>" class="btn btn-primary clear">Clear</a>
					</div>
				</div><!-- /.box-body -->
				<?php echo $this->Form->end() ?>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Media List</h3>
					<div class="box-tools">
						<?php
						echo $this->Html->link(
							'<i class="fa fa-plus"></i> Upload Media',
							array('controller' => 'MediaUpload', 'action' => 'add'),
							array('escape' => false, 'class' => "btn btn-success btn-sm", "title" => __("Add Projects", true))
						);
						?>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<?php echo $this->Form->create('', ['url' => ['action' => 'deleteAllCompany'], 'id' => 'listForm']); ?>
					<?php echo $this->Form->end() ?>
					<table class="table table-hover">
						<tr>
							<th>S.No</th>
							<th>Title</th>
							<th>URL</th>
							<th class="actions"><?= __('Actions') ?></th>
						</tr>
						<?php if (!empty($mediaFiles)) : ?>
							<?php $count = 1; ?>
							<?php foreach ($mediaFiles as $file) : ?>
								<tr>
									<td><?= $count++; ?></td>
									<td><?= h($file['name']); ?></td>
									<td><button class="btn btn-info btn-xs copy-url-btn" data-url="<?php echo $file['url']; ?>">Copy URL</button></td>
									<td class="actions">
										<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $file['name']], [
											'confirm' => __('Are you sure you want to delete # {0}?', $file['name']),
											'class' => 'btn btn-xs btn-danger'
										]); ?>
										<?= $this->Html->link('Download', ['action' => 'download', $file['name']], ['class' => 'btn btn-xs btn-primary']); ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="3">No media available.</td>
							</tr>
						<?php endif; ?>
					</table>
				</div><!-- /.box-body -->
			</div>
		</div>
	</div>
</section>

<script>
	$(".clear").click(function() {
		$('#title').val('');

	});
	// When the Copy URL button is clicked
	$('.copy-url-btn').on('click', function() {
		var $btn = $(this); // Reference to the clicked button
		var url = $btn.data('url'); // Get the URL from the data-url attribute

		// Create a temporary input element to copy the URL to clipboard
		var tempInput = $('<input>');
		$('body').append(tempInput);
		tempInput.val(url).select();
		document.execCommand('copy');
		tempInput.remove(); // Remove the temporary input element

		// Change the button text to "Copied!"
		$btn.text('Copied!');

		// Revert the button text back to "Copy URL" after 3 seconds
		setTimeout(function() {
			$btn.text('Copy URL');
		}, 3000); // Revert after 3 seconds
	});
	$("#select_chkbx").change(function() {
		$("input:checkbox").prop('checked', $(this).prop("checked"));
	});
</script>