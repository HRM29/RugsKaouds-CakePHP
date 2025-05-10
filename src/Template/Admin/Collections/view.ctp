<style>
	.card-img-top {
		height: 150px;
		object-fit: cover;
	}
</style>
<section class="content-header">
	<h1>Collection </h1>

</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Collection Detail</h3>
					<div class="box-tools pull-right">
						<?php echo $this->Html->link('<i class="fa fa-pencil"></i> Edit', array('controller' => 'Collections', 'action' => 'edit', $collection->id), array('escape' => false, 'class' => "btn btn-info btn-xs", "title" => __("Edit", true))); ?>

						<?php echo $this->Html->link('<i class="fa fa-trash"></i> Delete', array('controller' => 'Collections', 'action' => 'Delete', $collection->id), array('escape' => false, 'confirm' => __('Are you sure you want to Delete?', $collection->id), 'class' => "btn btn-danger btn-xs", "title" => __("Delete", true))); ?>

						<?php echo $this->Html->link('<i class="fa fa-reply"></i> Back', array('controller' => 'Collections', 'action' => 'index'), array('escape' => false, 'class' => "btn bg-navy btn-xs", "title" => __("Back", true))); ?>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body table-responsive">
					<div class="col-md-4">
						<div class="box box-success">
							<div class="box-header with-border">
								<h3 class="box-title"><?php
														if ($collection->collection_type == '1') {
															echo "Category";
														} else {
															echo "Sub-Category";
														}
														?></h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body" style="display: block;">
								<?php echo ucfirst($collection->title); ?>
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
								<?php
								$parentData = $this->General->returnCollectionParentData($collection->id);
								if (!empty($parentData)) {
									echo $parentData['Collection2']['title'];
								} else {
									echo '-';
								}
								?>
							</div>
						</div>
					</div>
					<?php
					if ($collection->collection_type == 'page') {
					?>
						<div class="col-md-4">
							<div class="box box-info">
								<div class="box-header with-border">
									<h3 class="box-title">Meta Title</h3>
									<div class="box-tools pull-right">
										<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
									</div>
								</div>
								<div class="box-body" style="display: block;">
									<?php
									echo h($collection->meta_title);
									?>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="box box-info">
								<div class="box-header with-border">
									<h3 class="box-title">Meta Tags</h3>
									<div class="box-tools pull-right">
										<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
									</div>
								</div>
								<div class="box-body" style="display: block;">
									<?php
									echo h($collection->meta_tags);
									?>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="box box-info">
								<div class="box-header with-border">
									<h3 class="box-title">Meta Keywords</h3>
									<div class="box-tools pull-right">
										<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
									</div>
								</div>
								<div class="box-body" style="display: block;">
									<?php
									echo h($collection->meta_keywords);
									?>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="box box-info">
								<div class="box-header with-border">
									<h3 class="box-title">Page Slug</h3>
									<div class="box-tools pull-right">
										<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
									</div>
								</div>
								<div class="box-body" style="display: block;">
									<?php
									echo h($collection->page_url);
									?>
								</div>
							</div>
						</div>
					<?php
					}
					?>
					<div class="col-md-4">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Status</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body" style="display: block;">
								<?php echo $this->General->getAdminStatus($collection->status); ?>
							</div>
						</div>
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
								<?php echo date("Y-m-d H:i A", strtotime($collection->created)); ?>
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
								<?php echo date("Y-m-d H:i A", strtotime($collection->modified)); ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box box-primary">
							<!-- /.box-header -->
							<div class="box-body" style="display: block;">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#imageModal">
									View
								</button>
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

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="imageModalLabel">Images for Collection</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<?php if (!empty($collectionImages)) { ?>
						<?php foreach ($collectionImages as $eachImage): ?>
							<?php
							$parentPath = WWW_ROOT . '/uploads/collection' . DS;
							$original = $parentPath . $eachImage['file_path'];
							if (file_exists($original)) {
							?>
								<div class="col-md-3 mb-3">
									<div class="card">
										<?php
										echo $this->Html->image('/uploads/collection/' . $eachImage['file_path'], array('width' => '100px', 'class' => 'img-responsive remove_image card-img-top', 'data' => $eachImage['id'], 'atrValue' => 'file_path'));
										?>
									</div>
								</div>
							<?php } ?>
						<?php endforeach; ?>
					<?php } else { ?>
						<div class="col-md-8">
							<p>No images found for this collection.</p>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>