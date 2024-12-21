<?php use Cake\Routing\Router;?>
<section class="content-header">
  <h1>
	<?= $title; ?>
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/index"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add Vehicles</li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title">Add <?= $title; ?></h3>
                </div><!-- /.box-header -->
                <?= $this->Form->create($data, ['type' => 'file']) ?>
				<div class="box-body">
					<div class="form-group row">
					    <div class="col-xs-5">
							<label for="Password">Country</label>
							<?= $this->Form->control('country_id', ['options'=>$country,'label'=>false,'class'=>'form-control','empty'=>'Select Country']);?>
						</div>
						<div class="col-xs-5">
							<label for="Password">Type</label>
							<?php $ty_options = array(1 => "%" , 2 => "amount");?>
							<?= $this->Form->control('type', ['options'=>$ty_options,'label'=>false,'class'=>'form-control sub-typo','empty'=>'Select Type']);?>
						</div>
					</div>
					
					<div class="form-group row">
					    <div class="col-xs-5">
							<label for="Name">Charge</label>
							<?= $this->Form->control('amount', ['placeholder'=>'Charge','label'=>false,'type'=>'text','class'=>'form-control', "onkeypress"=>"return NumericValidation(event)"]);?>
						</div>
						<div class="col-xs-5">
							<label for="Password">Status</label>
							<?php $options = array(Active => "Active" , Inactive => "Inactive");?>
							<?= $this->Form->control('status', ['options'=>$options,'label'=>false,'class'=>'form-control','empty'=>'Select Status','required'=>true]);?>
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

<?php echo $this->Html->script('ckeditor/ckeditor');?>  	
<script type="text/javascript">

    function NumericValidation(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
		//alert(charCode);
		if (charCode > 31 && (charCode < 46 || charCode > 57) )
			return false;

		return true;
    }
	
	$(".sub-typo").change(function(e){  
		e.preventDefault();
		$typo_val = $(this).val();
		
		if($typo_val == 1){
			$('.chargtypo').text('Per Km.');
		}
		else if($typo_val == 2){
			$('.chargtypo').text('Per Hour.');
		}
		else if($typo_val == 3){
			$('.chargtypo').text('Per Day.');
		}
		else{
			$('.chargtypo').text(' ');
		}
		
	});
	
	
	
	
	
	
</script>
	
	
	
	
	