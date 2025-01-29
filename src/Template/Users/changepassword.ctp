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
<section class="dshbrd">
    <div class="container">
        <div class="row">
            <?php echo $this->element('front/account_menu'); ?>
            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-one" role="tabpanel" aria-labelledby="v-pills-one-tab">
                        <?= $this->Flash->render('positive_changepass') ?>
                        <?= $this->Form->create($user); ?>
                        <h3 class="heading-title">Change Passowrd</h3>
                        <div class="col-md-6">
                            <div class="form_group">
                                <input placeholder="New Password" class="fotm_control" type="password" name="new_pswd" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form_group">
                                <input placeholder="Confirm Password" class="fotm_control" type="password" name="confirm_password" required>
                            </div>
                        </div>
                        <div class="form_group">
                            <button id="submitcreate" type="submit" class="btn">
                                Change Password
                            </button>
                        </div>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Cart Page Area Start-->
<div class="check-out-area">
    <div class="container">
        <div class="row">





        </div>
    </div>
</div>
<!--Cart Page Area End-->