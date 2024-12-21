<?php use Cake\Routing\Router;?>
<section class="content-header">
  <h1>
	Order Status
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add Order Status</li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title">Add Order Status</h3>
                </div><!-- /.box-header -->
                <?= $this->Form->create($data, ['type' => 'file']) ?>
				<div class="box-body">
					<div class="form-group row">
					    <div class="col-xs-5">
							<label for="Name">Order Status</label>
							<?= $this->Form->control('name', ['placeholder'=>'Order Status Name','label'=>false,'class'=>'form-control']);?>
						</div>
						<div class="col-xs-5">
							<label for="Password">Status</label>
							<?php $options = array(Active => "Active" , Inactive => "Inactive");?>
							<?= $this->Form->control('status', ['options'=>$options,'label'=>false,'class'=>'form-control','empty'=>'Select Status']);?>
					    </div>  
					</div>
					
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
<script type="text/javascript">

    $(".timepicker").timepicker({
          showInputs: false,
		  
    }); 
	
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
			
			//$(this).timepicker();
			$(this).timepicker({
				showInputs: false
			}); 
	
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
	
 //iCheck for checkbox and radio inputs
	$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
	  checkboxClass: 'icheckbox_minimal-blue',
	  radioClass: 'iradio_minimal-blue'
	});	
	
	
	$('.chk_checkbox').click(function() {
        if($(this).is(":checked")) {
            var returnVal = confirm("Are you sure use cron for fatching result ?. enter company link");
            //$(this).attr("checked", returnVal);
        }
		else{
			var returnVal = confirm("Are you sure remove cron for fatching result?");
		}
        $('#textbox1').val($(this).is(':checked'));        
    });
</script>
	
	
	
	
	