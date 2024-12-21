<?php 
use Cake\Routing\Router;
use Cake\Core\Configure;
?>

	<div class="contact-area pb-34 pb-md-18 pb-sm-0">
    <div class="container p-0"> 
            <div class="img-static">
<img src="../img/gor_store_front_nc.jpg">
</div>
                <div class="row">
                    <div class="col-sm-4 m-30">
                        <div class="contact-message">
                            <h1>Get In Touch</h1>
							<?= $this->Flash->render('positive') ?>
							<?= $this->Form->create($data, ['class'=>'contact-form']) ?>
                                <div class="row">
                                    <div class="form-group col-sm-12">
										<?= $this->Form->control('name', ['placeholder'=>'Name *','label'=>false,'class'=>'form-control','required'=>true]);?>
                                    </div>
                                    <div class="form-group col-sm-12">
										<?= $this->Form->control('phone', ['placeholder'=>'Phone *','label'=>false,'class'=>'form-control','required'=>true]);?>
                                    </div>
                                    <div class="form-group col-sm-12">
										<?= $this->Form->control('email', ['placeholder'=>'Email *','label'=>false,'class'=>'form-control','required'=>true,'type'=>'email']);?>
                                    </div>
                                    <div class="form-group col-sm-12">
										<?= $this->Form->control('subject', ['placeholder'=>'Subject *','label'=>false,'class'=>'form-control','required'=>true]);?>
                                    </div>
									<div class="form-group col-sm-12">
                                        <div class="contact2-textarea text-center">
											<?= $this->Form->control('message', ['placeholder'=>'Message *','label'=>false,'class'=>'form-control','required'=>true,'type'=>'textarea']);?>     
                                        </div>   
                                        <div class="contact-btn m-30">
                                            <?= $this->Form->button(__('Send Message'),['class'=>'view-button']) ?>
                                        </div> 
                                    </div> 
                                    <div class="col-12 d-flex justify-content-center">
                                        <p class="form-messege"></p>
                                    </div>
                                </div>
                            <?= $this->Form->end() ?>
                        </div> 
                        </div>
                    <div class="col-sm-7 m-30 offset-sm-1">
                    <div class="contact-info">
                        <div class="mt-md-28 mt-sm-28">
                            <h1>Contact us</h1>
                            <ul>
                                <li><!--i class="fa fa-map-o"></i--> <?= Configure::read('App.Address'); ?></li>
                                <li><!--i class="fa fa-mobile-phone"></i--> <?= Configure::read('App.contactus_phone'); ?></li>
                                <li><!--i class="fa fa-envelope-o"></i--> <?= Configure::read('App.ConfigEmail'); ?></li>
                            </ul>
                            <div class="working-time">
                                <h2>STORE HOURS</h2>
                                <p><span><? //= Configure::read('App.store_hours'); ?>
								Monday-Saturday 9:00AM – 06:00PM <br>Sundays by Appointment
								</span></p>
                            </div>
                            <div class="contact-directions">
                            <h2><a href="http://maps.google.com/maps?daddr=4101+Oleander+Drive,+Wilmington,+NC+28403" target="_blank">Get directions</a></h2>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- contact area end -->