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
               <div class="col-md-8">
                  <div class="checkout-step">
                     <div class="accordion" id="accordionExample">
                        <!--div class="card">
                           <div class="card-header" id="headingOne">
                              <h5 class="mb-0">
                                 <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                 <span class="number">1</span> Phone Number Verification
                                 </button>
                              </h5>
                           </div>
                           <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                              <div class="card-body">
                                 <p>We need your phone number so that we can update you about your order.</p>
                                 <form>
                                    <div class="form-row align-items-center">
                                       <div class="col-auto">
                                          <label class="sr-only">phone number</label>
                                          <div class="input-group mb-2">
                                             <div class="input-group-prepend">
                                                <div class="input-group-text"><span class="mdi mdi-cellphone-iphone"></span></div>
                                             </div>
                                             <input type="text" class="form-control" placeholder="Enter phone number">
                                          </div>
                                       </div>
                                       <div class="next-button">
                                         <a href="#" class="">NEXT</a>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div-->
						<div class="card">
								<div class="card-header" role="tab" id="headingOne">
									<h5 class="mb-0">
										 <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										 <span class="number">1</span> Checkout Method
										 </button>
									
									  </h5>
								</div>
								<?php if(empty($authUser['User']['id'])){ ?>
								<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
								<?php }else{ ?>
								<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
								<?php } ?>
								<?php if(empty($authUser['User']['id'])){
										 
											 ?>
									<div class="panel-body">
										
										<div class="row">
											<div class="col-md-12 col-sm-12">
												<!--h2 class="collapse-title">CHECKOUT AS A GUEST OR REGISTER</h2-->
												<!--<div class="checkout-login">	<h5 class="collapse-title">CHECKOUT METHOD</h5>-->
												<!--h4>Register with us for future convenience:</h4-->
												<!--form action="#"-->
													<div class="check-register">
														<?php $options = array('Guest' => 'Checkout As Guest','Login' => 'Login');
														echo $this->Form->radio('checkoutOption', $options); ?>
													</div>
													<!--div class="check-register">
														<input type="radio" />
														<label>Register</label>
													</div-->	
                                                 											
												</form>
											
												<!--p>Register and save time!</p>
												<p>Register with us for future convenience:</p>
												<p>Fast and easy check out</p>
												<p>Easy access to your order history and status</p-->
												
												<!--button class="btn btn-default" id="continue_for_guest" style="display:none;" >CONTINUE</button-->
												<div class="continue_for_guest m-20" style="display:none;" ><a class="view-button" id="continue_for_guest" style="cursor: pointer;">Continue</a></div>
												</div>
											<div class="col-md-12 col-sm-12" id="login-form" style="display:none;">
											<div class="checkout-login">
												 <?= $this->Flash->render('positivee') ?>
												<?php echo $this->Form->create($user,['url' => ['controller' => 'Products', 'action' => 'login']]); ?>
												<div class="form-group">
														<?php echo  $this->Form->control('email', ['label' => false,"placeholder"=>"Enter Email Address","class"=>"form-control","div"=>false]); ?>
														</div>
														<div class="form-group">
														<?php echo  $this->Form->control('password', ['label' => false,"placeholder"=>"Enter Password","class"=>"form-control","div"=>false]); ?>
														</div>
													<div class="check-register login-button form-group">
														<?php echo $this->Form->button("<span>Login</span>", array('name' => 'submitcreate2', 'class' => 'view-button', 'type' => 'submit','id'=>'submitcreate2', 'title' => 'Create an account')); ?>
													</div>													
												<?php echo $this->Form->end(); ?>
											</div>
										</div>
										</div>
										
									</div>
									<?php }else{?>
											<ul class="static-list" style="padding:15px 15px 0px 15px;"> 
												<li>Login As : <?php if(!empty($authUser['User']['id'])){ echo $authUser['User']['email']; } ?></li>
											</ul>
										<?php }?>
								</div>
							</div>
						
						<?= $this->Form->create($order, ['url' => ['controller' => 'Products', 'action' => 'checkoutnew'],'type' => 'file','id'=>'form_paypal']); ?>
                        <div class="card checkout-step-two">
                           <div class="card-header" id="headingTwo">
                              <h5 class="mb-0">
									<?php if(!empty($authUser['User']['id'])){ ?>
													<button class="btn btn-link collapsed" type="button" id="delivery_address" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
													<span class="number">2</span> Billing Information
													</button>
									 <?php  }else{ ?>
													 <button class="btn btn-link collapsed" type="button" id="delivery_address" data-toggle="collapse" data-target="#" aria-expanded="false" aria-controls="collapseTwo">
													 <span class="number">2</span> Billing Information
													 </button>
									<?php }?>
                                 
                              </h5>
                           </div>
						   <?php if(!empty($authUser['User']['id'])){ ?>
                           <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
                             <?php  }else{ ?>
							 <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
							 <?php }?>
							 <div class="card-body">
                               <?php  
												if(!empty($cardData)){
													$total_quanty = 0;
													$total_price = 0;
													foreach ($cardData as $item) { 
														$total_quanty += $item['product_qty'];
														$total_price += $item['selling_price'];
													}
												}
											?>
											<?php
											if(!empty($authUser['User']['id'])){
											?>
											<?php  echo $this->Form->hidden('user_id', ['value'=>$authUser['User']['id']]); ?>
											<?php } ?> 
											<?php  echo $this->Form->hidden('total_price', ['value'=>$total_price]); ?>
											<?php  echo $this->Form->hidden('total_qty', ['value'=>$total_quanty]); ?>
											<?php  echo $this->Form->hidden('checkout_option', ['value'=>2,'id'=>'checkout_option']); ?>
                                    <div class="row">
                                       <div class="col-sm-6">
                                          <div class="form-group">
											 <?= $this->Form->control('billing_first_name', ['type'=>'text','placeholder'=>'First Name','label'=>false,'class'=>'form-control border-form-control','value' =>isset($userData->first_name)?$userData->first_name:'' ]);?>
                                          </div>
                                       </div>
                                       <div class="col-sm-6">
                                          <div class="form-group">
											 <?= $this->Form->control('billing_last_name', ['type'=>'text','placeholder'=>'Last Name','label'=>false,'class'=>'form-control border-form-control','value' =>isset($userData->last_name)?$userData->last_name:'']);?>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-6">
                                          <div class="form-group">
                                             
											 <?= $this->Form->control('billing_phone', ['type'=>'number','placeholder'=>'Billing Phone','label'=>false,'class'=>'form-control border-form-control','value' =>isset($userData->phone)?$userData->phone:'' ]);?>
                                          </div>
                                       </div>
                                       <div class="col-sm-6">
                                          <div class="form-group">
                                            
											 <?= $this->Form->control('billing_email', ['type'=>'email','placeholder'=>'Billing Email','label'=>false,'class'=>'form-control border-form-control','value' =>isset($userData->email)?$userData->email:'' ]);?>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-6">
                                          <div class="form-group">
                                             
											 <?= $this->Form->control('billing_country', ['type'=>'text','placeholder'=>'Billing Country','label'=>false,'class'=>'form-control border-form-control' ]);?>
                                          </div>
                                       </div>
                                       <div class="col-sm-6">
                                          <div class="form-group">
											  <?= $this->Form->control('billing_city', ['type'=>'text','placeholder'=>'Billing City','label'=>false,'class'=>'form-control border-form-control' ]);?>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-6">
                                          <div class="form-group">
                                             
											 <?= $this->Form->control('billing_zip', ['type'=>'text','placeholder'=>'Billing zip Code','label'=>false,'class'=>'form-control border-form-control' ]);?>
                                          </div>
                                       </div>
                                       <div class="col-sm-6">
                                          <div class="form-group">
											 <?= $this->Form->control('billing_state', ['type'=>'text','placeholder'=>'Billing State','label'=>false,'class'=>'form-control border-form-control' ]);?>
                                             
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-12">
                                          <div class="form-group">
											 <?= $this->Form->control('billing_street_address', ['type'=>'textarea','placeholder'=>'Billing Street Address','label'=>false,'class'=>'form-control border-form-control' ]);?>
                                             
                                             <small>(Please provide the number and street.)</small>
                                          </div>
                                       </div>
                                    </div>
									<div class="custom-control custom-checkbox mb-3">
                                       <input type="checkbox" class="custom-control-input same_as_billing" id="customCheckbill">
                                       <label class="custom-control-label" for="customCheckbill">Use my billing address as my delivery address</label>
                                    </div>
                                    <div class="heading-part">
                                       <h3 class="sub-heading">Delivery Address</h3>
                                    </div>
                                    <hr>
                                    <div class="row">
                                       <div class="col-sm-6">
                                          <div class="form-group">
											  <?= $this->Form->control('delivery_first_name', ['type'=>'text','placeholder'=>'First Name','label'=>false,'class'=>'form-control border-form-control' ]);?>
                                          </div>
                                       </div>
                                       <div class="col-sm-6">
                                          <div class="form-group">
											 <?= $this->Form->control('delivery_last_name', ['type'=>'text','placeholder'=>'Last Name','label'=>false,'class'=>'form-control border-form-control' ]);?>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-6">
                                          <div class="form-group">
											 <?= $this->Form->control('delivery_phone', ['type'=>'number','placeholder'=>'Delivery Phone','label'=>false,'class'=>'form-control border-form-control' ]);?>
                                          </div>
                                       </div>
                                       <div class="col-sm-6">
                                          <div class="form-group">
											 <?= $this->Form->control('delivery_email', ['type'=>'email','placeholder'=>'Delivery Email','label'=>false,'class'=>'form-control border-form-control' ]);?>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-6">
                                          <div class="form-group">
											 <?= $this->Form->control('delivery_country', ['type'=>'text','placeholder'=>'Delivery Country','label'=>false,'class'=>'form-control border-form-control' ]);?>
                                          </div>
                                       </div>
                                       <div class="col-sm-6">
                                          <div class="form-group">
											 <?= $this->Form->control('delivery_city', ['type'=>'text','placeholder'=>'Delivery City','label'=>false,'class'=>'form-control border-form-control' ]);?>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-6">
                                          <div class="form-group">
											 <?= $this->Form->control('delivery_zip', ['type'=>'text','placeholder'=>'Delivery Zip Code','label'=>false,'class'=>'form-control border-form-control' ]);?>
                                          </div>
                                       </div>
                                       <div class="col-sm-6">
                                          <div class="form-group">
											 <?= $this->Form->control('delivery_state', ['type'=>'text','placeholder'=>'Delivery State','label'=>false,'class'=>'form-control border-form-control' ]);?>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-12">
                                          <div class="form-group">
											 <?= $this->Form->control('delivery_street_address', ['type'=>'textarea','placeholder'=>'Delivery Street Address','label'=>false,'class'=>'form-control border-form-control' ]);?>
                                             <small>
											 Please include landmark (e.g : Opposite Bank) as the carrier service may find it easier to locate your address.
                                             </small>
                                          </div>
                                       </div>
                                    </div>
                                    
                                    <!--button type="button" class="btn btn-default" id="continue_to_address">CONTINUE</button--> 
									<div class="continue_to_address"><a class="view-button" id="continue_to_address" style="cursor: pointer;">Continue</a></div>
                              </div>
                           </div>
                        </div>
						<div class="card">
                           <div class="card-header" id="headingThree">
                              <h5 class="mb-0">
                                 <button class="btn btn-link" type="button" id="payment_information" data-toggle="collapse" data-target="#" aria-expanded="true" aria-controls="collapseThree">
                                 <span class="number">3</span> Payment Information
                                 </button>
                              </h5>
                           </div>
                           <div id="collapseThree" class="collapse " aria-labelledby="headingThree" data-parent="#accordionExample">
                              <div class="panel-body no-padding">
										<div class="order-review" id="checkout-review">    
											<div class="table-responsive" id="checkout-review-table-wrapper">
												<table class="data-table" id="checkout-review-table">
													<thead>
														<tr>
															<th style="width: 0%!important">SKU No</th>
															<th >Product Name</th>
															<th >Qty</th>
															<th >Price</th>
															<th >Subtotal</th>
														</tr>
													</thead>
													<tbody>
													<?php 
													$total_quanty = 0;
													$sub_total = 0;
													if(!empty($cardData)){ foreach ($cardData as $item) {
													$total_quanty += $item['product_qty'];
													$sub_total += $item['selling_price'];
														?>
														<tr>
															<td><?=$item['sku_no'] ;?></td>
															<td><h5 class="product-name product-name1"><?=$item['title'] ;?></h5></td>
															<td><?=$item['product_qty'] ;?></td>
															<td><span class="cart-price"><span class="price"><?="$".$item['selling_price'];?></span></span></td>
															 <!-- sub total starts here -->
															<td><span class="cart-price"><span class="price"><?="$".$item['selling_price'];?></span></span></td>
														</tr>
													 <?php } } ?>
													</tbody>
													<tfoot>
														
														<tr>
															<td colspan="2">Total Qty.</td>
															<td><span class="price"><?=$total_quanty;?></span></td>
															<td>Subtotal</td>
															<td><span class="price" id="sub_total"><?="$".$sub_total;?></span></td>
														</tr>
														
														<tr>
															<td colspan="4"><strong>Grand Total</strong></td>
															<td><strong><span class="price" id="total"><?="$".$sub_total;?></span></strong></td>
														</tr>
													</tfoot>
												</table>
											</div>
											
											<div id="checkout-review-submit">
												<div class="cart-btn-3" id="review-buttons-container">
													<p >Forgot an Item? <a href="<?php echo $this->Url->build(['controller'=>'products','action'=>'shopping']); ?>">Edit Your Cart</a></p>
													
													<div class="order-btn"><button type="submit" class="view-button" id="submit_button">Place Order</button></div>
												 </div>
											</div>
										</div>
									</div>
                           </div>
                        </div>
						<?= $this->Form->end() ?>
						<?php echo $this->Form->create(false,['url' => 'https://www.sandbox.paypal.com/cgi-bin/webscr','id'=>'form_paypal_submit']);?>
								<?php  echo $this->Form->hidden('cmd', ['value'=>'_cart']); ?>
								<?php  echo $this->Form->hidden('upload', ['value'=>1]); ?>
								<?php  echo $this->Form->hidden('business', ['value'=>$paypalemail]); ?>
								<?php  echo $this->Form->hidden('currency_code', ['value'=>'USD']); ?>
								<?php  echo $this->Form->hidden('custom', ['value'=>'','id'=>'order_id']); ?>
								
								<?php
								
								if(!empty($cardData)){$i =1; foreach ($cardData as $item) {
									 echo $this->Form->hidden('item_number_'.$i, ['value'=>$item['id']]);
									 echo $this->Form->hidden('item_name_'.$i, ['value'=>$item['title']]);
									 
									 echo $this->Form->hidden('amount_'.$i, ['value'=>$item['selling_price']]);
									 $i++; }}
								?>
								<!--echo $this->Form->hidden('shipping_1', ['value'=> '','id'=>'shipping_paypal']); -->
								<?php  echo $this->Form->hidden('return', ['value'=> Router::url('/', true).'Payments/success']); ?> 
								<?php  echo $this->Form->hidden('cancel_return', ['value'=>  Router::url('/', true).'Payments/cancel']); ?>
								<?php  echo $this->Form->hidden('notify_url', ['value'=>  Router::url('/', true).'Payments/success']); ?>
							<?= $this->Form->end() ?>
						
                        <!--div class="card">
                           <div class="card-header" id="headingThree">
                              <h5 class="mb-0" >
                                 <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                 <span class="number">3</span> Payment
                                 </button>
                              </h5>
                           </div>
                           <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                              <div class="card-body">
                                 <form class="col-lg-8 col-md-8 ">
                                    <div class="form-group">
                                       <label class="control-label">Card Number</label>
                                       <input class="form-control border-form-control" value="" placeholder="0000 0000 0000 0000" type="text">
                                    </div>
                                    <div class="row">
                                       <div class="col-sm-3">
                                          <div class="form-group">
                                             <label class="control-label">Month</label>
                                             <input class="form-control border-form-control" value="" placeholder="01" type="text">
                                          </div>
                                       </div>
                                       <div class="col-sm-3">
                                          <div class="form-group">
                                             <label class="control-label">Year</label>
                                             <input class="form-control border-form-control" value="" placeholder="15" type="text">
                                          </div>
                                       </div>
                                       <div class="col-sm-3">
                                       </div>
                                       <div class="col-sm-3">
                                          <div class="form-group">
                                             <label class="control-label">CVV</label>
                                             <input class="form-control border-form-control" value="" placeholder="135" type="text">
                                          </div>
                                       </div>
                                    </div>
                                    <hr>
                                    <div class="custom-control custom-radio">
                                       <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                       <label class="custom-control-label" for="customRadio1">Would you like to pay by Cash on Delivery?</label>
                                    </div>
                                    <p>Vestibulum semper accumsan nisi, at blandit tortor maxi'mus in phasellus malesuada sodales odio, at dapibus libero malesuada quis.</p>
                                    <div class="next-button"><a href="#">NEXT</a></div>
                                 </form>
                              </div>
                           </div>
                        </div>
                        <div class="card">
                           <div class="card-header" id="headingThree">
                              <h5 class="mb-0">
                                 <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                                 <span class="number">4</span> Order Complete
                                 </button>
                              </h5>
                           </div>
                           <div id="collapsefour" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                              <div class="card-body">
                                 <div class="text-center">
                                    <div class="col-lg-10 col-md-10 mx-auto order-done">
                                       <i class="mdi mdi-check-circle-outline text-secondary"></i>
                                       <h4 class="text-success">Congrats! Your Order has been Accepted..</h4>
                                       <p>
                                          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque lobortis tincidunt est, et euismod purus suscipit quis. Etiam euismod ornare elementum. Sed ex est, Sed ex est, consectetur eget consectetur, Lorem ipsum dolor sit amet...
                                       </p>
                                    </div>
                                    <div class="text-center next-button">
                                       <a href="#">Return to store</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div-->
                     </div>
                     </div>
                     </div>
               <div class="col-md-4">
                  <div class="card cart-right">
                     <h5 class="card-header">My Cart <span class="float-right">(<?= count($cardData); ?> item)</span></h5>
                     <div class="card-body pt-0 pr-0 pl-0 pb-0">
					 <?php
						if(!empty($cardData)){
							foreach($cardData as $key => $data){ ?>
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
                        <span class="badge badge-success">&nbsp;</span>
                           <h5><a href="<?php echo $this->Url->build(['controller'=>'products','action'=>'productView',base64_encode($data['sku_no'])]); ?>"><?= $data['title'];?></a></h5>
                           
                           <p class="offer-price mb-0">$<?= $data['selling_price'];?>  <span class="regular-price">$<?= $data['everyday_price'];?></span></p>
                        </div>
					 <?php }}else{ ?>
						<h4 style="text-align:center;margin-top: 20px;">Cart is empty !!</h4>
					 <?php } ?>	
					 <div class="cart-btn"><a class="view-button" href="<?php echo Router::url('/', true)."Products/shopping/"; ?>">Continue shopping</a></div>
					 
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
	  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
