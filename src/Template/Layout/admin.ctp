<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Core\Configure;
 
$cakeDescription = Configure::read('App.meta');
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->css(array('../plugins/bootstrap/css/bootstrap.min','admin/AdminLTE.min','../plugins/iCheck/css/all','../plugins/iCheck/flat/css/blue','admin/skin-blue.min.css?ver=2.5')) ?>
	 <!-- <link rel="stylesheet" href="/Kaouds/css/admin/skin-blue.min.css?ver=2.5"> -->
	
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      
	<?php echo $this->Html->css(array('../plugins/timepicker/css/bootstrap-timepicker.min.css','admin/daterangepicker/daterangepicker-bs3',)) ?>
	<?php echo $this->Html->css(array('../plugins/bootstrap-multiselect/css/bootstrap-multiselect.css')) ?> <!-- multi select-->
	<?php echo $this->Html->css(array('../plugins/bootstrap/css/bootstrap-select.min.css')) ?> <!-- multi select-->
	<?php echo $this->Html->css(array('../plugins/jQuery/css/jquery-ui.css')) ?> <!-- auto complete-->

	
    
	<?php //echo $this->Html->script(array('admin/bootstrap-timepicker.min','admin/daterangepicker/daterangepicker'));?>

	<?php echo $this->Html->script(array('../plugins/jQuery/jQuery-2.1.4.min'));?>
	<?php echo $this->Html->script(array('../plugins/timepicker/js/bootstrap-timepicker.min','admin/daterangepicker/daterangepicker'));?>   
	<?php echo $this->Html->script(array('../plugins/iCheck/js/icheck.min'));?>
	
	<?php echo $this->Html->script('../plugins/bootstrap/js/bootstrap-select.min.js');?> <!-- multi select-->
	<?php echo $this->Html->script('../plugins/bootstrap-multiselect/js/bootstrap-multiselect.js');?> <!-- multi select-->
	<?php echo $this->Html->script('../plugins/jQuery/js/jquery-ui.js');?> <!-- auto complete-->
	
	
	
    <title>
        <?= $cakeDescription ?>
        <?php // $this->fetch('title') ?>
    </title>
    <!-- <?= $this->Html->meta('icon') ?> -->
 
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper"> 
		<?= $this->element('admin_header'); ?> 
		<?= $this->element('admin_menu'); ?> 
		<div class="content-wrapper">
			<?= $this->Flash->render('positive') ?>
			<?= $this->fetch('content') ?>
		</div>
		<footer class="main-footer"> 
			<strong><?= Configure::read('App.copyright') ?></strong>
	  <?php echo $this->Html->script(array('../plugins/bootstrap/js/bootstrap.min.js','admin/jquery-ui.min.js'));?>
	  <!-- jQuery UI 1.11.4 -->
		 
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
		  $.widget.bridge('uibutton', $.ui.button);
		</script>
		
		<?php echo $this->Html->script(array('admin/app.min.js'));?> 
	</div>
</body>
</html>
