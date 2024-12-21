<?php use Cake\Routing\Router;?>
<?php
$session = $this->request->getSession();
$action = $this->request->getParam('action');
$controller = $this->request->getParam('controller');
$authUser = $session->read('Auth');
?>
<section class="checkout-page section-padding">
         <div class="container p-0">
            <div class="row">
			<div class="col-md-3 col-xs-12 col-sm-3 account-sidebar">
						<div class="checkout-widget">
							<h2 class="widget-title">My Account</h2>
							<ul>
								<li><a href="<?php echo Router::url('/', true); ?>users/myaccount">My Details</a></li>
                                <!-- <li><a href="#"><i class="fa fa-map-marker"></i> My Addres book</a></li> -->
                                <li><a href="<?php echo Router::url('/', true); ?>users/myorder">My Orders</a></li>
								<li><a href="<?php echo Router::url('/', true); ?>users/wishlist">My Favourite list</a></li>
                                <li><a href="<?php echo Router::url('/', true); ?>users/changepassword">Change Password</a></li>
							</ul>
						</div>                        
                    </div>
               <div class="col-lg-9 col-md-9 col-sm-9 my-order account-main">
                  <div class="checkout-step">
               <div class="col-md-12">
                  <div class="card cart-right">
                     <h5 class="card-header">My Favourite List <span class="float-right">(<?= count($favouritesDatas); ?> item)</span></h5>
					 <div class="container success-section-wishlist p-0" style="display:none;">
						<div class="row">
							<div class="col-lg-12">
								<table>
									<tbody>
										<tr>
											<td><h3>Product added to cart successfully.</h3></td>
										</tr>
									</tbody></table>
							</div>
						</div>
					 </div>
                     <div class="card-body pt-0 pr-0 pl-0 pb-0">
					 <?php
						if(!empty($favouritesDatas)){
							foreach($favouritesDatas as $key => $data){ ?>
                        <div class="cart-list-product">
                           <a class="float-right remove-cart delete" data1="<?=$data['id'];?>" style="cursor: pointer;"><i class="mdi mdi-close"></i></a>
						   <?php 
									$img_src = 'https://shrugs.com/rug_pictures/';	
											
									$img_no = str_replace("GOR"," ",$data['sku_no'] );
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
											<img src="<?php echo $fileUrl; ?>"  alt="<?php echo $data['title']; ?>" class="img-fluid">
									<?php  
									}
									
									if($this->General->remote_file_exists($fileUrl) == "")
										{	$data =  $this->General->getProductImages($data['id']);
									 foreach($data as $images){
									?>
										<img src="<?php echo $images['image']; ?>"  alt="<?php echo $images['title']; ?>" class="img-fluid">
										<?php }
										$i = '';
										} 
									?>
                        <!--span class="badge badge-success">&nbsp;</span-->
                           <h5><a href="<?php echo $this->Url->build(['controller'=>'products','action'=>'productView',base64_encode($data['sku_no'])]); ?>"><?= $data['title'];?></a></h5>
                           
                           <p class="offer-price mb-0">$<?= $data['selling_price'];?>  <span class="regular-price">$<?= $data['everyday_price'];?></span></p>
						   <div class="pdocut-buton-wishlist cart-button" id="cart-button" data1="<?=$data['id'];?>"><a class="cart-btn"  style="cursor: pointer;" >Add To Cart</a></div>
                        </div>
					 <?php }}else{ ?>
						<h4 style="text-align:center;margin-top: 20px;">No item in your wishlist !!</h4>
					 <?php } ?>	
					 <div class="cart-btn"></div>
					 
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
<script>
	$('.cart-button').click(function(){
		
		var product_id = $(this).attr('data1');
		//var csrfToken = $("[name='_csrfToken']").val();
		var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
		var url = '<?php echo $this->Url->build(['controller'=>'users','action'=>'addToCart']); ?>';
		$.ajax({
			type:'POST',
			data:{product_id:product_id,_csrfToken:csrfToken},
			url:url,
			success:function(data) {
				
				$('.success-section-wishlist').css('display','block');
				$('html, body').animate({scrollTop: $(".top-nav-bar").offset().top}, 500);
				window.setTimeout(function(){location.reload()},3000);
				//console.log(data); 
				//cartdata();
			}
		});
	});
	$('.delete').click(function() {
		var csrfToken =  <?= json_encode($this->request->getParam('_csrfToken')) ?>;
		var id = $(this).attr("data1");
		
		var url ='<?php echo $this->Url->build(['controller'=>'users','action'=>'deleteWishlistItem']); ?>';    
		$.ajax({
			type:'POST',
			url:url,
			data:{_csrfToken:csrfToken,id:id},
			success: function(result){
				//cartdata();	
				location.reload();  
				//console.log(result);
			}

		});
	});
</script>