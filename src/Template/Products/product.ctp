<?php use Cake\Routing\Router;?> 
<section class="add-cart-page">
  <div class="container">
    <div class="row">
      <div class="col-sm-5 col-xs-12">
        <div class="shop-detail-left">
                     <div class="shop-detail-slider">
                        <div class="favourite-icon">
                           
                        </div>
						
                        <div id="sync1" class="owl-carousel text-center">
						<?php 
									$img_src = 'https://shrugs.com/rug_pictures/';	
									
									$img_no = str_replace("GOR"," ",$productDetail->sku_no );
									$img_name = "sh".$img_no/9;
									$inFolder = $this->General->__get_picture_folder($img_name);
									$i = 'active';
									for($j=1;$j<=12;$j++) 
									{
										if($j<10){$k="00";}else{$k="0";}
										$imgName =  "l_".$img_name." ".$k.$j.".jpg";
										 
										$fileUrl = $img_src.$inFolder."/large/".$imgName;
									   
										$thumb_imgName =  	$img_name." ".$k.$j.".jpg";
										$thumbArr = explode('_',$pimg['ProductImage']['image']);	
										$fileUrlThumb = $img_src.$inFolder.'/thumbs/thumb_'.$thumb_imgName;
									 
										if($this->General->remote_file_exists($fileUrl))
										{
										?>
											<div class="item <?php echo $i; ?>"><img alt="" src="<?php echo $fileUrl; ?>"  alt="<?php echo $productDetail->title; ?>" class="img-fluid img-center"></div>
									<?php  
									}
									$i = '';
									}
									if($this->General->remote_file_exists($fileUrl) == "")
										{	$data =  $this->General->getProductImages($productDetail->id);
									 foreach($data as $images){
									?>
										<div class="item <?php echo $i; ?>"><img alt="" src="<?php echo $images->image; ?>"  alt="<?php echo $productDetail->title; ?>" class="img-fluid img-center"></div>
										<?php }
										$i = '';
										} 
									?>
                           
						   
                        </div>
                        <div id="sync2" class="owl-carousel">
						<?php 
								
									$i = 'synced';
									for($j=1;$j<=12;$j++) 
									{
										if($j<10){$k="00";}else{$k="0";}
										$imgName =  "l_".$img_name." ".$k.$j.".jpg";
										 
										$fileUrl = $img_src.$inFolder."/large/".$imgName;
									   
										$thumb_imgName =  	$img_name." ".$k.$j.".jpg";
										$thumbArr = explode('_',$pimg['ProductImage']['image']);	
										$fileUrlThumb = $img_src.$inFolder.'/thumbs/thumb_'.$thumb_imgName;
									 
										if($this->General->remote_file_exists($fileUrl))
										{
										?>
											<div class="item <?php echo $i; ?>"><img alt="" src="<?php echo $fileUrl; ?>"  alt="<?php echo $productDetail->title; ?>" class="img-fluid img-center"></div>
									<?php  
									}
									$i = '';
									}
									if($this->General->remote_file_exists($fileUrl) == "")
										{	$data =  $this->General->getProductImages($productDetail->id);
									 foreach($data as $images){
									?>
										<div class="item <?php echo $i; ?>"><img alt="" src="<?php echo $images->image; ?>"  alt="<?php echo $productDetail->title; ?>" class="img-fluid img-center"></div>
										<?php }
										$i = '';
										} 
									?>
                          
                        </div>
                     </div>
                  </div>
      </div>
    
      <div class="col-sm-6 col-xs-12 offset-md-1 ">
 
          <div class="cart-subtotal-products"> 
          <p class="label"><?= $productDetail->dimension_1_feet."'".$productDetail->dimension_1_inches.'" X '.$productDetail->dimension_2_feet."'".$productDetail->dimension_2_inches.'"'." ".$productDetail->title;  ?></p>
          <span class="product-prize">$<?= $productDetail->selling_price;?><p>$<?= $productDetail->everyday_price;?></p></span>
          <span class="social-share pull-right"><a href="#"><i class="fa fa-share-alt"></i>Share</a>
          <a href="#"><i class="fa fa-heart-o"></i>add to favorites</a></span>          
          </div>
          <div class="pdocut-buton"><a href="#">Add To Cart</a></div>
            
           <div class="product-discrip"><ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Description</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Rug Details</a>
  </li>
  
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</div>
</div></div>
            
          
          </div>
 
          
          
 
 
    </div>
  </div>
</section><div class="spacing">&nbsp;</div>
<section class="product-items-slider section-padding">
         <div class="container">
            <div class="main-heading ">
      <div class="col-md-6">
        <h1>featureD</h1>
        <p class="heading-text">products</p>
      </div>
      <!--<div class="col-md-6"><a href="#"  class="view-button">View All</a></div>-->
    </div>
            <div class="owl-carousel owl-carousel-featured">
			<?php foreach($featuredProductData as $data){?>
				<div class="item">
                  <div class="product-detail">
                     <a href="<?php echo Router::url('/', true)."Products/product-view/".base64_encode($data->sku_no); ?>">
				<?php 
					$img_src = 'https://shrugs.com/rug_pictures/';	
					
					$img_no = str_replace("GOR"," ",$data->sku_no );
					$img_name = "sh".$img_no/9;
					$inFolder = $this->General->__get_picture_folder($img_name);
					
					 
					$imgName =  "l_".$img_name." 001.jpg";
						 
					$fileUrl = $img_src.$inFolder."/large/".$imgName;
					$thumb_imgName =  	$img_name." 001.jpg";
					$thumbArr = explode('_',$pimg['ProductImage']['image']);	
					$fileUrlThumb = $img_src.$inFolder.'/thumbs/thumb_'.$thumb_imgName;
					 
					if($this->General->remote_file_exists($fileUrl))
						{
					?> 
						<img src="<?php echo $fileUrl; ?>" alt="<?php echo $data->title; ?>" />
					 
					<?php }else{
					?>
					<img src="<?php echo $this->General->getProductSingleImages($data->id)->image; ?>" alt="<?php echo $data->title; ?>"/>
					<?php
					}?>
				<div class="product_info">
					<h3><?= $data->sku_no;?></h3>
					<div class="exact-size"><span> <strong> Exact Size: </strong></span><?php echo $data->dimension_1_feet."'".$data->dimension_1_inches.'" X '.$data->dimension_2_feet."'".$data->dimension_2_inches.'"'; ?></div>
					<div class="price">
						<strong>$<?= $data->selling_price;?></strong> <span>was <strike>$<?= $data->everyday_price;?> </strike></span>
					</div>
				</div></a></div></div>
			<?php } ?>
               
            </div>
         </div>
      </section>