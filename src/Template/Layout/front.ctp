<?php

use Cake\Routing\Router; ?>
<!doctype html>
<html class="no-js" lang="">


<head>
	<?php
	$url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	if ($url == 'https://kaouds.com') {
		$title_for_layout = "Best Place To Get Carpet & Rugs Online in Wilton - Kaouds";
		$description_for_layout = "Shop today & buy high-quality, modern, unique Rugs & Carpets online at Kaouds. We also provide hand washing cleaning solutions to get your Carpet & Rug clean.";
		$keyword_for_layout = "oushak rugs for sale, oushak rugs carolina";
		$seoH2 = "";
		$seoH1 = "";
	}



	$title_for_layout = isset($title_for_layout) ? $title_for_layout : 'Best Place To Get Carpet & Rugs Online in Wilton - Kaouds';

	if (empty($title_for_layout)) {
		$title_for_layout = 'Best Place To Get Carpet & Rugs Online in Wilton - Kaouds';
	}
	if (empty($keyword_for_layout)) {
		$keyword_for_layout = 'oriental wall to wall carpet in Wilton';
	}
	if (empty($description_for_layout)) {
		$description_for_layout = 'Shop today & buy high-quality, modern, unique Rugs & Carpets online at Kaouds. We also provide hand washing cleaning solutions to get your Carpet & Rug clean.';
	}
	// print_r($title); die;
	?>

	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?php echo $title_for_layout; ?></title>
	<meta name="keywords" content="<?php echo $keyword_for_layout; ?>" />
	<meta name="description" content="<?php echo $description_for_layout; ?>">
	<link href="<?php echo Router::url('/', true) . "img/favicon.jpeg"; ?>" type="image/x-icon" rel="icon" />
	<link href="<?php echo Router::url('/', true) . "img/favicon.jpeg"; ?>" type="image/x-icon" rel="shortcut icon" />
	<meta name="facebook-domain-verification" content="3rrn0glngylfceooaifricmhzex1j9" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<?php echo $this->Html->css(array('front/bootstrap.min.css?ver=1.0', 'front/bootstrap-icons.min.css?ver=1.0', 'front/owl.carousel.min', 'front/owl.theme.default.min', 'front/custom.css?ver=1.0348', 'front/responsive.css?ver=1.128', 'front/sweetalert2.min.css?ver=1.0', 'front/fancybox.umd.css?ver=0.1')); ?>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-J34YWES5NL"></script>

	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());
		gtag('config', 'G-J34YWES5NL');
	</script>

</head>

<body>

	<?php echo $this->element('front_header'); ?>

	<?php echo $this->fetch('content'); ?>
	<?php echo $this->element('front_footer'); ?>

</body>

</html>