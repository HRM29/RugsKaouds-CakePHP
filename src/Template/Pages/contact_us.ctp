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
                    <div class="col-sm-5 m-30">
                        <div class="contact-message">
                            <h1>Gallery Of Oriental Rugs</h1>
                            <p><span>For more information, please email <a href="mailto:info@rugsnc.com">info@rugsnc.com or call 910.392.2605. Thank you!</p>
							
                        </div> 
                        </div>
                    <div class="col-sm-6 m-30 offset-sm-1">
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