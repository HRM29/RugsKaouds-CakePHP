<?php

use Cake\Routing\Router;
use Cake\Core\Configure;

$priceFilters = isset($price_range) ? $price_range : array();
$sizeFilters = isset($size_range) ? $size_range : array();
?>
<div class="col-md-4">
	<div class="sidebar">

		<?php
		if (isset($enabledCategories) && !empty($enabledCategories)) {
		?>
			<div class="product_categories">
				<ul>
					<li><a href="<?= Router::url('/', true) . "shop"; ?>">All Products</a> <span class="count">(<?= $totalCategoriesCount; ?>)</span></li>
					<?php
					foreach ($enabledCategories as $categoryData) {
					?>
						<li><a href="<?= Router::url('/', true) . 'product-category/' . $categoryData['page_link']; ?>"><?= $categoryData['title'] ?></a> <span class="count">(<?= $categoryData['total_products'] ?>)</span></li>
					<?php
					}
					?>
				</ul>
			</div>
		<?php
		}
		if (isset($enabledDimentions) && !empty($enabledDimentions)) {
		?>
			<div class="product_categories size">
				<h3>Choose Size</h3>
				<ul id="size-filter">
					<?php
					foreach ($enabledDimentions as $dimensionItem => $dimensionData) {
						if (in_array($dimensionData['id'], $sizeFilters)) {
							$checked = true;
						} else {
							$checked = false;
						}
					?>
						<li><input data-name="<?= $dimensionData['title']; ?>" <?= $checked ? 'checked' : ''; ?> data-slug="<?= $dimensionData['slug']; ?>" class="size-filter" type="checkbox" value="<?= $dimensionData['id']; ?>"><label for="bapf_1_2543"><?= $dimensionData['title']; ?></label></li>
					<?php
					}
					?>
				</ul>
			</div>
		<?php
		} ?>
		<!-- <div class="product_categories clrs">
			<h3>Search by Color</h3>
			<select class="srch_ctgrs" name="product_cat">
				<option value="" selected="selected">All</option>
				<option value="all-products">All Products</option>
				<option value="antique">Antique</option>
				<option value="arts-and-crafts">Arts And Crafts</option>
				<option value="casual">Casual</option>
				<option value="clearance">Clearance</option>
				<option value="fine-oriental">Fine Oriental</option>
				<option value="flat-weave">Flat Weave</option>
				<option value="hand-loomed">Hand-Loomed</option>
				<option value="heriz">Heriz</option>
				<option value="ikat-and-suzani-design">Ikat And Suzani Design</option>
				<option value="kazak">Kazak</option>
				<option value="khotan-and-samarkand">Khotan and Samarkand</option>
				<option value="kids-tween">Kids &amp; Tween</option>
				<option value="maharaja">Maharaja</option>
				<option value="mamluk">Mamluk</option>
				<option value="modern-contemporary">Modern &amp; Contemporary</option>
				<option value="modern-and-contemporary">Modern and Contemporary</option>
				<option value="n-a">N/A</option>
				<option value="oushak-and-peshawar">Oushak And Peshawar</option>
				<option value="overdyed-vintage">Overdyed &amp; Vintage</option>
				<option value="persian">Persian</option>
				<option value="rajasthan">Rajasthan</option>
				<option value="silk">Silk</option>
				<option value="traditional">Traditional</option>
				<option value="transitional">Transitional</option>
				<option value="tribal-geometric">Tribal &amp; Geometric</option>
				<option value="tropical">Tropical</option>
				<option value="white-wash-vintage-silver-wash">White Wash Vintage &amp; Silver Wash</option>
				<option value="wool-and-silk">Wool and Silk</option>
			</select>
		</div> -->
		<?php
		$priceRanges = [
			['id' => 'prc_001', 'range' => '100-1000', 'label' => '$100-$1,000'],
			['id' => 'prc_002', 'range' => '1000-10000', 'label' => '$1,000-$10,000'],
			['id' => 'prc_003', 'range' => '10000-20000', 'label' => '$10,000-$20,000'],
			['id' => 'prc_004', 'range' => '20000-30000', 'label' => '$20,000-$30,000'],
			['id' => 'prc_005', 'range' => '40000-50000', 'label' => '$40,000-$50,000'],
			['id' => 'prc_006', 'range' => '50000-60000', 'label' => '$50,000-$60,000'],
			['id' => 'prc_007', 'range' => '60000-70000', 'label' => '$60,000-$70,000'],
			['id' => 'prc_008', 'range' => '70000-80000', 'label' => '$70,000-$80,000'],
			['id' => 'prc_009', 'range' => '80000-90000', 'label' => '$80,000-$90,000'],
			['id' => 'prc_010', 'range' => '90000-100000', 'label' => '$90,000-$1,00,000'],
			['id' => 'prc_011', 'range' => '100000', 'label' => '$1,00,000 Above'],
		];
		?>
		<div class="product_categories prc">
			<h3>Filter By Price</h3>
			<ul id="price-filter">
				<?php foreach ($priceRanges as $price): ?>
					<li>
						<input
							data-name="<?= $price['label']; ?>"
							id="<?= $price['id']; ?>"
							name="price[]"
							type="checkbox"
							value="<?= $price['range']; ?>"
							<?= in_array($price['range'], $priceFilters) ? 'checked' : ''; ?>>
						<label for="<?= $price['id']; ?>"><?= $price['label']; ?></label>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>





