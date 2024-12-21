<?php use Cake\Routing\Router;?>
<?php use Cake\Core\Configure;?>
<style>
table{
	width:100%;
	margin-top:50px;
	text-align:center;
}
.section-padding {
    padding: 0px;
}
#order_id{
	text-align:right;
}
</style>
<div class="container success-section p-0">
			<div class="row">
				<div class="col-lg-12">
					<div>
						<div class="section-title">
							<h2 class="widget-title">Your Payment Details</h2>
						</div>
						<table style="text-align:left;">
						<tr>
						<?php  if($payment_status == "Success" || $payment_status == "SuccessWithWarning"){?>
							<td><h3>Your payment has been successful.</h3></td>
						<?php } ?>
						<?php if($payment_status == "Failure" || $payment_status == "FailureWithWarning"){?>
							<td><h3>Your payment status is Failed.</h3></td>
						<?php } ?>
						
							<td id="order_id"><h4><b>Order ID:</b> <?php echo '#'.$orderid->id; ?></h4></td>
						</tr>
						</table>
						
						
					</div>
				</div>
			</div>
		</div>
		

 <!--Cart Page Area Start-->
        <div class="shopping-cart-area section-padding">
            <div class="container success-section p-0">
                <div class="row">
                    <div class="col-md-12">
                        <div class="wishlist-table-area table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
										<th class="t-product-name" style="width:87px;!important">Image</th> 
                                        <th class="t-product-name" >Product Name</th>
										<th class="product-unit-price">Unit Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php if(!empty($orderitems)){$total_amount = 0; $total_quantity = 0; $i=1; foreach ($orderitems as $item) {  
								?>
                                    <tr>
                                        <td class="product-image" style="width:87px;!important">
                                            <a href="<?php echo Router::url('/', true)."Products/product-view/".base64_encode($item->product->sku_no); ?>"  > 
											<?php 
											$img_src = Router::url('/', true).'uploads/product/';	
											 
											$img_name = isset($item->product->product_images[0]->image)?$item->product->product_images[0]->image:'';
											
											$sku = $item->product->sku_no;
											 
											$inFolder = $this->General->__get_picture_folder($sku);
											
											 
											$filePath =  WWW_ROOT . 'uploads' . DS . 'product'.DS.$inFolder.DS.$img_name;
											
											$filePath21 =  WWW_ROOT . 'uploads' . DS . 'product'.DS.$inFolder.DS. str_replace('jpg','JPG',$img_name);
												 
											$fileUrl = $img_src.$inFolder."/".$img_name;
											
											$fileUr2l = $img_src.$inFolder."/".str_replace('jpg','JPG',$img_name);
											 
											if(file_exists($filePath)){
											?> 
												<img src="<?php echo $fileUrl; ?>" alt="<?php echo $item->product_name; ?>" />
											 
											<?php }else if(file_exists($filePath21)){
											?>
												<img src="<?php echo $fileUr2l; ?>" alt="<?php echo $item->product_name; ?>"/>
											<?php }else{ ?>
												<img src="<?php echo Router::url('/', true);?>img/no-image.png" alt="<?php echo $data->title; ?>" style="width:60px;" />
											<?php } ?>
											</a>
                                        </td>
                                        <td class="t-product-name" style="width: 317px;!important" >
                                            <h5>
                                                <?=$item->product_name;?>
                                            </h5>
                                        </td>
                                       <td class="product-unit-price">
                                          <p id="price"><?= "$".round($item->price,2);?></p>
										<p id="orginalprice<?=$i ;?>" style="display:none;"><?=$item['price'];?></p>
                                        </td>
										<td class="product-quantity product-cart-details qty">
											<p class="quantity" ><?=$item->qty;?></p>
										</td> 
                                        <td class="product-unit-price">
                                              <p id="sub<?=$i;?>" class="subtotal"><?="$".round($item->price,2);?> </p>
                                        </td>
                                    </tr>
									
								<?php 
								$total_amount += $item->price;
								$total_quantity += $item['total_qty'];
								$i++; }}?> 
									<tr style="height: 100px;" >
									<td colspan="3" style="border: 0;"></td>
									
									
										<!--td class="product-unit-price td-class" colspan="3" style="border-bottom: none;border-left: none;"></td-->
										<td class="product-unit-price">
										<!--p><?php echo $total_quantity; ?></p-->
										Subtotal 
										</td>
										<td class="product-unit-price">
										<p><?php echo "$".round($total_amount,2); ?></p>
										</td>
									</tr>
                                </tbody>
                            </table>
							<table class="table table-bordered success-section-bottom"  align="right">
								<thead>
								  <tr>
									<th>Order ID:</th>
									<th><?php echo '#'.$orderid->id; ?></th>
								  </tr>
								</thead>
								<tbody>
								  <tr>
									<th>Transaction ID:</th>
									<th><?php echo $orderid->trans_id; ?></th>
								  </tr>
								  <tr>
									<th>Payment Gross:</th>
									<th><?php echo "$".round($orderid->total_price,2)." USD"; ?></th>
								  </tr>
								  <tr>
								    <th>Payment Status:</th>
									<th> <?php echo $payment_status; ?></th>
								  </tr>
								</tbody>
						  </table>
                        </div>
                        
                    </div>
                </div>
                <div class="row subtotal-section success-section-bottom">
                    <!--div class="col-md-4 col-xs-12">
                                    <div class="coupon">
                            <h2>Coupon</h2> 
                            <div class="form-group">
                            <p>Enter your coupon code if you have one.</p>
                            <input type="text" name="coupon_code" class="form-control" value="" placeholder="Coupon code"> <input type="submit" class="cart-btn" name="apply_coupon" value="Apply coupon">
                            </div>
                            </div>
                    </div-->
					
					<?php if(!empty($cartitems)){ ?>
                    <div class="col-md-8 cart-subtotal">
                        <h2>Cart totals</h2>
                        <div class="row">
                            <div class="col-xs-6">Subtotal</div>
                            <div class="col-xs-6 text-right" id="sub_total"></div>
                        </div>
                        <div class="row">
                                <div class="col-xs-6">Shipping</div>
                                <div class="col-xs-6 text-right" id="shipping"></div>
                        </div>
                        <div class="row">
                                <div class="col-xs-6">Total</div>
                                <div class="col-xs-6 text-right" id="total"></div>
                        </div>
                        <div class="clearfix">
                        <div class="checkout-btn pull-right">
                            <a class="cart-btn checkout" style="cursor: pointer;"><span>Proceed to checkout</span></a>
                        </div>
                    </div>
                    </div>
					<?php  } ?>
                </div>
            </div>
        </div>  
        <!--Cart Page Area End-->
		<?php echo $this->Form->create();
			echo $this->Form->end(); 
		?>
		
 <div style="display: none" id="curcuren"><?=$getcur;?></div>
<script>
subtotall();
var total_quantity = 0;

$(".qty" ).change(function() {
  if($(this).children().val() < 1){
     alert("Product Quantity One is Necessary");
	$(this).children().val("1");
  }  
});
	function subtotall(){
		var csrfToken = $("[name='_csrfToken']").val(); 
		var urls ='<?php echo Router::url('/', true) . 'pages/subtotal'?>';    
		$.ajax({
			type:'POST',
			url:urls,
			data:{_csrfToken:csrfToken},
			dataType: 'json',
			success: function(result){
				 
				$("#sub_total").html(result[0]);
				$("#shipping").html(result[1]);
				$("#total").html(result[2]);  
				//$("#total_quantity").html(result[3]); 
				total_quantity = result[3];	
			} 
		});
	}

</script>		
		
		
				