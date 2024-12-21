<?php
	use Cake\Core\Configure;
	use Cake\Routing\Router;
?>
<section class="content-header">
	<h1>Dimensions </h1>
 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo __('Edit Dimension'); ?></h3>
					<div class="box-tools">
						<?php 
							echo $this->Html->link('<i class="fa fa-reply"></i> Back', array('action'=>'index'), array('escape' => false,'class'=>"btn bg-navy btn-xs","title"=>__("Back",true)));
						?>
					</div>
                </div><!-- /.box-header -->
                <?= $this->Form->create($dimension, ['type' => 'file']); ?>
				<div class="box-body">
					<div class="form-group">
						<label for="type">Dimension Type<span class="required">*</span></label>
						<?php
							$options	=	Configure::read('size.type');
							echo $this->Form->control('type', ['options'=>$options,'empty'=>'Select Dimensions Type','label'=>false,'class'=>'form-control','required'=>true]);
						?>
					</div>
					<div class="form-group">
						<label for="Title">Dimension Size<span class="required">*</span></label>
						<?php echo $this->Form->control('title', ['placeholder'=>'Dimension Size','label'=>false,'class'=>'form-control','required'=>true]); ?>
					</div>
					<div class="form-group custome_checkbox">
						<label for="is_large_runner">Is Large Runner</label>
						<?php echo $this->Form->control('is_large_runner',array('type'=>"checkbox",'label'=>false,'div'=>false,'class'=>"is_large_runner ")); ?>
					</div>
					<div class="form-group">
						<label for="description">Dimension Description<span class="required">*</span></label>
						<?php echo $this->Form->control('description', ['placeholder'=>'Dimension Description','label'=>false,'class'=>'form-control','required'=>true]); ?>
					</div>
					<div class="form-group">
						<label for="meta_title">Meta Title</label>
						<?php echo $this->Form->control('meta_title', ['placeholder'=>'Meta Title','label'=>false,'class'=>'form-control']); ?>
					</div>
					<div class="form-group">
						<label for="meta_tags">Meta Tags</label>
						<?php echo $this->Form->control('meta_tags', ['placeholder'=>'Meta Tags','label'=>false,'class'=>'form-control']); ?>
					</div>
					<div class="form-group">
						<label for="meta_keywords">Meta Keywords</label>
						<?php echo $this->Form->control('meta_keywords', ['placeholder'=>'Meta Keywords','label'=>false,'class'=>'form-control']); ?>
					</div>
					<div class="form-group">
						<label for="Password">Status<span class="required">*</span></label>
						<?php
							$options	=	Configure::read('status');
							echo $this->Form->control('status', ['options'=>$options,'label'=>false,'class'=>'form-control','empty'=>'Select Status','required'=>true]);
						?>
					</div> 
				</div>
				<div class="box-footer"> 
					<?php echo $this->Form->button(__('Submit'),['class'=>'btn btn-primary']); ?>
				</div>
				<?php echo $this->Form->end(); ?>
			</div><!-- /.box -->
		</div>   <!-- /.row -->
	</div>   <!-- /.row -->
</section><!-- /.content -->  
