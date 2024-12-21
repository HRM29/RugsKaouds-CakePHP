<?php 
use Cake\Routing\Router;
use Cake\Core\Configure;
?> 
<?php echo $this->Html->script(['jquery.js']);?>
<?php echo $this->Html->script(['xzoom.min.js']);?>
<?php echo $this->Html->css(array('front/xzoom.css')); ?>
<section class="add-cart-page">
  <div class="container">
    <div class="row">
      <div class="col-md-5 col-sm-12">
        <div class="shop-detail-left">
			<div class="row">
			  <div class="large-5 column">
				<div class="xzoom-container">
				<?php 
					$img_src = Router::url('/', true).'uploads/product/';	
					 // echo "<pre>";print_r($productDetail);
					$img_name = isset($productDetail->product_images[0]->image)?$productDetail->product_images[0]->image:'';
					
					$sku = $productDetail->sku_no;
					 
					$inFolder = $this->General->__get_picture_folder($sku);
					
					 
					$filePath =  WWW_ROOT . 'uploads' . DS . 'product'.DS.$inFolder.DS.$img_name;
					$filePath21 =  WWW_ROOT . 'uploads' . DS . 'product'.DS.$inFolder.DS. str_replace('jpg','JPG',$img_name);
						 
					$fileUrl = $img_name;
					
					 
					 
				
					?> 
						<img class="xzoom" id="xzoom-default" src="<?php echo $fileUrl; ?>" xoriginal="<?php echo $fileUrl; ?>" />
					
				  
				  
				  <div class="xzoom-thumbs">
				  <?php 
					$imagesArr = $productDetail->product_images; 
					$i = 'active';
				 
					if(!empty($imagesArr)) 
					{
						foreach($imagesArr as $imgs){
						 // echo "<pre>";print_r($imgs);
							$filePath1 =  $imgs->image;
							$fileUrl1 = $imgs->image;
						?>
								<a href="<?php echo $fileUrl1; ?>"><img class="xzoom-gallery" width="80" src="<?php echo $fileUrl1; ?>" alt="<?php echo $productDetail->title; ?>" class="img-fluid img-center"></a>
					<?php 
						}
					}  
					?>
				
				  </div>
				</div>        
			  </div>
			  <div class="large-7 column"></div>
			</div>
                      
		  </div>
      </div>
    
      <div class="col-md-6 col-sm-12 offset-md-1">
 
          <div class="cart-subtotal-products"> 
          <!--p class="label"><php echo strtoupper($productDetail->title);  ?></p-->          <h1><?php echo strtoupper($productDetail->title);  ?><h1>
          <span class="product-prize">$<?php echo number_format($productDetail->selling_price,2);?></span>
          <span class="social-share pull-right"><!--a href="#"><i class="fa fa-share-alt"></i>Share</a-->
		  <?php
		  if($user_id != 0){
			if(!empty($favouriteData)){?>
				<a id="remove_from_favourite" data-value="<?php echo $productDetail->id; ?>" style="cursor:pointer;"><i class="fa fa-heart-o" style="color:#dcbb72;"></i>Remove from favourite</a>  
			<?php }else{ ?>
				<a id="add_to_favourite" data-value="<?php echo $productDetail->id; ?>" style="cursor:pointer;"><i class="fa fa-heart-o"></i>add to favourite</a>
			<?php }	?>
			
		  <?php }else{ ?>
			  <a href="<?php echo $this->Url->build(['controller' =>'users','action'=>'login']); ?>" style="cursor:pointer;"><i class="fa fa-heart-o"></i>add to favourite</a>
			  
		  <?php } ?>
		  </span>  
	   
          </div>
		  <input type="hidden" id="p_id" value="<?php echo $productDetail->id;?>">
		  <input type="hidden" id="u_id" value="<?php echo $user_id;?>">
          <div class="pdocut-buton" style="display:none" id="cart-button"><a class="cart-btn"  style="cursor: pointer;" >Add To Cart</a></div>
          <div class="pdocut-buton" style="display:none" id="go_to_cart"><a href="<?php echo $this->Url->build(['controller'=>'products','action'=>'cart']); ?>" class="cart-btn" >Go To Cart</a></div>
            
           <div class="product-discrip"><ul class="nav nav-tabs" id="myTab" role="tablist">
  <!--li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Description</a>
  </li-->
  <li class="nav-item">
    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Rug Details</a>
  </li>
  
