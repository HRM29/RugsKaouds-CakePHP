<?php
	use Cake\Core\Configure;
	use Cake\Routing\Router;
?>
<style>
	.checkbox{margin-top:5px !important;}
	.select_checkbox,.status_checkbox{margin:0px !important;}
</style>
<section class="content-header">
	<h1>Designs </h1>
 
	<?php echo $this->Flash->render('positive'); ?>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Search Designs</h3>
				</div>
				<?php echo $this->Form->create($result,array('class' =>'form-horizontal form-label-left', 'id'=>'demo-form2', 'inputDefaults' => array('label' => false, 'div' => false, 'novalidate' => true))); ?>
					<div class="box-body">
						<div class="col-sm-3">
							<label for="name">Design Name</label> 
							<?= $this->Form->control('title', ['placeholder'=>'Design Name','label'=>false,'class'=>'form-control','value'=>isset($savesearch['title']) ? $savesearch['title'] : '','required' => false]); ?>
						</div>
						<div class="col-sm-3">
							<label for="status">Status</label>
							<?php  
								$status	=	Configure::read('status');
								echo $this->Form->control('status', ['options' => $status,'label'=>false,'class'=>'form-control','value'=>isset($savesearch['status']) ? $savesearch['status'] : '','empty'=>'Select Status','required' => false]);
							?>
						</div>
						<div class="col-sm-3">
							<label for="button">&nbsp;</label><br>
							<button type="submit" class="btn btn-primary">Search</button>&nbsp;
							<a href="<?php echo Router::url('/', true).'/admin/designs/clearSearch';?>" class="btn btn-primary clear">Clear</a>
						</div> 
					</div><!-- /.box-body --> 
				<?php echo $this->Form->end()?>    
			</div>
		</div>
		<div class="col-xs-12"> 
			<div class="box">
				<div class="box-header">
				  <h3 class="box-title">Design List</h3>
				  <div class="box-tools">
						<?php 
							echo $this->Html->link('<i class="fa fa-plus"></i> Add Design', array('controller' => 'designs','action'=>'add'), array('escape' => false,'class'=>"btn btn-success btn-sm","title"=>__("Add Design",true)));
						?>
						<?php 
							echo $this->Html->link('<i class="fa fa-trash"></i> Delete All', 'javascript::void()', array('escape' => false,'class'=>"btn btn-danger btn-sm btnDeleteAll","title"=>__("Delete Design",true),'confirm' => 'Are you sure you want to delete the selected designs?'));
						?>
					</div>
				</div><!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<?php echo $this->Form->create('',['url'=>['action'=>'deleteAll'],'id'=>'listForm']); ?>
					<table class="table table-hover"> 
						<tr>
							<th>
								<?php echo $this->Form->control('select_checkbox',array('type'=>"checkbox","label"=>false,'div'=>false,'class'=>"select_checkbox tableflat", "id"=>"select_chkbx")); ?>
							</th>
							<th><?php echo $this->Paginator->sort('id'); ?></th>
							<th><?php echo $this->Paginator->sort('Design Name'); ?></th> 
							<th><?php echo $this->Paginator->sort('Status'); ?></th>
							<th><?php echo $this->Paginator->sort('Created'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
						<?php
						if(!empty($result)) {
							$i = 0;
							foreach($result as $record) { $i++;?>
								<tr>
									<td class="a-center">
										<?php echo $this->Form->control('user_chk.',array('type'=>"checkbox","label"=>false,'div'=>false,'class'=>"status_checkbox tableflat",'value'=>$record->id)) ; ?>
									</td>
									<td><?php echo $i; ?></td>
									<td><?php echo ucfirst($record->title); ?></td> 
									<td><?php echo $this->General->getAdminStatus($record->status); ?></td>
									<td><?php echo h($record->created); ?></td>
									<td class="actions">
										<?php
											echo $this->Html->link('<i class="fa fa-eye"></i> View', array('controller' => 'designs','action'=>'view', $record->id), array('escape' => false,'class'=>"btn btn-primary btn-xs","title"=>__("View",true)));
										?>
										<?php 
											echo $this->Html->link('<i class="fa fa-pencil"></i> Edit', array('controller' => 'designs','action'=>'edit', $record->id), array('escape' => false,'class'=>"btn btn-info btn-xs","title"=>__("Edit",true)));
										?>
										<?php
											echo $this->Html->link('<i class="fa fa-trash"></i> Delete', array('controller' => 'designs','action'=>'delete', $record->id), array('escape' => false,'class'=>"btn btn-danger btn-xs","title"=>__("Delete",true),'confirm' => __('Are you sure you want to delete # {0}?', $record->id)));
										?> 
									</td> 
								</tr>
								<?php
							}
						} else { ?>
							<tr>
								<td colspan="8" class="text-center">No Record Found</td>
							</tr>
						<?php } ?> 
					</table>
					<?php echo $this->Form->end(); ?>    
				</div><!-- /.box-body -->
				<?php echo $this->element('admin_paginate'); ?>
			</div><!-- /.box -->
		</div>
	</div>
</section><!-- /.content --> 
<script>
	$(".btnDeleteAll").click(function(e){
		e.preventDefault();
		var favorite	=	[];
		$.each($("input[name='user_chk[]']:checked"), function() {
			favorite.push($(this).val());
		});
		var csrfToken = $("[name='_csrfToken']").val();
		if(favorite.length > 0){
			$.ajax({
				url :	'<?php echo $this->Url->build(['action'=>'deleteAll']); ?>',
				type:	'POST',
				data:	{user_chk : favorite,_csrfToken : csrfToken},
				success : function(data) {
					$('.ajaxdata').show();
				    location.reload(1);
				}
			})
		} else {
			alert("Please Select atleast one group result");
		}
	});
	$("#select_chkbx").change(function () {
		$("input:checkbox").prop('checked', $(this).prop("checked"));
	});
</script>