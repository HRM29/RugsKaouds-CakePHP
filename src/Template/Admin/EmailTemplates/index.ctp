<?php use Cake\Routing\Router;?>
<style>
.checkbox{margin-top:5px !important;}
.select_checkbox,.status_checkbox{margin:0px !important;}
</style>
<section class="content-header">
  <h1>
	EmailTemplates 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/EmailTemplates"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">EmailTemplates List</li>
  </ol>
  <?= $this->Flash->render('positive') ?>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Search EmailTemplates</h3>
                </div>
				<?php echo $this->Form->create($EmailTemplate,array(
						'class' =>'form-horizontal form-label-left',
						'id'=>'demo-form2',
						'inputDefaults' => array(
						'label' => false,
						'div' => false,
						'novalidate' => true
					)));
				?> 
				<div class="box-body">
						
					<div class="col-sm-3">
						<label for="title">Name</label> 
						<?= $this->Form->control('name', ['placeholder'=>'Name','label'=>false,'class'=>'form-control','value'=>isset($savesearch['name'])?$savesearch['name']:'','required' => false]);?>
					</div>
                   
					<div class="col-sm-3">
							<label for="Fund">Subject</label>
							<?= $this->Form->control('subject', ['placeholder'=>'subject','label'=>false,'class'=>'form-control','value'=>isset($savesearch['subject'])?$savesearch['subject']:'','required' => false]);?>
					</div> 
 
					<div class="col-sm-3">
						<label for="status">Status</label>
						<?php  
						$status = array(Active => "Active" , Inactive => "Inactive");
						echo $this->Form->control('status_id', ['options' => $status,'label'=>false,'class'=>'form-control','value'=>isset($savesearch['status_id'])?$savesearch['status_id']:'','empty'=>'Select Status']);
						?>
                    </div>
					<div class="col-sm-3">
						<label for="button">&nbsp;</label><br>
						<button type="submit" class="btn btn-primary">Search</button>&nbsp;
						<a href="<?= Router::url('/', true).'/admin/EmailTemplates/clearSearch';?>" class="btn btn-primary clear">Clear</a>
					</div> 
                  </div><!-- /.box-body --> 
					<?php echo $this->Form->end()?>    
			</div>
		</div>
		<div class="col-xs-12"> 
		  <div class="box">
			<div class="box-header">
			  <h3 class="box-title">EmailTemplates List</h3>
			  <div class="box-tools">
					<?php 
					echo $this->Html->link('<i class="fa fa-plus"></i> Add EmailTemplate',
					array('controller' => 'EmailTemplates','action'=>'add'),
					array('escape' => false,'class'=>"btn btn-success btn-sm","title"=>__("Add EmailTemplate",true))
					);
					?>
                     
					<?php 
					echo $this->Html->link('<i class="fa fa-trash"></i> Delete All',
					array('controller' => 'EmailTemplates','action'=>'deleteAllEmailTemplate'),
					array('escape' => false,'class'=>"btn btn-danger btn-sm btnDeleteAll","title"=>__("Delete EmailTemplate",true))
					);  
					?> 
					<?php echo $this->Html->link('<i class="fa fa-reply"></i> Back',
					array('controller' => 'users','action'=>'index'),
					array('escape' => false,'class'=>"btn btn-info btn-sm","title"=>__("Back",true))
					);
					?>			  
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
			  <?php echo $this->Form->create('',['url'=>['action'=>'deleteAllEmailTemplates'],'id'=>'listForm']); ?>
			  <table class="table table-hover"> 
				<tr>
					<th>
						<?php echo $this->Form->control('select_checkbox',array('type'=>"checkbox","label"=>false,'div'=>false,'class'=>"select_checkbox tableflat", "id"=>"select_chkbx")) ; ?>
					</th>
					<th><?= $this->Paginator->sort('id') ?></th> 
					<th><?= $this->Paginator->sort('Name') ?></th>
					<th><?= $this->Paginator->sort('Subject') ?></th>
					<th><?= $this->Paginator->sort('status') ?></th>
					<th><?= $this->Paginator->sort('created') ?></th>
					<th class="actions"><?= __('Actions') ?></th>
				</tr>
				<?php $i=0;foreach ($EmailTemplate as $Data): $i++;?>
		
				<tr>
					<td class="a-center ">
						<?php echo $this->Form->control('project_chk.',array('type'=>"checkbox","label"=>false,'div'=>false,'class'=>"status_checkbox tableflat",'value'=>$Data->id)) ; ?>
					</td>
					
					<td><?= $i ?></td> 
					<td><?= $Data->name ?></td>
					<td><?= $Data->subject ?></td>
					<td><?= $this->General->getStatus($Data->status) ?></td>
					<td><?= $Data->created ?></td> 
					<td class="actions">
						<?php 
							echo $this->Html->link('<i class="fa fa-eye"></i> View',
								array('controller' => 'EmailTemplates','action'=>'view', $Data->id),
								array('escape' => false,'class'=>"btn btn-primary btn-sm","title"=>__("View",true)));
						?>
						<?php 
							echo $this->Html->link('<i class="fa fa-pencil"></i> Edit',
								array('controller' => 'EmailTemplates','action'=>'edit', $Data->id),
								array('escape' => false,'class'=>"btn btn-info btn-sm","title"=>__("Edit",true)));
						?>
						<?php 
							echo $this->Html->link('<i class="fa fa-trash"></i> Delete',
								array('controller' => 'EmailTemplates','action'=>'delete', $Data->id),
								array('escape' => false,'class'=>"btn btn-danger btn-sm","title"=>__("Delete",true),'confirm' => __('Are you sure you want to delete # {0}?', $Data->id)));
						?> 
					</td> 
				</tr>
				<?php endforeach; ?> 
			  </table>
			  <?php echo $this->Form->end()?>    
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
$(".clear").click(function(){
		$('#title').val('');
});
$(".btnDeleteAll").click(function(e){  
		e.preventDefault();
		var favorite = [];
		$.each($("input[name='project_chk[]']:checked"), function(){            
				favorite.push($(this).val());
		}); 
		if(favorite.length < 1){ 
			alert("Please Select atleast one group result");
		}else{
			if(confirm("Are you sure you want to delete the selected projects?")){ 
				if(favorite.length > 0){ 
					$('#listForm').submit();
				} 
			}  
		}
});
$("#select_chkbx").change(function () {
	      $("input:checkbox").prop('checked', $(this).prop("checked"));
});
</script>