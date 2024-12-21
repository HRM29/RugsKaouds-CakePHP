<?php use Cake\Routing\Router;?>
<section class="content-header">
	<h1>Users </h1>
	
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Edit User</h3>
					<div class="box-tools">
						<?php 
							if($user->role_id == ADMIN) {
								echo $this->Html->link('<i class="fa fa-reply"></i> Back', array('action'=>'userList'), array('escape' => false,'class'=>"btn bg-navy btn-xs","title"=>__("Back",true)));
							} else {
								echo $this->Html->link('<i class="fa fa-reply"></i> Back', array('action'=>'customerList'), array('escape' => false,'class'=>"btn bg-navy btn-xs","title"=>__("Back",true)));
							}
						?>
					</div>
                </div><!-- /.box-header -->
                <?= $this->Form->create($user, ['type' => 'file','id'=>'userEditForm']); ?>
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="Name">First Name</label>
								<?= $this->Form->control('first_name', ['placeholder'=>'First Name','label'=>false,'class'=>'form-control']);?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Last Name">Last Name</label>
								<?= $this->Form->control('last_name', ['placeholder'=>'Last Name','label'=>false,'class'=>'form-control']);?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Email">Email</label>
								<?= $this->Form->control('email', ['placeholder'=>'Email','label'=>false,'class'=>'form-control']);?>
							</div>
						</div>
						<?php if($user->role_id == FRONT) { ?>
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
									<?php echo $this->Form->control('user_detail.country', ['options'=>$countryList,'empty'=>'Select Country','label'=>false,'class'=>'form-control']); ?>
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
						<?php } ?>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Password">Phone</label>
								<?= $this->Form->control('phone', ['placeholder'=>'Phone','label'=>false,'class'=>'form-control','onkeypress'=>"return isNumberKey(event)",'maxlength'=>10]);?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Password">Status</label>
								<?php $options = array(ACTIVE => "Active" , INACTIVE => "Inactive");?>
								<?= $this->Form->control('status', ['options'=>$options,'label'=>false,'class'=>'form-control','empty'=>'Select Status']);?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<div class="checkbox">
									<label>
										<input type="checkbox" id="ch_pass">
										Change Password ?
									</label>
								</div> 
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="normal">Password<span class="required_field">*</span></label>
								<div class="controls"> 
									<?= $this->Form->control('password', ['placeholder'=>'Password','label'=>false,'class'=>'form-control','disabled','value'=>'']);?>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Avatar">Avatar</label> 
								<?= $this->Form->control('avatar', ['type'=>'file','label'=>false]);?>
							</div> 
							<div class="form-group" id="img_grid_upload"> 
								<?php
								if (!empty($user->avatar)) {
									$original = WWW_ROOT . 'uploads/user' . DS . 'thumb' . DS . $user->avatar;
									if (file_exists($original)) { 
										echo $this->Html->image('../uploads/user/thumb/' . $user->avatar, array('width' => '100px', 'class' => 'img-responsive','title'=>'admin_user'));
										echo $this->Html->link('<i class="fa fa-trash"></i> Remove','javascript::void()', array('escape' => false,'class'=>"text-red","title"=>__("Remove Avatar",true),'data' => $user->id, 'id' => 'remove_image'));
									}
								} 
								?>
							</div>
						</div>
					</div>
				</div><!-- /.box-body -->
				<div class="box-footer"> 
					<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
				</div>
				<?= $this->Form->end() ?>
			</div><!-- /.box -->
		</div>   <!-- /.row -->
	</div>   <!-- /.row -->
</section><!-- /.content -->  
<script>
	$("#remove_image").click(function(){
		var id			=	$(this).attr('data');
		var csrfToken	=	$("[name='_csrfToken']").val(); 
		var url			=	'<?php echo Router::url('/', true) . '/admin/users/remove_image_user'; ?>';
		if(confirm('Are you sure you want to remove avatar?')) {
			$.ajax({
				type:	'POST',
				data:	{id:id,_csrfToken:csrfToken},
				url	:	url,
				success : function(data) {
					$('#img_grid_upload').empty();
				}
			});
		}
	});
	
	$('#ch_pass').on('click',function(){
		if($(this).is(':checked')){ 
			$('#password').prop('disabled', false);
		}else{
			$('#password').prop('disabled', true);
		} 
	});

</script>