<?php use Cake\Routing\Router;?>
<?php
	$session = $this->request->getSession(); 
	$action = $this->request->getParam('action');
	$controller = $this->request->getParam('controller');
	$authUser = $session->read('Auth');

	$usrs = array('userList','add','edit','view');
	$defaulActions = array('index','add','edit','view');
	 
?> 
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
	  <!-- Sidebar user panel -->
	  <div class="user-panel">
		<div class="pull-left image">
		  <!--img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"-->
		  <!--img src="<?php //echo $this->html->image('../uploads/user/thumb/' . $authUser['User']['avatar']); ?>" alt="Logo" /-->
		 <?php //=   $this->html->image('../uploads/user/thumb/' . $authUser['User']['avatar'], 	array('height' => '100%', 'class' => 'profile-user-img img-responsive img-circle'));  ?>
		</div>
		<!--div class="pull-left info"-->
		  <!--p><?php echo ucfirst($authUser['User']['first_name'])." ".$authUser['User']['last_name'];?></p-->
		  <!--a href="#"><i class="fa fa-circle text-success"></i> Online</a-->
		<!--/div-->
	  </div>
	  <!-- search form -->
	  <!--form action="#" method="get" class="sidebar-form">
		<div class="input-group">
		  <input type="text" name="q" class="form-control" placeholder="Search...">
		  <span class="input-group-btn">
			<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
		  </span>
		</div>
	  </form-->
	  <!-- /.search form -->
	  <!-- sidebar menu: : style can be found in sidebar.less -->
	  <ul class="sidebar-menu">
		<!--li class="header">MAIN NAVIGATION</li-->
		<li class="treeview <?php echo ($controller == 'Users' && $action == 'index')?'active':'';?>">
		  <a href="<?php echo Router::url('/', true); ?>admin/users">
			<i class="fa fa-dashboard"></i> <span>Dashboard</span>
		  </a> 
		</li>
		
			
		<!-- Email Templates -->
		
		<li class="treeview <?php echo ($controller == 'EmailTemplates' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-envelope"></i>
			<span>Manage Email Templates</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/EmailTemplates"><i class="fa fa-th"></i> Email Templates List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/EmailTemplates/add"><i class="fa fa-plus"></i> Add Email Templates</a></li> 
		  </ul>
		</li>

		<!-- Manage Banner -->
		
		<li class="treeview <?php echo ($controller == 'Banners' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-image"></i>
			<span>Manage Banner</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/Banners"><i class="fa fa-th"></i> Banner List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/Banners/add"><i class="fa fa-plus"></i> Add Banner</a></li>
		  </ul>
		</li>
		
		<!-- Manage Caption -->
		
		<li class="treeview <?php echo ($controller == 'Captions' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-image"></i>
			<span>Manage Captions</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/Captions"><i class="fa fa-th"></i> Caption list </a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/Captions/add"><i class="fa fa-plus"></i> Add Caption</a></li>
		  </ul>
		</li>
		
		<!-- Manage CMS Pages -->
		<li class="treeview <?php echo ($controller == 'CmsPages' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa fa-tasks"></i><span>Manage CMS Pages</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/CmsPages"><i class="fa fa-th"></i> CmsPages List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/CmsPages/add"><i class="fa fa-plus"></i> Add CmsPage</a></li>
		  </ul>
		</li>
		
		<!-- Manage currencies -->
		
		<li class="treeview <?php echo ($controller == 'Currencies' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-money "></i>
			<span>Manage Currency</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/currencies"><i class="fa fa-th"></i> Currency List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/currencies/add"><i class="fa fa-plus"></i> Add Currency </a></li> 
		  </ul>
		</li>
		
		<!-- Manage Country -->
		
		<li class="treeview <?php echo ($controller == 'Countries' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-flag"></i>
			<span>Manage Country</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/Countries"><i class="fa fa-th"></i> Country List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/Countries/add"><i class="fa fa-plus"></i> Add Country </a></li> 
		  </ul>
		</li>
		
		<!-- Manage States -->
		
		<li class="treeview <?php echo ($controller == 'States' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-flag"></i>
			<span>Manage States</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/states"><i class="fa fa-th"></i> States List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/states/add"><i class="fa fa-plus"></i> Add States </a></li> 
		  </ul>
		</li>
		
		<!-- Manage City -->
		<li class="treeview <?php echo ($controller == 'Cities' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-flag"></i>
			<span>Manage Clty</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/cities"><i class="fa fa-th"></i> City List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/cities/add"><i class="fa fa-plus"></i> Add City </a></li> 
		  </ul>
		</li>
		<!-- Usesrs -->
		
		<li class="treeview <?php echo ($controller == 'Users' && (in_array($action,$usrs)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-user"></i>
			<span>Manage Users</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/users/adminList"><i class="fa fa-user-secret"></i> Admin List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/users/userList"><i class="fa fa-user"></i> Customers List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/users/add"><i class="fa fa-plus"></i> Add Customer</a></li> 
		  </ul>
		</li>
		
		<!-- Manage Shipping Charges -->
		<li class="treeview <?php echo ($controller == 'ShippingCharges' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-money"></i>
			<span>Manage Shipping Charges</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/ShippingCharges"><i class="fa fa-th"></i> Shipping Charges List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/ShippingCharges/add"><i class="fa fa-plus"></i> Add Shipping Charge </a></li> 
		  </ul>
		</li>
		
		<!-- Taxes -->
		
		<li class="treeview <?php echo ($controller == 'Taxes' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-tags"></i>
			<span>Manage Taxes</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/taxes"><i class="fa fa-th"></i> Taxes List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/taxes/add"><i class="fa fa-plus"></i> Add Tax</a></li> 
		  </ul>
		</li>
		
		
		<!-- Manage Colour -->
		
		<li class="treeview <?php echo ($controller == 'Colours' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-paint-brush"></i>
			<span>Manage Colours</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/colours"><i class="fa fa-th"></i>Colours  List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/colours/add"><i class="fa fa-plus"></i> Add Colours </a></li> 
		  </ul>
		</li>
		
		<!-- Manage Colour -->
		
		<li class="treeview <?php echo ($controller == 'Brands' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-xing"></i>
			<span>Manage Brands</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/brands/index"><i class="fa fa-th"></i>Brands  List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/brands/add"><i class="fa fa-plus"></i> Add Brands </a></li> 
		  </ul>
		</li>
		
		<!-- Manage Categoury -->
		
		<li class="treeview <?php echo ($controller == 'Categories' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-list-alt"></i>
			<span>Manage Categoury</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/categories"><i class="fa fa-th"></i>Categoury  List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/categories/add"><i class="fa fa-plus"></i> Add Categoury</a></li> 
		  </ul>
		</li>
		
		<!-- Manage Sub Categoury -->
		
		<li class="treeview <?php echo ($controller == 'SubCategories' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-list-alt"></i>
			<span>Manage SubCategoury</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/SubCategories"><i class="fa fa-th"></i>SubCategoury  List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/SubCategories/add"><i class="fa fa-plus"></i> Add SubCategoury</a></li> 
		  </ul>
		</li>
		
		<!-- Manage Sub Categoury -->
		
		<li class="treeview <?php echo ($controller == 'Coupons' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-gift"></i>
			<span>Manage Coupons</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/coupons"><i class="fa fa-th"></i>Coupons  List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/coupons/add"><i class="fa fa-plus"></i> Add Coupons</a></li> 
		  </ul>
		</li>
		
		<!-- Manage Product -->
		
		<!--li class="treeview <?php echo ($controller == 'Products' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-truck"></i>
			<span>Manage Products</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/products"><i class="fa fa-plus"></i> Product  List </a></li> 
			<li><a href="<?php echo Router::url('/', true); ?>admin/products/add"><i class="fa fa-plus"></i> Add Product</a></li> 
		  </ul>
		</li-->
		
		<!-- manage Orders Status -->
		
		<li class="treeview <?php echo ($controller == 'LatestNews' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-server"></i>
			<span>Manage Order Status </span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/OrderStatus"><i class="fa fa-th"></i> Order Status List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/OrderStatus/add"><i class="fa fa-plus"></i> Add Order status</a></li> 
		  </ul>
		</li>
		
		<!-- manage Orders -->
		
		<!--li class="treeview <?php echo ($controller == 'LatestNews' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-th-list"></i>
			<span>Manage Orders </span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/orders"><i class="fa fa-th"></i> Orders List</a></li>
		  </ul>
		</li-->
		
		<!-- Manage Reports -->
		
		<li class="treeview <?php echo ($controller == 'subscribes' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-file-archive-o"></i>
			<span>Manage Reports </span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/subscribes/index"><i class="fa fa-th"></i> Subscription List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/reviews/index"><i class="fa fa-th"></i> Review List</a></li> 
			<li><a href="<?php echo Router::url('/', true); ?>admin/UserLoginLogs/index"><i class="fa fa-th"></i> User Login Logs </a></li> 
		  </ul>
		</li>
		
	  </ul>
	</section>
<!-- /.sidebar -->
</aside>