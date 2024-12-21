<?php use Cake\Routing\Router;?>
<?php use Cake\Core\Configure;?>
<section class="content-header">
  <h1>
	Update Order 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Update order</li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title">Update order</h3>
                </div><!-- /.box-header -->
				
 
                <?= $this->Form->create($order, ['type' => 'file']) ?>
				<div class="box-body">
			   <div class="form-group">
						<label for="Status">Payment Status</label>
						<?php $payment_options = array(0 => "Pending",1 => "Completed", 2 => "Cancelled"); ?>
						<?= $this->Form->control('payment_status', ['options'=>$payment_options,'label'=>false,'class'=>'form-control','required'=>'required']);?>
				</div>	
									
				  <div class="form-group">
						<label for="Status">Order Status</label>
						<?php $order_options = array(0 => 'Pending', 1 => "Cancelled" , 2 => "Processing", 3 => "Completed", 4 =>"Return", 5 =>"Shipped"); ?>
						<?= $this->Form->control('order_status', ['options'=>$order_options,'label'=>false,'class'=>'form-control','required'=>'required']);?>
					</div>	
					
					 
				</div><!-- /.box-body -->

				<div class="box-footer"> 
					<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
				</div>
				<?= $this->Form->end() ?>
			</div><!-- /.box -->
		</div>   <!-- /.row -->
	</div>   <!-- /.row -->
</section><!-- /.content -->  
 <script>
  
 
</script>