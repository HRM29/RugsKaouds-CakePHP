<?php use Cake\Core\Configure;?>
<?php use Cake\Routing\Router;?>
<section class="content-header">
  <h1>
	<?= $title ?> 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active"><?= __('Add '.$title) ?></li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title"><?= __('Add '.$title) ?></h3>
                </div><!-- /.box-header -->
                <?= $this->Form->create($data, ['type' => 'file']) ?>
				<div class="box-body">
					
					<div class="form-group">
						<label for="Password">Country</label>
						<?= $this->Form->control('con_id', ['options'=>$country,'label'=>false,'class'=>'form-control country','empty'=>'Select Country']);?>
					</div>
					
					<div class="form-group">
						<label for="Password">States</label>
						<?= $this->Form->control('sta_id', ['label'=>false,'class'=>'form-control state','empty'=>'Select States']);?>
					</div>
					
					<div class="form-group">
						<label for="Title">City Name</label>
						<?= $this->Form->control('name', ['placeholder'=>'Name','label'=>false,'class'=>'form-control']);?>
					</div>
					
					<div class="form-group">
						<label for="Password">Status</label>
						<?php $options = array(Active => "Active" , Inactive => "Inactive");?>
						<?= $this->Form->control('status', ['options'=>$options,'label'=>false,'class'=>'form-control','empty'=>'Select Status']);?>
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

	/* Get  States LIst by COuntry id  */

	$(".country").change(function () {
		
		var cid = $(this).val();
		var csrfToken = $("[name='_csrfToken']").val();
		if(cid==''){
			location.reload();
		}
		
	
		$.ajax({
			type:'POST',
			data:{_csrfToken:csrfToken,cid:cid},
			url:'<?php echo SITE_URL.'/admin/cities/getstate';?>',
			success:function(data) { 
					var datas = jQuery.parseJSON(data);
					
					var selectoptoon = "<option value=''>Select States</option>";
						$('.state').html(selectoptoon);
						$.each(datas, function( key, value ) {
							var option = '<option value="'+value+'">'+key+'</option>';
							$('.state').append(option);
						}); 
			}
		}); 
	});

</script> 