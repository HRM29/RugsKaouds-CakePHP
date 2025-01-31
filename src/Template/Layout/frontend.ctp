<?php use Cake\Routing\Router;?>
<!doctype html>
<html class="no-js" lang="">
    

<head>

<?php 
	
	$url = 'https://'.$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
	if($url == 'https://Kaouds.com/Products/Oushak/design')
	{
		$title_for_layout = "Oushak Rugs for Sale - Oushak Rugs in Carolina - Kaoud Carpets & Rugs";  
		$description_for_layout = "Oushak rugs are available for sale in Carolina at the Kaoud Carpets & Rugs. These rugs give fabulous design to your home interior. Place order today!" ;
		$keyword_for_layout = "oushak rugs for sale, oushak rugs carolina";
		$seoH2 = "";
		$seoH1 = "";
	}	




		        $title_for_layout = isset($title_for_layout) ? $title_for_layout : 'Kaoud Carpets & Rugs';
		        
		        if(empty($title_for_layout)){
		            $title_for_layout = 'Kaoud Carpets & Rugs';
		        }
				if(empty($keyword_for_layout)){
		            $keyword_for_layout = 'oriental wall to wall carpet in Wilton';
		        }
		        if(empty($description_for_layout)){
		            $description_for_layout = 'Kaoud Carpets & Rugs has the exclusive collection of oriental wall to wall carpet in Wilton that will complement your existing walls and furnishings.';
		        }				
		       // print_r($title); die;
?>

	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?php echo $title_for_layout; ?></title>
	<meta name="keywords" content="<?php echo $keyword_for_layout;?>" />
	<meta name="description" content="<?php echo $description_for_layout;?>">
	<link href="<?php echo Router::url('/', true)."favicon.ico"; ?>"  type="image/x-icon" rel="icon"/><link href="<?php echo Router::url('/', true)."favicon.ico"; ?>" type="image/x-icon" rel="shortcut icon"/>	
	<meta name="facebook-domain-verification" content="3rrn0glngylfceooaifricmhzex1j9" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<?php echo $this->Html->css(array('front/bootstrap.min','front/bootstrap-grid','front/style','front/responsive','front/owl.carousel','front/owl.theme','front/materialdesignicons.min','front/bootsnav')); ?>
	<?php //echo $this->Html->css(array('front/bootstrap.min','front/style','front/responsive')); ?>	<!-- Global site tag (gtag.js) - Google Analytics -->	<script async src="https://www.googletagmanager.com/gtag/js?id=G-J34YWES5NL"></script>	<script>	  window.dataLayer = window.dataLayer || [];	  function gtag(){dataLayer.push(arguments);}	  gtag('js', new Date());	  gtag('config', 'G-J34YWES5NL');	</script>
    
    </head>
    <body>
         
		<?php echo $this->element('front_header'); ?> 
			<?php echo $this->fetch('content');?>  
		<?php echo $this->element('front_footer'); ?>  
		 
		<?php echo $this->Html->script(['bootstrap.min.js']);?>
		<?php echo $this->Html->script(['jquery.min.js']);?>
		<?php echo $this->Html->script(['jquery-3.3.1.min.js']);?>
		<?php echo $this->Html->script(['bootstrap.bundle.min.js']);?>
		<?php echo $this->Html->script(['select2.min.js']);?>
		<?php //echo $this->Html->script(['owl.carousel.js']);?>
		<?php echo $this->Html->script(['custom.min.js']);?>
		<?php echo $this->Html->script(['search.custom.min.js']);?>
	   <?php echo $this->Html->script(['jquery.payform.min.js']);?>
		<?php echo $this->Html->script(['script.js']);?>
    </body>
</html>	