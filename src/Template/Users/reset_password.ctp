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
        <div class="container">
            <div class="row forgot-password">
                <div class="account-details forgot-password-form">
                    <?= $this->Flash->render('positive_reset') ?>	
						<?= $this->Form->create(false,['url'=>['controller'=>'Users','action'=>'resetPassword',$initial_id],'class'=>'forgot-password-form2','id'=>'loginform']);?>
							  <h2>Forgot Password</h2>
			  				<div class="form-row">
			  				<?= $this->form->control('password',['div'=>false,'label'=>false,'placeholder'=>'Enter Your Password','class'=>'form-control']);?>
							</div>		 
							<div class="form-row">
			  				<?= $this->form->control('password2',['div'=>false,'type'=>'password','label'=>false,'placeholder'=>'Confirm Your Password','class'=>'form-control']);?>
							</div>
							 
			  				<div class="submit">
						  		<?php echo $this->Form->button("<span>Reset Password</span>", array('name' => 'submitcreate2', 'class' => '', 'type' => 'submit','id'=>'submitcreate2', 'title' => 'Reset Password')); ?>
								
						  	</div>
					  	<?= $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
<!-- About Area end -->
 