<?php
	use Cake\Core\Configure;
	use Cake\Routing\Router;
?>
<section class="content-header">
	<h1>Patterns </h1>
 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo __('Add Pattern') ?></h3>
					<div class="box-tools">
						<?php 
							echo $this->Html->link('<i class="fa fa-reply"></i> Back', array('action'=>'index'), array('escape' => false,'class'=>"btn bg-navy btn-xs","title"=>__("Back",true)));
						?>
					</div>
                </div><!-- /.box-header -->
                <?php echo $this->Form->create('pattern', ['type' => 'file']); ?>
				<div class="box-body">
					<div class="form-group">
						<label for="name">Pattern Name<span class="required">*</span></label>
						<?php
							echo $this->Form->control('title', ['placeholder'=>'Pattern Name','label'=>false,'class'=>'form-control','required'=>true]);
						?>
					</div>
					 
					<div class="form-group">
						<label for="Password">Status<span class="required">*</span></label>
						<?php
							$options	=	Configure::read('status');
							echo $this->Form->control('status', ['options'=>$options,'label'=>false,'class'=>'form-control','empty'=>'Select Status','required'=>true]);
						?>
					</div>
				</div><!-- /.box-body -->
				<div class="box-footer"> 
					<?php echo $this->Form->button(__('Submit'),['class'=>'btn btn-primary']); ?>
				</div>
				<?php echo $this->Form->end(); ?>
			</div><!-- /.box -->
		</div>   <!-- /.row -->
	</div>   <!-- /.row -->
</section><!-- /.content -->  
