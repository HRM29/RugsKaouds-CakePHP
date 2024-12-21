 <?php use Cake\Routing\Router;?>

<style>
.product-quantity{
	height: 50px;
}
th{
	text-align:center;
	width: 112px;
}
.order-list {
    text-align: center;
}
</style>
 <!--Cart Page Area Start-->
        <div class="check-out-area">
            <div class="container">
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
							<div class="about_status" style="padding: 20px;">
								<strong>Total Orders : <?= count($totalOrders);?> </strong><br />
								<strong>Payment Status (Pending) : <?= count($PendingListing);?> </strong><br />
								<strong>Payment Status (Completed) : <?= count($CompleteListing);?> </strong>
							</div>
                            <div class="wishlist-table-area table-responsive">
                            <table class="table"> 
                                <thead>
                                    <tr style="height: 50px;">
                                       
										<!--th class="product-image">Image</th>
                                        <th class="t-product-name">Product Name</th>
                                        <th class="product-edit">Item Number</th>
                                        <th class="product-unit-price">Unit Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Subtotal</th-->

                                        <th >Order ID</th>
                                        <th >Payment Status</th>
                                        <th >Total Price</th>
                                        <th >Order Date</th>
                                        <th >Order Status</th>
										<th >View More</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
								<?php
									foreach($OrderListing as $key => $value){

								?>
                                    <tr class="order-list" style="height: 50px;">
                                        <td >
                                            <?= "#".$value->id; ?>
                                        </td>
										<td >
                                            <?php if($value->payment_status == 1){
													  echo "Completed";
												  }else if($value->payment_status == 2){
													  echo "Cancelled";
												  }else{
													  echo "Pending";
												  };?>
                                        </td>
                                        <td >
											<?= "$".$value->total_price;?>
                                        </td>
										<td >
											<?= $value->created;?>
                                        </td>
										<td >
											<?= $this->General->getOrderstatus($value->order_status) ?>
                                        </td>
                                        <td >
                                            <a href="<?php echo Router::url('/', true); ?>users/orderDetail/<?= $value->id; ?>" title="View Order"><i class="fa fa-eye"></i></a>	
                                        </td>
                                        
                                    </tr>
								 <?php } ?>
                                </tbody>
                            </table>
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
							   
							 </ul>
						</nav>
                     </div>
                </div>
                        </div>
				
 			
        </div>
        </div>
        </div>
        <!--Cart Page Area End-->