<?php

use Cake\Core\Configure; ?>
<?php

use Cake\Routing\Router; ?>
<section class="content-header">
	<h1>
		Manage Product Reviews
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Product Reviews List</li>
	</ol>
	<?= $this->Flash->render('positive') ?>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Search Product Reviews</h3>
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
						<label for="Fund">Description</label>
						<?= $this->Form->control('review_description', ['placeholder' => 'Review Description', 'label' => false, 'class' => 'form-control', 'value' => isset($savesearch['description']) ? $savesearch['description'] : '', 'required' => false]); ?>
					</div>
					<div class="col-sm-3">
						<label for="status">Status</label>
						<?php $status = array("approved" => "Approved", "rejected" => "Rejected", "pending" => "Pending"); ?>
						<?php
						echo $this->Form->control('status_id', ['options' => $status, 'label' => false, 'class' => 'form-control', 'value' => isset($savesearch['status_id']) ? $savesearch['status_id'] : '', 'empty' => 'Select Status']);
						?>
					</div>
					<div class="col-sm-3">
						<label for="status">Rating</label>
						<?php
						$rating = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);
						echo $this->Form->control('rating', ['options' => $rating, 'label' => false, 'class' => 'form-control', 'value' => isset($savesearch['rating_val']) ? $savesearch['rating_val'] : '', 'empty' => 'All', "required" => false]);
						?>
					</div>
					<div class="col-sm-3">
						<label for="button">&nbsp;</label><br>
						<button type="submit" class="btn btn-primary">Search</button>&nbsp;
						<a href="<?= Router::url('/', true) . '/admin/ProductReview/clearSearch'; ?>" class="btn btn-primary clear">Clear</a>
					</div>
				</div><!-- /.box-body -->
				<?php echo $this->Form->end() ?>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Reviews List</h3>
					<div class="box-tools">
						<?php
						echo $this->Html->link(
							'<i class="fa fa-plus"></i> Add Product Review',
							array('controller' => 'ProductReview', 'action' => 'add'),
							array('escape' => false, 'class' => "btn btn-success btn-sm", "title" => __("Add Product Review", true))
						);
						?>
						<?php
						/* echo $this->Html->link('<i class="fa fa-trash"></i> Delete All',
					'#',
					array('escape' => false,'class'=>"btn btn-danger btn-sm btnDeleteAll","title"=>__("Delete Page",true))
					); */
						?>
						<?php /* echo $this->Html->link('<i class="fa fa-reply"></i> Back',
					array('controller' => 'users','action'=>'index'),
					array('escape' => false,'class'=>"btn btn-info btn-sm","title"=>__("Back",true))
					); */
						?>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<?php echo $this->Form->create('', ['url' => ['action' => 'deleteAllCompany'], 'id' => 'listForm']); ?>
					<?php echo $this->Form->end() ?>
					<table class="table table-hover">
						<tr>
							<th>
								<label><input type="checkbox" id="select_chkbx"></label>
							</th>
							<th><?= $this->Paginator->sort('S.No') ?></th>
							<th><?= $this->Paginator->sort('Description') ?></th>
							<th><?= $this->Paginator->sort('Rating') ?></th>
							<th><?= $this->Paginator->sort('status') ?></th>
							<th><?= $this->Paginator->sort('created') ?></th>
							<th class="actions"><?= __('Actions') ?></th>
						</tr>
						<?php foreach ($data as $key => $val): ?>
							<tr>
								<td class="a-center">
									<label><input name="comp_chk" type="checkbox" class="status_checkbox tableflat" id="select_chkbx" value="<?php echo $val->id; ?>"></label>
								</td>
								<td><?= $this->Number->format(++$key) ?></td>
								<td title="<?= h($val->review_text); ?>"><?= $this->General->limitText(h($val->review_text), 75) ?></td>
								<td><?= $this->Number->format($val->rating) ?></td>
								<td><?= $this->General->getAdminStatus($val->status) ?></td>
								<td><?= h($val->created_at) ?></td>
								<td class="actions">
									<?php
									echo $this->Html->link(
										'<i class="fa fa-eye"></i> View',
										array('controller' => 'ProductReview', 'action' => 'view', base64_encode($val->id)),
										array('escape' => false, 'class' => "btn btn-primary btn-sm", "title" => __("View", true))
									);
									?>
									<?php
									echo $this->Html->link(
										'<i class="fa fa-pencil"></i> Edit',
										array('controller' => 'ProductReview', 'action' => 'edit', base64_encode($val->id)),
										array('escape' => false, 'class' => "btn btn-info btn-sm", "title" => __("Edit", true))
									);
									?>
									<?php
									echo $this->Html->link(
										'<i class="fa fa-trash"></i> Delete',
										array('controller' => 'ProductReview', 'action' => 'delete', base64_encode($val->id)),
										array('escape' => false, 'class' => "btn btn-danger btn-sm", "title" => __("Delete", true), 'confirm' => __('Are you sure you want to delete ?', $val->id))
									);
									?>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
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
			</div>
		</div>
	</div>
</section>

<script>
	$(".clear").click(function() {
		$('#title').val('');

	});
	$(".btnDeleteAll").click(function() {
		var favorite = [];
		$.each($("input[name='comp_chk']:checked"), function() {
			favorite.push($(this).val());
		});
		if (favorite.length < 1) {
			alert("Please Select Atleast One Cmspage");
		} else {
			if (confirm('Are you sure you want to delete the selected pages?')) {
				if (favorite.length > 0) {

					var url = '<?php echo Router::url('/', true) . 'admin/companies/deleteAllCompany'; ?>';
					var newRow = JSON.stringify(favorite);
					var csrfToken = $("[name='_csrfToken']").val();
					$.ajax({
						type: 'POST',
						//dataType: 'json',
						data: {
							ID: newRow,
							_csrfToken: csrfToken
						},
						url: url,
						success: function(data) {
							window.location.href = window.location.protocol + "//" + window.location.host + window.location.pathname;
						}
					});
				}
			}
		}
	});
	$("#select_chkbx").change(function() {
		$("input:checkbox").prop('checked', $(this).prop("checked"));
	});
</script>