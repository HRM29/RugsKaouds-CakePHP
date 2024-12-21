<?php use Cake\Core\Configure;?>
<?php use Cake\Routing\Router;?> 
<style>
.checkbox{margin-top:5px !important;}
.select_checkbox,.status_checkbox{margin:0px !important;}
</style>
<section class="content-header">
  <h1>
	<?= __('Contact Query') ?> 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users/dashoard"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active"><?= __('Contact Query List') ?></li>
  </ol>
  <?= $this->Flash->render('positive') ?>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12"> 
		  <div class="box">
			<div class="box-header">
			  	<h3 class="box-title">Contact Query List</h3>
			  	<div class="box-tools">
					
                     
					<?php 
					echo $this->Html->link('<i class="fa fa-trash"></i> Delete All',
					array('controller' => 'contactquery','action'=>'deleteAll'),
					array('escape' => false,'class'=>"btn btn-danger btn-sm btnDeleteAll","title"=>__("Delete Record",true),'confirm' => 'Are you sure you want to delete the selected Record?')
					);
					?> 
                    		  
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
			 <?php echo $this->Form->create('',['url'=>['action'=>'deleteAll'],'id'=>'listForm']); ?>
			  <table class="table table-hover"> 
				<tr>
					<th>
						<?php echo $this->Form->control('select_checkbox',array('type'=>"checkbox","label"=>false,'div'=>false,'class'=>"select_checkbox tableflat", "id"=>"select_chkbx")) ; ?>
					</th>
				
					<th>Name</th>
					<th>Email</th>
					<th>Query</th>
					<th class="actions"><?= __('Actions') ?></th>
				</tr>
				<?php foreach ($contactquerys as $contactquery): ?>
				<tr>
					<td class="a-center ">
						<?php echo $this->Form->control('user_chk.', array('type'=>"checkbox", "label"=>false, 'div'=>false, 'class'=>"status_checkbox tableflat", 'value'=>$contactquery->id)) ; ?>
					</td>
					
					<td><?= h($contactquery->name) ?></td>
					<td><?= h($contactquery->email) . "<br>" . h($contactquery->created)  ?></td>
					<td><?= substr(h($contactquery->message), 0, 100) ?></td>
					<td class="actions">

						<?php 
							echo $this->Html->link('<i class="fa fa-eye"></i> View',
								array('controller' => 'ContactUs', 'action'=>'view', $contactquery->id),
								array('escape' => false, 'class'=>"btn btn-primary btn-sm", "title"=>__("Delete", true)));
						?> 
						<?php 
							echo $this->Html->link('<i class="fa fa-trash"></i> Delete',
								array('controller' => 'ContactUs', 'action'=>'delete', $contactquery->id),
								array('escape' => false, 'class'=>"btn btn-danger btn-sm", "title"=>__("Delete", true),'confirm' => __('Are you sure you want to delete # {0}?', $contactquery->id)));
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
		$.each($("input[name='user_chk[]']:checked"), function(){            
			favorite.push($(this).val());
		}); 
		if(favorite.length > 0){
			$('#listForm').submit();
		}
		else{
			 alert("Please Select atleast one group result");
		} 
	});
	$("#select_chkbx").change(function () {
	      $("input:checkbox").prop('checked', $(this).prop("checked"));
	});
</script>

