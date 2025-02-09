
<?php use Cake\Core\Configure;?> 
<?php use Cake\Routing\Router;?>
<section class="content-header">
  <h1>
	Orders
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Orders List</li>
  </ol>
  <?= $this->Flash->render('positive') ?>
</section>
<section class="content">
	<div class="row">
	    <div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Search Orders</h3>
                </div>
				<?php echo $this->Form->create($data,array(
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
							<label for="Fund">Customer</label>
							<?php 
								echo $this->Form->control('user_id', array(
												'type'=>'select', 'class' => "form-control selectpicker" ,'required'=>false,'data-show-subtext'=>true,'data-live-search'=>true,'options'=>$customer,'value'=>isset($savesearch['user_id'])?$savesearch['user_id']:'', 'label' => false,'empty'=>__('Select Customer')));
							?>
					</div>
					<div class="col-sm-3">
							<label for="Fund">Order Id #</label>
							<?= $this->Form->control('order_number', ['placeholder'=>'Invoice Number','label'=>false,'class'=>'form-control','value'=>isset($savesearch['order_number'])?$savesearch['order_number']:'','required' => false,"onkeypress"=>"return NumericValidation(event)"]);?>
					</div> 
					<div class="col-sm-3">
						<label for="status">Status</label>
						<?php  
						$status = array("start"=> "Pending" , 1 => "Cancelled" , 2 => "Processing" , 3 => "Completed" , 4 => "Return" , 5 => "Shipped");
						echo $this->Form->control('status_id', ['options' => $status,'label'=>false,'class'=>'form-control','value'=>isset($savesearch['status_id'])?$savesearch['status_id']:'','empty'=>'Select Status']);
						?>
                    </div>
					<div class="col-sm-3">
						<label for="button">&nbsp;</label><br>
						<button type="submit" class="btn btn-primary">Search</button>&nbsp;
						<a href="<?= Router::url('/', true).'/admin/Orders/clearSearch';?>" class="btn btn-primary clear">Clear</a>
					</div> 
                  </div><!-- /.box-body --> 
					<?php echo $this->Form->end()?>    
			</div>
		</div>
		<div class="col-xs-12"> 
		  <div class="box">
			<div class="box-header">
			  <h3 class="box-title">Orders List</h3>
			  <div class="box-tools">
					<?php 
					/*echo $this->Html->link('<i class="fa fa-plus"></i> Add Order',
					array('controller' => 'Orders','action'=>'add'),
					array('escape' => false,'class'=>"btn btn-success btn-sm","title"=>__("Add Order",true))
					);*/
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
				<?php echo $this->Form->create('',['url'=>['action'=>'deleteAllCompany'],'id'=>'listForm']); ?>
				<?php echo $this->Form->end()?>    
				<table class="table table-hover"> 
				<tr>
					<th> 
						<label><input type="checkbox" id="select_chkbx"></label>
					</th>
					<th><?= $this->Paginator->sort('S.No') ?></th>
					<th><?= $this->Paginator->sort('Order #') ?></th>
					<th><?= $this->Paginator->sort('Customer') ?></th>
					<th><?= $this->Paginator->sort('total Quantity') ?></th>
					<th><?= $this->Paginator->sort('Order Amount') ?></th> 
					<th><?= $this->Paginator->sort('Payment status') ?></th>
					<th><?= $this->Paginator->sort('payment method') ?></th>	
					<th><?= $this->Paginator->sort('Order status') ?></th>
					<th><?= $this->Paginator->sort('created') ?></th>
					<th class="actions"><?= __('Actions') ?></th>
				</tr> 
				<?php foreach ($data as $key => $page): ?>
				<tr>
					<td class="a-center"> 
						<label><input name="comp_chk" type="checkbox" class="status_checkbox tableflat" id="select_chkbx" value="<?php echo $page->id;?>"></label>
					</td>
					<td><?= $this->Number->format(++$key) ?></td>
					<td><?= "#".h($page->id) ?></td>
					<td><?= $this->General->getUserName($page->user->id) ?></td>
					<td><?= $page->total_qty ?></td>
					<td>$ <?= h(number_format($page->total_price,2)) ?></td>
					<td><?= $this->General->getPaymentstatus($page->payment_status) ?></td>
					<td><?= $page->payment_method ?></td>
					<td><?= $this->General->getOrderstatus($page->order_status) ?></td>
					<td><?= h($page->created) ?></td> 
					<td class="actions">
						<?php 
							echo $this->Html->link('<i class="fa fa-eye"></i> View',
								array('controller' => 'orders','action'=>'view', base64_encode($page->id)),
								array('escape' => false,'class'=>"btn btn-primary btn-xs","title"=>__("View",true)));
						?>
						<?php 
							echo $this->Html->link('<i class="fa fa-pencil"></i> Edit',
								array('controller' => 'Orders','action'=>'edit', base64_encode($page->id)),
								array('escape' => false,'class'=>"btn btn-info btn-xs","title"=>__("Edit",true)));
						?>
						<?php 
							echo $this->Html->link('<i class="fa fa-trash"></i> Delete',
								array('controller' => 'Orders','action'=>'delete', base64_encode($page->id)),
								array('escape' => false,'class'=>"btn btn-danger btn-xs","title"=>__("Delete",true),'confirm' => __('Are you sure you want to delete # {0}?', $page->id))); 
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
	function NumericValidation(e) {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if (unicode != 8) {
            if ((unicode < 48 || unicode > 57) && unicode != 46) {
                return false;
            }
        }
    }

 
	$(".clear").click(function(){
			$('#title').val('');
			
	});
	$(".btnDeleteAll").click(function(){ 
		var favorite = [];
		$.each($("input[name='comp_chk']:checked"), function(){            
			favorite.push($(this).val());
		});  
		if(favorite.length < 1){
			alert("Please Select Atleast One Cmspage");
		}else{
			if(confirm('Are you sure you want to delete the selected pages?')){
				if(favorite.length > 0){
				
					var url 	= '<?php echo Router::url('/', true).'admin/Vehicles/deleteAllCompany';?>';
					var newRow = JSON.stringify(favorite);
					var csrfToken = $("[name='_csrfToken']").val();
					$.ajax({
						type:'POST',
						//dataType: 'json',
						data: {ID:newRow,_csrfToken:csrfToken},
						url:url,
						success:function(data) {  
							window.location.href = window.location.protocol + "//" + window.location.host +window.location.pathname; 
						}
					});  
				}
			} 
		}
	});
	$("#select_chkbx").change(function () {
		$("input:checkbox").prop('checked', $(this).prop("checked"));
	});
</script> 