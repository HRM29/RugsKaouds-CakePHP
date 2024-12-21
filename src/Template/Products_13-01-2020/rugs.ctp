<?php
use Cake\Routing\Router;
use Cake\Core\Configure;
?> 
<section class="shop-list section-padding">
         <div class="container">
            <div class="row">
			
			<?php echo $this->element('front/search_bar'); ?>
               
               <div class="col-md-9">
                  <h1 class="rugs-headding"><?= $title ?></h5>
                  <!--div class="shop-head">
                     <h2> There are <?= count($result); ?> products</h2>   
                     <div class="  float-right " style="display: none;">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort by Products &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                           <a class="dropdown-item" href="#">Relevance</a>
                           <a class="dropdown-item" href="#">Price (Low to High)</a>
                           <a class="dropdown-item" href="#">Price (High to Low)</a>
                           <a class="dropdown-item" href="#">Discount (High to Low)</a>
                           <a class="dropdown-item" href="#">Name (A to Z)</a>
                        </div>
                     </div>
                  
                  </div-->
                  <div class="rugs-tab" <?php if(count($result) == 0){?> style="display:none;" <?php } ?>>
					  <a href="#">Active Filters</a>
					  <div style="text-align:left" id="filter-tags-region" class = "tag-add">	
					  </div>
				  </div>
                  <div class="row no-gutters">
				  <?php
					if(count($result) > 0){
				  foreach($result as $data){?>
				  <div class="col-md-4 col-6">
                     <div class="product-detail" style="padding:15px 10px !important;">
						<a href="<?php echo $this->Url->build(['controller'=>'products','action'=>'productView',base64_encode($data->sku_no)]); ?>">
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
                  <div class="shop-head shop-head-bottom">
                     <h2><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></h2>   
                     <div class="shop-bottom-section">
                        <nav>
                     <ul class="pagination justify-content-center">
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
         </div>
      </section>
	  <script type="text/javascript" src="http://code.jquery.com/jquery-1.4.3.min.js" ></script>
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
	
	$( document ).ready(function() {
		$('input[class="filtercheckbox"]:checked').each(function() {
			var val = $(this).attr('data_val');
			var typ = $(this).attr('data_typ');
			//alert(typ);
			//var newtag = '<div class="filter-tag beige" id="search_beige">'+ typ+' '+val.toUpperCase()+'</div>';
			var newtag = '<a class="filter-tag beige" id="search_beige" style="color: #fff !important;">'+ typ+' '+val.toUpperCase()+'</a>';
		
			$(".tag-add").append(newtag);
		});
		// var price_min = $('#price_min').val();
		// var price_max = $('#price_max').val();
		// var typ = 'Price';
		// if(price_min != "" || price_max != ""){
		// 	var newtag = '<a class="filter-tag beige" id="search_beige" style="color: #fff !important;">'+ typ+' '+price_min+'-'+price_max+'</a>';
		// 	$(".tag-add").append(newtag);
		// }
		let specialSize = $("input[name='speceialSize']").val();
		if(specialSize != ""){
			var specialSize_typ = $("input[name='speceialSize']").attr('data_typ');
			var newtag2 = '<a class="filter-tag beige" id="search_beige" style="color: #fff !important;">'+ specialSize_typ+' '+specialSize.toUpperCase()+'</a>';
			$('.rugs-tab').css('display','block');
			$(".tag-add").append(newtag2);
		}
		
		
	});
</script>