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
 			<?php echo $this->element('front/account_menu'); ?>
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
 									<?= $this->Form->control('email-null', ['value' => $user->email, 'type' => 'email', 'placeholder' => 'Email', 'label' => false, 'class' => 'fotm_control', "readonly" => true, "disabled" => true]); ?>
 									<?= $this->Form->control('email', ['type' => 'hidden', 'label' => false]); ?>
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
 				</div>
 			</div>
 		</div>
 	</div>
 </section>
 <!--Cart Page Area End-->