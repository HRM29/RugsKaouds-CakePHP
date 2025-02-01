<section class="inner_banner shp">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 no_padding">
            </div>
        </div>
    </div>
</section>
<!-- About Area start -->
<section class="rg_clng acount">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?= $this->Flash->render('positive_login') ?>
                <?php echo $this->Form->create($userlogin, ['url' => ['controller' => 'Users', 'action' => 'login'], 'class' => 'login-form', 'id' => 'loginform']); ?>
                <!-- <form method="post" class="login-form" action="#"> -->
                <h3 class="heading-title">Login</h3>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form_group">
                            <input class="fotm_control" type="email" name="email" id="emailId" value="" placeholder="Username or Email" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form_group">
                            <input class="fotm_control" type="password" name="password" id="login-password" value="" placeholder="Password">
                        </div>
                    </div>
                    <label>
                        <input type="checkbox" value="" name="remember-me-check" id="remember-me-check">
                        <span for="remember-me-check">Remember me</span>
                    </label>
                    <div class="form_group">
                        <?php echo $this->Form->button("<span>Login</span>", array('name' => 'submitcreate2', 'class' => 'btn', 'type' => 'submit', 'id' => 'submitcreate2', 'title' => 'Create an account')); ?>
                    </div>
                    <p class="lst_pswrd"><a rel="nofollow" href="<?php echo $this->Url->build(['controller' => 'users', 'action' => 'forgotPassword']); ?>">Lost Your Password?</a></p>
                </div>
                <?= $this->Form->control('g-recaptcha-response', ["type" => "hidden", "class" => "g-recaptcha-response", "id" => false]); ?>
                <?php echo $this->Form->end(); ?>
            </div>
            <div class="col-md-6">
                <?= $this->Flash->render('positive_register'); ?>
                <?php echo $this->Form->create($user, ['url' => ['controller' => 'Users', 'action' => 'register'], 'class' => 'create-account-form', 'id' => 'signupform']); ?>
                <!-- <form method="post" class="create-account-form" action="#"> -->
                <h3 class="heading-title">Register</h3>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form_group ">
                            <?php echo  $this->Form->control('email', ['label' => false, "placeholder" => "Enter Email Address", "class" => "fotm_control", "div" => false, "required" => true]); ?>
                        </div>
                    </div>
                </div>
                <p>A link to set a new password will be sent to your email address.</p>
                <p>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our </p>
                <label>
                    <input name="sign-up-letter" type="checkbox" value="" id="sign-up-letter">
                    <span for="sign-up-letter">Sign me up for the newsletter!</span>
                </label>
                <div class="form_group">
                    <?php echo $this->Form->button("<span>Register</span>", array('name' => 'submitcreate', 'class' => 'view-button btn', 'type' => 'submit', 'id' => 'submitcreate',  'title' => 'Create an account')); ?>
                </div>
                <?= $this->Form->control('g-recaptcha-response', ["type" => "hidden", "class" => "g-recaptcha-response", "id" => false]); ?>
                <?php echo $this->Form->end(); ?>
            </div>

        </div>
    </div>
</section>
<!-- About Area end -->
<script>
    function toggleRemeberMeCheckbox() {
        const remeberMeCheckbox = document.getElementById('remember-me-check');
        remeberMeCheckbox.addEventListener('change', function() {
            if (this.checked) {
                this.value = '1';
            } else {
                this.value = '0';
            }
        });
    }
    function toggleNewsletterCheckbox() {
		const newsletterCheckbox = document.getElementById('sign-up-letter');
		newsletterCheckbox.addEventListener('change', function() {
			if (this.checked) {
				this.value = '1';
			} else {
				this.value = '0';
			}
		});
	}
    toggleRemeberMeCheckbox();
    toggleNewsletterCheckbox();
</script>