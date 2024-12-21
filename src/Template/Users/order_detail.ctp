 <?php use Cake\Routing\Router;?>
 <?php use Cake\Core\Configure;?>

<style>
.product-quantity{
	height: 50px;
}
th{
	text-align:center;
}
.order-list {
    text-align: center;
}
</style>
 <!--Cart Page Area Start-->
        <div class="check-out-area">
            <div class="container">
                <div class="row">
                    
                    <div class="col-sm-3 account-sidebar">
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

                    <div class="col-sm-9 my-order account-main">
							<div class="about_status" style="padding: 20px;">
								<strong>Payment Status : <?= ($OrderStatus->payment_status == 1 )? "Completed" : "Pending"; ?> </strong><br />
							</div>
                            <div class="wishlist-table-area table-responsive">
                            <table class="table" width="100%">
                                <thead>
                                    <tr class="headding-color">
                                       
                                        <th>Order ID</th>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th >Total Quantity</th>
                                        <th >Total Price</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								
									foreach($OrderDetail as $key => $value){

								?>
                                    <tr class="order-list">
                                        <td>
                                            <?= "#".$value->order_id; ?>
                                        </td>
										<td  style="width:87px;!important">
                                            <a href="<?= $this->Url->build(['controller'=>'products','action'=>'productView']) ?>/<?=base64_encode($value->product_sku);?>"  > 
												<?php 
												$img_src = 'https://shrugs.com/rug_pictures/';	
												
												$img_no = str_replace("GOR"," ",$value->product_sku );
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
													<img src="<?php echo $fileUrl; ?>" alt="<?php echo $value->title; ?>" />
												 
												<?php }else{
												?>
												<img src="<?php echo $this->General->getProductSingleImages($value->id)->image; ?>" alt="<?php echo $value->title; ?>" />
												<?php
												}?>
													</a>
                                        </td>
                                        <td >
                                             <a href="<?=  $this->Url->build(['controller'=>'products','action'=>'productView']) ?>/<?=base64_encode($value->product_sku);?>"  > <?= $value->product_name;?></a>
                                        </td>
                                        <td >
                                            <?= $value->qty;?>
                                        </td>
                                        <td >
											<?= "$".$value->price;?>
                                        </td>
                                        
                                    </tr>
								 <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        </div>



                </div>
            </div>
        </div>
        <!--Cart Page Area End-->