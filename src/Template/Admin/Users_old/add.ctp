<?php use Cake\Routing\Router;?>
<section class="content-header">
  <h1>
	Users 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add Customer</li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title">Add Customer</h3>
                </div><!-- /.box-header -->
                <?= $this->Form->create($user, ['type' => 'file']) ?>
				<div class="box-body">
					<div class="form-group row">
					    <div class="col-xs-5">
							<label for="Name">Company Name</label>
							<?= $this->Form->control('company_name', ['placeholder'=>'Company Name','label'=>false,'class'=>'form-control']);?>
						</div>
						<div class="col-xs-5">
							<label for="Name">Email</label>
							<?= $this->Form->control('email', ['placeholder'=>'Email','label'=>false,'class'=>'form-control']);?>
						</div>
					</div>
				
				    <div class="form-group row">
					    <div class="col-xs-5">
							<label for="Name">First Name</label>
							<?= $this->Form->control('first_name', ['placeholder'=>'First Name','label'=>false,'class'=>'form-control']);?>
						</div>
						<div class="col-xs-5">
							<label for="Last Name">Last Name</label>
							<?= $this->Form->control('last_name', ['placeholder'=>'Last Name','label'=>false,'class'=>'form-control']);?>
						</div>
					</div>
				
				    <div class="form-group row">
					    <div class="col-xs-5">
							<label for="Name">Phone</label>
							<?= $this->Form->control('phone', ['placeholder'=>'Phone','label'=>false,'class'=>'form-control','onkeypress'=>"return isNumberKey(event)",'maxlength'=>10]);?>
						</div>
						<div class="col-xs-5">
							<label for="Last Name">Gst Number</label>
							<?= $this->Form->control('gstn_number', ['placeholder'=>'Gstn Number','label'=>false,'class'=>'form-control']);?>
						</div>
					</div>
					
					<div class="form-group row">
					    <div class="col-xs-5">
							<label for="Password">Status</label>
							<?php $options = array(Active => "Active" , Inactive => "Inactive");?>
						   <?= $this->Form->control('status', ['options'=>$options,'label'=>false,'class'=>'form-control','empty'=>'Select Status']);?>
						</div>
						<div class="col-xs-5">
							<label for="Last Name">Address</label>
							<?= $this->Form->control('address', ['placeholder'=>'Address','type'=>'textarea','label'=>false,'class'=>'form-control']);?>
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
function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	return true;
}  

</script>