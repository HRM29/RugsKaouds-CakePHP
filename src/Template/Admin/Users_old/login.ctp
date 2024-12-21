<style> 
.checkbox label {
    padding-left: 11px !important;
}
</style>
<?php 
use Cake\Routing\Router;
use Cake\Core\Configure;
?>
<style>
.checkbox label{padding-left:0px;}
</style>


	<div class="login-box">


		<!--div class="login-logo">
			<a href="../../index2.html"><b><?php echo Configure::read('App.meta'); ?></b></a>
			<!--img src="<?php echo Router::url('/', true); ?>img/dummy.png" alt="<?php echo Configure::read('App.meta'); ?>" class="logo-default" style="margin-top:0px; max-height:60px; line-height:60px;"-->
			<!--img src="<?php //echo Router::url('/', true); ?>img/logo.jpg" alt="Logo" width= "50%" height="50%"/-->
		</div-->
		<?php echo $this->Flash->render('positive'); ?>
		 
		<div class="login-box-body" style = "background: #fefefe;">

		<?php echo $this->Form->create($user,['url' => ['controller' => 'users', 'action' => 'login'],'novalidate' => true,'id'=>'loginform']);?>
			<!--p class="login-box-msg">Login to your account</p-->
			<div class="login-logo">
			
			<!--img src="<?php echo Router::url('/', true); ?>img/CLlogo3.png" alt="<?php echo Configure::read('App.meta'); ?>" class="logo-default" style="margin-top:0px; max-height:60px; line-height:60px;"-->
			<b> <?= Configure::read('App.meta') ?> </b>
			</div>
		
			<div class="form-group has-feedback">
				<?php echo  $this->Form->control('email', ['label' => false,"placeholder"=>"Username","class"=>"form-control","div"=>false]);?>
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<?php echo  $this->Form->control('password', ['label' => false,"placeholder"=>"Password","class"=>"form-control","div"=>false]);?>
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<div class="checkbox icheck">
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
			<a href="javascript:void(0)" id="to-recover">Forgot Password?</a><br> 
		<?php echo $this->Form->end(); ?>

		<?php echo  $this->Form->create($user,array('url'=>'/admin/users/passwordForget/','enctype'=>'multipart/form-data', 'class'=>'form-vertical form-label-left input_mask','id'=>'recoverform')); ?>
		 
			<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover password.</p>
			
			<div class="form-group has-feedback">
				<?php echo  $this->Form->control('email', ['label' => false,"placeholder"=>"Enter Email Address","class"=>"form-control","div"=>false]);?>
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
		   
			<div class="form-actions">
				<span class="pull-left"><a href="javascript:void(0)" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
				<span class="pull-right"> 
				<?php echo $this->Form->button("Recover", array('class' => 'btn btn-info', 'type' => 'submit', 'title' => 'Recover')); ?>
				</span>
			</div>
			<div class="clearfix"></div>
		<?php echo $this->Form->end() ?> 
		  
		</div><!-- /.login-box-body -->  

	</div>



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