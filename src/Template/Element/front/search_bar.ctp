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
						if (in_array($dimensionData['slug'], $sizeFilters)) {
							$checked = true;
						} else {
							$checked = false;
						}
					?>
						<li><input data-name="<?= $dimensionData['title']; ?>" <?= $checked ? 'checked' : ''; ?> data-slug-id="<?= $dimensionData['id']; ?>" class="size-filter" type="checkbox" value="<?= $dimensionData['slug']; ?>"><label for="bapf_1_2543"><?= $dimensionData['title']; ?></label></li>
					<?php
					}
					?>
					<button class="clearSizeFilter">Clear</button>
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

<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
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
			let sort = $('#sort-list').val();

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

			// Add sorting to URL
			if (sort) {
				url.searchParams.set('sort', sort);
			} else {
				url.searchParams.delete('sort');
			}

			window.location.href = url.toString();
		}
		$('#size-filter input.size-filter, #price-filter input[type="checkbox"], #sort-list').on('change', updateFilters);
		$('.clearSizeFilter').click(function() {
			$('#size-filter input.size-filter').prop('checked', false);
			updateFilters();
		});
	});

	$(document).ready(function() {

	});
</script>