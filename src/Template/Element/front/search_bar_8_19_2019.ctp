<?php 
	use Cake\Routing\Router;
	use Cake\Core\Configure;
 ?>
  
<div class="col-md-3 sidebar-filter"><span class="filter-by">Filter by</span>
	<?php echo $this->Html->link('Clear All',['controller'=>'products','action'=>'shopping'],['class'=>'btn ir clear clear-filter-sidebar','title'=>'Clear All']); ?>
	<?php echo $this->Form->create('rugs',['id'=>'CustomerRugsForm', 'class'=>'ajaxform registerForm','novalidate'=>false,'url'=>['controller'=>'products','action'=>'searchProducts']]);
				
				$req_url = isset($this->request->url) ? $this->request->url : '';
				
				$req_url = str_replace('%26', '&', $req_url);
				$req_url = str_replace('%2C', ',', $req_url);
				
				$rug_style_slug = $rug_size_type = $rug_size_slug = $rug_color_slug = '';
				$collpcolor = $collpsize = '';
				$collpstyle = 'show';
				
				
				if(!empty($req_url)){
					$req_url = explode("/",$req_url);
					
					$col_val = $req_url[0];
					$check_slug = isset($req_url[2]) ? $req_url[2] : '';
					
					if($col_val == 'rug-style'){
						$rug_style_slug = $req_url[1];
						$collpstyle = 'show';
					}
					else if($col_val == 'rug-size'){
						$collpsize = 'show';
						$collpstyle = '';
						$rug_size_type = $req_url[1];
						$rug_size_slug = $req_url[2];
						$options	=	Configure::read('size.type');
							foreach($options as $o_key => $val){
								if($rug_size_type == $val){
									$rug_size_type = $o_key;
								}
							}
					}
					else if($col_val == 'rug-color'){
						$collpcolor = 'show';
						$collpstyle = '';
						$rug_color_slug = $req_url[1];
					}
					else if($col_val == 'Products'){  
						$ser_val_arr = explode(',',$req_url[1]);
						$ser_key_arr = explode(',',$req_url[2]);
						$style_val = $size_val = $color_val = array();
						$newSizeArr = [];
						
						if(!empty($ser_key_arr)){
							foreach($ser_key_arr as $ks => $ckVal){ 
								if($ckVal == 'collection'){
									$collpstyle = 'show';
									$style_val 	   = explode('~',$ser_val_arr[$ks]);
								}
								if($ckVal == 'size'){
									$collpsize = 'show';
									$size_val = explode('~',$ser_val_arr[$ks]);
									if(!empty($size_val)){
										foreach($size_val as $sze => $szeVal){
											$size_val_arr = explode('&',$szeVal);
											$newSizeArr[$sze]['val']  = $size_val_arr[0];
											$newSizeArr [$sze]['type'] = $size_val_arr[1];
										}
									}
								}
								
								if($ckVal == 'color'){
									$collpcolor = 'show';
									$color_val = explode('~',$ser_val_arr[$ks]);
								}
								
								if($ckVal == 'slug'){
									echo $this->Form->control('search_details',['class'=>'filtercheckbox','type'=>'hidden','value'=>$ser_val_arr[$ks],'filterTypo'=>'search_details','checked'=>'checked']);
								}
								
								if($ckVal == 'price'){
									$collprice = 'show';
									$price_val 	   = explode('~',$ser_val_arr[$ks]);
								}
								
								if($ckVal == 'price_sort'){
									$collprice = 'show';
									$price_sort_val = explode('~',$ser_val_arr[$ks]);
								}
							}
						}
						
						/* if($check_slug == 'slug' && $col_val = 'Products'){		
							$slg_val = $req_url[1] ? $req_url[1] : ''; 
							echo $this->Form->control('search_details',['class'=>'filtercheckbox','type'=>'hidden','value'=>$slg_val,'filterTypo'=>'search_details','checked'=>'checked']);
						} */
					}	
					else{
						$collpstyle = 'show';
					}
				}
	?>
	<?php 
	
			if(!empty($allCategories)) {
					foreach($allCategories as $categoryKey => $categories) {
						$checked = '';
						if($categories->term == $rug_style_slug){
							echo $this->Form->control('collection[]',['class'=>'filtercheckbox','type'=>'hidden','label'=>$categories->title,'id'=>'collection'.$categories->id,'value'=>$categories->term,'filterTypo'=>'collection','checked'=>$checked]);
						}
						
						if(!empty($style_val)){
							if( in_array($categories->term ,$style_val ) ){
									echo $this->Form->control('collection[]',['class'=>'filtercheckbox','type'=>'hidden','label'=>$categories->title,'id'=>'collection'.$categories->id,'value'=>$categories->term,'filterTypo'=>'collection','checked'=>$checked]);
							}
						} 
					}
			} 
	?>
	
	<nav class="nav" role="navigation">
		<ul class="nav__list filter_custom">
		<li>
			<input id="group-4" type="checkbox" hidden />
			<label for="group-4"><span class="fa fa-angle-right " style="line-height: 10px;"></span>Rug Style</label>
			
			 <ul class="group-list" style="overflow: scroll;overflow-x: hidden;height: 15em;">
				
					<?php if(!empty($allCategories)) {
							$arr = array();
							foreach($allCategories as $key => $Categories) { 
							$arr = array($Categories->title => $Categories->title);
							$attributes = array('data-value'=>$Categories->term);
						?>
								<li style="line-height: 10px;">
									<?php echo $this->Form->radio('collections', $arr, $attributes); ?>
								</li>
							<?php
							}
						} ?>	
					
				</ul>
		</li>
		<li>
			<input id="group-1" type="checkbox" hidden />
			<label for="group-1"><span class="fa fa-angle-right"></span>Rug Size</label>
			
			<ul class="group-list">
		  <?php if(!empty($allSizes)) {
					$options	=	Configure::read('size.type');
					/* echo "<pre>";
					print_r($options);die; */
					foreach($options as $opt_key => $optsval){
			?>
						<li>
						<input id="sub-group-<?= $opt_key ?>" type="checkbox" hidden />
						<label for="sub-group-<?= $opt_key ?>"><span class="fa fa-angle-right"></span><?= $optsval ?></label>
							<ul class="sub-group-list">
							<?php 
				if($opt_key == 3){ ?>
									<li>
										<input id="sub-sub-group-<?= $opt_key ?>" type="checkbox" hidden />
										<label for="sub-sub-group-<?= $opt_key ?>"><span class="fa fa-angle-right"style="padding-left: 5px;"></span>Extra Long Runners</label>
										<ul class="sub-sub-group-list">
							<?php					
										foreach($extralongreturn as $ovrsizeKey => $ovrsizes) { 
											//pr($ovrsizes->slug);
											$slegExp = explode('x',$ovrsizes->slug);
											$exp_val_1 = isset($slegExp[0]) ? $slegExp[0] : ''; 
											$exp_val_2 = isset($slegExp[1]) ? $slegExp[1] : ''; 
											
											//pr($exp_val_1);
											if($opt_key == $ovrsizes->type && $ovrsizes->is_large_runner == 1){
										
												$checked = '';
												if($ovrsizes->slug == $rug_size_slug && $opt_key == $rug_size_type){
													$checked="checked";
												}
												if(!empty($newSizeArr)){
													foreach($newSizeArr as $szck =>$sztyp){
														if($ovrsizes->slug == $sztyp['val'] && $opt_key == $sztyp['type']){
															$checked="checked";
														}
													}
												}
												echo $this->Form->control('size[]',['class'=>'filtercheckbox','data_val'=>$ovrsizes->slug,'data_typ'=>$optsval,'type'=>'checkbox','label'=>$ovrsizes->title,'id'=>'size'.$ovrsizes->id,'value'=>$ovrsizes->slug.'&'.$opt_key,'filterTypo'=>'Size','checked'=>$checked]);
											}
										}		
								?>
										</ul>
									</li>
			<?php 
								} ?>
					  <?php	 	/* if($opt_key != 2 && $opt_key != 4){ ?>
									<li>
										<input id="sub-sub-group-<?= $opt_key ?>" type="checkbox" hidden />
										<label for="sub-sub-group-<?= $opt_key ?>"><span class="fa fa-angle-right"></span>Special Sizes</label>
										<ul class="sub-sub-group-list">
							<?php		
										foreach($allSizes as $ovrsizeKey => $ovrsizes) { 
											//pr($ovrsizes->slug);
											$slegExp = explode('x',$ovrsizes->slug);
											$exp_val_1 = isset($slegExp[0]) ? $slegExp[0] : ''; 
											$exp_val_2 = isset($slegExp[1]) ? $slegExp[1] : ''; 
											
											//pr($exp_val_1);
											if($exp_val_1 >= 10 && $exp_val_2 >= 14 &&  $opt_key == $ovrsizes->type){
										
												$checked = '';
												if($ovrsizes->slug == $rug_size_slug && $opt_key == $rug_size_type){
													$checked="checked";
												}
												if(!empty($newSizeArr)){
													foreach($newSizeArr as $szck =>$sztyp){
														if($ovrsizes->slug == $sztyp['val'] && $opt_key == $sztyp['type']){
															$checked="checked";
														}
													}
												}
												echo $this->Form->control('size[]',['class'=>'filtercheckbox','data_val'=>$ovrsizes->slug,'data_typ'=>$optsval,'type'=>'checkbox','label'=>$ovrsizes->title,'id'=>'size'.$ovrsizes->id,'value'=>$ovrsizes->slug.'&'.$opt_key,'filterTypo'=>'Size','checked'=>$checked]);
											}
										}		
								?>
										</ul>
									</li>
			<?php 
								} */ 
								
								foreach($allSizes as $sizeKey => $sizes) {
									
									$slegExp = explode('x',$sizes->slug);
									$exp_val_1 = isset($slegExp[0]) ? $slegExp[0] : ''; 
									$exp_val_2 = isset($slegExp[1]) ? $slegExp[1] : ''; 
									
									/* echo $sizes->slug;
									echo $exp_val_1;
									echo $sizes->type; */
									//if((($exp_val_1 < 10 && $exp_val_1 < 14) 
										/* || strpos($sizes->slug,'Ft') == true */
									//) && $opt_key == $sizes->type ){ 
									
										if($opt_key == $sizes->type ){
										$checked = '';
										
										if($sizes->slug == $rug_size_slug && $opt_key == $rug_size_type){
											$checked="checked";
										}
										
										
										if(!empty($newSizeArr)){
											foreach($newSizeArr as $szck =>$sztyp){
												if($sizes->slug == $sztyp['val'] && $opt_key == $sztyp['type']){
													$checked="checked";
												}
											}
										}
				?>
										<li>
											<?php echo $this->Form->control('size[]',['class'=>'filtercheckbox','data_val'=>$sizes->slug,'data_typ'=>$optsval,'type'=>'checkbox','label'=>$sizes->title,'id'=>'size'.$sizes->id,'value'=>$sizes->slug.'&'.$opt_key,'filterTypo'=>'Size','checked'=>$checked]); ?>
										</li>
			<?php					}
								}  
				?>				
								<?php  
								if(!empty($specialdimension)){
									if($opt_key == 5){
						foreach($specialdimension as $sizeKey => $sizes) {
									
										//if(1 == $sizes->type ){
										$checked = '';
										
										if($sizes->slug == $rug_size_slug && $opt_key == $rug_size_type){
											$checked="checked";
										}
										
										
										if(!empty($newSizeArr)){
											foreach($newSizeArr as $szck =>$sztyp){
												if($sizes->slug == $sztyp['val'] && $opt_key == $sztyp['type']){
													$checked="checked";
												}
											}
										}
				?>
										<li>
											<?php echo $this->Form->control('size[]',['class'=>'filtercheckbox','data_val'=>$sizes->slug,'data_typ'=>$optsval,'type'=>'checkbox','label'=>$sizes->title,'id'=>'size'.$sizes->id,'value'=>$sizes->slug.'&'.$opt_key,'filterTypo'=>'Size','checked'=>$checked]); ?>
										</li>
			<?php					//}
								}
								}
								}
						?>
						
							</ul>
						
						</li>
			<?php
					}
			?>
					
								
			<?php
				} ?>
			</ul>
		</li>
		<li>
			<input id="group-2" type="checkbox" hidden />
			<label for="group-2"><span class="fa fa-angle-right "></span>Color</label>
			
			  <ul class="group-list" style="overflow: scroll;overflow-x: hidden;height: 15em;">
				  <?php if(!empty($allColors)) {
							foreach($allColors as $key => $colors) { 
								$checked = '';
								if($colors->slug == $rug_color_slug){
									$checked="checked";
								}
								
								if(!empty($color_val)){
									if( in_array($colors->slug,$color_val ) )
										{
											$checked="checked";
										}
								}
						?>
								<li style="line-height: 10px;">
									<?php echo $this->Form->control('color[]',['class'=>'filtercheckbox','data_val'=>$colors->slug,'data_typ'=>'','type'=>'checkbox','label'=>$colors->name,'id'=>'color'.$colors->id,'value'=>$colors->slug,'filterTypo'=>'colors','checked'=>$checked]); ?>
								</li>
							<?php
							}
						} ?>
				</ul>
		</li>
		<li>
			<input id="group-3" type="checkbox" hidden />
			<label for="group-3"><span class="fa fa-angle-right"></span>Price</label>
			
			    <ul class="group-list">
			        <?php 
							$valPrs[0] = '';
							$valPrs[1] = '';
							if(!empty($price_val[0])){
								$valPrs = explode('-',$price_val[0]);
							}
					?>
				   <li class="price-sidebar">
					  <?php echo $this->Form->control('price_min',['value'=>$valPrs[0], "onkeypress"=>"return NumericValidation(event)",'type'=>'text','label'=>'Min Price','id'=>'price_min','filterTypo'=>'price','data_typ'=>'Price']); ?>
					</li>
				   <li class="price-sidebar">
					  <?php echo $this->Form->control('price_max',['value'=>$valPrs[1], "onkeypress"=>"return NumericValidation(event)",'type'=>'text','label'=>'Max Price','id'=>'price_max','filterTypo'=>'price','data_typ'=>'Price']); ?>
				  </li>
				  <li class="price-sidebar">
					  <?php echo $this->Form->button(__('Submit'),['class'=>'filtercheckbox btn','type'=>'button']); ?>
				  </li>
				  
				  <?php if(!empty($allPrice)) {
							foreach($allPrice as $p_key =>$Price) { 
								$checked = '';
								if(!empty($price_val)){
									if( in_array($p_key,$price_val ) )
										{
											$checked="checked";
										}
								}
						?>
								<!--li  style="line-height: 10px;">
									<?php echo $this->Form->control('price[]',['class'=>'filtercheckbox','data_val'=>$p_key,'type'=>'checkbox','data_typ'=>'$','label'=>$Price,'id'=>'price'.$p_key,'value'=>$p_key,'filterTypo'=>'price','checked'=>$checked]); ?>
								</li-->
							<?php
							}
							
							if(!empty($allPriceSort)) {
								foreach($allPriceSort as $so_key =>$SortPrice) { 
										$sort_checked = '';
										if(!empty($price_sort_val)){
											if( in_array($so_key,$price_sort_val)){
												$sort_checked = "checked";
											}
										}
						?>	
									<li>
										<div class="input checkbox">
										   <label for="price_sort">
											<input type="radio" class = "filtercheckbox" name="price_sort[]" id="<?= 'price_sort'.$so_key ?>" value="<?= $so_key ?>" filterTypo='price_sort' data_val=" " data_typ = '<?= $SortPrice ?>'  <?= $sort_checked ?> > <?= $SortPrice ?>
											</label>
										</div>
									</li>
						<?php
								}
							}		
						} ?>
						
				</ul>
		</li>
		</ul>
    </nav>
	<?php echo $this->Form->end(); ?>
