 <?php

	use Cake\Routing\Router;
	?>
 <section class="inner_banner shp">
 	<div class="container-fluid">
 		<div class="row">
 			<div class="col-md-12 no_padding">
 				<div class="inr_bnr">
 					<div class="col-md-12 no_padding">
 						<div class="inr_bnr">
 							<?php
								$image = WWW_ROOT . 'img' . DS . 'conact_us_banner.jpg';
								if (file_exists($image)) {
									echo $this->Html->image('/img/' . "conact_us_banner.jpg", ['alt' => "conact_us_banner"]);
								}
								?>
 						</div>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
 </section>
 <!--Cart Page Area Start-->
 <section class="dshbrd">
 	<div class="container">
 		<div class="row">
 			<div class="col-md-3">
 				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
 					<a class="nav-link active" id="v-pills-one-tab" href="<?php echo Router::url('/', true); ?>users/myaccount">Dashboard</a>
 					<a class="nav-link" id="v-pills-two-tab" href="<?php echo Router::url('/', true); ?>users/myorder">Orders</a>
 					<!-- <button class="nav-link" id="v-pills-three-tab" data-bs-toggle="pill" data-bs-target="#v-pills-three" type="button" role="tab" aria-controls="v-pills-three" aria-selected="false">Download</button> -->
 					<a class="nav-link" id="v-pills-four-tab" href="<?php echo Router::url('/', true); ?>users/myorder">Address</a>
 					<!-- <button class="nav-link" id="v-pills-five-tab" data-bs-toggle="pill" data-bs-target="#v-pills-five" type="button" role="tab" aria-controls="v-pills-five" aria-selected="false">Payment Methods</button> -->
 					<!-- <button class="nav-link" id="v-pills-six-tab" >Account Details</button> -->
 					<a class="nav-link" id="v-pills-six-tab" href="<?php echo Router::url('/', true); ?>users/changepassword">Change Password</a>
 					<a class="nav-link" id="v-pills-seven-tab" href="<?php echo Router::url('/', true); ?>users/wishlist">Wishlist</a>
 					<button class="nav-link" id="v-pills-eight-tab" href="<?php echo Router::url('/', true); ?>users/logout">Logout</button>
 				</div>
 			</div>
 			<div class="col-md-9">
 				<div class="tab-content" id="v-pills-tabContent">
 					<div class="tab-pane fade show active" id="v-pills-one" role="tabpanel" aria-labelledby="v-pills-one-tab">
 						<?= $this->Flash->render('positive_myaccount') ?>
 						<?= $this->Form->create($user, ['url' => ['controller' => 'Users', 'action' => 'myaccount'], 'type' => 'file']); ?>
 						<h3>Dashboard</h3>
 						<div class="row">
 							<div class="col-md-6">
 								<div class="form_group">
 									<?= $this->Form->control('first_name', ['type' => 'text', 'placeholder' => 'First Name"', 'label' => false, 'class' => 'fotm_control']); ?>
 								</div>
 							</div>
 							<div class="col-md-6">
 								<div class="form_group">
 									<?= $this->Form->control('last_name', ['type' => 'text', 'placeholder' => 'Last Name"', 'label' => false, 'class' => 'fotm_control']); ?>
 								</div>
 							</div>
 							<div class="col-md-6">
 								<div class="form_group">
 									<?= $this->Form->control('email', ['type' => 'email', 'placeholder' => 'Email', 'label' => false, 'class' => 'fotm_control']); ?>
 								</div>
 							</div>
 							<div class="col-md-6">
 								<div class="form_group">
 									<?= $this->Form->control('phone', ['type' => 'text', 'placeholder' => 'Phone', 'label' => false, 'class' => 'fotm_control']); ?>
 								</div>
 							</div>
 							<div class="col-md-6">
 								<div class="form_group">
 									<?= $this->Form->control('company_name', ['type' => 'text', 'placeholder' => 'Company Name', 'label' => false, 'class' => 'fotm_control']); ?>
 								</div>
 							</div>
 							<?php echo $this->Form->hidden('password', ['value' => 'nothing']); ?>
 							<?php echo $this->Form->hidden('status', ['value' => 1]); ?>
 							<div class="form_group">
 								<button type="submit" title="Update Profile" class="btn"><span>Update Profile</span></button>
 							</div>
 						</div>
 						<?= $this->Form->end() ?>
 					</div>
 					<div class="tab-pane fade" id="v-pills-two" role="tabpanel" aria-labelledby="v-pills-two-tab">
 						<div class="table-responsive crt_tbl">
 							<h3>Orders</h3>
 							<table class="table table-bordered">
 								<thead>
 									<tr>
 										<th scope="col">Product</th>
 										<th scope="col">Product Name</th>
 										<th scope="col">Price</th>
 										<th scope="col">Quantity</th>
 										<th scope="col">Subtotal</th>
 										<th scope="col">Edit</th>
 									</tr>
 								</thead>
 								<tbody>
 									<tr>
 										<th scope="row"><img src="images/crt_prdct001.jpg" alt="crt_prdct"></th>
 										<td>2'9"x4'1" Polar Bear White, Nain with Large Medallion Design, 250 KPSI, Wool and Silk, Hand Knotted, Oriental Rug</td>
 										<td>$922.28</td>
 										<td>
 											<form class="qnty">
 												<div class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
 												<input type="number" id="number" value="0" />
 												<div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
 											</form>
 										</td>
 										<td>$922.28</td>
 										<td><a href="#"><img src="images/dlt.png" alt="dlt"></a></td>
 									</tr>
 								</tbody>
 							</table>
 						</div>
 					</div>
 					<div class="tab-pane fade" id="v-pills-three" role="tabpanel" aria-labelledby="v-pills-three-tab">
 						<h3>Download</h3>
 					</div>
 					<div class="tab-pane fade" id="v-pills-four" role="tabpanel" aria-labelledby="v-pills-four-tab">
 						<form action="#">
 							<h3>Address</h3>
 							<div class="row">
 								<div class="col-md-6">
 									<div class="form_group">
 										<input class="fotm_control" type="text" name="name" value="" placeholder="First Name">
 									</div>
 								</div>
 								<div class="col-md-6">
 									<div class="form_group">
 										<input class="fotm_control" type="text" name="name" value="" placeholder="Last Name">
 									</div>
 								</div>
 								<div class="col-md-6">
 									<div class="form_group">
 										<input class="fotm_control" type="mail" name="mail" value="" placeholder="Email">
 									</div>
 								</div>
 								<div class="col-md-6">
 									<div class="form_group">
 										<input class="fotm_control" type="number" name="number" value="" placeholder="Phone Number">
 									</div>
 								</div>
 								<div class="col-md-12">
 									<div class="form_group">
 										<input class="fotm_control" type="text" name="adrs" value="" placeholder="Address Line 1">
 									</div>
 								</div>
 								<div class="col-md-12">
 									<div class="form_group">
 										<input class="fotm_control" type="text" name="adrs" value="" placeholder="Address Line 2">
 									</div>
 								</div>
 								<div class="col-md-4">
 									<div class="form_group">
 										<input class="fotm_control" type="text" name="city" value="" placeholder="city">
 									</div>
 								</div>
 								<div class="col-md-4">
 									<div class="form_group">
 										<input class="fotm_control" type="text" name="State" value="" placeholder="State">
 									</div>
 								</div>
 								<div class="col-md-4">
 									<div class="form_group">
 										<input class="fotm_control" type="text" name="Zip Code" value="" placeholder="Zip Code">
 									</div>
 								</div>
 							</div>
 							<div class="form_group">
 								<a class="btn" href="#">Submit</a>
 							</div>
 						</form>
 					</div>
 					<div class="tab-pane fade" id="v-pills-five" role="tabpanel" aria-labelledby="v-pills-five-tab">
 						<form action="#">
 							<h3>Payment Methods</h3>
 							<div class="row">
 								<div class="col-md-12">
 									<div class="form_group">
 										<input class="fotm_control" inputmode="numeric" type="tel" maxlength="16" placeholder="Card Number">
 									</div>
 								</div>
 								<div class="col-md-6">
 									<div class="form_group">
 										<input class="fotm_control" type="date" name="date" value="" placeholder="Expiry (MM/YY)">
 									</div>
 								</div>
 								<div class="col-md-3">
 									<div class="form_group">
 										<input class="fotm_control" inputmode="numeric" type="tel" maxlength="4" placeholder="CVV">
 									</div>
 								</div>
 								<div class="form_group">
 									<a class="btn" href="#">Add Payment method</a>
 								</div>
 							</div>
 						</form>
 					</div>
 					<div class="tab-pane fade" id="v-pills-six" role="tabpanel" aria-labelledby="v-pills-six-tab">
 						<form action="#">
 							<h3>Dashboard</h3>
 							<div class="row">
 								<div class="col-md-6">
 									<div class="form_group">
 										<input class="fotm_control" type="text" name="name" value="" placeholder="First Name">
 									</div>
 								</div>
 								<div class="col-md-6">
 									<div class="form_group">
 										<input class="fotm_control" type="text" name="name" value="" placeholder="Last Name">
 									</div>
 								</div>
 								<div class="col-md-6">
 									<div class="form_group">
 										<input class="fotm_control" type="text" name="mail" value="" placeholder="Email">
 									</div>
 								</div>
 								<div class="col-md-6">
 									<div class="form_group">
 										<input class="fotm_control" type="text" name="number" value="" placeholder="Phone Number">
 									</div>
 								</div>
 								<div class="col-md-12">
 									<div class="form_group">
 										<textarea class="fotm_control" name="" placeholder="Message"></textarea>
 									</div>
 								</div>
 								<div class="form_group">
 									<a class="btn" href="#">Submit</a>
 								</div>

 							</div>
 						</form>
 					</div>
 					<div class="tab-pane fade" id="v-pills-seven" role="tabpanel" aria-labelledby="v-pills-seven-tab">
 						<div class="table-responsive crt_tbl">
 							<h3>Wishlist</h3>
 							<table class="table table-bordered">
 								<thead>
 									<tr>
 										<th scope="col">Product Name</th>
 										<th scope="col">Unit Price</th>
 										<th scope="col">Stock Status</th>
 									</tr>
 								</thead>
 								<tbody>
 									<tr>
 										<td>2'9"x4'1" Polar Bear White, Nain with Large Medallion Design, 250 KPSI, Wool and Silk, Hand Knotted, Oriental Rug</td>
 										<td>$922.28</td>
 										<td>-</td>
 									</tr>
 								</tbody>
 							</table>
 						</div>
 					</div>
 					<div class="tab-pane fade" id="v-pills-eight" role="tabpanel" aria-labelledby="v-pills-eight-tab">Eight</div>
 				</div>
 			</div>
 		</div>
 	</div>
 </section>
 <!--Cart Page Area End-->