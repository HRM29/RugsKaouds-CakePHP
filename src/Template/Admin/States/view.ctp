<?php use Cake\Routing\Router;?> 
<section class="content-header">
  <h1>
	<?= $title; ?> 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active"><?= $title; ?> Detail</li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-xs-12"> 
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title"><?= $title; ?> Detail</h3>
					<div class="box-tools pull-right">
						<?php echo $this->Html->link('<i class="fa fa-pencil"></i> Edit',
							array('controller' => 'states','action'=>'edit',base64_encode($data->id)),
							array('escape' => false,'class'=>"btn btn-info btn-sm","title"=>__("Edit",true))
						);
						?>
						<?php  
						/*	echo $this->Html->link('<i class="fa fa-trash"></i> Delete',
							array('controller' => 'states','action'=>'Delete',base64_encode($data->id)),
							array('escape' => false,'confirm' => __('Are you sure you want to Delete?', $data->id),'class'=>"btn btn-danger btn-sm","title"=>__("Delete",true))
							); */
						?>
						<?php echo $this->Html->link('<i class="fa fa-reply"></i> Back',
						array('controller' => 'states','action'=>'index'),
						array('escape' => false,'class'=>"btn bg-navy btn-sm","title"=>__("Back",true))
						);
						?>	
					</div>
				</div><!-- /.box-header -->
				<div class="col-md-4">
					  <div class="box box-warning">
						<div class="box-header with-border">
						  <h3 class="box-title">Country</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						  <?= $this->General->getCountry($data->country_id); ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
				</div>
				<div class="box-body table-responsive"> 
					<div class="col-md-4">
					  <div class="box box-success">
						<div class="box-header with-border">
						  <h3 class="box-title">States Name</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						  <?= ucfirst($data->region_name); ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
					
					<div class="col-md-4">
					  <div class="box box-danger">
						<div class="box-header with-border">
						  <h3 class="box-title">Status</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						  <?= $this->General->getAdminStatus($data->status); ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
					
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
</section><!-- /.content -->   