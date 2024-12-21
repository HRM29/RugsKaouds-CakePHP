<?php
	use Cake\Core\Configure;
?>
<?php echo $this->element('front/banner'); ?>
<?php echo $this->element('front/category'); ?>
<section id="listing">
	<div class="container">
		<div class="row">
			<?php echo $this->element('front/search_bar');
			?>
			<div class="col-lg-9 col-md-8 col-12">
	<?php	
				$pageCount = $this->Paginator->counter('{{count}}');
				if($pageCount > 0) { ?>
						<div class="row">
							<div class="col-12">
								<h1 class="category-title"><?= $title ?></h1>
								<?php echo $this->element('front/pagination'); ?>
							</div>
						</div>
						<div class="row">
					  <?php if(!empty($result)) {
								foreach($result as $products) { ?>
									<div class="col-lg-4 col-md-6 col-sm-6 col-12">
										<div class="product_box">
											<a href="<?php echo $this->Url->build(['controller'=>'products','action'=>'productView',base64_encode($products->sku_no)]); ?>" title="<?php echo $products->title; ?>" class="recent_view_product" data-id="<?php echo $products->id; ?>">
												<div class="embed-responsive embed-responsive-4by3">
													<!--img class="embed-responsive-item" src="<?php echo $products->product_images[0]->image_url; ?>" alt="<?php echo $products->title; ?>" /-->
													<?php 
        											//$img_src = 'https://shrugs.com/rug_pictures/';	
        											
        											$img_src = 'https://shrugs.com/rug_pictures/overstock_rugs/';
        											
        											$img_no = str_replace("ORC"," ",$products->sku_no );
        											$img_name = "sh".$img_no/9;
        											$inFolder = $this->General->__get_picture_folder($img_name);
        											
        											 
        											//$imgName =  "l_".$img_name." 001.jpg";
        												 
        											//$fileUrl = $img_src.$inFolder."/large/".$imgName;
        											 
        											$imgName =  $img_name." 001.jpg";
							                    	$fileUrl = $img_src.$inFolder."/".$imgName; 
        											  
        											$thumb_imgName =  	$img_name." 001.jpg";
        											$thumbArr = explode('_',$pimg['ProductImage']['image']);	
        											$fileUrlThumb = $img_src.$inFolder.'/thumbs/thumb_'.$thumb_imgName;
        											 
        											if($this->General->remote_file_exists($fileUrl))
        												{
        											?> 
        												<img class="embed-responsive-item" src="<?php echo $fileUrl; ?>" alt="<?php echo $products->title; ?>" />
        											
        											<?php }  ?>
												</div>
												<div class="product_info">
													<h3>
														<?php //echo $this->Html->link($products->sku_no,['controller'=>'products','action'=>'productView',base64_encode($products->sku_no)],['title'=>$products->title,'escape'=>false]); ?>
														<?php echo $products->sku_no; ?>
													</h3>
													<div> 
														<span> <strong> Exact Size: </strong></span>
														<?php echo $products->dimension_1_feet."'".$products->dimension_1_inches.'" x '.$products->dimension_2_feet."'".$products->dimension_2_inches.'"'; ?>
													</div>
													<div class="price">
														<strong>
															<?php echo CURRENCY.number_format($products->selling_price,2); ?>
														</strong> 
														<span>was 
															<strike><?php echo CURRENCY.$products->everyday_price; ?> </strike>
														</span>
													</div>
												</div>
											</a>
										</div>
									</div>
								<?php
								}
							} ?>
						</div>
						<div class="row">
							<div class="col-12">
								<?php echo $this->element('front/pagination'); ?>
							</div>
						</div>
	<?php   	}
				else{
	?>
						<div class="row">
							<h1 class="category-title"><?= $title ?></h1>
								
							<div class="col-12">
								
								<?php echo 'No Record Found.'; ?>
							</div>
						</div>
	<?php					
				}
	?>
			</div>
		</div>
	</div>
</section>
<?php echo $this->element('front/recent_products'); ?>
<script>
	$(document).ready(function() {
		$('.recent_view_product').click(function() {
			var productId	=	$(this).attr('data-id');
			$.ajax({
				url	:	'<?php echo $this->Url->build(['controller'=>'pages','action'=>'getFilterParam']); ?>',
				type:	'POST',
				data:	{product_id: productId},
				success : function(data) {
					console.log(data);
					// return false
				}
				
			});
		});
	});
</script>