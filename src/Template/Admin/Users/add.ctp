<?php
	use Cake\Routing\Router;
	use Cake\Core\Configure;
?>
<section class="content-header">
	<h1> Users </h1>
 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Add User</h3>
					<div class="box-tools">
						<?php 
							echo $this->Html->link('<i class="fa fa-reply"></i> Back', array('action'=>'userList'), array('escape' => false,'class'=>"btn bg-navy btn-xs","title"=>__("Back",true)));
						?>
					</div>
                </div>
                <?php echo $this->Form->create($user, ['type' => 'file']); ?>
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="Name">User Role</label>
								<?php
									$options	=	Configure::read('user_role');
									echo $this->Form->control('role_id', ['options'=>$options,'empty'=>'Select Status','label'=>false,'class'=>'form-control']);
								?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Name">First Name</label>
								<?php echo $this->Form->control('first_name', ['placeholder'=>'First Name','label'=>false,'class'=>'form-control']); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Last Name">Last Name</label>
								<?php echo $this->Form->control('last_name', ['placeholder'=>'Last Name','label'=>false,'class'=>'form-control']); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Email">Email</label>
								<?php echo $this->Form->control('email', ['placeholder'=>'Email','label'=>false,'class'=>'form-control']); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Password">Password</label>
								<?php echo $this->Form->control('password', ['placeholder'=>'Password','label'=>false,'class'=>'form-control']); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="company">Company</label>
								<?php echo $this->Form->control('user_detail.company', ['placeholder'=>'Company','label'=>false,'class'=>'form-control']); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="address">Street Address</label>
								<?php echo $this->Form->control('user_detail.address', ['placeholder'=>'Street Address','label'=>false,'class'=>'form-control']); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="country">Country</label>
								<?php echo $this->Form->control('user_detail.country', ['options'=>$countryLists,'empty'=>'Select Country','label'=>false,'class'=>'form-control']); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="state">State Region Province</label>
								<?php echo $this->Form->control('user_detail.state', ['placeholder'=>'State Region Province','label'=>false,'class'=>'form-control']); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="city">City</label>
								<?php echo $this->Form->control('user_detail.city', ['placeholder'=>'City','label'=>false,'class'=>'form-control']); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="postal_code">Postal Code</label>
								<?php echo $this->Form->control('user_detail.postal_code', ['placeholder'=>'Postal Code','label'=>false,'class'=>'form-control']); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Password">Phone</label>
								<?php echo $this->Form->control('phone', ['placeholder'=>'Phone','label'=>false,'class'=>'form-control','onkeypress'=>"return isNumberKey(event)",'maxlength'=>10]); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Password">Status</label>
								<?php $options = array(ACTIVE => "Active" , INACTIVE => "Inactive");?>
								<?php echo $this->Form->control('status', ['options'=>$options,'label'=>false,'class'=>'form-control','empty'=>'Select Status']); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Avatar">Avatar</label> 
								<?php echo $this->Form->control('avatar', ['type'=>'file','label'=>false]); ?>
							</div> 
						</div>
					</div>
				</div><!-- /.box-body -->
				<div class="box-footer"> 
					<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']); ?>
				</div>
				<?= $this->Form->end() ?>
			</div><!-- /.box -->
		</div>   <!-- /.row -->
	</div>   <!-- /.row -->
</section><!-- /.content -->  
