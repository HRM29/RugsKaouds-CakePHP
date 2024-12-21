<?php
	use Cake\Core\Configure;
	use Cake\Routing\Router;
?>
<section class="content-header">
	<h1>Colors </h1>
	 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo __('Edit Color'); ?></h3>
					<div class="box-tools">
						<?php 
							echo $this->Html->link('<i class="fa fa-reply"></i> Back', array('action'=>'index'), array('escape' => false,'class'=>"btn bg-navy btn-xs","title"=>__("Back",true)));
						?>
					</div>
                </div><!-- /.box-header -->
                <?php echo $this->Form->create($color, ['type' => 'file']); ?>
				<div class="box-body">
					<div class="form-group">
						<label for="name">Color Name<span class="required">*</span></label>
						<?php
							echo $this->Form->control('name', ['placeholder'=>'Color Name','label'=>false,'class'=>'form-control','required'=>true]);
						?>
					</div>
					<div class="form-group">
						<label for="description">Color Description<span class="required">*</span></label>
						<?php echo $this->Form->control('description', ['placeholder'=>'Description','label'=>false,'class'=>'form-control','required'=>true]); ?>
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
				</div><!-- /.box-body -->

				<div class="box-footer"> 
					<?php echo $this->Form->button(__('Submit'),['class'=>'btn btn-primary']); ?>
				</div>
				<?php echo $this->Form->end(); ?>
			</div><!-- /.box -->
		</div>   <!-- /.row -->
	</div>   <!-- /.row -->
</section><!-- /.content -->  
