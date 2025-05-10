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
			
				<div class="box-header with-border">
					<h1 class="box-title" style="font-size: 30px;"><span>Product List [Total Product : <?=$total;?>][Published : <?=$publishedtotal;?>][Unpublished : <?=$unpublishedtotal;?>]</span></h1>
                </div>
				<div class="box-header with-border">
					<h3 class="box-title">Search  <?= $title; ?></h3>
                </div>
				<?php echo $this->Form->create($Products,array(
						'class' =>'form-horizontal form-label-left',
						'id'=>'demo-form2',
						'inputDefaults' => array(
						'label' => false,
						'div' => false,
						'novalidate' => true
					)));
				?> 
                  <div class="box-body">
                    <div class="col-sm-3">
						<label for="name">Products Title</label> 
						<?= $this->Form->control('title', ['placeholder'=>'Title','label'=>false,'class'=>'form-control','value'=>isset($savesearch['title'])?$savesearch['title']:'','required' => false]);?>
                    </div>
					
					<div class="col-sm-3">
						<label for="name">Products SKU</label> 
						<?= $this->Form->control('sku', ['placeholder'=>'SKU','label'=>false,'class'=>'form-control','value'=>isset($savesearch['sku'])?$savesearch['sku']:'','required' => false]);?>
                    </div>
                    
					<div class="col-sm-3">
						<label for="status">Status</label>
						<?php  
						$status = array(Active => "Active" , Inactive => "Inactive");
						echo $this->Form->control('status_id', ['options' => $status,'label'=>false,'class'=>'form-control','value'=>isset($savesearch['status_id'])?$savesearch['status_id']:'','empty'=>'Select Status']);
						?>
                    </div>
					<div class="col-sm-3">
						<label for="button">&nbsp;</label><br>
						<button type="submit" class="btn btn-primary">Search</button>&nbsp;
						<a href="<?= Router::url('/', true).'/admin/products/clearSearch';?>" class="btn btn-primary clear">Clear</a>
					</div> 
                  </div><!-- /.box-body --> 
                <?php echo $this->Form->end()?>    
			</div>
		</div>
		<div class="col-xs-12">  
		  <div class="box">
			<div class="box-header">
				<h3 class="box-title"><?= $title; ?> List</h3>
			  <div class="box-tools">
					 
                    <?php 
					echo $this->Html->link('<i class="fa fa-plus"></i> Add Product',
					array('controller' => 'Products','action'=>'add'),
					array('escape' => false,'class'=>"btn btn-success btn-sm","title"=>__("Add Product",true))
					);
					?>  
					<?php 
					/* echo $this->Html->link('<i class="fa fa-trash"></i> Delete All',
					array('controller' => 'Products','action'=>'deleteAll'),
					array('escape' => false,'class'=>"btn btn-danger btn-sm btnDeleteAll","title"=>__("Delete Products",true))
					); */ 
					?> 
					<?php 
					/*
					 echo $this->Html->link('<i class="fa fa-trash"></i> Update URL',
					array('controller' => 'Products','action'=>'updateurlall'),
					array('escape' => false,'class'=>"btn btn-danger btn-sm btnDeleteAll","title"=>__("UpdateURL Products",true))
					);  
					*/
					?> 
                     <?php echo $this->Html->link('<i class="fa fa-reply"></i> Back',
					array('controller' => 'users','action'=>'index'),
					array('escape' => false,'class'=>"btn btn-info btn-sm","title"=>__("Back",true))
					);
					?>				  
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
			  <?php // echo $this->Form->create('',['url'=>['action'=>'deleteAll'],'id'=>'listForm']); ?>
			  <?php echo $this->Form->create('',['url'=>['action'=>'updateurlall'],'id'=>'listForm']); ?>
			  <table class="table table-hover"> 
				<tr>
					<th>
						<?php echo $this->Form->control('select_checkbox',array('type'=>"checkbox","label"=>false,'div'=>false,'class'=>"select_checkbox tableflat", "id"=>"select_chkbx")) ; ?>
					</th>
					<th><?php echo 'Image'; ?></th>
							<th><?php echo 'Product Name'; ?></th>
							<th><?php echo 'SKU'; ?></th>
							<th><?php echo 'SQFT'; ?></th>
							<th><?php echo 'Price'; ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
				<?php 
					//echo "<pre>";print_r($Products);
					foreach ($Products as $key => $product): ?>
				<tr>
									<td class="a-center">
										<?php // echo $this->Form->control('user_chk.',array('type'=>"checkbox","label"=>false,'div'=>false,'class'=>"status_checkbox tableflat",'value'=>$product->id)) ; ?>
										<?php echo $this->Form->control('user_chk.',array('type'=>"checkbox","label"=>false,'div'=>false,'class'=>"status_checkbox tableflat",'value'=>$product->sku_no)) ; ?>
										
									</td>
									<!--td><img src="<?php echo $this->General->getProductSingleImages($product->id)->image; ?>" alt="<?php echo $product->title; ?>" style="height:80px;" /></td-->
									<td>
										<!--img src="<?php echo $record->product_images[0]->image_url; ?>" alt="<?php echo $record->title; ?>" style="height:80px;"-->
										<?php 
											$img_src = Router::url('/', true).'uploads/product/';	
											
											$img_name = isset($product->product_images[0]->image)?$product->product_images[0]->image:'';
											
											$sku = $product->sku_no;
											 
											$inFolder = $this->General->__get_picture_folder($sku);
											
											 
											$filePath =  WWW_ROOT . 'uploads' . DS . 'product'.DS.$inFolder.DS.$img_name;
												 
											$fileUrl = $img_src.$inFolder."/".$img_name;
											
											$filePath1 =  WWW_ROOT . 'uploads' . DS . 'product'.DS.$inFolder.DS. str_replace('jpg','JPG',$img_name);
												 
											$fileUr1l = $img_src.$inFolder."/". str_replace('jpg','JPG',$img_name);
											 
											 
											if(file_exists($filePath))
											{
											?> 
												<img src="<?php echo $fileUrl; ?>" alt="<?php echo $record->title; ?>" style="height:80px;" />
											 
											<?php }else if(file_exists($filePath1))
											{
											?> 
												<img src="<?php echo $fileUr1l; ?>" alt="<?php echo $record->title; ?>" style="height:80px;" />
											 
											<?php }else{ ?>
											<img src="<?php echo Router::url('/', true);?>img/no-image.png" alt="<?php echo $product->title; ?>" style="height:80px;" />
											<?php } ?>
									</td>
									<td><?php echo $product->title; ?></td>
									<td><?php echo $product->sku_no; ?></td>
									<td><?php echo $product->total_square_ft; ?></td>
									<td><?php echo number_format($product->everyday_price,2); ?></td>
									<td class="actions">
										<?php 
											echo $this->Html->link('<i class="fa fa-eye"></i> View',
												array('controller' => 'Products','action'=>'view', base64_encode($product->id)),
												array('escape' => false,'class'=>"btn btn-primary btn-xs","title"=>__("View",true)));
										?>
										 <?php 
											echo $this->Html->link('<i class="fa fa-pencil"></i> Edit',
												array('controller' => 'Products','action'=>'edit',base64_encode($product->id)),
												array('escape' => false,'class'=>"btn btn-info btn-xs","title"=>__("Edit",true)));
										?>
										<?php 
											echo $this->Html->link('<i class="fa fa-trash"></i> Delete',
												array('controller' => 'Products','action'=>'delete',base64_encode($product->id)),
												array('escape' => false,'class'=>"btn btn-danger btn-xs","title"=>__("Delete",true),'confirm' => __('Are you sure you want to delete # {0}?', $product->id)));
										?> 
									</td> 
								</tr>
				<?php endforeach; ?> 
			  </table>
			  <?php echo $this->Form->end()?>    
			</div><!-- /.box-body -->
			 
			<div class="box-footer clearfix">
				<div class="col-sm-5">
					<div><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></div>
				</div>
				<div class="col-sm-7">
					  <ul class="pagination pagination-sm no-margin pull-right">
						<?= $this->Paginator->first('<< ' . __('First')) ?>
						<?= $this->Paginator->prev('< ' . __('Previous')) ?>
						<?= $this->Paginator->numbers() ?>
						<?= $this->Paginator->next(__('Next') . ' >') ?>
						<?= $this->Paginator->last(__('Last') . ' >>') ?>
					  </ul>
				</div>
			</div>
		  </div><!-- /.box -->
		</div>
	</div>
</section><!-- /.content --> 
<script>
    $(".clear").click(function(){
		$('#title').val('');
	});
	$(".btnDeleteAll").click(function(e){  
		/*
		e.preventDefault();
		var favorite = [];
		$.each($("input[name='user_chk[]']:checked"), function(){            
			favorite.push($(this).val());
		});
		// alert(favorite); 
		if(favorite.length < 1){
			 alert("Please Select atleast one Products");
		}
		if(confirm('Are you sure you want to delete the selected Products?')){
			if(favorite.length > 0){
				$('#listForm').submit();
			}
		}  
			*/
	});
	$("#select_chkbx").change(function () {
	      $("input:checkbox").prop('checked', $(this).prop("checked"));
	});
	
	 
	
	
</script>
 