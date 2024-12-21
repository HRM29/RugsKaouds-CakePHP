<?php use Cake\Routing\Router; ?>
<!-- About Area start -->
<style>
.forgot-password-form{
	max-width: 430px;
    margin: 0 auto;
}
.forgot-password-form h2 {
    font-size: 18px;
    margin-bottom: 20px;
}
.forgot-password-form2{
    background: #fbfbfb none repeat scroll 0 0;
    border: 1px solid #d6d4d4;
    line-height: 20px;
    padding: 14px 18px 20px;
}
</style>
    <div class="login-account-area section-padding">
        <div class="container height30">
            <div class="row forgot-password">
                <div class="account-details forgot-password-form">
                    
						<?= $this->Flash->render('positive_forgot') ?>
                         <?php echo $this->Form->create($user,['url' => ['controller' => 'users', 'action' => 'forgotpassword'],'class'=>'forgot-password-form2','id'=>'loginform']); ?>
						 <h2>Forgot Password</h2>
                            <div class="form-row">
                                <?php echo  $this->Form->control('email', ['label' => false,"placeholder"=>"Enter Email Address","class"=>"form-control","div"=>false]); ?>
                            </div>
                            <div class="submit">                    
                                <?php echo $this->Form->button("<span>send link</span>", array('name' => 'submitcreate2', 'class' => 'view-button', 'type' => 'submit','id'=>'submitcreate2', 'title' => 'send link')); ?>
                            </div>
                        <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
<!-- About Area end -->