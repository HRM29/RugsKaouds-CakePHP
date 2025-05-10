<?php

use Cake\Routing\Router;

$session = $this->request->getSession();
$authUser = $session->read('Auth');
?>
<section class="content-header">
	<h1>
		Orders Details
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Orders Detail</li>
	</ol>
</section>
<section class="content">
	<div class="row">

		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Orders Detail</h3>
					<div class="box-tools pull-right">
						<?php echo $this->Html->link(
							'<i class="fa fa-pencil"></i> Edit',
							array('controller' => 'orders', 'action' => 'edit', base64_encode($orders->id)),
							array('escape' => false, 'class' => "btn btn-info btn-sm", "title" => __("Edit", true))
						);
						?>
						<?php
						if ($orders->id != '1') {
							echo $this->Html->link(
								'<i class="fa fa-trash"></i> Delete',
								array('controller' => 'orders', 'action' => 'Delete', base64_encode($orders->id)),
								array('escape' => false, 'confirm' => __('Are you sure you want to Delete?', $orders->id), 'class' => "btn btn-danger btn-sm", "title" => __("Delete", true))
							);
						}
						?>
						<?php echo $this->Html->link(
							'<i class="fa fa-reply"></i> Back',
							array('controller' => 'orders', 'action' => 'index'),
							array('escape' => false, 'class' => "btn bg-navy btn-sm", "title" => __("Back", true))
						);
						?>
					</div>
				</div><!-- /.box-header -->

				<!-- START : CUSTOMER DETAILS-->

				<div class="box-body table-responsive">
					<div class="box-header with-border">
						<h3 class="box-title">Customer Billing Detail</h3>
					</div>
					<div class="col-md-4">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title">Customer Name</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->billing_first_name . " " . $orders->billing_last_name; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title">Phone</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->billing_phone; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title">Email</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->billing_email; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Street Address</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->billing_street_address; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">City</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->billing_city; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">State</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $this->General->getStates($orders->billing_state); ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Country</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->billing_country; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>

					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Zip</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->billing_zip; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
				</div>



				<div class="box-body table-responsive">
					<div class="box-header with-border">
						<h3 class="box-title">Customer Shipping Detail</h3>
					</div>
					<div class="col-md-4">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title">Customer Name</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->delivery_first_name . " " . $orders->delivery_last_name; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title">Phone</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->delivery_phone; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title">Email</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->delivery_email; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Street Address</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->delivery_street_address; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">City</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->delivery_city; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">State</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $this->General->getStates($orders->delivery_state); ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Country</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->delivery_country; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>

					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Zip</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->delivery_zip; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
				</div>

				<!-- END : CUSTOMER DETAILS-->
				<div class="box-body table-responsive">
					<div class="box-header with-border">
						<h3 class="box-title">Orders Detail</h3>
					</div>
					<div class="col-md-4">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title">Transaction Id</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->trans_id ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title">Username</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $this->General->getUserName($orders->user_id) ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title">User Email</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $this->General->getUserEmail($orders->user_id) ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Order Discount</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= "$ " . $orders->discount_amount; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Order Amount</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= "$ " . $orders->total_price; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Created Date:</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php 
								$date = DateTime::createFromFormat('n/j/y, g:i A', $orders->created);

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
					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Updated Date:</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?php
								$date = DateTime::createFromFormat('n/j/y, g:i A', $orders->modified);

                                // Check for errors in the parsing process
                                if ($date === false) {
                                    echo "There was an error parsing the date.";
                                    print_r(DateTime::getLastErrors());  // This will provide more details on what went wrong
                                } else {
                                    // Output the formatted date
                                    $formattedDate = $date->format('Y-m-d g:i A');
                                    echo $formattedDate;
                                }
								
								//date("Y-m-d", strtotime($orders->modified)); 
								?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">Payment Method</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $orders->payment_method; ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>

					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Payment Status</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $this->General->getPaymentstatus($orders->payment_status) ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Order Status</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div><!-- /.box-tools -->
							</div><!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<?= $this->General->getOrderstatus($orders->order_status); ?>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>

				</div>
				<div class="box-body table-responsive">
					<div class="box-header with-border">
						<h3 class="box-title">Product Detail</h3>
					</div>
					<?php foreach ($orders->order_details as $dtls => $value) {  ?>
						<div class="row">
							<div class="col-md-12">

								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Product Image</h3>
										<div class="box-tools pull-right">
											<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
										</div><!-- /.box-tools -->
									</div>
									<div class="box-body box-profile">
										<?php
										$img_src = Router::url('/', true) . 'uploads/product/';
										$sku = $value->product_sku;
										$prId = $value->product_id;

										$res =  $this->General->getProductImages($prId);

										$inFolder = $this->General->__get_picture_folder($sku);

										if (!empty($res)) {
											foreach ($res as $valueK) {
												$img_name = $valueK->image;
												$filePath =  WWW_ROOT . 'uploads' . DS . 'product' . DS . $inFolder . DS . $img_name;

												$filePath21 =  WWW_ROOT . 'uploads' . DS . 'product' . DS . $inFolder . DS . str_replace('jpg', 'JPG', $img_name);

												$fileUrl = $img_src . $inFolder . "/" . $img_name;

												$fileUr2l = $img_src . $inFolder . "/" . str_replace('jpg', 'JPG', $img_name);
												if (file_exists($filePath)) {
										?>
													<img src="<?php echo $fileUrl; ?>" alt="<?php echo $value->product_name; ?>" class="img-fluid" style="width:80px;">

												<?php } else if (file_exists($filePath21)) {  ?>
													<img src="<?php echo $fileUr2l; ?>" alt="<?php echo $value->product_name; ?>" class="img-fluid" style="width:80px;">
										<?php }
											}
										} ?>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4">
										<div class="box box-success">
											<div class="box-header with-border">
												<h3 class="box-title">Product Title</h3>
												<div class="box-tools pull-right">
													<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
												</div><!-- /.box-tools -->
											</div><!-- /.box-header -->
											<div class="box-body" style="display: block;">
												<?php echo $value->product_name; ?>
											</div><!-- /.box-body -->
										</div><!-- /.box -->
									</div>
									<div class="col-md-4">
										<div class="box box-success">
											<div class="box-header with-border">
												<h3 class="box-title">Product SKU</h3>
												<div class="box-tools pull-right">
													<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
												</div><!-- /.box-tools -->
											</div><!-- /.box-header -->
											<div class="box-body" style="display: block;">
												<?= $value->product_sku; ?>
											</div><!-- /.box-body -->
										</div><!-- /.box -->
									</div>
									<div class="col-md-4">
										<div class="box box-success">
											<div class="box-header with-border">
												<h3 class="box-title">Product Price</h3>
												<div class="box-tools pull-right">
													<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
												</div><!-- /.box-tools -->
											</div><!-- /.box-header -->
											<div class="box-body" style="display: block;">
												<?= "$ " . $value->price; ?>
											</div><!-- /.box-body -->
										</div><!-- /.box -->
									</div>
								</div>

							</div>
						</div>
					<?php } ?>
					<div class="clearfix"></div>

				</div><!-- /.box-body -->

			</div><!-- /.box-header -->
		</div>
	</div>
</section><!-- /.content -->