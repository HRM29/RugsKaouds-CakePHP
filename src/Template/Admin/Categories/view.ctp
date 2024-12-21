<?php use Cake\Routing\Router;?> 
<section class="content-header">
	<h1>Category </h1>
	 
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Category Detail</h3>
					<div class="box-tools pull-right">
						<?php echo $this->Html->link('<i class="fa fa-pencil"></i> Edit', array('controller' => 'categories','action'=>'edit',$category->id), array('escape' => false,'class'=>"btn btn-info btn-xs","title"=>__("Edit",true))); ?>
						
						<?php echo $this->Html->link('<i class="fa fa-trash"></i> Delete', array('controller' => 'categories','action'=>'Delete',$category->id), array('escape' => false,'confirm' => __('Are you sure you want to Delete?', $category->id),'class'=>"btn btn-danger btn-xs","title"=>__("Delete",true))); ?>
						
						<?php echo $this->Html->link('<i class="fa fa-reply"></i> Back', array('controller' => 'categories','action'=>'index'), array('escape' => false,'class'=>"btn bg-navy btn-xs","title"=>__("Back",true))); ?>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body table-responsive">
					<div class="col-md-4">
						<div class="box box-success">
							<div class="box-header with-border">
								<h3 class="box-title">Title</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body" style="display: block;">
								<?php echo ucfirst($category->title); ?>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title">Parent Category</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body" style="display: block;">
								<?php echo $this->General->getCategorys($category->parent_id); ?>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Status</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body" style="display: block;">
								<?php echo $this->General->getAdminStatus($category->status); ?>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Description</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
								<!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php echo $category->description; ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Created</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
								<!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php echo date("Y-m-d H:i A",strtotime($category->created)); ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Modified</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
								<!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php echo date("Y-m-d H:i A",strtotime($category->modified)); ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>
<!-- /.content -->