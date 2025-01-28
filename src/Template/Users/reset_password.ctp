<?php

use Cake\Routing\Router; ?>
<!-- About Area start -->
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
    <div class="container">
        <div class="row forgot-password">
            <div class="account-details forgot-password-form">
                <p>Reset Password</p>
                <?= $this->Flash->render('positive_reset') ?>
                <?= $this->Form->create(false, ['url' => ['controller' => 'Users', 'action' => 'resetPassword', $initial_id], 'class' => 'forgot-password-form2', 'id' => 'loginform']); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form_group">
                            <?= $this->form->control('password', ['div' => false, 'label' => false, 'placeholder' => 'Enter Your Password', 'class' => 'fotm_control']); ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form_group">
                            <?= $this->form->control('password2', ['div' => false, 'type' => 'password', 'label' => false, 'placeholder' => 'Confirm Your Password', 'class' => 'fotm_control']); ?>
                        </div>
                    </div>
                    <div class="form_group">
                        <?php echo $this->Form->button("<span>Reset Password</span>", array('name' => 'submitcreate2', 'class' => 'btn', 'type' => 'submit', 'id' => 'submitcreate2', 'title' => 'Reset Password')); ?>
                    </div>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</section>
<!-- About Area end -->