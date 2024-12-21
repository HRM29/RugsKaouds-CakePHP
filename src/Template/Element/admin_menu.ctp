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
		
		<!--li class="treeview <?php echo ($controller == 'EmailTemplates' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-envelope"></i>
			<span>Manage Email Templates</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/EmailTemplates"><i class="fa fa-list-alt"></i> Email Templates List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/EmailTemplates/add"><i class="fa fa-plus"></i> Add Email Templates</a></li> 
		  </ul>
		</li-->

		<!-- Manage Banner -->
		
		<li class="treeview <?php echo ($controller == 'Banners' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-image"></i>
			<span>Manage Banner</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/Banners"><i class="fa fa-list-alt"></i> Banner List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/Banners/add"><i class="fa fa-plus"></i> Add Banner</a></li>
		  </ul>
		</li>
		
		<!-- Manage Caption -->
		
		<!--li class="treeview <?php echo ($controller == 'Captions' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-image"></i>
			<span>Manage Captions</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/Captions"><i class="fa fa-list-alt"></i> Caption list </a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/Captions/add"><i class="fa fa-plus"></i> Add Caption</a></li>
		  </ul>
		</li-->
		
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
		
		<!--li class="treeview <?php echo ($controller == 'Currencies' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-money "></i>
			<span>Manage Currency</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/currencies"><i class="fa fa-list-alt"></i> Currency List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/currencies/add"><i class="fa fa-plus"></i> Add Currency </a></li> 
		  </ul>
		</li-->
		
		<!-- Manage Country -->
		<?php /* ?>
		<li class="treeview <?php echo ($controller == 'Countries' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-flag"></i>
			<span>Manage Country</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/Countries"><i class="fa fa-list-alt"></i> Country List</a></li>
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
			<li><a href="<?php echo Router::url('/', true); ?>admin/states"><i class="fa fa-list-alt"></i> States List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/states/add"><i class="fa fa-plus"></i> Add States </a></li> 
		  </ul>
		</li>
		
		<!-- Manage City -->
		<li class="treeview <?php echo ($controller == 'Cities' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-flag"></i>
			<span>Manage City</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/cities"><i class="fa fa-list-alt"></i> City List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/cities/add"><i class="fa fa-plus"></i> Add City </a></li> 
		  </ul>
		</li>
		
		<?php */  ?>
		<!-- Usesrs -->
		
		<li class="treeview <?php echo ($controller == 'Users' && (in_array($action,$usrs)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-user"></i>
			<span>Manage Users</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/users/userList"><i class="fa fa-user-secret"></i> Admin List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/users/customerList"><i class="fa fa-user"></i> Customers List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/users/add"><i class="fa fa-plus"></i> Add Customer</a></li> 
		  </ul>
		</li>
		
		<!-- Manage Shipping Charges -->
		<!--li class="treeview <?php echo ($controller == 'ShippingCharges' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-money"></i>
			<span>Manage Shipping Charges</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/ShippingCharges"><i class="fa fa-th"></i> Shipping Charges List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/ShippingCharges/add"><i class="fa fa-plus"></i> Add Shipping Charge </a></li> 
		  </ul>
		</li-->
		
		<!-- Taxes -->
		
		<!--li class="treeview <?php echo ($controller == 'Taxes' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-tags"></i>
			<span>Manage Taxes</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/taxes"><i class="fa fa-list-alt"></i> Taxes List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/taxes/add"><i class="fa fa-plus"></i> Add Tax</a></li> 
		  </ul>
		</li-->
		
		
		<!-- Manage Colour -->
		
		<li class="treeview <?php echo ($controller == 'Colours' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-paint-brush"></i>
			<span>Manage Colours</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/colors"><i class="fa fa-list-alt"></i>Colours  List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/colors/add"><i class="fa fa-plus"></i> Add Colours </a></li> 
		  </ul>
		</li>
		
		<li class="treeview <?php echo ($controller == 'Piles' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-paint-brush"></i>
			<span>Manage Piles</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/piles"><i class="fa fa-list-alt"></i>Piles  List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/piles/add"><i class="fa fa-plus"></i> Add Pile </a></li> 
		  </ul>
		</li>
		
		<li class="treeview <?php echo ($controller == 'Patterns' && (in_array($action,$defaulActions)))?'active':'';?>">
			<a href="#">
				<i class="fa fa-list"></i>
				<span>Manage Patterns</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="<?php echo Router::url('/', true); ?>admin/patterns"><i class="fa fa-list-alt"></i>Patterns  List</a></li>
				<li><a href="<?php echo Router::url('/', true); ?>admin/patterns/add"><i class="fa fa-plus"></i> Add Pattern </a></li> 
			</ul>
		</li>
		
		<li class="treeview <?php echo ($controller == 'Materials' && (in_array($action,$defaulActions)))?'active':'';?>">
			<a href="#">
				<i class="fa fa-list"></i>
				<span>Manage Materials</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="<?php echo Router::url('/', true); ?>admin/materials"><i class="fa fa-list-alt"></i>Materials  List</a></li>
				<li><a href="<?php echo Router::url('/', true); ?>admin/materials/add"><i class="fa fa-plus"></i> Add Material </a></li> 
			</ul>
		</li>
		
		<li class="treeview <?php echo ($controller == 'Designs' && (in_array($action,$defaulActions)))?'active':'';?>">
			<a href="#">
				<i class="fa fa-list"></i>
				<span>Manage Designs</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="<?php echo Router::url('/', true); ?>admin/designs"><i class="fa fa-list-alt"></i>Designs  List</a></li>
				<li><a href="<?php echo Router::url('/', true); ?>admin/designs/add"><i class="fa fa-plus"></i> Add Design </a></li> 
			</ul>
		</li>
		
		<li class="treeview <?php echo ($controller == 'Foundations' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-paint-brush"></i>
			<span>Manage Foundations</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/foundations"><i class="fa fa-list-alt"></i>Foundations  List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/foundations/add"><i class="fa fa-plus"></i> Add Foundation </a></li> 
		  </ul>
		</li>
		
		<!-- Manage Sizes -->
		
		<!--li class="treeview <?php echo ($controller == 'Sizes' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-paint-brush"></i>
			<span>Manage Sizes</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/sizes"><i class="fa fa-list-alt"></i>Sizes  List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/sizes/add"><i class="fa fa-plus"></i> Add Sizes </a></li> 
		  </ul>
		</li-->
			<li class="treeview <?php echo ($controller == 'Dimensions' && (in_array($action,$defaulActions))) ? 'active' : ''; ?>">
				<a href="javascript::void()">
					<i class="fa fa-image"></i>
					<span>Dimensions Management</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li>
						<?php echo $this->Html->link('<i class="fa fa-th"></i> Dimensions List',['controller'=>'dimensions','action'=>'index'],['escape'=>false,'title'=>'Dimensions List']); ?>
					</li>
					<li>
						<?php echo $this->Html->link('<i class="fa fa-plus"></i> Add Dimension',['controller'=>'dimensions','action'=>'add'],['escape'=>false,'title'=>'Add Dimension']); ?>
					</li>
				</ul>
			</li>
		<!-- Manage Colour -->
		
		<!--li class="treeview <?php echo ($controller == 'Brands' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-xing"></i>
			<span>Manage Brands</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/brands/index"><i class="fa fa-th"></i>Brands  List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/brands/add"><i class="fa fa-plus"></i> Add Brands </a></li> 
		  </ul>
		</li-->
		
		<!-- Manage Categoury -->
		
		<li class="treeview <?php echo ($controller == 'Categories' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-list-alt"></i>
			<span>Manage Category</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/categories"><i class="fa fa-list-alt"></i>Category  List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/categories/add"><i class="fa fa-plus"></i> Add Category</a></li> 
		  </ul>
		</li>
		
		<!-- Manage Sub Categoury -->
		
		<!--li class="treeview <?php echo ($controller == 'SubCategories' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-list-alt"></i>
			<span>Manage SubCategoury</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/SubCategories"><i class="fa fa-list-alt"></i>SubCategoury  List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/SubCategories/add"><i class="fa fa-plus"></i> Add SubCategoury</a></li> 
		  </ul>
		</li-->
		
		<!-- Manage Coupons -->
		<?php /* ?>
		<li class="treeview <?php echo ($controller == 'Coupons' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-gift"></i>
			<span>Manage Coupons</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/coupons"><i class="fa fa-list-alt"></i>Coupons  List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/coupons/add"><i class="fa fa-plus"></i> Add Coupons</a></li> 
		  </ul>
		</li>
		<?php */ ?>
		<!-- Manage Product -->
		
		<li class="treeview <?php echo ($controller == 'Products' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-pinterest-p"></i>
			<span>Manage Products</span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/products"><i class="fa fa-list-alt"></i> Product  List </a></li> 
			<li><a href="<?php echo Router::url('/', true); ?>admin/products/add"><i class="fa fa-plus"></i> Add Product</a></li> 
			<li><a href="<?php echo Router::url('/', true); ?>admin/products/uploadcsv"><i class="fa fa-plus"></i> Import CSV</a></li> 
		  </ul>
		</li>
		
		<!-- manage Orders Status -->
		
		<li class="treeview <?php echo ($controller == 'OrderStatus' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-server"></i>
			<span>Manage Order Status </span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/OrderStatus"><i class="fa fa-list-alt"></i> Order Status List</a></li>
			<li><a href="<?php echo Router::url('/', true); ?>admin/OrderStatus/add"><i class="fa fa-plus"></i> Add Order status</a></li> 
		  </ul>
		</li>
		
		<!-- manage Orders -->
		
		<li class="treeview <?php echo ($controller == 'Orders' && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-shopping-cart"></i>
			<span>Manage Orders </span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/orders"><i class="fa fa-list-alt"></i> Orders List</a></li>
		  </ul>
		</li>
		
		<!-- Manage Reports -->
		<?php $rep_controller = array('subscribes','reviews','UserLoginLogs') ?>
		<li class="treeview <?php echo (in_array($controller,$rep_controller) && (in_array($action,$defaulActions)))?'active':'';?>">
		  <a href="#">
			<i class="fa fa-file-archive-o"></i>
			<span>Manage Reports </span>
			<i class="fa fa-angle-left pull-right"></i>
		  </a>
		  <ul class="treeview-menu">
			<li><a href="<?php echo Router::url('/', true); ?>admin/subscribes/index"><i class="fa fa-list-alt"></i> Subscription List</a></li>
			<!--li><a href="<?php echo Router::url('/', true); ?>admin/reviews/index"><i class="fa fa-list-alt"></i> Review List</a></li--> 
			<li><a href="<?php echo Router::url('/', true); ?>admin/UserLoginLogs/index"><i class="fa fa-list-alt"></i> User Login Logs </a></li> 
		  </ul>
		</li>
		
		
		<li class="treeview <?php echo (in_array($controller,$rep_controller) && (in_array($action,$defaulActions)))?'active':'';?>">
			<a href="<?php echo Router::url('/', true); ?>admin/ContactUs/index">		
				<i class="fa fa-file-archive-o"></i>
				<span>Contact Enquiries </span>
			</a>
		</li>
		
		
	  </ul>
	</section>
<!-- /.sidebar -->
</aside>