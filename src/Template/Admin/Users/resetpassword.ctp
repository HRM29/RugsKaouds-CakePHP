<?php use Cake\Routing\Router;?>
<div class="login-logo">
	<img src="<?php echo Router::url('/', true); ?>/img/logo.png" alt="Logo" />
</div>
<?php echo $this->Flash->render('positive'); ?>
<div class="login-box-body">
	<div class="control-group normal_text">
		<h3>Reset Password</h3>
	</div>
	<?php echo $this->Form->create('', array('url'=>'/admin/users/resetpassword/'.$id,'type'=>'file', 'admin'=>true, 'class'=>'form-vertical')); ?>
	<div class="form-group has-feedback">
		<?php echo  $this->Form->control('password', ['label' => false,"placeholder"=>"Enter New Password","class"=>"form-control","div"=>false]);?>
		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	</div>
	<div class="form-group has-feedback">
		<?php echo  $this->Form->control('confirm_password', ['type' => 'password','label' => false,"placeholder"=>"Enter Confirm Password","class"=>"form-control","div"=>false]);?>
		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	</div>
	<div class="form-actions">
		<?php echo $this->Form->submit("Update",array("class"=>"btn btn-primary btn-block btn-flat"));?>
	</div>
	<?php echo $this->Form->end() ?>
</div>
<style>
	.header{display:none;}
</style>
<script type="text/javascript">
	$('#password').focus();
</script>