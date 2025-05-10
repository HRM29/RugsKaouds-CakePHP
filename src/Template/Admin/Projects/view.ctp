<?php

use Cake\Routing\Router; ?>
<section class="content-header">
	<h1>
		Manage Project
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Banner Detail</li>
	</ol>
</section>
<section class="content">
	<div class="row">

		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Project Detail</h3>
					<div class="box-tools pull-right">
						<?php echo $this->Html->link(
							'<i class="fa fa-pencil"></i> Edit',
							array('controller' => 'Projects', 'action' => 'edit', base64_encode($data->id)),
							array('escape' => false, 'class' => "btn btn-info btn-sm", "title" => __("Edit", true))
						);
						?>

						<?php echo $this->Html->link(
							'<i class="fa fa-reply"></i> Back',
							array('controller' => 'Projects', 'action' => 'index'),
							array('escape' => false, 'class' => "btn bg-navy btn-sm", "title" => __("Back", true))
						);
						?>
					</div>
				</div><!-- /.box-header -->

				<div class="box-body table-responsive">
					<div class="col-md-3">
						<div class="box box-success">
							<div class="box-header with-border">
								<h3 class="box-title">Title</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= ucfirst($data->label); ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-3">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Status</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $this->General->getAdminTextStatus($data->status); ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>

					<div class="col-md-3">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Image</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php echo $this->Html->image('/uploads/projects/' . $data->image_url, array('alt' => $data->image_url, 'width' => '200px')); ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>

					<div class="col-md-3">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Created</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
							    <?php 
								$date = DateTime::createFromFormat('n/j/y, g:i A', $data->created_at);

                                // Check for errors in the parsing process
                                if ($date === false) {
                                    echo "There was an error parsing the date.";
                                    print_r(DateTime::getLastErrors());  // This will provide more details on what went wrong
                                } else {
                                    // Output the formatted date
                                    $formattedDate = $date->format('Y-m-d g:i A');
                                    echo $formattedDate;
                                }
								?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>

					<div class="col-md-3">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Modified</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
							     <?php 
								$date = DateTime::createFromFormat('n/j/y, g:i A', $data->updated_at);

                                // Check for errors in the parsing process
                                if ($date === false) {
                                    echo "There was an error parsing the date.";
                                    print_r(DateTime::getLastErrors());  // This will provide more details on what went wrong
                                } else {
                                    // Output the formatted date
                                    $formattedDate = $date->format('Y-m-d g:i A');
                                    echo $formattedDate;
                                }
								?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>

				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
</section><!-- /.content -->