<script>
	$('.delete').click(function() {
		var csrfToken =  <?= json_encode($this->request->getParam('_csrfToken')) ?>;
		var id = $(this).attr("data1");
		
		var url ='<?php echo $this->Url->build(['controller'=>'products','action'=>'deleteCart']); ?>';    
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
	$(".same_as_billing").on("change", function(){
	if (this.checked) {
		$("[name='delivery_first_name']").val($("[name='billing_first_name']").val());
		$("[name='delivery_last_name']").val($("[name='billing_last_name']").val());
		$("[name='delivery_phone']").val($("[name='billing_phone']").val());
		$("[name='delivery_email']").val($("[name='billing_email']").val());
		$("[name='delivery_country']").val($("[name='billing_country']").val());
		$("[name='delivery_city']").val($("[name='billing_city']").val());
		$("[name='delivery_zip']").val($("[name='billing_zip']").val());
		$("[name='delivery_state']").val($("[name='billing_state']").val());
		$("[name='delivery_street_address']").val($("[name='billing_street_address']").val());
	}else{
		$("[name='delivery_first_name']").val('');
		$("[name='delivery_last_name']").val('');
		$("[name='delivery_phone']").val('');
		$("[name='delivery_email']").val('');
		$("[name='delivery_country']").val('');
		$("[name='delivery_city']").val('');
		$("[name='delivery_zip']").val('');
		$("[name='delivery_state']").val('');
		$("[name='delivery_street_address']").val('');
	}
});
	 $( "#continue_for_guest" ).click(function() {
	
		var checkout_method = $("input[name='checkoutOption']:checked").val();
		if(checkout_method == 'Guest'){
			$("#delivery_address").attr("data-target", "#collapseTwo");
			$("#checkout_option").val(1);
			$('#collapseTwo').addClass("show");
			$('#collapseOne').removeClass("show");
			$('#collapseThree').removeClass("show");
		}
	});
	$( "#continue_to_address" ).click(function() {
/////////billing form validation start////////////	 
	if($('#billing-first-name').val() == ""){
		$('#billing-first-name').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#billing-first-name").offset().top}, 500);
		return false;
	}
	else{
		$('#billing-first-name').css('border','1px solid #ced4da');
	}
	if($('#billing-last-name').val() == ""){
		$('#billing-last-name').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#billing-last-name").offset().top}, 500);
		return false;
	}
	else{
		$('#billing-last-name').css('border','1px solid #ced4da');
	}
	 
	 
	if($('#billing-email').val() == ""){
		$('#billing-email').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#billing-last-name").offset().top}, 500);
		return false;
	}
	else if($('#billing-email').val() != ""){
		var str = $('#billing-email').val();
		var patt = new RegExp("@");
		var res = patt.test(str);
		if(res == false){
			$('#billing-email').css('border','1px solid red');
			$('html, body').animate({scrollTop: $("#billing-email").offset().top}, 500);
			return false;
		}else{
			$('#billing-email').css('border','1px solid #ced4da');
		}
	}
	else{
		$('#billing-email').css('border','1px solid #ced4da');
	}
	if($('#billing-phone').val() == ""){
		$('#billing-phone').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#billing-phone").offset().top}, 500);
		return false;
	}
	else{
		$('#billing-phone').css('border','1px solid #ced4da');
	}
	if($('#billing-country').val() == ""){
		$('#billing-country').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#billing-country").offset().top}, 500);
		return false;
	}
	else{
		$('#billing-country').css('border','1px solid #ced4da');
	}
	if($('#billing-city').val() == ""){
		$('#billing-city').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#billing-city").offset().top}, 500);
		return false;
	}
	else{
		$('#billing-city').css('border','1px solid #ced4da');
	}
	if($('#billing-zip').val() == ""){
		$('#billing-zip').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#billing-zip").offset().top}, 500);
		return false;
	}
	else{
		$('#billing-zip').css('border','1px solid #ced4da');
	}
	if($('#billing-state').val() == ""){
		$('#billing-state').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#billing-state").offset().top}, 500);
		return false;
	}
	else{
		$('#billing-state').css('border','1px solid #ced4da');
	}
	if($('#billing-street-address').val() == ""){
		$('#billing-street-address').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#billing-street-address").offset().top}, 500);
		return false;
	}
	else{
		$('#billing-street-address').css('border','1px solid #ced4da');
	}
	/////////billing form validation end////////////
	/////////delivery form validation start////////////	 
	if($('#delivery-first-name').val() == ""){
		$('#delivery-first-name').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#delivery-first-name").offset().top}, 500);
		return false;
	}
	else{
		$('#delivery-first-name').css('border','1px solid #ced4da');
	}
	if($('#delivery-last-name').val() == ""){
		$('#delivery-last-name').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#delivery-last-name").offset().top}, 500);
		return false;
	}
	else{
		$('#delivery-last-name').css('border','1px solid #ced4da');
	}
	 
	 
	if($('#delivery-email').val() == ""){
		$('#delivery-email').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#delivery-email").offset().top}, 500);
		return false;
	}
	else if($('#delivery-email').val() != ""){
		var str = $('#delivery-email').val();
		var patt = new RegExp("@");
		var res = patt.test(str);
		if(res == false){
			$('#delivery-email').css('border','1px solid red');
			$('html, body').animate({scrollTop: $("#delivery-email").offset().top}, 500);
			return false;
		}else{
			$('#delivery-email').css('border','1px solid #ced4da');
		}
	}
	else{
		$('#delivery-email').css('border','1px solid #ced4da');
	}
	if($('#delivery-phone').val() == ""){
		$('#delivery-phone').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#delivery-phone").offset().top}, 500);
		return false;
	}
	else{
		$('#delivery-phone').css('border','1px solid #ced4da');
	}
	if($('#delivery-country').val() == ""){
		$('#delivery-country').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#delivery-country").offset().top}, 500);
		return false;
	}
	else{
		$('#delivery-country').css('border','1px solid #ced4da');
	}
	if($('#delivery-city').val() == ""){
		$('#delivery-city').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#delivery-city").offset().top}, 500);
		return false;
	}
	else{
		$('#delivery-city').css('border','1px solid #ced4da');
	}
	if($('#delivery-zip').val() == ""){
		$('#delivery-zip').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#delivery-zip").offset().top}, 500);
		return false;
	}
	else{
		$('#delivery-zip').css('border','1px solid #ced4da');
	}
	if($('#delivery-state').val() == ""){
		$('#delivery-state').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#delivery-state").offset().top}, 500);
		return false;
	}
	else{
		$('#delivery-state').css('border','1px solid #ced4da');
	}
	if($('#delivery-street-address').val() == ""){
		$('#delivery-street-address').css('border','1px solid red');
		$('html, body').animate({scrollTop: $("#delivery-street-address").offset().top}, 500);
		return false;
	}
	else{
		$('#delivery-street-address').css('border','1px solid #ced4da');
	}
	/////////delivery form validation end////////////
	if ($("#same_as_billing").is(":checked"))
		{
			 	
		    if($("#cr_password").val()=='')
			{
				$('#cr_password').css('border','1px solid red');
				 
				return false;
			}
			if($("#cr_cf_password").val()=='')
			{	 
				$('#cr_cf_password').css('border','1px solid red');
				return false;
			}
			if($("#cr_cf_password").val()!=$("#cr_password").val()){
				alert("Your password and confirmation password do not match.");
				return false;	
			}
		} 
		
	$("#payment_information").attr("data-target", "#collapseThree");
	$('#collapseTwo').removeClass("show");
	$('#collapseOne').removeClass("show");
	$('#collapseThree').addClass("show");
}); 

	/* $( "#continue_to_address" ).click(function() {
		$("#payment_information").attr("data-target", "#collapseThree");
		$('#collapseTwo').removeClass("show");
		$('#collapseOne').removeClass("show");
		$('#collapseThree').addClass("show");
	}); */
	$('#form_paypal').on('submit', function (e) {
	$("#submit_button").attr("disabled", true);
	$("#submit_button").text("PLACING ORDER......");
	var form = $(this);
	if(!form.hasClass('pending')) {
		e.preventDefault();
		form.addClass('pending');
			$.ajax({
			type: 'post',
			url: '<?php echo $this->Url->build(['controller'=>'products','action'=>'checkoutnew']); ?>',
			data: $('#form_paypal').serialize(),
			success: function (result) {
				//alert(result);
				//return false;
				if(result != 0){
					$('#order_id').val(result);
					$("#form_paypal_submit").submit();
				}
			}
		}); 
	}
});	
	$(document).ready(function(){
     $("#checkoutoption-guest").click(function(){
		var radioValue = $("#checkoutoption-guest").val();
		if(radioValue == 'Guest'){
			
			$('.continue_for_guest').css("display", "block");
			$('#login-form').css("display", "none");
		}
	});
	$("#checkoutoption-login").click(function(){
		var radioValue = $("#checkoutoption-login").val();
		if(radioValue == 'Login'){
			$('#delivery_address').removeAttr('data-target','#collapseTwo');
			$('.continue_for_guest').css("display", "none");
			$('#login-form').css("display", "block");
		}
	});
	});
</script>