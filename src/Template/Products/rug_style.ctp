<?php
	use Cake\Core\Configure;
?>
<section id="listing" class="shop-list section-padding">
	<div class="container-fluid">
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
							</div>
						</div>
						
						
						<div class="row no-gutters">
				  <?php
				  if(count($result) > 0){
				  foreach($result as $data){?>
				  <div class="col-md-4 col-6">
                     <div class="product-detail" style="padding:15px 10px !important;">
						<a href="<?php echo $this->Url->build(['controller'=>'products','action'=>'productView',base64_encode($data->sku_no)]); ?>" title="<?php echo $data->title; ?>" class="recent_view_product" data-id="<?php echo $data->id; ?>">
				<?php 
					$img_src = 'https://shrugs.com/rug_pictures/';	
					
					$img_no = str_replace("GOR"," ",$data->sku_no );
					$img_name = "sh".$img_no/7;
					$inFolder = $this->General->__get_picture_folder($img_name);
					
					 
					$imgName =  $img_name." 001.jpg";
						 
					$fileUrl = $img_src."overstock_rugs/".$inFolder."/".$imgName;
					$thumb_imgName =  	$img_name." 001.jpg";
					$thumbArr = explode('_',$pimg['ProductImage']['image']);	
					$fileUrlThumb = $img_src.$inFolder.'/thumbs/thumb_'.$thumb_imgName;
					 
					if($this->General->remote_file_exists($fileUrl))
						{
					?> 
						<img src="<?php echo $fileUrl; ?>" alt="<?php echo $data->title; ?>" />
					 
					<?php }else{
					?>
					<img src="<?php echo $this->General->getProductSingleImages($data->id)->image; ?>" alt="<?php echo $data->title; ?>" />
					<?php
					}?>
					<p>Size: <?php echo $data->dimension_1_feet."'".$data->dimension_1_inches.'" X '.$data->dimension_2_feet."'".$data->dimension_2_inches.'"'; ?></p>
				<!--div class="product_info">
					<h3><?= $data->sku_no;?></h3>
					<div class="exact-size"><span> <strong> Exact Size: </strong></span><?php echo $data->dimension_1_feet."'".$data->dimension_1_inches.'" X '.$data->dimension_2_feet."'".$data->dimension_2_inches.'"'; ?></div>
					<div class="price">
						<strong>$<?= $data->selling_price;?></strong> <span>was <strike>$<?= $data->everyday_price;?> </strike></span>
					</div>
				</div--></a> </div></div>
				  <?php }}else{
						echo "No record Found!";
					}?>
                  </div>
						
						<div class="row">
							<div class="col-12">
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
	<div class=" row shop-head shop-head-bottom">
                     <h2><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></h2>   
                     <div class="  float-right ">
                        <nav>
                     <ul class="pagination justify-content-center mt-2 mr-2">
						<?= $this->Paginator->first(('First')) ?>
						<?= $this->Paginator->prev(('Previous')) ?>
						<?= $this->Paginator->numbers() ?>
						<?= $this->Paginator->next(('Next')) ?>
						<?= $this->Paginator->last(('Last')) ?>
                        <!--li class="page-item disabled">
                           <span class="page-link"><  Previous</span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active">
                           <span class="page-link">
                           2
                           <span class="sr-only">(current)</span>
                           </span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                           <a class="page-link" href="#">Next  > </a>
                        </li-->
                     </ul>
                  </nav>
                        </div>
                     </div>
			</div>
		</div>
	</div>
</section>
<script>
	$(document).ready(function() {
		
		var selectd = '<?php echo $title; ?>';
		$("input[name='collections'][value='"+selectd+"'").prop('checked', true);
		
		$('.recent_view_product').click(function() {
			var productId	=	$(this).attr('data-id');
			$.ajax({
				url	:	'<?php echo $this->Url->build(['controller'=>'products','action'=>'updateRecentView']); ?>',
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