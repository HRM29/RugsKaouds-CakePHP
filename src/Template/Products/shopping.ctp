<?php
use Cake\Routing\Router;
use Cake\Core\Configure;?> 
<section class="shop-list section-padding">
         <div class="container">
            <div class="row">
			
			<?php echo $this->element('front/search_bar'); ?>
               
               <div class="col-lg-9 col-md-8">
                  <h1 class="rugs-headding">Rugs</h5>
                  <!--div class="shop-head">
                     <h2> There are <?php count($ProductData); ?> products</h2>   
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
				  <div style="width:100%" class="filter-tags-region columns">
						<div style="text-align:left" id="filter-tags-region" class = "tag-add">	
						</div>
				  </div>
                  <div class="rugs-tab" style="display:none;">
					  <a href="#">Active Filters</a>
					  <div style="text-align:left" id="filter-tags-region" class = "tag-add">	
					  </div>
				  </div>
                  <div class="row no-gutters">
				  <?php
				 //echo "<pre>";print_r($ProductData);
				  foreach($ProductData as $data){?>
				  <div class="col-lg-4 col-md-6 col-12">
                     <div class="product-detail" style="padding:15px 10px !important;">
						
						<a href="<?php echo $this->Url->build(['controller'=>'products','action'=>'productView',base64_encode($data->sku_no)]); ?>">
						<div class="product-thumb">
				<?php 
					$img_src = Router::url('/', true).'uploads/product/';	
											
					$img_name = isset($data->product_images[0]->image)?$data->product_images[0]->image:'';
					
					// $img_name = $data->sku_no."t.jpg";
					$img_name_a = substr($data->sku_no,3)."a.jpg";
					
					
					$sku = $data->sku_no;
					 
					$inFolder = $this->General->__get_picture_folder($sku);
					
					 
					$filePath =  WWW_ROOT . 'uploads' . DS . 'product'.DS.$inFolder.DS.$img_name;
				 	$filePath_A =  WWW_ROOT . 'uploads' . DS . 'product'.DS.$inFolder.DS.$img_name_a;
					
					$filePath21 =  WWW_ROOT . 'uploads' . DS . 'product'.DS.$inFolder.DS. str_replace('jpg','JPG',$img_name);
						 
					$fileUrl = $img_src.$inFolder."/".$img_name;
					$fileUrl_A = $img_src.$inFolder."/".$img_name_a;
					
					$fileUr2l = $img_src.$inFolder."/".str_replace('jpg','JPG',$img_name);
					 
					if($img_name !='')
					{
					?> 
						<img src="<?php echo $img_name; ?>" alt="<?php echo $data->title; ?>" />

					<?php 
					}else{ ?>
						<img src="<?php echo Router::url('/', true);?>img/no-image.png" alt="<?php echo $data->title; ?>" style="height:250px;" />
					<?php
					}?>
					</div>
					<?php
					//echo "<pre>";print_r($data);
					?>
					
					<h3><?php echo $data->title; ?></h3>
					<h4 class="product-prize">$<?php echo number_format($data->selling_price,2);?></h4>
					<p class="product-name">Size: <?php echo $data->dimension_1_feet."'".$data->dimension_1_inches.'" X '.$data->dimension_2_feet."'".$data->dimension_2_inches.'"'; ?></p>
					<p class="product-name">Code: <?php echo $data->sku_no; ?></p>
				<!--div class="product_info">
					<h3><?php $data->sku_no;?></h3>
					<div class="exact-size"><span> <strong> Exact Size: </strong></span><?php echo $data->dimension_1_feet."'".$data->dimension_1_inches.'" X '.$data->dimension_2_feet."'".$data->dimension_2_inches.'"'; ?></div>
					<div class="price">
						<strong>$<?php $data->selling_price;?></strong> <span>was <strike>$<?php $data->everyday_price;?> </strike></span>
					</div>
				</div--></a> </div></div>
				  <?php } ?>
                     
                  </div>
                  <div class="shop-head shop-head-bottom">
                     <h2><?php $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></h2>   
                     <div class="shop-bottom-section">
                        <nav>
                     <ul class="pagination justify-content-center">
						<?php $this->Paginator->first(('First')) ?>
						<?php $this->Paginator->prev(('Previous')) ?>
						<?php $this->Paginator->numbers() ?>
						<?php $this->Paginator->next(('Next')) ?>
						<?php $this->Paginator->last(('Last')) ?>
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
	  <script type="text/javascript" src="https://code.jquery.com/jquery-1.4.3.min.js" ></script>
	  <script>
	$(document).ready(function() {
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
			if(newtag != ""){
				$('.rugs-tab').css('display','block');
			}
			$(".tag-add").append(newtag);
		});
	});
</script>
<script>
equalheight = function(){
    $('.product-detail').each(function(){  
      
        // Cache the highest
         var highestBox = 0;
          
        // Select and loop the elements you want to equalise
        $('.product-thumb', this).each(function(){
            
            // If this box is higher than the cached highest then store it
            if($(this).height() > highestBox) {
              highestBox = $(this).height(); 
            }
          
        });  
                
        // Set the height of all those children to whichever was highest 
        $('.product-thumb',this).height(highestBox);
                    
    }); 
}
 
$(window).load(function(){

    // Select and loop the container element of the elements you want to equalise
    equalheight(); 

});

</script>