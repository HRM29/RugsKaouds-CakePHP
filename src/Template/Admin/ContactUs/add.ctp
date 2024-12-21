<?php use Cake\Routing\Router;?>
<section class="content-header">
  <h1>
	Currencys
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add Currencys</li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title">Add Currencys</h3>
                </div><!-- /.box-header -->
                <?= $this->Form->create($currencysadd, ['type' => 'file']) ?>
				<div class="box-body">
					<div class="form-group">
						<label for="Name">Name</label>
						<?= $this->Form->control('name', ['placeholder'=>'Name','label'=>false,'class'=>'form-control']);?>
					</div>
					<div class="form-group">
						<label for="Name">Code</label>
						<?= $this->Form->control('code', ['placeholder'=>'Code','label'=>false,'class'=>'form-control']);?>
					</div>
					<div class="form-group">
						<label for="Name">Symbol</label>
						<?= $this->Form->control('symbol', ['placeholder'=>'Symbol','label'=>false,'class'=>'form-control']);?>
					</div>
					<div class="form-group">
						<label for="Name">Price</label>
						<?= $this->Form->control('price', ['placeholder'=>'Price','label'=>false,'class'=>'form-control']);?>
					</div>
					<div class="form-group">
						<label for="Name">Default</label>
						<?= $this->Form->control('defaults', ['placeholder'=>'Default','label'=>false,'class'=>'form-control']);?>
					</div>
					<div class="form-group">
						<label for="Password">Status</label>
						<?php $options = array(Active => "Active" , Inactive => "Inactive");?>
						<?= $this->Form->control('status', ['options'=>$options,'label'=>false,'class'=>'form-control','empty'=>'Select Status']);?>
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