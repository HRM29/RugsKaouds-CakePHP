<?php use Cake\Core\Configure;?>
<?php use Cake\Routing\Router;?>
<section class="content-header">
  <h1>
	<?= $title; ?> 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active"><?= __('Edit '.$title) ?></li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title"><?= __('Edit '.$title) ?></h3>
                </div><!-- /.box-header -->
                <?= $this->Form->create($subcategory, ['type' => 'file']) ?>
				<div class="box-body">
					<div class="form-group">
						<label for="Title">Title</label>
						<?= $this->Form->control('title', ['placeholder'=>'Title','label'=>false,'class'=>'form-control']);?>
					</div>
					<div class="form-group">
						<label for="Parent">Parent Node</label>
						<?php $default = 'Select Parent Node';?>
						<?= $this->Form->control('parent_id', ['empty'=>$default,'options'=>$categoryOption,'label'=>false,'class'=>'form-control','required'=>false]);?> 
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<?= $this->Form->control('description', ['placeholder'=>'Description','label'=>false,'class'=>'form-control']);?>
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

</script> 