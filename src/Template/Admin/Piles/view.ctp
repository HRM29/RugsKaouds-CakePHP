<?php
	use Cake\Routing\Router;
	use Cake\Core\Configure;
?> 
<section class="content-header">
	<h1>Piles  </h1>
 
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">View Pile</h3>
					<div class="box-tools">
						<?php 
							echo $this->Html->link('<i class="fa fa-reply"></i> Back', array('action'=>'index'), array('escape' => false,'class'=>"btn bg-navy btn-xs","title"=>__("Back",true)));
						?>
					</div>
                </div><!-- /.box-header -->
				<div class="box-body table-responsive">
					<div class="col-md-3">
						<div class="box box-success">
							<div class="box-header with-border">
								<h3 class="box-title">Pile Name</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
								<!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php echo !empty($result->title) ? $result->title : ''; ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<div class="col-md-3">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Pile Description</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
								<!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php echo !empty($result->description) ? $result->description : ''; ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					 
					<div class="col-md-3">
						<div class="box box-success">
							<div class="box-header with-border">
								<h3 class="box-title">Meta Tags</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
								<!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php echo !empty($result->meta_tags) ? ucfirst($result->meta_tags) : ''; ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<div class="col-md-3">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Meta Keywords</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
								<!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php echo !empty($result->meta_keywords) ? ucfirst($result->meta_keywords) : ''; ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<div class="col-md-3">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title">Status</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
								<!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php echo $this->General->getAdminStatus($result->status); ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<div class="col-md-3">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Created</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
								<!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php echo date("Y-m-d H:i A",strtotime($result->created)); ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>
<!-- /.content -->