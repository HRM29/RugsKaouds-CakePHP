<?php

use Cake\Core\Configure; ?>
<?php

use Cake\Routing\Router; ?>
<section class="content-header">
	<h1>Collections </h1>

</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><?= __('Edit Collection'); ?></h3>
					<div class="box-tools">
						<?php
						echo $this->Html->link('<i class="fa fa-reply"></i> Back', array('action' => 'index'), array('escape' => false, 'class' => "btn bg-navy btn-xs", "title" => __("Back", true)));
						?>
					</div>
				</div><!-- /.box-header -->
				<?php
					echo "<pre>collection: ";print_r($collection);echo "</pre>";
				?>
				<?php echo $this->Form->create($collection, ['type' => 'file']); ?>
				<div class="box-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="collection-type">Collection Type<span class="required">*</span></label>
								<?php
								if ($collection->collection_type == 'category') {
									$collectionTypes = ['category' => 'Category'];
								} else {
									$collectionTypes = ['page' => 'Page'];
								}
								?>
								<?php echo $this->Form->control('collection-type', ['options' => $collectionTypes, 'label' => false, 'class' => 'form-control', 'required' => true, 'value' => $collection->collection_type]); ?>
							</div>
						</div>
						<div class="col-md-6 page-input">
							<div class="form-group">
								<label for="collection-type">Collection Category</label>
								<?php $collectionTypes = $collCategoryList ?>
								<?php echo $this->Form->control('collection-category', ['options' => $collectionTypes, 'label' => false, 'class' => 'form-control', 'required' => false, 'empty' => ['0' => 'Select a Category'], 'value' => $collection->parent_id]); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="collection-title">Category Name<span class="required">*</span></label>
								<?php echo $this->Form->control('title', ['placeholder' => 'Category Name', 'label' => false, 'class' => 'form-control', 'required' => true]); ?>
							</div>
						</div>
						<div class="col-md-6 page-input">
							<div class="form-group">
								<label for="page_link">Page Slug<span class="required">*</span></label>
								<?php echo $this->Form->control('page_slug', ['placeholder' => 'Page Link', 'label' => false, 'class' => 'form-control', 'value' => $collection->page_url, 'disabled']); ?>
							</div>
						</div>
						<div class="col-md-6 page-input">
							<div class="form-group">
								<label for="meta_title">Meta Title</label>
								<?php echo $this->Form->control('meta_title', ['placeholder' => 'Meta Title', 'label' => false, 'class' => 'form-control', 'value' => $collection->meta_title]); ?>
							</div>
						</div>
						<div class="col-md-6 page-input">
							<div class="form-group">
								<label for="meta_tags">Meta Description</label>
								<?php echo $this->Form->control('meta_description', ['placeholder' => 'Meta Description', 'label' => false, 'class' => 'form-control', 'escape' => false ,'value' => $collection->meta_tags]); ?>
							</div>
						</div>
						<div class="col-md-6 page-input">
							<div class="form-group">
								<label for="meta_keywords">Meta Keywords</label>
								<?php echo $this->Form->control('meta_keywords', ['placeholder' => 'Meta Keywords', 'label' => false, 'class' => 'form-control', 'value' => $collection->meta_keywords]); ?>
							</div>
						</div>
						<div class="col-md-6 page-input">
							<div class="form-group">
								<?php echo $this->Form->control('image', ['type' => 'file']); ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="Password">Status</label>
								<?php
								$options = array(ACTIVE => "Active", INACTIVE => "Inactive");
								echo $this->Form->control('status', ['options' => $options, 'label' => false, 'class' => 'form-control']);
								?>
							</div>
						</div>

					</div>
				</div>
				<div class="box-footer">
					<?php echo $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</section>

<script>
	setCollectionType();

	function setCollectionType() {
		const collectionType = document.getElementById('collection-type');
		const collectionTitle = document.querySelector('label[for="collection-title"]');
		const collectionTitleInput = document.querySelector('#title');

		if (collectionType) {
			const categoryInputs = document.querySelectorAll('.category-input');
			const pageInputs = document.querySelectorAll('.page-input');

			function toggleInputs(value) {
				if (value === 'category') {
					const titleLabel = "Category Name";
					collectionTitle.firstChild.nodeValue = titleLabel;
					collectionTitleInput.setAttribute('placeholder', titleLabel);
					categoryInputs.forEach(element => element.style.display = 'block');
					pageInputs.forEach(element => element.style.display = 'none');
					setPageElements(false);
				} else if (value === 'page') {
					const titleLabel = "Page Name";
					collectionTitle.firstChild.nodeValue = titleLabel;
					collectionTitleInput.setAttribute('placeholder', titleLabel);
					pageInputs.forEach(element => element.style.display = 'block');
					categoryInputs.forEach(element => element.style.display = 'none');
					setPageElements(true);
				} else if (value == '') {
					categoryInputs.forEach(element => element.style.display = 'none');
					pageInputs.forEach(element => element.style.display = 'none');
				}
			}

			toggleInputs(collectionType.value);

			collectionType.addEventListener('change', function() {
				toggleInputs(collectionType.value);
			});
		}
	}

	function setPageElements(status) {
		const collectionCategoryEle = document.getElementById('collection-category');
		toggleElementAttributes(collectionCategoryEle, false, status)
		const pageLinkEle = document.getElementById('page-link');
		toggleElementAttributes(pageLinkEle, status, status)
	}

	function toggleElementAttributes(element, isRequired, isDisabled) {
		// Set the 'required' attribute
		if (isRequired) {
			element.setAttribute('required', 'required');
		} else {
			element.removeAttribute('required');
		}

		// Set the 'disabled' attribute
		if (isDisabled) {
			element.removeAttribute('disabled');
		} else {
			element.setAttribute('disabled', 'disabled');
		}
	}
</script>