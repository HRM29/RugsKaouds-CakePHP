<?php use Cake\Routing\Router;?> 
<section class="content-header">
  <h1>
	Users 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">User Detail</li>
  </ol> 
</section>
<section class="content">
	<div class="row">
		<div class="col-md-3">

              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile"> 
				  <?php
					if (!empty($user->avatar)) {
						$original = WWW_ROOT . 'uploads/user' . DS . 'thumb' . DS . $user->avatar;
						if (file_exists($original)) {
					 
							echo $this->Html->image('../uploads/user/thumb/' . $user->avatar, 	array('height' => '100%', 'class' => 'profile-user-img img-responsive img-circle')); 
						}else{
							echo $this->Html->image('user-img.jpg', 	array('height' => '100%', 'class' => 'profile-user-img img-responsive img-circle')); 
						}
					}else{
						echo $this->Html->image('user-img.jpg', 	array('height' => '100%', 'class' => 'profile-user-img img-responsive img-circle')); 
					}	
					?>
					
                  <h3 class="profile-username text-center"><?= ucfirst($user->first_name).' '.$user->last_name; ?></h3>
                  <p class="text-muted text-center"><?= h($user->email); ?></p> 
                  <p class="text-muted text-center"><?= $this->General->getStatus($user->status); ?></p> 
                </div><!-- /.box-body -->
              </div><!-- /.box --> 
		</div>
		<div class="col-xs-9"> 
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">User Detail</h3>
					<div class="box-tools pull-right">
						<?php echo $this->Html->link('<i class="fa fa-pencil"></i> Edit',
							array('controller' => 'users','action'=>'edit',$user->id),
							array('escape' => false,'class'=>"btn btn-info btn-sm","title"=>__("Edit",true))
						);
						?>
						<?php 
						if($user->role_id != '1'){
							echo $this->Html->link('<i class="fa fa-trash"></i> Delete',
							array('controller' => 'users','action'=>'Delete',$user->id),
							array('escape' => false,'confirm' => __('Are you sure you want to Delete?', $user->id),'class'=>"btn btn-danger btn-sm","title"=>__("Delete",true))
							);
						}
						?>
						<?php echo $this->Html->link('<i class="fa fa-reply"></i> Back',
						array('controller' => 'users','action'=>'userList'),
						array('escape' => false,'class'=>"btn bg-navy btn-sm","title"=>__("Back",true))
						);
						?>	
					</div>
				</div><!-- /.box-header -->
			
				<div class="box-body table-responsive"> 
					<div class="col-md-3">
					  <div class="box box-success">
						<div class="box-header with-border">
						  <h3 class="box-title">Name</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						  <?= ucfirst($user->first_name).' '.$user->last_name; ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
					<div class="col-md-3">
					  <div class="box box-warning">
						<div class="box-header with-border">
						  <h3 class="box-title">Email</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						  <?= h($user->email); ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
					<div class="col-md-3">
					  <div class="box box-default">
						<div class="box-header with-border">
						  <h3 class="box-title">Phone</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						  <?= h($user->phone); ?>
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
						  <?= $this->General->getStatus($user->status); ?>
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
						  <?= date("Y-m-d H:i A",strtotime($user->created)); ?>
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
						  <?= date("Y-m-d H:i A",strtotime($user->modified)); ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
					
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
</section><!-- /.content -->  