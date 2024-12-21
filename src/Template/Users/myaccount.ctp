 <?php use Cake\Routing\Router;?>
 <!--Cart Page Area Start-->
        <div class="check-out-area">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-3 col-xs-12 col-sm-3 account-sidebar">
						<div class="checkout-widget">
							<h1 class="heading-title">My Account</h2>
							<ul>
								<li><a href="<?php echo Router::url('/', true); ?>users/myaccount">My Details</a></li>
								<!-- <li><a href="#"><i class="fa fa-map-marker"></i> My Addres book</a></li> -->
								<li><a href="<?php echo Router::url('/', true); ?>users/myorder">My Orders</a></li>
								<li><a href="<?php echo Router::url('/', true); ?>users/wishlist">My Favourite list</a></li>
								<li><a href="<?php echo Router::url('/', true); ?>users/changepassword">Change Password</a></li>
							</ul>
						</div>                        
                    </div>
					
                    <div class="offset-md-1 col-md-7 col-sm-8 col-xs-12 account-main">
					<?= $this->Flash->render('positive_myaccount') ?>	
                            <?= $this->Form->create($user, ['url' => ['controller' => 'Users', 'action' => 'myaccount'],'type' => 'file']); ?>
                                <h1 class="heading-title">My Details</h1>
								<div class="user-profile">
									<div class="profile-img">
										<div class="form-group">
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
											} ?>
										</div>
									</div>
									<div class="profile-content">
										<div class="form-group">
											
											<input class="choose-file" type="file" id="choose-file" name="avatar" required>
  <label for="choose-file" class="upload-file"></label>
										</div>
									</div>	
									</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<?= $this->Form->control('first_name', ['type'=>'text','placeholder'=>'First Name"','label'=>false,'class'=>'form-control']);?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<?= $this->Form->control('last_name', ['type'=>'text','placeholder'=>'Last Name"','label'=>false,'class'=>'form-control']);?>
										</div>
									</div>	
									</div>
								
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<?= $this->Form->control('email', ['type'=>'email','placeholder'=>'Email','label'=>false,'class'=>'form-control']);?>
										</div>
									</div>
									</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<?= $this->Form->control('phone', ['type'=>'text','placeholder'=>'Phone','label'=>false,'class'=>'form-control' ]);?>
										</div>
									</div>
								</div>
								<div class="row">
									<?php  echo $this->Form->hidden('password', ['value'=>'nothing']); ?>
									<?php  echo $this->Form->hidden('status', ['value'=>1]); ?>
									<div class="col-md-6">
										<div class="form-group m-20">
										   <button type="submit" title="Update Profile" class="view-button"><span>Update Profile</span></button>
										</div>
									</div>									
								</div>								
                            <?= $this->Form->end() ?>
                        </div>



                </div>
            </div>
        </div>
        <!--Cart Page Area End-->