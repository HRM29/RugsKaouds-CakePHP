<?php

use Cake\Routing\Router;
use Cake\Core\Configure;

$session = $this->request->getSession();
$action = $this->request->getParam('action');
$controller = $this->request->getParam('controller');
$authUser = $session->read('Auth');
?>
<header class="main-header">
  <!-- Logo -->
  <a href="<?php echo Router::url('/', true); ?>admin/users" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b><?php echo $this->Html->image('/img/logo.jpg', ['alt' => Configure::read('App.HeaderName')]); ?></b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><?php
                          echo $this->Html->image('/img/admn_logo.jpg', ['alt' => Configure::read('App.meta')]);
                          ?></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php
            if (!empty($authUser['User']['avatar'])) {
              $original = WWW_ROOT . 'uploads/user' . DS . 'thumb' . DS . $authUser['User']['avatar'];
              if (file_exists($original)) {

                echo $this->html->image('../uploads/user/thumb/' . $authUser['User']['avatar'],   array('height' => '100%', 'class' => 'user-image'));
              } else {
                echo $this->html->image('user-img.jpg',   array('height' => '100%', 'class' => 'user-image'));
              }
            } else {
              echo $this->html->image('user-img.jpg',   array('height' => '100%', 'class' => 'user-image'));
            }
            ?>
            <span class="hidden-xs"><?php echo ucfirst($authUser['User']['first_name']) . " " . $authUser['User']['last_name']; ?></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <?php
              if (!empty($authUser['User']['avatar'])) {
                $original = WWW_ROOT . 'uploads/user' . DS . 'thumb' . DS . $authUser['User']['avatar'];
                if (file_exists($original)) {

                  echo $this->html->image('../uploads/user/thumb/' . $authUser['User']['avatar'],   array('height' => '100%', 'class' => 'profile-user-img img-responsive img-circle'));
                } else {
                  echo $this->html->image('user-img.jpg',   array('height' => '100%', 'class' => 'profile-user-img img-responsive img-circle'));
                }
              } else {
                echo $this->html->image('user-img.jpg',   array('height' => '100%', 'class' => 'profile-user-img img-responsive img-circle'));
              }
              ?>
              <p>
                <?php echo ucfirst($authUser['User']['first_name']) . " " . $authUser['User']['last_name']; ?>
                <small>Member since <?php echo date("Y-m-d H:i A", strtotime($authUser['User']['created'])); ?></small>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="<?php echo Router::url('/', true); ?>admin/users/view/<?php echo $authUser['User']['id']; ?>" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="<?php echo Router::url('/', true); ?>admin/users/logout" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
          <a href="<?php echo Router::url('/', true); ?>admin/settings"><i class="fa fa-gears"></i></a>
        </li>
      </ul>
    </div>
  </nav>
</header>
<script>
  CKEDITOR.on('dialogDefinition', function(e) {
    dialogName = e.data.name;
    dialogDefinition = e.data.definition;
    if (dialogName == 'image') {
      dialogDefinition.removeContents('Link');
      dialogDefinition.removeContents('advanced');
      var tabContent = dialogDefinition.getContents('info');
      tabContent.remove('txtBorder');
      tabContent.remove('txtHSpace');
      tabContent.remove('txtVSpace');
      tabContent.remove('cmbAlign');
      tabContent.remove('txtAlt');
      tabContent.remove('txtBorder');
      tabContent.remove('ratioLock'); // Remove Lock Ratio
      tabContent.remove('resetSize');
    }
  });
</script>