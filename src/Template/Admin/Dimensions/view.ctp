<?php
	use Cake\Routing\Router;
	use Cake\Core\Configure;
?> 
<section class="content-header">
	<h1>Dimensions  </h1>
	 
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">View Dimension</h3>
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
								<h3 class="box-title">Dimension Type</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
								<!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php echo !empty($dimension->type) ? Configure::read('size.type.'.$dimension->type) : ''; ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<div class="col-md-3">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Dimension Size</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
								<!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php echo !empty($dimension->title) ? ucfirst($dimension->title) : ''; ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<div class="col-md-3">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title">Is Large Runner</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
								<!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php echo ($dimension->is_large_runner == 1) ? LARGERUNNER : NOTLARGERUNNER; ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<div class="col-md-3">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Dimension Description</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
								<!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php echo !empty($dimension->description) ? ucfirst($dimension->description) : ''; ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<div class="col-md-3">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Meta Title</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
								<!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php echo !empty($dimension->meta_title) ? ucfirst($dimension->meta_title) : ''; ?>
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
								<?php echo !empty($dimension->meta_tags) ? ucfirst($dimension->meta_tags) : ''; ?>
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
								<?php echo !empty($dimension->meta_keywords) ? ucfirst($dimension->meta_keywords) : ''; ?>
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
								<?php echo $this->General->getAdminStatus($dimension->status); ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<div class="clearfix"></div>
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
								<?php echo date("Y-m-d H:i A",strtotime($dimension->created)); ?>
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