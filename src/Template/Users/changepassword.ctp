 <?php use Cake\Routing\Router;?>
 <!--Cart Page Area Start-->
        <div class="check-out-area">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-3 col-xs-12 col-sm-3 account-sidebar">
						<div class="checkout-widget">
							<h2 class="widget-title">My Account</h2>
							<ul>
								<li><a href="<?php echo Router::url('/', true); ?>users/myaccount">My Details</a></li>
                                <!-- <li><a href="#"><i class="fa fa-map-marker"></i> My Addres book</a></li> -->
                                <li><a href="<?php echo Router::url('/', true); ?>users/myorder">My Orders</a></li>
								<li><a href="<?php echo Router::url('/', true); ?>users/wishlist">My Favourite list</a></li>
                                <li><a href="<?php echo Router::url('/', true); ?>users/changepassword">Change Password</a></li>
							</ul>
						</div>                        
                    </div>

                    <div class="offset-md-1 col-sm-6 col-xs-12 account-main chng-pwd">
<?= $this->Flash->render('positive_changepass') ?>
							<?= $this->Form->create($user); ?>
                                <h1 class="heading-title">Change Passowrd</h1>
                                <div class="form-group">
                                    <input placeholder="New Password" class="form-control" type="password" name="new_pswd" required>
                                </div>
                                <div class="form-group">
                                    <input placeholder="Confirm Password" class="form-control" type="password" name="confirm_password" required>
                                </div>
                                 <p class="form-cols">
                                <div class="submit2 m-20">                    
                                    <button id="submitcreate" type="submit" class="view-button">
                                        Change Password
                                    </button>
                                </div>   
                                </p>   
                           <?= $this->Form->end() ?>
                        </div>



                </div>
            </div>
        </div>
        <!--Cart Page Area End-->