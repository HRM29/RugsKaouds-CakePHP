 <?php

	use Cake\Routing\Router;
	?>
 <section class="inner_banner shp">
 	<div class="container-fluid">
 		<div class="row">
 			<div class="col-md-12">
  				<div class="heading">
					<h3>Address</h3>
				</div>
 			</div>
 		</div>
 	</div>
 </section>
 <!--Cart Page Area Start-->
 <section class="dshbrd">
 	<div class="container-fluid">
 		<div class="row">
 			<?php echo $this->element('front/account_menu'); ?>
 			<div class="col-md-9 no_padding">
 				<div class="tab-content" id="v-pills-tabContent">
 					<div class="tab-pane fade show active" id="v-pills-one" role="tabpanel" aria-labelledby="v-pills-one-tab">
 						<?= $this->Flash->render('positive_myaccount') ?>
 						<?php
							// echo "<pre>states: ";
							// print_r($states);
							// echo "</pre>";
							?>
 						<?= $this->Form->create($userDetail, ['url' => ['controller' => 'Users', 'action' => 'myaccountDetails'], 'type' => 'file']); ?>
 						<h3>Account Details</h3>
 						<div class="row">
 							<div class="col-md-6">
 								<div class="form_group">
 									<?= $this->Form->control('address', ['type' => 'text', 'placeholder' => 'Address', 'label' => false, 'class' => 'fotm_control']); ?>
 								</div>
 							</div>
 							<div class="col-md-6">
 								<div class="form_group">
 									<?= $this->Form->control('city', ['type' => 'text', 'placeholder' => 'City', 'label' => false, 'class' => 'fotm_control']); ?>
 								</div>
 							</div>
 							<div class="col-md-6">
 								<div class="form_group">
 									<?= $this->Form->control('state', [
											'type' => 'select',
											'options' => $states,
											'empty' => 'Select State',
											'label' => false,
											'class' => 'fotm_control',
											'required' => true
										]); ?>
 								</div>
 							</div>
 							<div class="col-md-6">
 								<div class="form_group">
 									<?= $this->Form->control('country-null', [
											'type' => 'select',
											'options' => [
												'US' => 'United States',
											],
											'empty' => 'Select Country',
											'label' => false,
											'class' => 'fotm_control',
											'required' => true,
											'value'	=> 'US',
											"readonly" => true,
											"disabled" => true
										]); ?>
 									<?= $this->Form->control('country', ['type' => 'hidden', 'label' => false, 'value' => "US"]); ?>
 								</div>
 							</div>
 							<div class="col-md-6">
 								<div class="form_group">
 									<?= $this->Form->control('postal_code', ['type' => 'text', 'placeholder' => 'Postal Code', 'label' => false, 'class' => 'fotm_control', 'required' => true]); ?>
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
 				</div>
 			</div>
 		</div>
 	</div>
 </section>
 <!--Cart Page Area End-->
 