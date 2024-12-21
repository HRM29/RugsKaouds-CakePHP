<?php 
use Cake\Routing\Router;
use Cake\Core\Configure;
$session = $this->request->getSession();
$authUser = $session->read('Auth');
?> 
<section class="top-nav-bar">
  <div class="container">
    <div class="row">
      <div class="col-6 top-bar-socials"> <span class="icons"> <a target="_blank" href="https://www.facebook.com/GalleryOfOrientalRugs"><i class="fa fa-facebook"></i></a> <a target="_blank" href="https://www.instagram.com/galleryoforientalrugsnc"><i class="fa fa-instagram"></i></a> 
       <a target="_blank"  href="https://www.pinterest.com/GalleryofOrientalRugs/"><i class="fa fa-pinterest-p"></i></a>
            <!--a href="#"><i class="fa fa-rss"></i></a>--> 
        </span> <span class="text">Enjoy Free Shipping</span>
		<span class="text"><i class="fa fa-phone"></i> <?php echo Configure::read('App.phone'); ?></span> </div>
      <div class="col-5 top-link">
        <ul class="nav">
		<?php if(!empty($authUser['User']['id'])){ ?>
			 <!--p class="nav-link active">Welcome : <?= $authUser['User']['first_name']; ?> &nbsp;&nbsp;&nbsp; <a href="<?php echo $this->Url->build(['controller'=>'users','action'=>'logout']); ?>" style="display: inline-block;color: #fff;"><i class="fa fa-sign-out" aria-hidden="true"></i></a></p-->
			 <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="background: rgb(70, 64, 64) !important;"> 
				  <a href="<?php echo $this->Url->build(['controller'=>'users','action'=>'myaccount']) ?>" class="deshbord-menu">Dashboard</a>
				  <a href="<?php echo $this->Url->build(['controller'=>'users','action'=>'wishlist']) ?>" class="deshbord-menu">Favourite List</a>
				  <a href="<?php echo $this->Url->build(['controller'=>'users','action'=>'logout']) ?>" class="deshbord-menu">Logout</a>
			  </div>
            </li>
		<?php } else{ ?>
		<div class="nav_iner">	
			<li> <a class="nav-link active" href="<?php echo $this->Url->build(['controller'=>'users','action'=>'login']); ?>">Login</a> </li>
			<li><span>|</span></li>
			<li> <a class="nav-link" href="<?php echo $this->Url->build(['controller'=>'users','action'=>'login']); ?>">Register</a> </li>
		</div>	
		<?php } ?>
          
          <li class="nav-item">
		  
		<?php echo $this->Form->create('',['type' => 'post','id'=>'searchForm','enctype' =>'multipart/form-data']); ?>
				<div class="searchbar">	
					<input type="text" name="search_details" class="search_input" placeholder="Search..." id="search-details" required value=<?= isset($savesearch['search_details'])?$savesearch['search_details']:'' ?> >	
					<a class="search_icon searchForm" style="cursor:pointer;"><i class="fa fa-search"></i></a>
				</div>
			<?php  echo $this->Form->end();  ?>
		  	<?php /* echo $this->Form->create('',['type' => 'post','id'=>'searchForm','enctype' =>'multipart/form-data']); ?>
			<div class="searchbar">	
				<?php echo $this->Form->input("search_details",array('required'=>false,'type'=>'text','class'=>'search_input','label'=>false,'value'=>isset($savesearch['search_details'])?$savesearch['search_details']:'',"placeholder"=>"Search...")); ?>
				
			<button class="btn btn-outline-success my-2 my-sm-0 searchForm" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
				<!--a href="#" class="search_icon"><i class="fa fa-search"></i></a-->
				</div>
				<!--button class="btn btn-outline-success my-2 my-sm-0 searchForm" type="button"><i class="fa fa-search" aria-hidden="true"></i></button-->
		    <?php   echo $this->Form->end();  */?>
            <!--form action="/action_page.php">
			
             <div class="searchbar">
				  <input class="search_input" type="text" name="" placeholder="Search...">
				  <a href="#" class="search_icon"><i class="fa fa-search"></i></a>
				</div>
            </form-->
          </li>
          <!--li class="customer-link"><a href="<?php echo $this->Url->build(['controller'=>'products','action'=>'cart']) ?>"><i class="fa fa-shopping-cart"></i></a></li-->
		  <?php if(!empty($authUser['User']['id'])){ ?>
			<li class="customer-link"><a href="<?php echo $this->Url->build(['controller'=>'users','action'=>'wishlist']) ?>"><i class="fa fa-heart"></i></a></li>
		  <?php } ?>
		  </div>
		  
		  
		  <div class="col-1">
		  <div class="attr-nav">
            <ul>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                        <i class="fa fa-shopping-cart"></i>
                        <span class="badge"><?= count($cartData);?></span>
                    </a>
                    <ul class="dropdown-menu cart-list">
					<?php
					if(!empty($cartData)){
					$total = 0;
					foreach($cartData as $key => $data){ ?>
                        <li>
                            <a  class="photo"><?php 
									$img_src = 'https://shrugs.com/rug_pictures/';	
											
									$img_no = str_replace("GOR"," ",$data['sku_no'] );
									$img_name = "sh".$img_no/7;
									$inFolder = $this->General->__get_picture_folder($img_name);
									
									 
									$imgName =  $img_name." 001.jpg";
						 
									$fileUrl = $img_src."overstock_rugs/".$inFolder."/".$imgName;
									$thumb_imgName =  	$img_name." 001.jpg";
									$thumbArr = explode('_',$pimg['ProductImage']['image']);	
									$fileUrlThumb = $img_src.$inFolder.'/thumbs/thumb_'.$thumb_imgName;
										if($this->General->remote_file_exists($fileUrl))
										{
										?>
											<img src="<?php echo $fileUrl; ?>"  alt="<?php echo $data['title']; ?>" class="img-fluid">
									<?php  
									}
									
									if($this->General->remote_file_exists($fileUrl) == "")
										{	$data =  $this->General->getProductImages($data['id']);
									 foreach($data as $images){
									?>
										<img src="<?php echo $images['image']; ?>"  alt="<?php echo $images['title']; ?>" class="img-fluid">
										<?php }
										$i = '';
										} 
									?></a>
                            <h6><a ><?= $data['title'];?></a></h6>
							<p>1 X $<?= round($data['selling_price'],2);?>  <span class="regular-price">$<?= round($data['everyday_price'],2);?></span></p>
                        </li>
					<?php
						$total = $total + round($data['selling_price'],2);
					} ?>
                       
                        <li class="total">
                            <span class="pull-right"><strong>Total</strong>: $ <?= $total; ?></span>
                            <a href="<?php echo $this->Url->build(['controller'=>'products','action'=>'cart']) ?>" class="btn btn-default btn-cart">Checkout</a>
                        </li>
					<?php }else{ ?>
						<p style="text-align:center">Your cart is empty !</p>
					<?php }?>
                    </ul>
                </li>
            </ul>
        </div>  
		
        </ul>
      </div>
    </div>
  </div>