</ul>
<div class="tab-content" id="myTabContent">
  <!--div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</div-->
  	<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
		<div class="tt-add-info">
			<ul>
				<li class="sku-js">
					<span>Code:</span>
					<span><?php echo $productDetail->sku_no; ?></span>
				</li>
				<li class="sku-js">
					<span>Exact Size:</span>
					<span><?php echo $productDetail->dimension_1_feet."'".$productDetail->dimension_1_inches.'" X '.$productDetail->dimension_2_feet."'".$productDetail->dimension_2_inches.'"'; ?></span>
				</li>

			<?php
				$price_sh = $productDetail->selling_price/2.5;
				$jgor = round($price_sh *7) ;
			?>

				<li class="sku-js">
					<span>JGOR:</span>
					<span><?php echo $jgor;?></span>
				</li>
				<li class="sku-js">
					<span>Shape:</span>
					<span><?php echo $productDetail->available_shape; ?></span>
				</li>
				<li class="sku-js">
					<span>Origin:</span>
					<span><?php echo ucfirst(strtolower($productDetail->overstock_origin)); ?></span>
				</li>
				<li class="availability">
					<span>Foundation:</span>
					<span><?php echo $this->General->getFoundation($productDetail->foundation_id);?></span>
				</li>
				<li class="availability">
					<span>Pile:</span>
					<span><?php echo $this->General->getPile($productDetail->pile_id);?></span>
				</li>
				<li class="availability">
					<span>Construction:</span>
					<span><?php echo $productDetail->rug_type;?></span>
				</li>
				<li class="availability">
					<span>Group Color:</span>
					<span><?php echo $this->General->getColor($productDetail->color_id);?></span>
				</li>
				<li class="availability">
					<span>Exact Field Color:</span>
					<span><?php echo $productDetail->field_color_exact;?></span>
				</li>
				<li class="availability">
					<span>Age:</span>
					<span><?php echo $productDetail->age; ?></span>
				</li>
				<li class="availability">
					<span>Border Color:</span>
					<span><?php echo $productDetail->border_color; ?></span>
				</li>
				<li class="availability">
					<span>Rug Style:</span>
					<span><?php echo $productDetail->style; ?></span>
				</li>
				<li class="availability">
					<span>Pattern:</span>
					<span><?php echo $productDetail->pattern; ?></span>
				</li>
				<li class="availability">
					<span>Design:</span>
					<span><?php echo $productDetail->rug_design; ?></span>
				</li>
				<li class="availability">
					<span>Category:</span>
					<span><?php echo $this->General->getCategory($productDetail->category_id);?></span>
				</li>
				<?php /* ?><li class="availability">
					<span>Location:</span>
					<span><?php echo $productDetail->location;?></span>
				</li><?php */ ?>

				<li class="availability">
					<span>Sale Price:</span>
					<span>$ <?php echo number_format($productDetail->selling_price,2);?></span>
				</li>
			
			</ul>
		</div>
  	</div>
  <!--div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</div-->
</div>
</div>
            
          
          </div>
 
          
          
 
 
    </div>
  </div>
