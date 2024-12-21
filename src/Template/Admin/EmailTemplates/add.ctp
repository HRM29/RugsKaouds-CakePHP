<?php use Cake\Routing\Router;?>
<section class="content-header">
  <h1>
	EmailTemplates 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add EmailTemplates</li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title">Add EmailTemplate</h3>
                </div><!-- /.box-header -->
                <?= $this->Form->create($EmailTemplate, ['type' => 'file']) ?>
				<div class="box-body">
					<div class="form-group">
						<label for="Name">Name</label>
						<?= $this->Form->control('name', ['placeholder'=>'Name','label'=>false,'class'=>'form-control']);?>
					</div>
					
					<div class="form-group">
						<label for="Fund Amount">Subject</label>
						<?= $this->Form->control('subject', ['type'=>'text','placeholder'=>'Subject','label'=>false,'class'=>'form-control']);?>
					</div> 
				 
					<div class="form-group">
						<label for="Status">Status</label>
						<?php $options = array(Active => "Active" , Inactive => "Inactive");?>
						<?= $this->Form->control('status', ['options'=>$options,'label'=>false,'class'=>'form-control','empty'=>'Select Status']);?>
					</div>
						 
					
					<div class="form-group">
						<label for="project Description">Description</label>
						<?= $this->Form->control('description', ['placeholder'=>'Description','type'=>'textarea','label'=>false,'class'=>'form-control ckeditor']);?>
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
<script>
function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode;
 
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	return true;
}  

</script>