</div>	

<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href="https://www.cssscript.com/wp-includes/css/sticky.css" rel="stylesheet" type="text/css">
<style>
/* reset css */



.nav a, .nav label {
  display: block;
 padding: .85rem;
  color: #000;
  background-color: #FFF;
  box-shadow: inset 0 -1px #1d1d1d;
  -webkit-transition: all .25s ease-in;
  transition: all .25s ease-in;
}

.nav a:focus, .nav a:hover, .nav label:focus, .nav label:hover {
 
  background: #151567;
}

.nav label { cursor: pointer; }

/**
 * Styling first level lists items
 */

.group-list a, .group-list label {
  padding-left: 2rem;
  background: #FFF;
  box-shadow: inset 0 -1px #373737;
}

.group-list a:focus, .group-list a:hover, .group-list label:focus, .group-list label:hover { background: #151567; }

/**
 * Styling second level list items
 */

.sub-group-list a, .sub-group-list label {
  padding-left: 4rem;
  background: #FFF;
  box-shadow: inset 0 -1px #474747;
}

.sub-group-list a:focus, .sub-group-list a:hover, .sub-group-list label:focus, .sub-group-list label:hover { background: #151567; }

/**
 * Styling third level list items
 */

.sub-sub-group-list a, .sub-sub-group-list label {
  padding-left: 3rem;
  background: #FFF;
  text-align:left;
  box-shadow: inset 0 -1px #575757;
  
}

.sub-sub-group-list a:focus, .sub-sub-group-list a:hover, .sub-sub-group-list label:focus, .sub-sub-group-list label:hover { background: #151567; }

/**
 * Hide nested lists
 */

.group-list, .sub-group-list, .sub-sub-group-list {
  height: 100%;
  max-height: 0;
  overflow: hidden;
  -webkit-transition: max-height .5s ease-in-out;
  transition: max-height .5s ease-in-out;
  margin: 0;
  padding: 0;

}

.sub-group-list, .sub-sub-group-list {
  position: relative;
  height: 140px;
  max-height:0px;
  -webkit-transition: max-height .5s ease-in-out;
  transition: max-height .5s ease-in-out;
  overflow-x: hidden;
  overflow-y: scroll;
  width: 100%;
  border-left: 1px solid #eee;
border-bottom: 1px solid #eee;
margin-top: 0 !important;

  
}

.nav__list input[type=checkbox]:checked + label + ul { /* reset the height when checkbox is checked */
max-height: 1000px; 
margin: 11px 0;
}

/**
 * Rotating chevron icon
 */

label > span {
  float: right;
  -webkit-transition: -webkit-transform .65s ease;
  transition: transform .65s ease;
}

.nav__list input[type=checkbox]:checked + label > span {
  -webkit-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  transform: rotate(90deg);
}
</style>

<!--script type="text/javascript"src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script-->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
<script>
	function NumericValidation(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
		//alert(charCode);
		if (charCode > 31 && (charCode < 46 || charCode > 57) )
			return false;

		return true;
    }
  /* (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46156385-1', 'cssscript.com');
  ga('send', 'pageview'); */
   $(document).ready(function(){
		$("input[name='collections']").on('change', function () {
			var selectedValue = $("input[name='collections']:checked").attr("data-value");
			if (selectedValue) {
				var base_url = '<?php echo Router::url('/', true); ?>';
				var url = base_url+'rug-style/'+selectedValue;
				window.location.replace(url);
			}
		});
  })
</script>