</section><div class="spacing">&nbsp;</div>
<section class="product-items-slider section-padding">
         <div class="container">
            <div class="main-heading ">
      <div class="col-md-6">
        <h2>featureD</h2>
        <p class="heading-text">products</p>
      </div>
      <!--<div class="col-md-6"><a href="#"  class="view-button">View All</a></div>-->
    </div>
            <div class="owl-carousel owl-carousel-featured">
			<?php foreach($featuredProductData as $data){?>
				<div class="item">
                  <div class="product-detail">
                     <a href="<?php echo $this->Url->build(['controller'=>'products','action'=>'productView',base64_encode($data->sku_no)]); ?>">
				<?php 
					$img_src = Router::url('/', true).'uploads/product/';	
											
					$img_name = isset($data->product_images[0]->image)?$data->product_images[0]->image:'';
					
					$sku = $data->sku_no;
					 
					$inFolder = $this->General->__get_picture_folder($sku);
					
					 
					$filePath =  WWW_ROOT . 'uploads' . DS . 'product'.DS.$inFolder.DS.$img_name;
						 
					$fileUrl = $img_src.$inFolder."/".$img_name;
					 
					if(file_exists($filePath))
						{
					?> 
						<img src="<?php echo $fileUrl; ?>" alt="<?php echo $data->title; ?>" />
					 
					<?php }else{
					?>
						<img src="<?php echo Router::url('/', true);?>img/no-image.png" alt="<?php echo $product->title; ?>" style="height:250px;" />
					<?php
					}?>
					<p>Size: <?php echo $data->dimension_1_feet."'".$data->dimension_1_inches.'" X '.$data->dimension_2_feet."'".$data->dimension_2_inches.'"'; ?></p>
				<!--div class="product_info">
					<h3><?= $data->sku_no;?></h3>
					<div class="exact-size"><span> <strong> Exact Size: </strong></span><?php echo $data->dimension_1_feet."'".$data->dimension_1_inches.'" X '.$data->dimension_2_feet."'".$data->dimension_2_inches.'"'; ?></div>
					<div class="price">
						<strong>$<?= $data->selling_price;?></strong> <span>was <strike>$<?= $data->everyday_price;?> </strike></span>
					</div>
				</div--></a></div></div>
			<?php } ?>
               
            </div>
         </div>
      </section>
	  <?php echo $this->Html->script(['setup.js']);?>
	  <script type="text/javascript" src="https://code.jquery.com/jquery-1.4.3.min.js" ></script>
<?php echo $this->Html->script(['owl.carousel.js']);?>
<script type="text/javascript">
$(document).ready(function(){
	checkCartButton();
	
	$('#cart-button').click(function(){
		
		var product_id = $('#p_id').val();
		//var csrfToken = $("[name='_csrfToken']").val();
		var csrfToken = <?php echo json_encode($this->request->getParam('_csrfToken')) ?>;
		var url = '<?php echo $this->Url->build(['controller'=>'products','action'=>'addToCart']); ?>';
		$.ajax({
			type:'POST',
			data:{product_id:product_id,_csrfToken:csrfToken},
			url:url,
			success:function(data) {
				//console.log(data); 
				//cartdata();
				window.location.replace('<?php echo $this->Url->build(['controller'=>'products','action'=>'cart']); ?>');
				//checkCartButton();
			}
		});
	});
	function checkCartButton(){
			var csrfToken = <?php echo json_encode($this->request->getParam('_csrfToken')) ?>;
			
			var url = '<?php echo $this->Url->build(['controller'=>'products','action'=>'checkCartButton']); ?>';
			var pr_id = $("#p_id").val();
			$.ajax({
				type:'POST',
				data:{pr_id:pr_id,_csrfToken:csrfToken},
				url:url,
				success:function(result) {
					console.log(result);
					if(result==0){
						$("#cart-button").show();
						$("#go_to_cart").hide();
					}else{
						$("#cart-button").hide();
						$("#go_to_cart").show();
					}
				}
			 });
			
		} 
		$('#add_to_favourite').click(function(){
			var csrfToken = <?php echo json_encode($this->request->getParam('_csrfToken')) ?>;
			
			var url = '<?php echo $this->Url->build(['controller'=>'products','action'=>'addToFaviourite']); ?>';
			var product_id = $('#add_to_favourite').attr('data-value');
			var u_id = $('#u_id').val();
			var sku = "<?php echo $productDetail->sku_no; ?>";
			$.ajax({
				type:'POST',
				data:{product_id:product_id,user_id:u_id,sku:sku,_csrfToken:csrfToken},
				url:url,
				success:function(result) {
					if(result == 1){
						location.reload();
					}
				}
			 });
		})
		$('#remove_from_favourite').click(function(){
			var csrfToken = <?php echo json_encode($this->request->getParam('_csrfToken')) ?>;
			
			var url = '<?php echo $this->Url->build(['controller'=>'products','action'=>'removeFromFaviourite']); ?>';
			var product_id = $('#removeFromFaviourite').attr('data-value');
			var u_id = $('#u_id').val();
			var sku = "<?php echo $productDetail->sku_no; ?>";
			$.ajax({
				type:'POST',
				data:{product_id:product_id,user_id:u_id,sku:sku,_csrfToken:csrfToken},
				url:url,
				success:function(result) {
					if(result == 1){
						location.reload();
					}
				}
			 });
		})		
});
</script>