</section>
<div class="container">
  <div class="logo mobile">
	  <a href="<?php echo Router::url('/', true) ?>">
		   <?= $this->Html->image('logo.png', ['alt' => '','width'=>'60px']);?>
	  </a>
    <p><a href="<?php echo Router::url('/', true) ?>">GALLERY OF ORIENTAL RUGS</a></p>
  </div>
</div>
<div class="container-fluid bg-light">
  <div class="row">
    <div class="col-md-12">
      <nav class="navbar navbar-expand-lg navbar-light "> <span class="navbar-brand">Enjoy Free Shipping</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item active"> <a class="nav-link underline" href="<?php echo Router::url('/', true) ?>">Home <span class="sr-only">(current)</span></a> </li>
            <li class="nav-item"> <a class="nav-link underline" href="<?php echo $this->Url->build(['controller'=>'products','action'=>'shopping']); ?>">Shop </a> </li>
            <li class="nav-item"> <a class="nav-link underline" href="<?php echo Router::url('/', true) ?>pages/carpet">Carpet</a> </li>
            <li class="nav-item dropdown"> 
			 <a class="nav-link dropdown-toggle underline" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Rug Cleaning </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"> 
			  <a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/rugcleaning">Rug Cleaning</a> 
			  <a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/rugrepair">Rug Repair</a> 
			  <a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/rugappraisal">Rug Appraisal</a> 
			  </div>
            </li>
			<!--li class="nav-item"> <a class="nav-link" href="<?php echo Router::url('/', true) ?>pages/portfolio">Portfolio</a> </li-->
             
          </ul>
		  
		  <div class="logo">
	  <a href="<?php echo Router::url('/', true) ?>">
		   <?= $this->Html->image('logo.png', ['alt' => '','width'=>'60px']);?>
	  </a>
    <p><a href="<?php echo Router::url('/', true) ?>">GALLERY OF ORIENTAL RUGS</a></p>
  </div>
  
		  <ul class="navbar-nav">
		  <li class="nav-item dropdown"> 
			 <a class="nav-link dropdown-toggle underline" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Interior design </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"> 
			  <a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/interiordesign">Interior Design</a> 
			  <a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/pairingpatternsorientalrug">Pairing Patterns</a> 
			</div>
            </li>
			
			<li class="nav-item dropdown"> 
			 <a class="nav-link dropdown-toggle underline" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">About Us</a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"> 
			  <a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/aboutus">About Us</a> 
			  <a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/awardwinning">Award Winning</a> 
			  <a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/businesshighlights">Business Highlights</a> 
			  <a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/frednasseribio">Fred Nasseri Bio</a> 
			  <a class="dropdown-item" href="<?php echo Router::url('/', true) ?>pages/videos">Videos</a> 
			  </div>
            </li>
			
			<li class="nav-item"> <a class="nav-link underline" href="<?php echo Router::url('/', true) ?>pages/contactUs">Contact Us</a> </li>
		  <ul>
		  
		  
        </div>
      </nav>
    </div>
  </div>
</div>
 <script>document.getElementById('search-details')    .addEventListener('keyup', function(event) {        if (event.code === 'Enter')        {             event.preventDefault();            document.querySelector('form').submit();        }    });</script>
 
