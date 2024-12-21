	<?php use Cake\Routing\Router;?>
<div class="container-fluid slider">
  <div class="row">
  <?php if(!empty($banners)){?>
    <div class="desktop_slider">
	<div id="demo" class="carousel slide" data-ride="carousel"> 
      <div class="carousel-inner">
        <?php   
			$i = 0;
			foreach($banners as $banner){
		?>
		<div class="carousel-item <?php echo ($i==0)?'active':'';?>">
		  <?php
			   $image = WWW_ROOT . 'uploads' . DS . 'banner' . DS . $banner->image;
			   if (file_exists($image)) {
					echo $this->Html->image('/uploads/banner/'.$banner->image, array('alt' => $banner->image)); 
			   }else{
					echo $this->Html->image('slider1.jpg', ['alt' => 'Los Angeles']);
			   }
			?>  
          <div class="carousel-caption">
            <h3><?php echo $banner->title;?></h3>
            <p><?php echo $banner->description;?> </p>
          </div>
        </div>
		<?php $i++;} ?>
      </div>   
      
      <a class="carousel-control-prev" href="#demo" data-slide="prev"> <span class="carousel-control-prev-icon"></span> </a> <a class="carousel-control-next" href="#demo" data-slide="next"> <span class="carousel-control-next-icon"></span> </a> </div>
	  </div>
	  <?php } ?>  
	  
	  
	  <div class="mob_slider">
	  <div id="demo" class="carousel slide" data-ride="carousel"> 
      <div class="carousel-inner">
        		<div class="carousel-item">
		  <img src="/uploads/banner/mob_slide01.jpg" alt="223688703_Sh51439_slider3.jpg">  
          <div class="carousel-caption">
            <h3>New Arrivals</h3>
            <p>experience the mystical beauty of oriental rugs in your home </p>
          </div>
        </div>
		<div class="carousel-item active">
		  <img src="/uploads/banner/mob_slide02.jpg" alt="1316479190_slide02.jpg">  
          <div class="carousel-caption">
            <h3>New Arrivals01</h3>
            <p>experience the mystical beauty of oriental rugs </p>
          </div>
        </div>
		      </div>
      
      <a class="carousel-control-prev" href="#demo" data-slide="prev"> <span class="carousel-control-prev-icon"></span> </a> <a class="carousel-control-next" href="#demo" data-slide="next"> <span class="carousel-control-next-icon"></span> </a> </div>
	  </div>  
	  
	  
  </div>
</div>
<div class="container ">
  <div class="row ">
    <div class="spacing">&nbsp;</div>
    <div class="col-12 p-0">
    <div class="main-heading ">
      <h1>CARPET</h1>
      <p>Collection</p>
    </div>
    </div>
    <div class="col-md-7 wp-text">Selecting a Wall-to-Wall Carpet Carpet can do much more than cover your floors. It can be the foundation of a decorating plan, inspiring other ideas. Or, it can be selected to complement existing walls and furnishings. Above all, the carpet you choose should reflect your personality and bring comfort to your home.</div>
    <div  class="col-md-5 pull-right p-0 ">
      <div class="wp-button"><a href="<?php echo $this->Url->build(['controller'=>'pages','action'=>'carpet']); ?>" class="view-button">View All</a></div>
    </div>
    </div>
    <div class="row rugs">
      <div class="col-md-5">
        <div class="rugs-img"><a href="#"><?= $this->Html->image('rugs1.jpg', ['alt' => '']);?> 
          <p>Stanton Carpet</p></a>
        </div>
      </div>
      <div class="col-md-5">
        <div class="rugs-img"><a href="#"><?= $this->Html->image('rugs2.jpg', ['alt' => '']);?>  
          <p>Rosecore</p></a>
        </div>
      </div>
      <div class="col-md-2 ">
        <div class="rugs-left-img pt-m"><a href="#"><?= $this->Html->image('rugs3.jpg', ['alt' => '']);?>  
          <p>Crescent</p></a>
        </div>
        <div class="rugs-left-img pt"><a href="#"><?= $this->Html->image('rugs4.jpg', ['alt' => '']);?>  
          <p>Nourison</p></a>
        </div>
        <div class="rugs-left-img pt"><a href="#"><?= $this->Html->image('rugs5.jpg', ['alt' => '']);?>  
          <p>Karastan</p></a>
        </div>
      </div>
    </div>
  </div>

<div class="container ">
            <div class="row ">
            <div class="spacing1">&nbsp;</div>
            <div class="main-heading p-0">
            <div class="col-md-6"><h1>featureD</h1><p class="heading-text">products</p></div>
            <div class="col-md-6 p-0"><a href="<?php echo $this->Url->build(['controller'=>'products','action'=>'shopping']); ?>"  class="view-button">View All</a></div>
            </div>
             
            <div class="col-md-12 p-0 mt-4">
			<?php foreach($featuredProductData as $data){?>
				<div class="product "><a href="<?php echo $this->Url->build(['controller'=>'products','action'=>'productView',base64_encode($data->sku_no)]); ?>">
				<?php 
					//$img_src = 'https://shrugs.com/rug_pictures/';	
					$img_src = Router::url('/', true).'uploads/product/';
					
					$img_no = str_replace("GOR"," ",$data->sku_no );
					// $img_name = "sh".$img_no/7;
					$img_name = $data->sku_no."t.jpg";
					
					$inFolder = $this->General->__get_picture_folder($img_name);
					
					 
					$imgName =  $img_name." 001.jpg";
						 
					//$fileUrl = $img_src."overstock_rugs/".$inFolder."/".$imgName;
					$fileUrl =$img_src.$inFolder."/".$img_name;
					$thumb_imgName =  	$img_name." 001.jpg";
					$thumbArr = explode('_',$pimg['ProductImage']['image']);	
					$fileUrlThumb = $img_src.$inFolder.'/thumbs/thumb_'.$thumb_imgName;
					if($this->General->remote_file_exists($fileUrl))
						{
					?> 
						<img src="<?php echo $fileUrl; ?>" alt="<?php echo $record->title; ?>"   />
					 
					<?php }else{
					?>
					<img src="<?php echo $this->General->getProductSingleImages($data->id)->image; ?>" alt="<?php echo $data->title; ?>" style="height: 250px;"/>
					<?php
					}?>
				<p>Size: <?php echo $data->dimension_1_feet."'".$data->dimension_1_inches.'" X '.$data->dimension_2_feet."'".$data->dimension_2_inches.'"'; ?></p>
				<!--div class="product_info">
					<h3><?= $data->sku_no;?></h3>
					<div class="exact-size"><span> <strong> Exact Size: </strong></span><?php echo $data->dimension_1_feet."'".$data->dimension_1_inches.'" X '.$data->dimension_2_feet."'".$data->dimension_2_inches.'"'; ?></div>
					<div class="price">
						<strong>$<?= $data->selling_price;?></strong> <span>was <strike>$<?= $data->everyday_price;?> </strike></span>
					</div>
				</div-->
				</a></div>
			<?php } ?>
            
            </div>
            </div>
</div>