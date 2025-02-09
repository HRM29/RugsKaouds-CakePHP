<?php

use Cake\Routing\Router; ?>
<style>
	.checkbox {
		margin-top: 5px !important;
	}

	.select_checkbox,
	.status_checkbox {
		margin: 0px !important;
	}
</style>
<section class="content-header">
	<h1>
		<?= __('Collections') ?>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"><?= __('Collection List') ?></li>
	</ol>
	<?= $this->Flash->render('positive') ?>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Search Category</h3>
				</div>
				<?php echo $this->Form->create($categories, array(
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
						<label for="title">Category/Sub-Category Name</label>
						<?= $this->Form->control('title', ['placeholder' => 'Page/Category Name', 'label' => false, 'class' => 'form-control', 'value' => isset($savesearch['title']) ? $savesearch['title'] : '', 'required' => false]); ?>
					</div>
					<div class="col-sm-3">
						<label for="parent_id">Parent Category</label>
						<?= $this->Form->control('parent_id', ['empty' => 'Select category', 'label' => false, 'class' => 'form-control', 'value' => isset($savesearch['parent_id']) ? $savesearch['parent_id'] : '', 'required' => false, 'options' => $categoryOption]); ?>
					</div>
					<div class="col-sm-3">
						<label for="status">Status</label>
						<?php
						$status = array(Active => "Active", Inactive => "Inactive");
						echo $this->Form->control('status_id', ['options' => $status, 'label' => false, 'class' => 'form-control', 'value' => isset($savesearch['status_id']) ? $savesearch['status_id'] : '', 'empty' => 'Select Status']);
						?>
					</div>
					<div class="col-sm-3">
						<label for="button">&nbsp;</label><br>
						<button type="submit" class="btn btn-primary">Search</button>&nbsp;
						<a href="<?= Router::url('/', true) . '/admin/collections/clearSearch'; ?>" class="btn btn-primary clear">Clear</a>
					</div>
				</div><!-- /.box-body -->
				<?php echo $this->Form->end() ?>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Category List</h3>
					<div class="box-tools">
						<?php
						echo $this->Html->link(
							'<i class="fa fa-plus"></i> Add Collection',
							array('controller' => 'collections', 'action' => 'add'),
							array('escape' => false, 'class' => "btn btn-success btn-sm", "title" => __("Add Collection", true))
						);
						?>

						<?php
						echo $this->Html->link(
							'<i class="fa fa-trash"></i> Delete All',
							array('controller' => 'collections', 'action' => 'deleteAll'),
							array('escape' => false, 'class' => "btn btn-danger btn-sm btnDeleteAll", "title" => __("Delete Collections", true))
						);
						?>
						<?php echo $this->Html->link(
							'<i class="fa fa-reply"></i> Back',
							array('controller' => 'users', 'action' => 'index'),
							array('escape' => false, 'class' => "btn btn-info btn-sm", "title" => __("Back", true))
						);
						?>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<?php echo $this->Form->create('', ['url' => ['action' => 'deleteAll'], 'id' => 'listForm']); ?>
					<table class="table table-hover">
						<tr>
							<th>
								<?php echo $this->Form->control('select_checkbox', array('type' => "checkbox", "label" => false, 'div' => false, 'class' => "select_checkbox tableflat", "id" => "select_chkbx")); ?>
							</th>
							<th><?= $this->Paginator->sort('id', "S.No") ?></th>
							<th><?= $this->Paginator->sort('title', 'Category/Sub-Category Name') ?></th>
							<th><?= $this->Paginator->sort('collection_type') ?></th>
							<th><?= $this->Paginator->sort('parent_id', 'Parent Category') ?></th>
							<th><?= $this->Paginator->sort('status') ?></th>
							<th><?= $this->Paginator->sort('created') ?></th>
							<th class="actions"><?= __('Actions') ?></th>
						</tr>
						<?php foreach ($categories as $key => $category): ?>
							<?php
							$parentData = $this->General->returnCollectionParentData($category->id);
							?>
							<tr>
								<td class="a-center ">
									<?php
									$isDelete = $this->General->returnCollectionChildData($category->id);
									if ($isDelete['delete_parent']) {
									?>
										<?php echo $this->Form->control('user_chk.', array('type' => "checkbox", "label" => false, 'div' => false, 'class' => "status_checkbox tableflat", 'value' => $category->id)); ?>
									<?php
									}
									?>
								</td>

								<td><?= $this->Number->format(++$key) ?></td>
								<td><?= h($category->title) ?></td>
								<td><?= h(ucwords($category->collection_type == 1 ? 'Parent Category' : 'Sub-Category')) ?></td>
								<td><?= $category->parent_id > 0 ? $parentData['Collection2']['title'] : ''; ?></td>
								<td><?= $this->General->getAdminStatus($category->status) ?></td>
								<td><?= h($category->created) ?></td>
								<td class="actions">
									<?php
									echo $this->Html->link(
										'<i class="fa fa-eye"></i> View',
										array('controller' => 'collections', 'action' => 'view', $category->id),
										array('escape' => false, 'class' => "btn btn-primary btn-xs", "title" => __("View", true))
									);
									?>
									<?php
									echo $this->Html->link(
										'<i class="fa fa-pencil"></i> Edit',
										array('controller' => 'collections', 'action' => 'edit', $category->id),
										array('escape' => false, 'class' => "btn btn-info btn-xs", "title" => __("Edit", true))
									);
									?>
									<?php
									if ($isDelete['delete_parent']) {
										echo $this->Html->link(
											'<i class="fa fa-trash"></i> Delete',
											array('controller' => 'collections', 'action' => 'delete', $category->id),
											array('escape' => false, 'class' => "btn btn-danger btn-xs", "title" => __("Delete", true), 'confirm' => __('Are you sure you want to delete ?'))
										);
									}
									?>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
					<?php echo $this->Form->end() ?>
				</div><!-- /.box-body -->

				<div class="box-footer clearfix">
					<div class="col-sm-5">
						<div><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></div>
					</div>
					<div class="col-sm-7">
						<ul class="pagination pagination-sm no-margin pull-right">
							<?= $this->Paginator->first('<< ' . __('First')) ?>
							<?= $this->Paginator->prev('< ' . __('Previous')) ?>
							<?= $this->Paginator->numbers() ?>
							<?= $this->Paginator->next(__('Next') . ' >') ?>
							<?= $this->Paginator->last(__('Last') . ' >>') ?>
						</ul>
					</div>
				</div>
			</div><!-- /.box -->
		</div>
	</div>
</section><!-- /.content -->
<script>
	$(".clear").click(function() {
		$('#title').val('');
	});
	$(".btnDeleteAll").click(function(e) {
		e.preventDefault();
		var favorite = [];
		$.each($("input[name='user_chk[]']:checked"), function() {
			favorite.push($(this).val());
		});
		if (favorite.length < 1) {
			alert("Please Select atleast one group result");
			return false;
		}
		if (confirm('Are you sure you want to delete the selected collections?')) {
			if (favorite.length > 0) {
				$('#listForm').submit();
			}
		}
	});
	$("#select_chkbx").change(function() {
		$("input:checkbox").prop('checked', $(this).prop("checked"));
	});
</script>