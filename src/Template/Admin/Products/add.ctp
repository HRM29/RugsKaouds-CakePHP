<?php use Cake\Routing\Router;
use Cake\Core\Configure; ?>
<section class="content-header">
  <h1>
	 <?= $title; ?> 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/products"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add <?= $title; ?></li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title">Add <?= $title; ?></h3>
                </div><!-- /.box-header -->
                <?= $this->Form->create($product, ['type' => 'file']) ?>
				<div class="box-body">
					<div class="form-group row">
						<div class="col-xs-5">
							<label for="normal" class="control-label">Sku<span style="color:red;">*</span></label>
							<?= $this->Form->control('sku_no', ['placeholder'=> 'Sku','label'=>false,'class'=>'form-control','required'=>true]);?>
						</div>
						<div class="col-xs-5">
                            <label for="normal" class="control-label">Category<span style="color:red;">*</span></label>
							<?= $this->Form->control('category_id', ['options'=>$category,'label'=>false,'class'=>'form-control category','empty'=>'Select Category','required'=>true]);?>
						</div>
                    </div>
					
				    <div class="form-group row">
						<div class="col-xs-5">
							<label for="normal" class="control-label">Title<span class="required_field">*</span></label>
							<?= $this->Form->control('title', ['placeholder'=> 'Title','label'=>false,'class'=>'form-control','required'=>true]);?>
						</div>
						<div class="col-xs-5">
                            <label for="normal" class="control-label">Rug Type<span style="color:red;">*</span></label>
							<?php $rug_type=Configure::read('rug_type')?>
							<?= $this->Form->control('rug_type', ['options'=>$rug_type,'label'=>false,'class'=>'form-control','empty'=>'Select Rug Type','required'=>true]);?>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-5">
							<label for="normal" class="control-label">Dimension 1 Feet<span class="required_field">*</span></label>
							<?php $dimension1_feet=Configure::read('dimension1_feet')?>
							<?= $this->Form->control('dimension_1_feet', ['options'=>$dimension1_feet,'label'=>false,'class'=>'form-control','empty'=>'Select Rug Dimension','required'=>true]);?>
						</div>
						<div class="col-xs-5">
							<label for="normal" class="control-label">Dimension 1 Inches<span class="required_field">*</span></label>
							<?php $dimension1_inches=Configure::read('dimension1_inches')?>
							<?= $this->Form->control('dimension_1_inches', ['options'=>$dimension1_inches,'label'=>false,'class'=>'form-control','empty'=>'Select Rug Dimension','required'=>true]);?>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-5">
							<label for="normal" class="control-label">Dimension 2 Feet<span class="required_field">*</span></label>
							<?php $dimension2_feet=Configure::read('dimension2_feet')?>
							<?= $this->Form->control('dimension_2_feet', ['options'=>$dimension2_feet,'label'=>false,'class'=>'form-control','empty'=>'Select Rug Dimension','required'=>true]);?>
						</div>
						<div class="col-xs-5">
							<label for="normal" class="control-label">Dimension 2 Inches<span class="required_field">*</span></label>
							<?php $dimension2_inches=Configure::read('dimension2_inches')?>
							<?= $this->Form->control('dimension_2_inches', ['options'=>$dimension2_inches,'label'=>false,'class'=>'form-control','empty'=>'Select Rug Dimension','required'=>true]);?>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-5">
							<label for="normal" class="control-label">Dimension<span class="required_field">*</span></label>
							 
							<?= $this->Form->control('dimension_id', ['options'=>$dimension,'label'=>false,'class'=>'form-control','empty'=>'Select Dimension','required'=>true]);?>
						</div>
						<div class="col-xs-5">
							<label for="normal" class="control-label">Dimension Total sq. Feet<span class="required_field">*</span></label>
							<?= $this->Form->control('total_square_ft', ['placeholder'=>'Dimension Total sq. Feet','label'=>false,'class'=>'form-control','required'=>true]);?>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-5">
							<label for="normal" class="control-label">Color<span class="required_field">*</span></label>
							 
							<?= $this->Form->control('color_id', ['options'=>$color,'label'=>false,'class'=>'form-control','empty'=>'Select Color','required'=>true]);?>
						</div>
						<div class="col-xs-5">
							<label for="normal" class="control-label">Rug Border Color<span class="required_field">*</span></label>
							<?= $this->Form->control('border_color', ['placeholder'=>'Rug Border Color','label'=>false,'class'=>'form-control','required'=>true]);?>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-5">
							<label for="normal" class="control-label">Other Color<span class="required_field">*</span></label>
							
							<?php //= $this->Form->control('color', ['options'=>$color,'label'=>false,'class'=>'form-control','empty'=>'Select Color']);?>
							<?= $this->Form->control('other_colors', ['placeholder'=>'Other Color','label'=>false,'class'=>'form-control','required'=>true]); 
							
							/* $this->Form->control('other_colors', array('type'=>'select','required'=>true,'class'=>'form-control', 'id' => 'lstFruits','label' => false,'options' => $color,'multiple'=>true)); */ 
							?>
						</div>
						<div class="col-xs-5">
							<label for="normal" class="control-label">Style<span class="required_field">*</span></label>
							<?php $style=Configure::read('style')?>	
							<?= $this->Form->control('style', ['options'=>$style,'label'=>false,'class'=>'form-control','empty'=>'Select Style','required'=>true]);?>
						</div>
					</div>
					
					<div class="form-group row">
						<div class="col-xs-5">
							<label for="normal" class="control-label">Available Shape<span class="required_field">*</span></label>
							<?= $this->Form->control('available_shape', ['placeholder'=>'Available Shape','label'=>false,'class'=>'form-control','required'=>true]);
							/*  $availableShape=Configure::read('availableShape');
							 echo $this->Form->control('available_shape', ['options'=>$availableShape,'label'=>false,'class'=>'form-control','empty'=>'Select Available Shape']);  */?>
						</div>
						
						<div class="col-xs-5">
							<label for="normal" class="control-label">Size<span class="required_field">*</span></label>
							<?= $this->Form->control('size', ['placeholder'=>'Size','label'=>false,'class'=>'form-control','required'=>true]);?>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-5">
							<label for="normal" class="control-label">Foundation<span class="required_field">*</span></label>
							<?= $this->Form->control('foundation_id', ['options'=>$foundations,'label'=>false,'class'=>'form-control','empty'=>'Select Foundation','required'=>true]);?>
						</div>
						<div class="col-xs-5">
							<label for="normal" class="control-label">Pile<span class="required_field">*</span></label>
							<?= $this->Form->control('pile_id', ['options'=>$pile,'label'=>false,'class'=>'form-control','empty'=>'Select Pile','required'=>true]);?>
						</div>
						
					</div>
					
					<div class="form-group row">
					    <!--div class="col-xs-5">
							<label for="normal" class="control-label">Product Type<span class="required_field">*</span></label>
							<?php // $this->Form->control('product_type', ['placeholder'=> 'Product Type','label'=>false,'class'=>'form-control']);?>
						</div-->
						<div class="col-xs-5">
							<label for="normal" class="control-label">Pattern<span style="color:red;">*</span></label>
							<?= $this->Form->control('pattern', ['options'=>Configure::read('OverstockPattern'),'empty'=> 'Select Pattern','label'=>false,'class'=>'form-control','required'=>true]);?>
						</div>
					    <div class="col-xs-5">
							<label for="normal" class="control-label">Design<span style="color:red;">*</span></label>
							<?= $this->Form->control('rug_design', ['options'=>Configure::read('rugDesign'),'empty'=> 'Design','label'=>false,'class'=>'form-control','required'=>true]);?>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-5">
							<label for="normal" class="control-label">Material<span style="color:red;">*</span></label>
							<?= $this->Form->control('material', ['options'=>Configure::read('rugMaterial'),'empty'=> 'Material','label'=>false,'class'=>'form-control','required'=>true]);?>
						</div>
					    <div class="col-xs-5">
							<label for="normal" class="control-label">Field Color Exact<span style="color:red;">*</span></label>
							<?= $this->Form->control('field_color_exact', ['placeholder'=> 'Field Color Exact','label'=>false,'class'=>'form-control','required'=>true]);?>
						</div>
					</div>
					
					<div class="form-group row">
						<div class="col-xs-3">
							<label for="normal" class="control-label">Selling Price<span style="color:red;">*</span></label>
							<?= $this->Form->control('selling_price', ['placeholder'=> 'Selling Price','label'=>false,'class'=>'form-control','required'=>true]);?>
						</div>
						<div class="col-xs-2">
							<label for="normal">Rugpad Price<span style="color:red;">*</span></label>
							<?= $this->Form->control('rug_pad', ['placeholder'=> 'Rugpad Price','label'=>false,'class'=>'form-control','required'=>true]);?>
						</div>
						<div class="col-xs-2">
							<label for="normal">Shipping Rate<span style="color:red;">*</span></label>
							<?= $this->Form->control('shipping_price', ['placeholder'=> 'Shipping Rate','label'=>false,'class'=>'form-control','required'=>true]);?>
						</div>
						
						<div class="col-xs-2">
                            <label for="normal" class="control-label">Age</label>
                            <div class="controls">
								<?= $this->Form->control('age', ['placeholder'=> 'Age','label'=>false,'type'=>'text','class'=>'form-control']);?>
                            </div>
                        </div>
						<div class="col-xs-2">
                            <label for="normal" class="control-label">Is Featured</label>
                            <div class="controls">
								<?php echo $this->Form->control('is_future',['type'=>'checkbox','label'=>false,'style'=>array('margin-left:0px')]);?>
                            </div>
                        </div>
						
					
					</div>
					<!--div class="form-group row">
						<div class="">
							<div id="child-body" class="col-xs-5">
								<div class="appandable">
								    <div class="clearfix"></div>
									<div class="control-group">
										<label for="normal" class="control-label">Size<span style="color:red;">*</span></label>
										<div class="controls">
											<?php 
											//$default = 'Select Size';
											 //echo //$this->Form->control('size_id',['name'=>'size_id[]','label'=>false,
																	//	'options'=>$size,
																//		'class'=>'form-control input_cl input_size','empty' => ['' => $default]]
																//	);  
											?>
										</div>
									</div>
									 
									<div class="control-group" >
									    <div class="clearfix"></br></div>
										<div class="controls"><a href="javascript:void(0);" class="btn btn-danger btn-block removeChild">Remove</a> 
										</div>
									</div>	

								</div> 
							</div>
							<div class="control  col-xs-2">
									<label for="normal" class="control-label">&nbsp;</label>
									<div class="controls">
										<a href="javascript:void(0);" class="btn btn-info" id="addmore"><i class="icon-plus"></i> Add More</a>
									</div>
							</div>
						</div>
					</div-->
					
					
					<div class="form-group row">
					    <!--div class="col-xs-2">
							<label for="Last Name">Mrp Price<span style="color:red;">*</span></label>
							<?PHP // $this->Form->control('mrp', ['placeholder'=> 'Mrp Price','label'=>false,'type'=>'text','class'=>'form-control',"onkeypress"=>"return NumericValidation(event)"]);?>
						</div>
						<div class="col-xs-3">
							<label for="Last Name">Price<span style="color:red;">*</span></label>
							<?PHP // $this->Form->control('price', ['placeholder'=> 'Price','label'=>false,'type'=>'text','class'=>'form-control',"onkeypress"=>"return NumericValidation(event)"]);?>
						</div-->
						<div class="col-xs-5">
							<label for="normal" class="control-label">Location<span style="color:red;">*</span></label>
							<?= $this->Form->control('location', ['placeholder'=> 'Location','label'=>false,'class'=>'form-control','required'=>true]);?>
						</div>
						<div class="col-xs-5">
							<label for="Password">Status<span style="color:red;">*</span></label>
							<?php $options = array(Active => "Active" , Inactive => "Inactive");?>
							<?= $this->Form->control('status', ['options'=>$options,'label'=>false,'class'=>'form-control','empty'=>'Select Status','required'=>true]);?>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-xs-5">
                            <label for="normal" class="control-label">Image</label>
								<?php //echo $this->Form->input('image',['type'=>'file','label'=>false]);
										echo $this->Form->control('image[]', ['type' => 'file', 'multiple' => 'true', 'label' => 'Add Some Photos']);
								?>
                        </div>
					</div>
					
					<!--div class="form-group row">
						<div class="col-xs-5">
							<label for="Email">Description</label>
							<?= $this->Form->control('description', ['placeholder'=>'Description','label'=>false,'type'=>'textarea','class'=>'form-control ckeditor']);?>
						</div>
						 <div class="col-xs-5">
                            <label for="normal" class="control-label">Short Description<span style="color:red;">*</span></label>
							<?php 	echo $this->Form->control("short_description", array("type" => "textarea", 'id' => 'content', "class" => "form-control col-md-7 col-xs-12 ckeditor", 'label' => false, 'required' => true));?>
                        </div> 
					</div-->
					
				</div><!-- /.box-body -->

				<div class="box-footer"> 
					<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
				</div>
				<?= $this->Form->end() ?>
			</div><!-- /.box -->
		</div>   <!-- /.row -->
	</div>   <!-- /.row -->
