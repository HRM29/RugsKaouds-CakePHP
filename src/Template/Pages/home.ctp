	<?php

	use Cake\Routing\Router; ?>
	<section class="main_banner">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 no_padding">
					<div class="mn_bnr"></div>
				</div>
			</div>
		</div>
	</section>
	<?php
	if (isset($HomeBlocks['Block2']) && !empty($HomeBlocks['Block2'])) {
	?>
		<section class="rgs_type">
			<div class="container">
				<div class="row">
					<?php
					foreach ($HomeBlocks['Block2'] as $block2Data) {
					?>
						<div class="col-md-3">
							<div class="typ_box">
								<div class="typ_box_imag">
									<?php
									$image = WWW_ROOT . 'uploads' . DS . 'banner' . DS . $block2Data['image'];
									if (file_exists($image)) {
										echo $this->Html->link(
											$this->Html->image('/uploads/banner/' . $block2Data['image'], ['alt' => $block2Data['image'], "class" => "zoom-image"]),
											$block2Data['link'],
											['escape' => false]
										);
									}
									?>
								</div>
								<h4><?= $block2Data['title'] ?></h4>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</section>
	<?php
	}
	?>
	<?php
	if (isset($HomeBlocks['Block3']) && !empty($HomeBlocks['Block3'])) {
		foreach ($HomeBlocks['Block3'] as $Block3Data) {
	?>
			<section class="rgs_abt">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-md-6">
							<div class="rgs_abt_txt">
								<h1><?php echo $Block3Data['title'] ?></h1>
								<?php echo $Block3Data['description'] ?>
								<a class="btn" href="#">Shop Now</a>
								<a class="btn cntct" href="#">Contact Us</a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="rgs_abt_imag">
								<?php
								$image = WWW_ROOT . 'uploads' . DS . 'banner' . DS . $Block3Data['image'];
								if (file_exists($image)) {
									echo $this->Html->image('/uploads/banner/' . $Block3Data['image'], ['alt' => $Block3Data['image']]);
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php
		}
	}
	if (isset($HomeBlocks['Block4']) && !empty($HomeBlocks['Block4'])) {
		?>
		<section class="rgs_srvc">
			<div class="container">
				<div class="row">
					<?php
					foreach ($HomeBlocks['Block4'] as $Block4Data) {
					?>
						<div class="col-md-4">
							<div class="srvc_box">
								<div class="srvc_box_imag">
									<?php
									$image = WWW_ROOT . 'uploads' . DS . 'banner' . DS . $Block4Data['image'];
									if (file_exists($image)) {
										echo $this->Html->image('/uploads/banner/' . $Block4Data['image'], ['alt' => $Block4Data['image']]);
									}
									?>
								</div>
								<div class="srvc_box_txt">
									<h3><?php echo $Block4Data['title']; ?></h3>
									<?php
									echo $Block4Data['description'];
									if (isset($Block4Data['link']) && !empty($Block4Data['link'])) {
									?>
										<a class="btn" href="<?php echo $Block4Data['link']; ?>"><?php echo $Block4Data['link_name'] ?></a>
									<?php
									}
									?>

								</div>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</section>
	<?php
	}
	?>
	<section class="ltst_arrvls">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="heading">
						<h2>Latest Arrivals</h2>
					</div>
					<div class="arrvls_slide owl-carousel owl-theme">
						<div class="item">
							<div class="arrvl_box">
								<img src="images/arrvl_slide001.jpg">
								<div class="arrvl_text">
									<h3>Falu Red</h3>
									<p>3’x5’3″ Falu Red, Hand Knotted, Wool and Silk, Nain with Large Medallion, 250 KPSI, Oriental Rug</p>
									<span>$2,156.39</span>
									<span class="nw_price">$1,293.83</span>
									<a class="btn crt_btn" href="#"><i class="bi bi-bag-plus"></i> Add to Cart</a>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="arrvl_box">
								<img src="images/arrvl_slide002.jpg">
								<div class="arrvl_text">
									<h3>Spring White</h3>
									<p>2’7″x6’1″ Spring White, 250 KPSI, Hand Knotted, Nain with Center Motif Flower Design, Wool and Silk, Runner, Oriental Rug</p>
									<span>$2,152.26</span>
									<span class="nw_price">$1,291.35</span>
									<a class="btn crt_btn" href="#"><i class="bi bi-bag-plus"></i> Add to Cart</a>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="arrvl_box">
								<img src="images/arrvl_slide003.jpg">
								<div class="arrvl_text">
									<h3>Uranian Blue</h3>
									<p>2’8″x6’6″ Uranian Blue, Nain with Large Center Medallion, 250 KPSI, Wool and Silk, Hand Knotted, Runner, Oriental Rug</p>
									<span>$2,374.19</span>
									<span class="nw_price">$1,424.51</span>
									<a class="btn crt_btn" href="#"><i class="bi bi-bag-plus"></i> Add to Cart</a>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="arrvl_box">
								<img src="images/arrvl_slide002.jpg">
								<div class="arrvl_text">
									<h3>Spring White</h3>
									<p>2’7″x6’1″ Spring White, 250 KPSI, Hand Knotted, Nain with Center Motif Flower Design, Wool and Silk, Runner, Oriental Rug</p>
									<span>$2,152.26</span>
									<span class="nw_price">$1,291.35</span>
									<a class="btn crt_btn" href="#"><i class="bi bi-bag-plus"></i> Add to Cart</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	if (isset($HomeBlocks['Block5']) && !empty($HomeBlocks['Block5'])) {
	?>
		<section class="wrks">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="heading">
							<h2>How it Works at Kaoud Carpets & rugs</h2>
						</div>
					</div>
					<?php
					foreach ($HomeBlocks['Block5'] as $Block5Data) {
					?>
						<div class="col-lg-4 col-md-12">
							<div class="wrk_box">
								<div class="wrk_icn">
									<div class="wrk_icn_inr">
										<?php
										$image = WWW_ROOT . 'uploads' . DS . 'banner' . DS . $Block5Data['image'];
										if (file_exists($image)) {
											echo $this->Html->image('/uploads/banner/' . $Block5Data['image'], ['alt' => $Block5Data['image']]);
										}
										?>
									</div>
								</div>
								<div class="wrk_txt">
									<h3><?php echo $Block5Data['title']; ?></h3>
									<?php echo $Block5Data['description']; ?>
								</div>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</section>
	<?php
	}
	if (isset($HomeBlocks['BlockReviews']) && !empty($HomeBlocks['BlockReviews'])) {
	?>
		<section class="rvws">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="heading">
							<h2>Rave Reviews</h2>
						</div>
					</div>
					<?php
					foreach ($HomeBlocks['BlockReviews'] as $reviewData) {
					?>
						<div class="col-lg-4 col-md-12">
							<div class="rvw_box">
								<p style="height: 378px;"><?php echo $reviewData['review_text'] ?></p>
								<div class="rvw_prfl">
									<?php
									if (!empty($reviewData['reviewer_image'])) {
										$image = WWW_ROOT . 'uploads' . DS . 'reviewers' . DS . $reviewData['reviewer_image'];
										if (file_exists($image)) {
											echo $this->Html->image('/uploads/reviewers/' . $reviewData['reviewer_image'], ['alt' => $reviewData['reviewer_image'], "class" => "circular-image"]);
										} else {
											$image = WWW_ROOT . 'img' . DS . 'user-img.jpg';
											echo $this->Html->image('/img/user-img.jpg', ['alt' => 'user-img.jpg', "class" => "circular-image"]);
										}
									} else {
										$image = WWW_ROOT . 'img' . DS . 'user-img.jpg';
										echo $this->Html->image('/img/user-img.jpg', ['alt' => 'user-img.jpg', "class" => "circular-image"]);
									}
									?>
									<div class="rvw_text">
										<h3><?php echo $reviewData['reviewer_name'] ?></h3>
										<?php
										$totalStars = 5;
										$rating = $reviewData['rating'];
										$emptyStars = 5 - $rating;
										?>
										<div class="star-rating">
											<?php
											for ($fullStar = 0; $fullStar < $rating; $fullStar++) {
											?>
												<i class="bi bi-star-fill"></i>
											<?php
											}
											for ($emptyStar = 0; $emptyStar < $emptyStars; $emptyStar++) {
											?>
												<i class="bi bi-star"></i>
											<?php
											}
											?>
										</div>

									</div>
								</div>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</section>
	<?php
	}
	?>
	<!-- <div class="container-fluid slider">
		<div class="row">
			<?php if (empty($HomeBlocks)) {
			?>
				<div class="desktop_slider">
					<div id="demo" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">
							<?php
							$i = 0;
							foreach ($banners as $banner) {
							?>
								<div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?>">
									<?php
									$image = WWW_ROOT . 'uploads' . DS . 'banner' . DS . $banner->image;
									if (file_exists($image)) {
										echo $this->Html->image('/uploads/banner/' . $banner->image, array('alt' => $banner->image));
									} else {
										echo $this->Html->image('slider1.jpg', ['alt' => 'Los Angeles']);
									}
									?>
									<div class="carousel-caption">
										<h3><?php echo $banner->title; ?></h3>
										<p><?php echo $banner->description; ?> </p>
									</div>
								</div>
							<?php $i++;
							} ?>
						</div>

						<a class="carousel-control-prev" href="#demo" data-slide="prev"> <span class="carousel-control-prev-icon"></span> </a> <a class="carousel-control-next" href="#demo" data-slide="next"> <span class="carousel-control-next-icon"></span> </a>
					</div>
				</div>
			<?php } ?>


			<div class="mob_slider">
				<div id="demo" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">
						<div class="carousel-item">
							<img src="/uploads/banner/mob_slide01.jpg" alt="223688703_Sh51439_slider3.jpg">
							<div class="carousel-caption">
								<h3>New Arrivals</h3>
								<p>experience the mystical beauty of oriental rugs in your home </p>
							</div>
						</div>
						<div class="carousel-item active">
							<img src="/uploads/banner/mob_slide02.jpg" alt="1316479190_slide02.jpg">
							<div class="carousel-caption">
								<h3>New Arrivals01</h3>
								<p>experience the mystical beauty of oriental rugs </p>
							</div>
						</div>
					</div>

					<a class="carousel-control-prev" href="#demo" data-slide="prev"> <span class="carousel-control-prev-icon"></span> </a> <a class="carousel-control-next" href="#demo" data-slide="next"> <span class="carousel-control-next-icon"></span> </a>
				</div>
			</div>


		</div>
	</div>
	<div class="container ">
		<div class="row ">
			<div class="spacing">&nbsp;</div>
			<div class="col-12 p-0">
				<div class="main-heading ">
					<h1>CARPET</h1>
					<p>Collection</p>
				</div>
			</div>
			<div class="col-md-7 wp-text">Selecting a Wall-to-Wall Carpet Carpet can do much more than cover your floors. It can be the foundation of a decorating plan, inspiring other ideas. Or, it can be selected to complement existing walls and furnishings. Above all, the carpet you choose should reflect your personality and bring comfort to your home.</div>
			<div class="col-md-5 pull-right p-0 ">
				<div class="wp-button"><a href="<?php echo $this->Url->build(['controller' => 'pages', 'action' => 'carpet']); ?>" class="view-button">View All</a></div>
			</div>
		</div>
		<div class="row rugs">
			<div class="col-md-5">
				<div class="rugs-img"><a href="#"><?= $this->Html->image('rugs1.jpg', ['alt' => '']); ?>
						<p>Stanton Carpet</p>
					</a>
				</div>
			</div>
			<div class="col-md-5">
				<div class="rugs-img"><a href="#"><?= $this->Html->image('rugs2.jpg', ['alt' => '']); ?>
						<p>Rosecore</p>
					</a>
				</div>
			</div>
			<div class="col-md-2 ">
				<div class="rugs-left-img pt-m"><a href="#"><?= $this->Html->image('rugs3.jpg', ['alt' => '']); ?>
						<p>Crescent</p>
					</a>
				</div>
				<div class="rugs-left-img pt"><a href="#"><?= $this->Html->image('rugs4.jpg', ['alt' => '']); ?>
						<p>Nourison</p>
					</a>
				</div>
				<div class="rugs-left-img pt"><a href="#"><?= $this->Html->image('rugs5.jpg', ['alt' => '']); ?>
						<p>Karastan</p>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="container ">
		<div class="row ">
			<div class="spacing1">&nbsp;</div>
			<div class="main-heading p-0">
				<div class="col-md-6">
					<h1>featureD</h1>
					<p class="heading-text">products</p>
				</div>
				<div class="col-md-6 p-0"><a href="<?php echo $this->Url->build(['controller' => 'products', 'action' => 'shopping']); ?>" class="view-button">View All</a></div>
			</div>

			<div class="col-md-12 p-0 mt-4">
				<?php foreach ($featuredProductData as $data) { ?>
					<div class="product "><a href="<?php echo $this->Url->build(['controller' => 'products', 'action' => 'productView', base64_encode($data->sku_no)]); ?>">
							<?php
							$img_src = Router::url('/', true) . 'uploads/product/';

							$img_no = str_replace("GOR", " ", $data->sku_no);
							$img_name = $data->sku_no . "t.jpg";

							$inFolder = $this->General->__get_picture_folder($img_name);


							$imgName =  $img_name . " 001.jpg";

							$fileUrl = $img_src . $inFolder . "/" . $img_name;
							$thumb_imgName =    $img_name . " 001.jpg";
							$thumbArr = explode('_', $pimg['ProductImage']['image']);
							$fileUrlThumb = $img_src . $inFolder . '/thumbs/thumb_' . $thumb_imgName;
							if ($this->General->remote_file_exists($fileUrl)) {
							?>
								<img src="<?php echo $fileUrl; ?>" alt="<?php echo $record->title; ?>" />

							<?php } else {
							?>
								<img src="<?php echo $this->General->getProductSingleImages($data->id)->image; ?>" alt="<?php echo $data->title; ?>" style="height: 250px;" />
							<?php
							} ?>
							<p>Size: <?php echo $data->dimension_1_feet . "'" . $data->dimension_1_inches . '" X ' . $data->dimension_2_feet . "'" . $data->dimension_2_inches . '"'; ?></p>
						</a></div>
				<?php } ?>

			</div>
		</div>
	</div> -->
	<div class="mb-5"></div>

	<script>
		$('.arrvls_slide').owlCarousel({
			loop: true,
			margin: 30,
			nav: true,
			dots: false,
			autoplay: true,
			autoplayTimeout: 5000,
			navText: ['<?php echo $this->Html->image('prev.png', ['alt' => 'prev']); ?>', '<?php echo $this->Html->image('next.png', ['alt' => 'next']); ?>'],
			responsive: {
				0: {
					items: 1
				},
				768: {
					items: 2
				},
				1200: {
					items: 3
				}
			}
		});

		$('.blg_slide').owlCarousel({
			loop: true,
			margin: 30,
			nav: true,
			dots: false,
			autoplay: true,
			autoplayTimeout: 5000,
			navText: ['<?php echo $this->Html->image('prev.png', ['alt' => 'prev']); ?>', '<?php echo $this->Html->image('next.png', ['alt' => 'next']); ?>'],
			responsive: {
				0: {
					items: 1
				},
				768: {
					items: 2
				},
				1200: {
					items: 3
				}
			}
		});

		$('.tstmnls_slide').owlCarousel({
			loop: true,
			margin: 10,
			nav: true,
			dots: false,
			autoplay: true,
			autoplayTimeout: 5000,
			navText: ['<?php echo $this->Html->image('tstmnls_arow_prv.png', ['alt' => 'tstmnls_arow_prv']); ?>', '<?php echo $this->Html->image('tstmnls_arow_nxt.png', ['alt' => 'tstmnls_arow_nxt']); ?>'],
			responsive: {
				0: {
					items: 1
				},
				768: {
					items: 1
				},
				1200: {
					items: 1
				}
			}
		});
	</script>