<?php use Cake\Core\Configure;?>
<?php use Cake\Routing\Router;?> 
<style>
.checkbox{margin-top:5px !important;}
.select_checkbox,.status_checkbox{margin:0px !important;}
</style>
<section class="content-header">
  <h1>
	<?= __($title) ?> 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/products"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active"><?= $title.'List' ?></li>
  </ol>
  <?= $this->Flash->render('positive') ?>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<!-- <div class="box-header with-border">
					<h1 class="box-title" style="font-size: 30px;"><span>Import CSV File</span></h1>
                </div> -->
				<div class="box-header with-border">
					<h3 class="box-title">Import CSV File</h3>
                </div>
				<?php echo $this->Form->create('',array(
						'type'=>'file',
						'class' =>'form-horizontal form-label-left',
						'id'=>'demo-form2',
						'inputDefaults' => array(
						'label' => false,
						'div' => false,
						'novalidate' => true,
						'enctype' => 'multipart/form-data'
					)));
				?> 
                  <div class="box-body">
                    <div class="col-sm-3">
						<label for="name">Browse CSV File</label> 
						<?= $this->Form->control('product_csv', ['type'=>'file','placeholder'=>'Browse CSV File','label'=>false,'class'=>'form-control','required' => false]);?>
                    </div>
					<div class="col-sm-3">
						<label for="button">&nbsp;</label><br>
						<button type="submit" class="btn btn-primary">Import</button>
					</div> 
                  </div>
            <?php 
                echo $this->Form->end(); 

                if(!empty($successMessage) && $successMessage['status']==1){
                	echo '<h4 class="text-primary">Saved Row: '.$successMessage['saved_count'].'</h4>';
                	echo '<h3 class="text-danger">Not Saved Row: '.$successMessage['notsaved_count'].'</h3>';
                	echo '<div class="error-scroll">';
                	foreach ($successMessage['not_saved_list'] as $value) {
                		echo '<p class="text-danger">Error row number: '.$value['row_number'].', Error: '.$value['error'].'</p>';
                	}
                	echo '</div>';
                }
                if(!empty($successMessage) && $successMessage['status']==0){
                	echo '<h4 class="text-danger">Error: '.$successMessage['message'].'</h4>';
                }
            ?>    
			</div>
		</div>
	</div>
</section><!-- /.content --> 

<style>
	.error-scroll{
		max-height: 350px;
		overflow-y: auto;
		border: 1px solid #ccc;
    	padding: 10px;
	}
</style>
 