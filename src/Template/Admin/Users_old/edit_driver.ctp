<?php use Cake\Routing\Router;?>
<section class="content-header">
  <h1>
	Driver 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Edit Driver</li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title">Edit Driver</h3>
                </div><!-- /.box-header -->
                <?= $this->Form->create($driver, ['type' => 'file','id'=>'userEditForm']) ?>
				<div class="box-body">
					
				
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
							<label for="Name">Email</label>
							<?= $this->Form->control('email', ['placeholder'=>'Company Name','label'=>false,'class'=>'form-control']);?>
						</div>
						 <div class="col-xs-5">
							<label for="Name">Phone</label>
							<?= $this->Form->control('phone', ['placeholder'=>'Phone','label'=>false,'class'=>'form-control','onkeypress'=>"return isNumberKey(event)",'maxlength'=>10]);?>
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
$("#remove_image").click(function(){
	var id	= $(this).attr('data');
	var csrfToken = $("[name='_csrfToken']").val(); 
	var url = '<?php echo Router::url('/', true) . '/admin/users/remove_image_user'; ?>';
	if(confirm('Are you sure you want to remove avatar?'))
	{
		$.ajax({
			type:'POST',
			data:{id:id,_csrfToken:csrfToken},
			url:url,
			success:function(data) {
				$('#img_grid_upload').empty();
			}
		});
	}
});

function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	return true;
} 

$('#ch_pass').on('click',function(){
	if($(this).is(':checked')){ 
		$('#password').prop('disabled', false);
	}else{
		$('#password').prop('disabled', true);
	} 
});

</script>