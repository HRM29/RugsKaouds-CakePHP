<?php use Cake\Routing\Router;?>
<?php //echo $this->Html->css(array('../plugins/timepicker/css/bootstrap-timepicker.min.css')) ?>
<section class="content-header">
  <h1>
	Manage <?= $title; ?>
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/brands"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Edit <?= $title; ?></li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title">Edit <?= $title; ?></h3>
                </div><!-- /.box-header -->
                <?= $this->Form->create($data, ['type' => 'file']) ?>
				<div class="box-body">
				    <div class="form-group row">
					    <div class="col-xs-5">
							<label for="Name">Size</label>
							<?= $this->Form->control('size', ['placeholder'=>'Title','label'=>false,'class'=>'form-control']);?>
						</div>
						<div class="col-xs-5">
							<label for="Name">Code</label>
							<?= $this->Form->control('code', ['placeholder'=>'Code','label'=>false,'class'=>'form-control']);?>
						</div>
						<div class="col-xs-5">
							<label for="Password">Status</label>
							<?php $options = array(Active => "Active" , Inactive => "Inactive");?>
							<?= $this->Form->control('status', ['options'=>$options,'label'=>false,'class'=>'form-control','empty'=>'Select Status']);?>
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