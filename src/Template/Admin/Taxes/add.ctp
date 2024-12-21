<?php use Cake\Routing\Router;?>
<section class="content-header">
  <h1>
	Taxes
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/taxes"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add Tax</li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title">Add Tax</h3>
                </div><!-- /.box-header -->
                <?= $this->Form->create($taxes, ['type' => 'file']) ?>
				<div class="box-body">
				    <div class="form-group row">
					    <div class="col-xs-5">
							<label for="Name">Tax</label>
							<?= $this->Form->control('title', ['placeholder'=>'Tax Name','label'=>false,'class'=>'form-control']);?>
						</div>
						
						<div class="col-xs-5">
							<label for="Password">Type</label>
							<?php $Re_options = array(1 => "Fixed" , 2 => "Percentage");?>
							<?= $this->Form->control('type', ['options'=>$Re_options,'label'=>false,'class'=>'form-control','empty'=>'Select Type']);?>
						</div>
					</div>
					
					<div class="form-group row">
					    <div class="col-xs-5">
							<label for="Name">Amount</label>
							<?= $this->Form->control('amount', ['placeholder'=>'Amount','label'=>false,'type'=>'text','class'=>'form-control', "onkeypress"=>"return NumericValidation(event)"]);?>
						</div>
						
						<div class="col-xs-5">
							<label for="Password">Status</label>
							<?php $options = array(Active => "Active" , Inactive => "Inactive");?>
							<?= $this->Form->control('status', ['options'=>$options,'label'=>false,'class'=>'form-control','empty'=>'Select Status']);?>
					    </div>  
					</div>
					<div class="form-group row">
					    <div class="col-xs-5">
							<label for="Name">Descriptions</label>
							<?= $this->Form->control('descriptions', ['placeholder'=>'Descriptions','label'=>false,'type'=>'textarea','class'=>'form-control']);?>
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
	function NumericValidation(e) {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if (unicode != 8) {
            if ((unicode < 48 || unicode > 57) && unicode != 46) {
                return false;
            }
        }
    }

	function clear_form_elements(jquery_obj) {
	  jquery_obj.find(':input').each(function() {
		$(this).timepicker({
			  showInputs: false
		});
		/* $(this).timepicker({
			  showInputs: false
		});  */
		switch(this.type){
			case 'password':
			case 'text':
			case 'number':
			case 'textarea':
			case 'file':      
				$(this).attr("value","");
				break;
			case 'select-one':
				$(this).find("option").each(function (){
					$(this).attr("selected",false);
				});
				break;
			case 'checkbox':
			case 'radio':
				this.checked = false;
		}
	  });
	}

</script>