</section><!-- /.content --> 
<?php echo $this->Html->script('ckeditor/ckeditor');?> 
<link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css"
    rel="stylesheet" type="text/css" />
<script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"
    type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#lstFruits').multiselect({
            includeSelectAllOption: true
        });
    });
</script> 
<script type="text/javascript">
	function NumericValidation(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
		//alert(charCode);
		if (charCode > 31 && (charCode < 46 || charCode > 57) )
			return false;

		return true;
    }
	
	$(".removeChild").hide();
    // add more childs
    $(document).on("click", "#addmore", function () {
        var clone_copy = $("#child-body .appandable:first").clone();
        clear_form_elements(clone_copy);


        var original = $('select.input_size:eq(0)');
        var allSelects = $('select.input_size');
        //var clone = original.clone();

        $('option', clone_copy).filter(function (i) {
            return allSelects.find('option:selected[value="' + $(this).val() + '"]').length;
        }).remove();

        // change its name
        var total_count = $("#child-body .appandable").length;

        clone_copy.find(".id_cl").attr("name", "country_id[][" + total_count + "][]");

        clone_copy.find(".input_cl").each(function () {
            $(this).attr("name", $(this).attr("name").replace("][0][", "][" + total_count + "]["));
        });

        $("#child-body").append(clone_copy);
        adjustRemove();
        $("#child-body .appandable:last").find('.input_cl:first').focus();
        var input = document.createElement('INPUT');
    });
    $(document).on('focus', '#child-body .appandable .input_cl', function () {
        var top = $(this).offset().top;
        $(window).scrollTop(top - 100);

    });
    $(document).on("click", ".removeChild", function () {
        var total_count = $("#child-body .appandable").length;
        if (total_count > 1) {
            $(this).parents(".appandable").remove();
            adjustRemove();
        }

    });
    function adjustRemove() {
        var total_count = $("#child-body .appandable").length;
        if (total_count == 0) {
            $(".removeChild").hide();
        }
        if (total_count > 1) {
            $(".removeChild").hide();
            $("#child-body .removeChild:last").show();
        } else {
            $("#child-body .removeChild:last").hide();
        }
    }

    function clear_form_elements(jquery_obj) {
        jquery_obj.find(':input').each(function () {
            switch (this.type) {
                case 'password':
                case 'text':
                case 'number':
                case 'textarea':
                case 'file':
                    $(this).attr("value", "");
                    break;
                case 'select-one':
                    $(this).find("option").each(function () {
                        $(this).attr("selected", false);
                    });
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
            }
        });
    }
	
	/* Get  SubCategory LIst by COuntry id  */

	$(".category").change(function () {
		var cid = $(this).val();
		var csrfToken = $("[name='_csrfToken']").val();
		if(cid==''){
			location.reload();
		}
		
		$.ajax({
			type:'POST',
			data:{_csrfToken:csrfToken,cid:cid},
			url:'<?php echo SITE_URL.'/admin/products/sub_category';?>',
			success:function(data) { 
					var datas =jQuery.parseJSON(data);
					var selectoptoon = "<option value=''>Select Sub Category</option>";
						$('.subcategoury').html(selectoptoon);
						$.each(datas, function( key, value ) {
							var option = '<option value="'+value+'">'+key+'</option>';
							$('.subcategoury').append(option);
						}); 
			}
		}); 
	});
	
</script>