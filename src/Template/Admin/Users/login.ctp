<?php use Cake\Routing\Router;?>
<!-- <style>
	.checkbox label{padding-left:0px;}
</style> -->
<div class="login-logo">
	<img src="<?php echo Router::url('/', true); ?>/img/logo.png" alt="Logo" />
	<p class="logo1-title">The Finest Rugs for the Finest Homes</p>
</div>
<?php echo $this->Flash->render('positive'); ?>
 
<div class="login-box-body">

<?php echo $this->Form->create($user,['url' => ['controller' => 'users', 'action' => 'login'],'novalidate' => true,'id'=>'loginform']);?>
	<p class="login-box-msg">Sign in</p>	
	<div class="form-group has-feedback">
		<?php echo  $this->Form->control('email', ['label' => false,"placeholder"=>"Enter Email Address","class"=>"form-control","div"=>false]);?>
		<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	</div>
	<div class="form-group has-feedback">
		<?php echo  $this->Form->control('password', ['label' => false,"placeholder"=>"Enter Password","class"=>"form-control","div"=>false]);?>
		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	</div>
	<div class="row">
		<div class="col-xs-8">
			<div class="checkbox icheck" style="margin-top: 0;">
				<label>
					<?php echo $this->Form->control('remember_me',array('type'=>'checkbox','label'=>'Remember Me','value'=>'1'))?>
				</label>
			</div>
		</div>
		<!-- /.col -->
		<div class="col-xs-4">
			<?php echo $this->Form->submit("Sign In",array("class"=>"btn btn-primary btn-block btn-flat"));?>
		</div>
		<!-- /.col -->
	</div>
	<a href="#" id="to-recover">Forgot Password?</a><br> 
<?php echo $this->Form->end(); ?>

<?php echo  $this->Form->create($user,array('url'=>'/admin/users/passwordForget/','enctype'=>'multipart/form-data', 'class'=>'form-vertical form-label-left input_mask','id'=>'recoverform')); ?>
 
	<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover password.</p>
	
	<div class="form-group has-feedback">
		<?php echo  $this->Form->control('email', ['label' => false,"placeholder"=>"Enter Email Address","class"=>"form-control","div"=>false]);?>
		<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	</div>
   
	<div class="form-actions">
		<span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login" title="Back to Login">&laquo; Back to login</a></span>
		<span class="pull-right"> 
		<?php echo $this->Form->button("Recover", array('class' => 'btn btn-info', 'type' => 'submit', 'title' => 'Recover')); ?>
		</span>
	</div>
	<div class="clearfix"></div>
	<?php echo $this->Form->end(); ?> 
  
</div><!-- /.login-box-body -->  
<script>
	$(document).ready(function() {
		$("#recoverform").hide();
		$("#to-recover").click(function(){
			$("#recoverform").show();
			$("#loginform").hide();
		});
		
		$("#to-login").click(function(){
			$("#recoverform").hide();
			$("#loginform").show();
		});
		
	});    
</script>