<!-- <div class="col-lg-3 col-md-4 sidebar-filter"><span class="filter-by">Filter by</span>
	<?php echo $this->Html->link('Clear All', ['controller' => 'products', 'action' => 'shopping'], ['class' => 'btn ir clear clear-filter-sidebar', 'title' => 'Clear All']); ?>
	
	<?php echo $this->Form->create('rugs', ['id' => 'CustomerRugsForm', 'class' => 'ajaxform registerForm', 'novalidate' => false, 'url' => ['controller' => 'products', 'action' => 'searchProducts']]);

	$req_url = isset($this->request->url) ? $this->request->url : '';
	$req_url = str_replace('%26', '&', $req_url);
	$req_url = str_replace('%2C', ',', $req_url);

	$rug_style_slug = $rug_size_type = $rug_size_slug = $rug_color_slug =  '';
	$pattern_val = $design_val = $material_val = $construction_val = $category_val = array();
	$collpcolor = $collpsize = $collpattern = $colldesign = $collmaterial = $collconstruction = '';
	$collpstyle = 'show';
	$speceial_size_width_value = '';
	$speceial_size_height_value = '';
	$speceialSize_value = '';


	if (!empty($req_url)) {
		$req_url = explode("/", $req_url);


		$col_val = $req_url[0];
		$check_slug = isset($req_url[2]) ? $req_url[2] : '';

		if ($col_val == 'rug-style') {
			$rug_style_slug = $req_url[1];
			$collpstyle = 'show';
		} else if ($col_val == 'rug-size') {
			$collpsize = 'show';
			$collpstyle = '';
			$rug_size_type = $req_url[1];
			$rug_size_slug = $req_url[2];
			$options	=	Configure::read('size.type');
			foreach ($options as $o_key => $val) {
				if ($rug_size_type == $val) {
					$rug_size_type = $o_key;
				}
			}
		} else if ($col_val == 'rug-color') {
			$collpcolor = 'show';
			$collpstyle = '';
			$rug_color_slug = $req_url[1];
		} else if ($col_val == 'Products') {
			$ser_val_arr = explode(',', $req_url[1]);
			$ser_key_arr = explode(',', $req_url[2]);
			$style_val = $size_val = $color_val = array();
			$newSizeArr = [];

			if (!empty($ser_key_arr)) {
				foreach ($ser_key_arr as $ks => $ckVal) {
					if ($ckVal == 'style') {
						$collpstyle = 'show';
						$style_val 	   = explode('~', $ser_val_arr[$ks]);
					}

					if ($ckVal == 'size') {
						$collpsize = 'show';
						$size_val = explode('~', $ser_val_arr[$ks]);
						if (!empty($size_val)) {
							foreach ($size_val as $sze => $szeVal) {
								$size_val_arr = explode('&', $szeVal);
								$newSizeArr[$sze]['val']  = $size_val_arr[0];
								$newSizeArr[$sze]['type'] = $size_val_arr[1];

								if ($size_val_arr[1] == 5) {
									$special_temp = explode('x', $size_val_arr[0]);
									$speceial_size_width_value = $special_temp[0];
									$speceial_size_height_value = $special_temp[1];
									$speceialSize_value = $szeVal;
								}
							}
						}
					}

					if ($ckVal == 'color') {
						$collpcolor = 'show';
						$color_val = explode('~', $ser_val_arr[$ks]);
					}

					if ($ckVal == 'slug') {
						echo $this->Form->control('search_details', ['class' => 'filtercheckbox', 'type' => 'hidden', 'value' => $ser_val_arr[$ks], 'filterTypo' => 'search_details', 'checked' => 'checked']);
					}

					if ($ckVal == 'price') {
						$collprice = 'show';
						$price_val 	   = explode('~', $ser_val_arr[$ks]);
					}

					if ($ckVal == 'price_sort') {
						$collprice = 'show';
						$price_sort_val = explode('~', $ser_val_arr[$ks]);
					}

					if ($ckVal == 'pattern') {
						$colldesign	= 'show';
						$temp 	= explode('~', $ser_val_arr[$ks]);
						foreach ($temp as $key => $value2) {
							$pattern_val[] = str_replace('%20', ' ', $value2);
						}
					}

					if ($ckVal == 'design') {
						$collpattern	= 'show';
						$temp 	= explode('~', $ser_val_arr[$ks]);
						foreach ($temp as $key => $value2) {
							$design_val[] = str_replace('%20', ' ', $value2);
						}
					}

					if ($ckVal == 'material') {
						$collmaterial	= 'show';
						$temp 	= explode('~', $ser_val_arr[$ks]);
						foreach ($temp as $key => $value2) {
							$material_val[] = str_replace('%20', ' ', $value2);
						}
					}

					if ($ckVal == 'constr') {
						$collconstruction	= 'show';
						$temp 	= explode('~', $ser_val_arr[$ks]);
						foreach ($temp as $key => $value2) {
							$construction_val[] = str_replace('%20', ' ', $value2);
						}
					}

					if ($ckVal == 'collection') {
						$temp 	= explode('~', $ser_val_arr[$ks]);
						foreach ($temp as $key => $value2) {
							$category_val[] = str_replace('%20', ' ', $value2);
						}
					}
				}
			}
		} else {
			$collpstyle = 'show';
		}
	}
	?>
	 <div id="mySidenav01" class="sidenavs">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav0()">&times;</a>
  

	<nav class="nav" role="navigation">
		<ul class="nav__list filter_custom"> 
			<li>
				<input id="group-4" type="checkbox" <?php if (!empty($style_val)) {
														echo "checked";
													} ?> hidden />
				<label for="group-4"><span class="fa fa-angle-right " style="line-height: 10px;"></span>Rug Style</label>
				<ul class="group-list" style="overflow: scroll;overflow-x: hidden;">
					<?php
					$overstock_styles = Configure::read('OverstockStyle');
					if (isset($overstock_styles) && !empty($overstock_styles)) {
						$counter = 0;
						foreach ($overstock_styles as $key => $val) {
							$checked = '';
							if (!empty($val)) {
								if (in_array($val, $style_val)) {
									$checked = "checked";
								}
							}
					?>						
					<li> 
					<?php
							echo $this->Form->control('style[]', ['class' => 'filtercheckbox', 'data_val' => $val, 'data_typ' => '', 'type' => 'checkbox', 'label' => $val . $this->General->getRugStyle($val, $styleFilters), 'id' => 'style' . $counter, 'value' => $val, 'filterTypo' => 'style', 'checked' => $checked]); ?>
					</li>
						<?php
							$counter++;
							if ($counter % 5 == 0) {
								break;
							}
						}
					}
						?> 
				</ul>
			</li>
			<li>
			<?php
			foreach ($newSizeArr as $sizecode) {
				$activetype[] = $sizecode['type'];
			}
			?>
				<input id="group-1" type="checkbox" <?php if (!empty($activetype)) {
														echo "checked";
													} ?> hidden />
				<label for="group-1"><span class="fa fa-angle-right"></span>Rug Size</label>
			
				<ul class="group-list">
				<?php
				$options	=	Configure::read('size.type');

				foreach ($options as $opt_key => $optsval) {
					$allSizes = $this->General->getSizeByType($opt_key);

				?>
					<li> 
						<input id="sub-group-<?= $opt_key ?>" type="checkbox" <?php if (in_array($opt_key, $activetype)) {
																					echo "checked";
																				} ?> hidden />
						<label for="sub-group-<?= $opt_key ?>"><span class="fa fa-angle-right"></span><?= $optsval ?></label>
						<ul class="sub-group-list">
							<?php if ($opt_key == 3) { ?>
							<li>
								<input id="sub-sub-group-<?= $opt_key ?>" type="checkbox" hidden />
								<label for="sub-sub-group-<?= $opt_key ?>"><span class="fa fa-angle-right"style="padding-left: 5px;"></span>Extra Long Runners</label>
								<ul class="sub-sub-group-list">
									<?php
									foreach ($extralongreturn as $ovrsizeKey => $ovrsizes) {
										$slegExp = explode('x', $ovrsizes->slug);
										$exp_val_1 = isset($slegExp[0]) ? $slegExp[0] : '';
										$exp_val_2 = isset($slegExp[1]) ? $slegExp[1] : '';

										if ($opt_key == $ovrsizes->type && $ovrsizes->is_large_runner == 1) {

											$checked = '';
											if ($ovrsizes->slug == $rug_size_slug && $opt_key == $rug_size_type) {
												$checked = "checked";
											}
											if (!empty($newSizeArr)) {
												foreach ($newSizeArr as $szck => $sztyp) {
													if ($ovrsizes->slug == $sztyp['val'] && $opt_key == $sztyp['type']) {
														$checked = "checked";
													}
												}
											}
											echo $this->Form->control('size[]', ['class' => 'filtercheckbox', 'data_val' => $ovrsizes->slug, 'data_typ' => $optsval, 'type' => 'checkbox', 'label' => $ovrsizes->title . $this->General->getSizeCount($ovrsizes->slug, $opt_key, $sizeFilters), 'id' => 'size' . $ovrsizes->id, 'value' => $ovrsizes->slug . '&' . $opt_key, 'filterTypo' => 'Size', 'checked' => $checked]);
										}
									}
									?>
								</ul>
							</li>
							<?php } ?>
							<?php
							foreach ($allSizes as $sizeKey => $sizes) {
								$sizes = (object) $sizes;
								$slegExp = explode('x', $sizes->slug);
								$exp_val_1 = isset($slegExp[0]) ? $slegExp[0] : '';
								$exp_val_2 = isset($slegExp[1]) ? $slegExp[1] : '';

								if ($opt_key == $sizes->type) {
									$checked = '';

									if ($sizes->slug == $rug_size_slug && $opt_key == $rug_size_type) {
										$checked = "checked";
									}


									if (!empty($newSizeArr)) {
										foreach ($newSizeArr as $szck => $sztyp) {
											if ($sizes->slug == $sztyp['val'] && $opt_key == $sztyp['type']) {
												$checked = "checked";
											}
										}
									}
							?>
										<li>
											<?php echo $this->Form->control('size[]', ['class' => 'filtercheckbox', 'data_val' => $sizes->slug, 'data_typ' => $optsval, 'type' => 'checkbox', 'label' => $sizes->title . $this->General->getSizeCount($sizes->slug, $opt_key, $sizeFilters), 'id' => 'size' . $sizes->id, 'value' => $sizes->slug . '&' . $opt_key, 'filterTypo' => 'Size', 'checked' => $checked]); ?>
										</li>
							<?php
								}
							}
							?>				
							<?php
							if ($opt_key == 5) {
							?>
								<li class="row sidebarDropdown">
									<?php //echo $this->Form->control('size[]',['class'=>'filtercheckbox','data_val'=>$sizes->slug,'data_typ'=>$optsval,'type'=>'checkbox','label'=>$sizes->title.$this->General->getSizeCount($sizes->slug,$opt_key,$sizeFilters),'id'=>'size'.$sizes->id,'value'=>$sizes->slug.'&'.$opt_key,'filterTypo'=>'Size','checked'=>$checked]); 
									?>
									<div class="col-lg-6 ml-1">
									<?php
									//$speceialSizeWidth_drop = Configure::read('speceialSizeWidth_drop');
									//echo $this->Form->control('speceial_size_width', ['options' => $speceialSizeWidth_drop,'label'=>false,'class'=>'form-control','value'=>$speceial_size_width_value,'empty'=>'Select Width']);

									echo $this->Form->control('speceial_size_width', ['type' => 'number', 'label' => false, 'placeholder' => 'Width', 'class' => 'form-control speceial_size_width', 'value' => $speceial_size_width_value, 'min' => "0"]);
									?>
									</div>
									<div class="col-lg-5">
									<?php
									echo $this->Form->control('speceial_size_height', ['type' => 'number', 'placeholder' => 'Height', 'label' => false, 'class' => 'form-control speceial_size_height', 'value' => $speceial_size_height_value, 'min' => "0"]);

									echo $this->Form->control('speceialSize', ['type' => 'hidden', 'data_typ' => $optsval, 'value' => $speceialSize_value]);
									?>
									</div>
									<div class="col-12 mt-1">
									 	<?php echo $this->Form->button(__('Submit'), ['class' => 'speceialSizeButton btn btn-sm btn-dark', 'type' => 'button']); ?>
										
										<?php echo $this->Form->button(__('Clear'), ['class' => 'speceialSizeClearButton btn btn-sm btn-dark', 'type' => 'button']); ?>
									</div>
								</li>
							<?php
							}
							?> 
						</ul> 
					</li>
				<?php
				}
				?>
				</ul>
			</li>
			<li> 
				<input id="group-2" type="checkbox" <?php if (!empty($color_val)) {
														echo "checked";
													} ?> hidden />
				<label for="group-2"><span class="fa fa-angle-right "></span>Color</label>
			
				<ul class="group-list" style="overflow: scroll;overflow-x: hidden;">
					<?php
					if (!empty($allColors)) {
						foreach ($allColors as $key => $colors) {
							$checked = '';
							if ($colors->slug == $rug_color_slug) {
								$checked = "checked";
							}

							if (!empty($color_val)) {
								if (in_array($colors->slug, $color_val)) {
									$checked = "checked";
								}
							}
					?>
							<li style="line-height: 10px;">
								<?php echo $this->Form->control('color[]', ['class' => 'filtercheckbox', 'data_val' => $colors->slug, 'data_typ' => '', 'type' => 'checkbox', 'label' => $colors->name . $this->General->getColorCount($colors->id, $colorFilters), 'id' => 'color' . $colors->id, 'value' => $colors->slug, 'filterTypo' => 'colors', 'checked' => $checked]); ?>
							</li>
					<?php
						}
					}
					?>
				</ul>
			</li>
			<li> 
				<input id="group-5" type="checkbox" <?php if (!empty($pattern_val)) {
														echo "checked";
													} ?> hidden />
				<label for="group-5"><span class="fa fa-angle-right "></span>Patterns</label>
				<ul class="group-list" style="overflow: scroll;overflow-x: hidden;">
					<?php
					$patterns = Configure::read('OverstockPattern');
					if (!empty($patterns)) {
						foreach ($patterns as $key => $pattern) {
							$checked = '';
							if (!empty($pattern)) {
								if (in_array($pattern, $pattern_val)) {
									$checked = "checked";
								}
							}
					?>
						<li style="line-height: 10px;">
							<?php echo $this->Form->control('pattern[]', ['class' => 'filtercheckbox', 'data_val' => $pattern, 'data_typ' => '', 'type' => 'checkbox', 'label' => $pattern . $this->General->getRugPattern($pattern, $patternFilters), 'id' => 'pattern' . $pattern, 'value' => $pattern, 'filterTypo' => 'patterns', 'checked' => $checked]); ?>
						</li>
					<?php
						}
					}
					?>
				</ul>
			</li>
			<li> 
				<input id="group-6" type="checkbox" <?php if (!empty($design_val)) {
														echo "checked";
													} ?> hidden />
				<label for="group-6"><span class="fa fa-angle-right "></span>Designs</label>
				<ul class="group-list" style="overflow: scroll;overflow-x: hidden;">
				<?php
				$designs = Configure::read('rugDesign');
				if (!empty($designs)) {
					foreach ($designs as $key => $design) {
						$checked = '';
						if (!empty($design)) {
							if (in_array($design, $design_val)) {
								$checked = "checked";
							}
						}
				?>
							<li style="line-height: 10px;">
								<?php echo $this->Form->control('design[]', ['class' => 'filtercheckbox', 'data_val' => $design, 'data_typ' => '', 'type' => 'checkbox', 'label' => $design . $this->General->getRugDesign($design, $designFilters), 'id' => 'design' . $design, 'value' => $design, 'filterTypo' => 'designs', 'checked' => $checked]); ?>
							</li>
				<?php
					}
				} ?>
				</ul>
			</li>
			<li> 
				<input id="group-7" type="checkbox" <?php if (!empty($material_val)) {
														echo "checked";
													} ?> hidden />
				<label for="group-7"><span class="fa fa-angle-right "></span>Materials</label>
				<ul class="group-list" style="overflow: scroll;overflow-x: hidden;">
				<?php
				$materials = Configure::read('rugMaterial');
				if (!empty($materials)) {
					foreach ($materials as $key => $material) {
						$checked = '';
						if (!empty($material)) {
							if (in_array($material, $material_val)) {
								$checked = "checked";
							}
						}
				?>
						<li style="line-height: 10px;">
							<?php echo $this->Form->control('material[]', ['class' => 'filtercheckbox', 'data_val' => $material, 'data_typ' => '', 'type' => 'checkbox', 'label' => $material . $this->General->getRugMaterial($material, $materialFilters), 'id' => 'material' . $material, 'value' => $material, 'filterTypo' => 'material', 'checked' => $checked]); ?>
						</li>
				<?php
					}
				}
				?>
				</ul>
			</li>
			<li> 
				<input id="group-8" type="checkbox" <?php if (!empty($construction_val)) {
														echo "checked";
													} ?> hidden />
				<label for="group-8"><span class="fa fa-angle-right "></span>Constructions</label>
				<ul class="group-list" style="overflow: scroll;overflow-x: hidden;">
				<?php
				$constructions = Configure::read('rug_type');
				if (!empty($materials)) {
					foreach ($constructions as $key => $construction) {
						$checked = '';
						if (!empty($construction)) {
							if (in_array($construction, $construction_val)) {
								$checked = "checked";
							}
						}
				?>
							<li style="line-height: 10px;">
								<?php echo $this->Form->control('constr[]', ['class' => 'filtercheckbox', 'data_val' => $construction, 'data_typ' => '', 'type' => 'checkbox', 'label' => $construction . $this->General->getRugConstruction($construction, $constructionFilters), 'id' => 'construction' . $construction, 'value' => $construction, 'filterTypo' => 'material', 'checked' => $checked]); ?>
							</li>
				<?php
					}
				} ?>
				</ul>
			</li>
			<li>  
				<input id="group-3" type="checkbox"  <?php if (!empty($price_val) || !empty($price_sort_val)) {
															echo "checked";
														} ?> hidden />
				<label for="group-3"><span class="fa fa-angle-right"></span>Price</label>
				<ul class="group-list">
					<?php
					$valPrs[0] = '';
					$valPrs[1] = '';
					if (!empty($price_val[0])) {
						$valPrs = explode('-', $price_val[0]);
					}
					?>
				    
					<?php
					if (!empty($allPrice)) {
						foreach ($allPrice as $p_key => $Price) {
							$checked = '';
							if (!empty($price_val)) {
								if (in_array($p_key, $price_val)) {
									$checked = "checked";
								}
							}
					?>
								<li  style="line-height: 10px;">
									<?php echo $this->Form->control('price[]', ['class' => 'filtercheckbox', 'data_val' => $p_key, 'type' => 'checkbox', 'data_typ' => '$', 'label' => $Price, 'id' => 'price' . $p_key, 'value' => $p_key, 'filterTypo' => 'price', 'checked' => $checked]); ?>
								</li>
					<?php
						}
						if (!empty($allPriceSort)) {
							foreach ($allPriceSort as $so_key => $SortPrice) {
								$sort_checked = '';
								if (!empty($price_sort_val)) {
									if (in_array($so_key, $price_sort_val)) {
										$sort_checked = "checked";
									}
								}
					?>	
								<li>
									<div class="input checkbox">
									   <label for="price_sort">
										<input type="radio" class = "filtercheckbox" name="price_sort[]" id="<?= 'price_sort' . $so_key ?>" value="<?= $so_key ?>" filterTypo='price_sort' data_val=" " data_typ = '<?= $SortPrice ?>'  <?= $sort_checked ?> > <?= $SortPrice ?>
										</label>
									</div>
								</li>
					<?php
							}
						}
					}
					?>
				</ul>
			</li>
		</ul>
    </nav>
	
	</div>
	<?php echo $this->Form->end(); ?>
