<?php
	use Cake\Core\Configure;
	use Cake\Routing\Router;
?>
<section class="content-header">
	<h1>Category </h1>
	 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title"><?php echo __('Edit Category'); ?></h3>
					<div class="box-tools">
						<?php 
							echo $this->Html->link('<i class="fa fa-reply"></i> Back', array('action'=>'index'), array('escape' => false,'class'=>"btn bg-navy btn-xs","title"=>__("Back",true)));
						?>
					</div>
                </div><!-- /.box-header -->
                <?php echo $this->Form->create($category, ['type' => 'file']); ?>
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="Parent">Parent Category</label>
								<?php echo $this->Form->control('parent_cat', ['empty'=>'Select Parent Category','options'=>$categoryList,'label'=>false,'class'=>'form-control','required'=>false]); ?> 
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Title">Category Name<span class="required">*</span></label>
								<?php echo $this->Form->control('title', ['placeholder'=>'Category Name','label'=>false,'class'=>'form-control','required'=>true]);?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="description">Description<span class="required">*</span></label>
								<?php echo $this->Form->control('description', ['placeholder'=>'Description','label'=>false,'class'=>'form-control','required'=>true]);?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="meta_title">Meta Title</label>
								<?php echo $this->Form->control('meta_title', ['placeholder'=>'Meta Title','label'=>false,'class'=>'form-control']);?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="meta_tags">Meta Tags</label>
								<?php echo $this->Form->control('meta_tags', ['placeholder'=>'Meta Tags','label'=>false,'class'=>'form-control']);?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="meta_keywords">Meta Keywords</label>
								<?php echo $this->Form->control('meta_keywords', ['placeholder'=>'Meta Keywords','label'=>false,'class'=>'form-control']);?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<?php echo $this->Form->control('image',['type'=>'file']); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Password">Status</label>
								<?php
									$options	=	array(ACTIVE => "Active" , INACTIVE => "Inactive");
									echo $this->Form->control('status',['options'=>$options,'label'=>false,'class'=>'form-control','empty'=>'Select Status']);
								?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="tags">Tags</label>
								<?php echo $this->Form->control('tags', ['placeholder'=>'Tags','label'=>false,'class'=>'form-control']);?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="page_link">Page Link</label>
								<?php echo $this->Form->control('page_link', ['placeholder'=>'Page Link','label'=>false,'class'=>'form-control', "disabled"=>"disabled", "readonly"]);?>
							</div>
						</div>
					</div>
				</div>
				<div class="box-footer"> 
					<?php echo $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</section>