<?php use Cake\Routing\Router; ?>
<!-- About Area start -->
    <div class="login-account-area section-padding">
        <div class="container">
            <div class="row">
                    <div class="col-sm-12 col-md-6">
					<?= $this->Flash->render('positive_register');?>
                        <?php echo $this->Form->create($user,['url' => ['controller' => 'Users', 'action' => 'register'],'class'=>'create-account-form','id'=>'signupform']);?>
                            <!-- <form method="post" class="create-account-form" action="#"> -->
                            <h3 class="heading-title">Create an account</h3>
							<div class="row">
							<div class="col-sm-6 col-xs-12">
                             <div class="form-group">
                                <?php echo  $this->Form->control('first_name', ['label' => false,"placeholder"=>"Enter First Name","class"=>"form-control","div"=>false,"required" =>true]); ?>
                            </div>
							
							</div>
							<div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <?php echo  $this->Form->control('last_name', ['label' => false,"placeholder"=>"Enter Last Name","class"=>"form-control","div"=>false,"required" =>true]); ?>
                            </div>
							
							</div>
							</div>
							<div class="row">
							<div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <?php echo  $this->Form->control('password', ['type' => 'password','label' => false,"placeholder"=>"Enter Password","class"=>"form-control","div"=>false,"required" =>true]); ?>
                            </div>
							
							</div>
							<div class="col-sm-6 col-xs-12">
                            <div class="form-group ">
                                <?php echo  $this->Form->control('confirm_password', ['type' => 'password','label' => false,"placeholder"=>"Enter Confirm Password","class"=>"form-control","div"=>false,"required" =>true]); ?>
                            </div>
							
							</div>
							</div>
							<div class="row">
							<div class="col-sm-6 col-xs-12">
                            <div class="form-group ">
                                <?php echo  $this->Form->control('email', ['label' => false,"placeholder"=>"Enter Email Address","class"=>"form-control","div"=>false,"required" =>true]); ?>
                            </div>
							
							</div>
							
							<div class="col-sm-6 col-xs-12">
                            <div class="form-group ">
                                <?php echo  $this->Form->control('phone', ['label' => false,"placeholder"=>"Enter Phone No.","class"=>"form-control","div"=>false,"required" =>true]); ?>
                            </div>
							
							</div>
							
							<div class="col-12">
                           
                                <?php echo $this->Form->button("<span>Create an account</span>", array('name' => 'submitcreate','class' => 'view-button', 'type' => 'submit', 'id'=>'submitcreate',  'title' => 'Create an account')); ?> 
                           
							
							</div>
							</div>      
                        <?php echo $this->Form->end(); ?>
                    </div>
                    <div class="col-sm-12 col-md-5 offset-md-1 cols-for-mob">
						<?= $this->Flash->render('positive_login') ?>
                         <?php echo $this->Form->create($userlogin,['url' => ['controller' => 'Users', 'action' => 'login'],'class'=>'login-form','id'=>'loginform']); ?>
                            <!-- <form method="post" class="login-form" action="#"> -->
                            <h3 class="heading-title">Already registered?</h3>
                            <div class="form-group">
                                <?php echo  $this->Form->control('email', ['label' => false,"placeholder"=>"Enter Email Address","class"=>"form-control","id"=>"emailId","div"=>false,"required" =>true]); ?>
                            </div>
                            <div class="form-group">
                                <?php echo  $this->Form->control('password', ['label' => false,"placeholder"=>"Enter Password","class"=>"form-control","id"=>"login-password","div"=>false,"required" =>true]); ?>
                            </div>
                            <p class="lost-password form-group"><a rel="nofollow" href="<?php echo $this->Url->build(['controller'=>'users','action'=>'forgotPassword']); ?>">Forgot your password?</a></p>
                            <div class="submit">                    
                                <?php echo $this->Form->button("<span>Sign In</span>", array('name' => 'submitcreate2', 'class' => 'view-button', 'type' => 'submit','id'=>'submitcreate2', 'title' => 'Create an account')); ?>
                            </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
            </div>
        </div>
    </div>
<!-- About Area end -->