	<?php

	use Cake\Routing\Router; ?>
	<?php
	if (isset($HomeBlocks['Block1']) && !empty($HomeBlocks['Block1'])) {
	?>
		<section class="main_banner">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12 no_padding">
						<div class="mn_slide owl-carousel owl-theme">
							<?php
							foreach ($HomeBlocks['Block1'] as $Block1Data) {
							?>
								<div class="item">
									<div class="arrvl_box">
										<?php
										$image = WWW_ROOT . 'uploads' . DS . 'banner' . DS . $Block1Data['image'];
										if (file_exists($image)) {
											echo $this->Html->image('/uploads/banner/' . $Block1Data['image'], ['alt' => $Block1Data['image'], "class" => "carousel-image"]);
										}
										?>
									</div>
								</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php
	}
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
								<a class="btn" href="<?php echo Router::url('/', true) ?>shop">Shop Now</a>
								<a class="btn cntct" href="<?php echo Router::url('/', true) ?>contact">Contact Us</a>
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
	<?php
	if (count($latestProducts) > 0) {
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
						<?php
						foreach ($latestProducts as $productkeys => $productData) {
							if (!empty($productData['product_images'])) {
								$image_data = $productData['product_images'][0];
								$imageURL = $image_data->image;
							}
						?>
							<div class="item">
								<div class="arrvl_box">
									<a href="<?php echo $this->Url->build(['controller' => 'products', 'action' => 'productView', base64_encode($data->sku_no)]); ?>">
										<?php
										$img_src = Router::url('/', true) . 'uploads/product/';

										$img_name = isset($productData->product_images[0]->image) ? $productData->product_images[0]->image : '';

										// $img_name = $data->sku_no."a.jpg";
										$img_name_a = substr($productData->sku_no, 3) . "a.jpg";

										$sku = $productData->sku_no;

										$inFolder = $this->General->__get_picture_folder($sku);


										$filePath =  WWW_ROOT . 'uploads' . DS . 'product' . DS . $inFolder . DS . $img_name;
										$filePath_A =  WWW_ROOT . 'uploads' . DS . 'product' . DS . $inFolder . DS . $img_name_a;
										//echo $filePath ; die(" Check point1");

										$filePath21 =  WWW_ROOT . 'uploads' . DS . 'product' . DS . $inFolder . DS . str_replace('jpg', 'JPG', $img_name);

										$fileUrl = $img_src . $inFolder . "/" . $img_name;
										$fileUrl_A = $img_src . $inFolder . "/" . $img_name_a;

										$fileUr2l = $img_src . $inFolder . "/" . str_replace('jpg', 'JPG', $img_name);

										if ($img_name != '') {
										?>
											<img src="<?php echo $img_name; ?>" alt="<?= $productData->title; ?>" width="400" />

										<?php } else { ?>
											<img src="<?php echo Router::url('/', true); ?>img/no-image.png" alt="<?php echo $productData->title; ?>" style="height:250px;" />
										<?php
										} ?>
									</a>
									<div class="arrvl_text">
										<h3><?php echo $productData->style; ?></h3>
										<p><?= $productData->title; ?></p>
										<span>$<?php echo number_format($productData->selling_price, 2); ?></span>
										<span class="nw_price">$<?php echo number_format($productData->everyday_price, 2); ?></span>
										<?php
										if (in_array($productData->id, $cartItems)) {
										?>
											<div class="pdocut-buton cart-button" data-id=<?php echo $productData->id; ?>>
												<a class="btn crt_btn cart-button" data-id=<?php echo $productData->id; ?> href="<?php echo $this->Url->build(['controller' => 'products', 'action' => 'cart']); ?>"><i class="bi bi-bag-plus"></i> Added to Cart</a>
											</div>
										<?php
										} else {
										?>
											<div class="pdocut-buton cart-button" data-id=<?php echo $productData->id; ?>>
												<a class="btn crt_btn cart-button" data-id=<?php echo $productData->id; ?> href="javascript:void(0);"><i class="bi bi-bag-plus"></i> Add to Cart</a>
											</div>
										<?php
										}
										?>
									</div>
								</div>
							</div>
						<?php
						}
						?>

						<div class="item">
							<div class="arrvl_box">
								<?php
								$image = WWW_ROOT . 'uploads' . DS . 'product' . DS . 'arrvl_slide002.jpg';
								if (file_exists($image)) {
									echo $this->Html->image('/uploads/product/arrvl_slide002.jpg', ['alt' => 'arrvl_slide002.jpg']);
								}
								?>
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
								<?php
								$image = WWW_ROOT . 'uploads' . DS . 'product' . DS . 'arrvl_slide003.jpg';
								if (file_exists($image)) {
									echo $this->Html->image('/uploads/product/arrvl_slide003.jpg', ['alt' => 'arrvl_slide003.jpg']);
								}
								?>
								<div class="arrvl_text">
									<h3>Uranian Blue</h3>
									<p>2’8″x6’6″ Uranian Blue, Nain with Large Center Medallion, 250 KPSI, Wool and Silk, Hand Knotted, Runner, Oriental Rug</p>
									<span>$2,374.19</span>
									<span class="nw_price">$1,424.51</span>
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
	<section class="blogs">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="heading">
						<h2>From The Blog</h2>
					</div>
					<div class="blg_slide owl-carousel owl-theme">
						<div class="item">
							<div class="blg_box">
								<div class="blg_imag">
									<?php
									$image = WWW_ROOT . 'img' . DS . 'blogs' . DS . 'blog001.jpg';
									if (file_exists($image)) {
										echo $this->Html->image('/img/blogs/' . 'blog001.jpg', ['alt' => 'blog001.jpg']);
									}
									?>
									<span>01 Oct, 2024</span>
								</div>
								<div class="blg_text">
									<h3>Celebrating our 68th Year!</h3>
									<p>We have been selling and servicing our wonderful clients for 68 years with some of [...]</p>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="blg_box">
								<div class="blg_imag">
									<?php
									$image = WWW_ROOT . 'img' . DS . 'blogs' . DS . 'blog002.jpg';
									if (file_exists($image)) {
										echo $this->Html->image('/img/blogs/' . 'blog002.jpg', ['alt' => 'blog002.jpg']);
									}
									?>
									<span>25 Jul, 2024</span>
								</div>
								<div class="blg_text">
									<h3>We do love doing stairs!</h3>
									<p>Gorgeous Wool & Viscose woven modern pattern on this stair and landing project. Product is [...]</p>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="blg_box">
								<div class="blg_imag">
									<?php
									$image = WWW_ROOT . 'img' . DS . 'blogs' . DS . 'blog003.jpg';
									if (file_exists($image)) {
										echo $this->Html->image('/img/blogs/' . 'blog003.jpg', ['alt' => 'blog003.jpg']);
									}
									?>
									<span>24 Jun, 2024</span>
								</div>
								<div class="blg_text">
									<h3>Another Stair Creation!</h3>
									<p>Deerfield Mushroom Animal cut pile print with custom stair rods finish off this multi-level staircase [...]</p>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="blg_box">
								<div class="blg_imag">
									<?php
									$image = WWW_ROOT . 'img' . DS . 'blogs' . DS . 'blog002.jpg';
									if (file_exists($image)) {
										echo $this->Html->image('/img/blogs/' . 'blog002.jpg', ['alt' => 'blog002.jpg']);
									}
									?>
									<span>25 Jul, 2024</span>
								</div>
								<div class="blg_text">
									<h3>We do love doing stairs!</h3>
									<p>Gorgeous Wool & Viscose woven modern pattern on this stair and landing project. Product is [...]</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<script>
		$('.mn_slide').owlCarousel({
			loop: true,
			margin: 30,
			nav: true,
			dots: false,
			autoplay: true,
			autoplayTimeout: 5000,
			navText: ['<?php echo $this->Html->image('prev_wht.png', ['alt' => 'prev_wht']); ?>', '<?php echo $this->Html->image('next_wht.png', ['alt' => 'next_wht']); ?>'],
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
		$('.cart-button').click(function() {

			var product_id = $(this).attr('data-id');
			//var csrfToken = $("[name='_csrfToken']").val();
			var csrfToken = <?php echo json_encode($this->request->getParam('_csrfToken')) ?>;
			var url = '<?php echo $this->Url->build(['controller' => 'products', 'action' => 'addToCart']); ?>';
			$.ajax({
				type: 'POST',
				data: {
					product_id: product_id,
					_csrfToken: csrfToken
				},
				url: url,
				success: function(data) {
					window.location.replace('<?php echo $this->Url->build(['controller' => 'products', 'action' => 'cart']); ?>');
				}
			});
		});
	</script>