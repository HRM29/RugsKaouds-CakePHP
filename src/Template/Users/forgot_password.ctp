<?php

use Cake\Routing\Router; ?>
<section class="inner_banner shp">
    <div class="container-fluid">
        <div class="row">
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
</section>
<section class="rg_clng lst_pswrd">
    <div class="container-fluid">
        <div class="row forgot-password">
            <div class="account-details forgot-password-form">
                <p>Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.</p>
                <?= $this->Flash->render('positive_forgot') ?>
                <?php echo $this->Form->create($user, ['url' => ['controller' => 'users', 'action' => 'forgotpassword'], 'class' => 'forgot-password-form2', 'id' => 'loginform']); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form_group">
                            <?php echo  $this->Form->control('email', ["name" => "email", 'label' => false, "placeholder" => "Username or Email", "class" => "fotm_control", "div" => false, "required" => true]); ?>
                        </div>
                    </div>
                    <div class="form_group">
                        <?php echo $this->Form->button("<span>Reset Password</span>", array('name' => 'submitcreate2', 'class' => 'btn', 'type' => 'submit', 'id' => 'submitcreate2', 'title' => 'send link')); ?>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</section>
<!-- About Area end -->