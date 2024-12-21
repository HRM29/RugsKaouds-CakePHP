<?php use Cake\Routing\Router;?> 
<section class="content-header">
  <h1>
	<?= $title; ?> 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active"><?= $title; ?> Detail</li>
  </ol> 
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header with-border">
					
                </div><!-- /.box-header -->
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo 'View '.(!empty($result->title) ? $result->title : 'Product'); ?></h3>
					<div class="box-tools">
						<?php 
							echo $this->Html->link('<i class="fa fa-reply"></i> Back', array('action'=>'index'), array('escape' => false,'class'=>"btn bg-navy btn-xs","title"=>__("Back",true)));
						?>
					</div>
                </div><!-- /.box-header -->
				<div class="box-body table-responsive">
					<div class="col-md-12">
						<div class="box box-success">
							<div class="box-header with-border">
								<h3 class="box-title">Product Images</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body" style="display: block;">
								<a href="javascript:void()">
								 	 
									<?php 
									$imagesArr = $result->product_images;
									$img_src = Router::url('/', true).'uploads/product/';  
									$i = 'active';
									
									$sku = $result->sku_no;
											 
									$inFolder = $this->General->__get_picture_folder($sku);
								 
									if(!empty($imagesArr)) 
									{
										foreach($imagesArr as $imgs){
										 
										 
											$filePath1 =  WWW_ROOT . 'uploads' . DS . 'product'.DS.$inFolder.DS.$imgs->image;
									 
											$fileUrl1 = $img_src.$inFolder."/".$imgs->image;
											
											$filePath12 =  WWW_ROOT . 'uploads' . DS . 'product'.DS.$inFolder.DS. str_replace('jpg','JPG',$imgs->image);
									 
										     $fileUrl12 = $img_src.$inFolder."/". str_replace('jpg','JPG',$imgs->image);
										 
											if(file_exists($filePath1))
											{
									?>
												<img src="<?php echo $fileUrl1; ?>" alt='<?php echo $imgs->image; ?>'  style="height:80px;" /> 
										
									<?php  
											}else if(file_exists($filePath12)){ 
									?>
												<img src="<?php echo $fileUrl12; ?>" alt='<?php echo $imgs->image; ?>'  style="height:80px;" /> 
									<?php
											}
										}
									}   
									?>
									
								</a>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title">Product Details</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body" style="display: block;">
								<table class="table table-hover table-condensed">
									<tr>
										<th>SKU</th>
										<td><?php echo !empty($result->sku_no) ? $result->sku_no : ''; ?></td>
									</tr>
									<tr>
										<th>Product Name</th>
										<td><?php echo !empty($result->title) ? $result->title : ''; ?></td>
									</tr>
									<tr>
										<th>Rug Type</th>
										<td><?php echo !empty($result->rug_type) ? $result->rug_type : ''; ?></td>
									</tr>
									<tr>
										<th>Age</th>
										<td><?php echo !empty($result->age) ? $result->age : ''; ?></td>
									</tr>
									<tr>
										<th>Border Color</th>
										<td><?php echo !empty($result->border_color) ? $result->border_color : 'No Border'; ?></td>
									</tr>
									<tr>
										<th>Color</th>
										<td><?= $this->General->getColor($result->color_id);?></td>
									</tr>
									<tr>
										<th>Exact Field Color</th>
										<td><?= $result->field_color_exact?></td>
									</tr>
									<tr>
										<th>Other Color</th>
										<td>
										
										<?php
										echo $result->other_colors;
										/*  $Otherscolors = $this->General->getOtherColorName($result->other_colors);
										$color_coma_sep = implode(',', $Otherscolors);
										echo $color_coma_sep; */
										?>
									</tr>
									<tr>
										<th>Foundation</th>
										<td><?= $this->General->getFoundation($result->foundation_id);?></td>
									</tr>
									<tr>
										<th>Pile</th>
										<td><?= $this->General->getPile($result->pile_id);?></td>
									</tr>
									<tr>
										<th>Pattern</th>
										<td><?= $result->pattern;?></td>
									</tr>
									<tr>
										<th>Design</th>
										<td><?= $result->rug_design;?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">&nbsp;</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="box-body" style="display: block;">
								<table class="table table-hover table-condensed">
									<tr>
										<th>Exact Size</th>
										<td>
											<?php echo $result->dimension_1_feet."'".$result->dimension_1_inches.'" X '.$result->dimension_2_feet."'".$result->dimension_2_inches.'"'; ?>
										</td>
									</tr>
									<tr>
										<th>Selling Price</th>
										<td>
											<?php echo CURRENCY.(!empty($result->selling_price) ? number_format($result->selling_price,2) : '0'); ?>
										</td>
									</tr>
									<tr>
										<th>Old Price</th>
										<td>
											<?php echo CURRENCY.(!empty($result->everyday_price) ? number_format($result->everyday_price,2) : '0'); ?>
										</td>
									</tr>
									<tr>
										<th>Rugpad Price</th>
										<td>
											<?php echo CURRENCY.(!empty($result->rug_pad) ? number_format($result->rug_pad,2) : '0'); ?>
										</td>
									</tr>
									<tr>
										<th>Total Square Feet</th>
										<td>
											<?php echo (!empty($result->total_square_ft) ? number_format($result->total_square_ft,2) : '0'); ?>
										</td>
									</tr>
									<tr>
										<th>Shipping Rate</th>
										<td>
											<?php echo CURRENCY.(!empty($result->shipping_price) ? number_format($result->shipping_price,2) : '0'); ?>
										</td>
									</tr>
									<tr>
										<th>Primary Category</th>
										<td><?= $this->General->getCategory($result->category_id);?></td>
									</tr>
									<tr>
										<th>Secondary Category</th>
										<td>
											<?php 
												if(!empty($result->sub_category)) {
													echo $this->General->getSubCategories($result->sub_category);
												}
											?>
										</td>
									</tr>
									<tr>
										<th>Rug Style</th>
										<td><?php echo !empty($result->style) ? ucfirst($result->style) : ''; ?></td>
									</tr>
									<tr>
										<th>Available Shape</th>
										<td><?php echo !empty($result->available_shape) ? ucfirst($result->available_shape) : ''; ?></td>
									</tr>
									<tr>
										<th>Material</th>
										<td><?php echo !empty($result->material) ? ucfirst($result->material) : ''; ?></td>
									</tr>
									<tr>
										<th>Location</th>
										<td><?php echo !empty($result->location) ? ucfirst($result->location) : ''; ?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
</section><!-- /.content -->  
<style> 

.form-group.multi_image {
    width: 100%;
}

.form-group.multi_image ul {
    margin: 0;
    padding:  0;
    list-style: none;
    display: inline-block;
    width: 100%;
}

.form-group.multi_image ul li {
    display: inline-block;
    float: left;
    padding: 3px;
    border: 1px solid #ccc;
    margin: 1% .5%;
    width: 15.5%;
    text-align: center;
    font-weight: 600;
}

.control-group.multi_image ul li a#remove_image {
    display: inline-block;
    width: 100%;
}

.control-group.multi_image ul li img {
    display: block;
    width: auto;
    height: 100px;
    margin: auto;
}

</style>