</div>	 -->
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


<!--script type="text/javascript"src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script-->
<script>
	var valueArray = <?php echo json_encode($valueArr); ?>;
	var params = <?php echo json_encode($arrParms); ?>;

	$(document).ready(function() {
		$(valueArray).each(function(index, value) {
			jQuery("input[value='" + value + "']:checkbox").prop('checked', true);
			jQuery("input[value='" + value + "']:radio").prop('checked', true);
		});
	});

	function NumericValidation(evt) {
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		//alert(charCode);
		if (charCode > 31 && (charCode < 46 || charCode > 57))
			return false;

		return true;
	}

	$(document).ready(function() {

		$(".speceialSizeButton").click(function() {
			var selected_height = $(".speceial_size_height").val();
			var selected_width = $(".speceial_size_width").val();

			if (selected_height || selected_width) {

				var speceialSize = selected_width + 'x' + selected_height + '&5';

				$("input[name='speceialSize']").val(speceialSize);

				var data = $('#CustomerRugsForm').serialize();
				var SITE_URL = '<?php echo Router::url('/', true); ?>';
				var filterUrl = SITE_URL + 'products/getFilterParam';
				// console.log('data:'+data);
				$.ajax({
					url: filterUrl,
					type: 'POST',
					data: data,
					success: function(response) {
						// console.log(response);
						if (response == "") {
							response = "shopping";
						}
						var redirectUrl = 'Products/';
						setTimeout(function() {
							location.href = SITE_URL + redirectUrl + response;
						}, 100);
					}
				});
			} else {
				alert('Select Height');
				$("input[name='speceialSize']").val();
				// $("input[name='speceialSize']").val();
			}
		});

		$(".speceialSizeClearButton").click(function() {
			$(".speceial_size_height").val('');
			$(".speceial_size_width").val('');

			$("input[name='speceialSize']").val('');

			var data = $('#CustomerRugsForm').serialize();
			var SITE_URL = '<?php echo Router::url('/', true); ?>';
			var filterUrl = SITE_URL + 'products/getFilterParam';
			// console.log('data:'+data);
			$.ajax({
				url: filterUrl,
				type: 'POST',
				data: data,
				success: function(response) {
					// console.log(response);
					if (response == "") {
						response = "shopping";
					}
					var redirectUrl = 'Products/';
					setTimeout(function() {
						location.href = SITE_URL + redirectUrl + response;
					}, 100);
				}
			});

		});
	})



	function openNav0() {
		document.getElementById("mySidenav01").style.width = "100%";
		document.getElementById("main01").style.marginRight = "0";
	}

	function closeNav0() {
		document.getElementById("mySidenav01").style.width = "0";
		document.getElementById("main01").style.marginRight = "0";
	}
	$(document).ready(function() {
		// Function to update filters and URL
		function updateFilters() {
			let sizes = [];
			let prices = [];

			// Get all selected sizes
			$('#size-filter input.size-filter:checked').each(function() {
				sizes.push($(this).val());
			});

			// Get all selected prices
			$('#price-filter input[type="checkbox"]:checked').each(function() {
				prices.push($(this).val());
			});

			// Construct the URL
			let url = new URL(window.location.href);

			// Add sizes to URL
			if (sizes.length > 0) {
				url.searchParams.set('sizes', sizes.join('~'));
			} else {
				url.searchParams.delete('sizes');
			}

			// Add prices to URL
			if (prices.length > 0) {
				url.searchParams.set('price', prices.join('~'));
			} else {
				url.searchParams.delete('price');
			}
			// console.log(url.toString());
			window.location.href = url.toString();
		}
		$('#size-filter input.size-filter, #price-filter input[type="checkbox"]').on('change', updateFilters);
	});
</script>