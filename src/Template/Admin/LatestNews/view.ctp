<?php use Cake\Routing\Router;?> 
<section class="content-header">
  <h1>
	Project Details 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Project Detail</li>
  </ol> 
</section>
<section class="content">
	<div class="row">
		<div class="col-md-2">

              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile"> 
				  <?php
					if (!empty($project->image)) {
						$original = WWW_ROOT . 'uploads/projects' . DS . 'thumb' . DS . $project->image;
						if (file_exists($original)) {
					 
							echo $this->html->image('../uploads/projects/thumb/' . $project->image, 	array('height' => '100%', 'class' => 'img-thumbnail')); 
						}else{
							echo $this->html->image('project-img.png', 	array('height' => '100%', 'class' => 'img-thumbnail')); 
						}
					}else{
						echo $this->html->image('project-img.png', 	array('height' => '100%', 'class' => 'img-thumbnail')); 
					}	
					?>
				<p class="text-muted text-center"><?= $project->title; ?></p>	        
				<p class="text-muted text-center"><?= $this->General->getStatus($project->status); ?></p> 
				</div><!-- /.box-body -->
			</div><!-- /.box --> 
		</div>
		<div class="col-xs-10"> 
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Project Detail</h3>
					<div class="box-tools pull-right">
						<?php echo $this->Html->link('<i class="fa fa-pencil"></i> Edit',
							array('controller' => 'projects','action'=>'edit',$project->id),
							array('escape' => false,'class'=>"btn btn-info btn-sm","title"=>__("Edit",true))
						);
						?>
						<?php 
						if($project->id != '1'){
							echo $this->Html->link('<i class="fa fa-trash"></i> Delete',
							array('controller' => 'projects','action'=>'Delete',$project->id),
							array('escape' => false,'confirm' => __('Are you sure you want to Delete?', $project->id),'class'=>"btn btn-danger btn-sm","title"=>__("Delete",true))
							);
						}
						?>
						<?php echo $this->Html->link('<i class="fa fa-reply"></i> Back',
						array('controller' => 'projects','action'=>'index'),
						array('escape' => false,'class'=>"btn bg-navy btn-sm","title"=>__("Back",true))
						);
						?>	
					</div>
				</div><!-- /.box-header -->
			
				<div class="box-body table-responsive"> 
					<div class="col-md-4">
					  <div class="box box-success">
						<div class="box-header with-border">
						  <h3 class="box-title">Project Title</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						  <?= ucfirst($project->title); ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
					<div class="col-md-4">
					  <div class="box box-warning">
						<div class="box-header with-border">
						  <h3 class="box-title">Category</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						<?= $this->General->getCategorys($project->category_id) ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
					<div class="col-md-4">
					  <div class="box box-danger">
						<div class="box-header with-border">
						  <h3 class="box-title">Fund Amount</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						<?= $this->General->currency().$project->fund_amount; ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
					<div class="col-md-4">
					  <div class="box box-info">
						<div class="box-header with-border">
						  <h3 class="box-title">Interest Rate</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						<?= $project->interest_rate.'%'; ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
					<div class="col-md-4">
					  <div class="box box-warning">
						<div class="box-header with-border">
						  <h3 class="box-title">Return Time</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						<?= $project->return_time ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
					<div class="col-md-4">
					  <div class="box box-success">
						<div class="box-header with-border">
						  <h3 class="box-title">Min Amount</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						<?= $project->min_amount ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
					<div class="col-md-4">
					  <div class="box box-default">
						<div class="box-header with-border">
						  <h3 class="box-title">Max Amount</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						<?= $project->max_amount ?>
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
						  <?= $this->General->getStatus($project->status); ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
					
					<div class="col-md-4">
					  <div class="box box-info">
						<div class="box-header with-border">
						  <h3 class="box-title">Created</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						  <?= date("Y-m-d H:i A",strtotime($project->created)); ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
					
					<div class="col-md-4">
					  <div class="box box-primary">
						<div class="box-header with-border">
						  <h3 class="box-title">Modified</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						  <?= date("Y-m-d H:i A",strtotime($project->modified)); ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
					<div class="col-md-12">
					  <div class="box box-default">
						<div class="box-header with-border">
						  <h3 class="box-title">Description</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						  <?= $project->description; ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
</section><!-- /.content -->  