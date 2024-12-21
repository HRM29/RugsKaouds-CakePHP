<?php use Cake\Routing\Router;?>
<section class="content-header">
  <h1>
	Order
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/vehicles"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add Order</li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title">Add Order</h3>
                </div><!-- /.box-header -->
                <?= $this->Form->create($order, ['type' => 'file','id'=> 'inline_content']) ?>
				<div class="box-body">
				
					<div class="form-group row">
					    <div class="col-xs-5">
							<label for="Name">Invoice Number #</label>
							<?= $this->Form->control('invouce_id',['label'=>false,'type'=>'text','class'=>'form-control','readonly'=>true,'value'=>$check_invoice_number]); ?>
						</div>
						<div class="col-xs-5">
							<label for="Name">Invoice Date </label>
							<?= $this->Form->control('invouce_date',['label'=>false,'type'=>'text','class'=>'form-control','readonly'=>true,'value'=>date('d-m-Y')]); ?>
						</div>
					</div>
					<div class="form-group row">
					    <div class="col-xs-4">
								<label for="Name">Customer</label>
								<?php 
										echo $this->form->input('user',array('type'=>'hidden','id'=>"user_id",'value'=>isset($savesearch['user'])?$savesearch['user']:''));		
										echo $this->Form->input("user_id",array('required'=>false,'id'=>'txtpname','type'=>'text','class' =>'form-control','label'=>false,'value'=>isset($savesearch['user_id'])?$savesearch['user_id']:'',"placeholder"=>"Customer"));
								?>
							
						</div>
						<div class="col-xs-1">
								<label for="Name">&nbsp; </label>
								  <div class="clearfix"> </div>
								  <!--button class="btn btn-success" type="button">+</button-->
								   <a class="btn btn-social-icon btn-twitter" title="Add New Customer" data-toggle="modal" data-target="#modalForm"><i class="ion ion-person-add"></i></a>
						</div>
						
						
						<div class="col-xs-5">
						    <?php $category = array('1' => "Customer" , '2' => "Dealer"); ?>
							<label for="Password">Select Category</label>
							<?= $this->Form->control('category', ['options'=>$category,'label'=>false,'class'=>'form-control cat-change','empty'=>'Select Category','required'=>true]);?>
						</div>
					</div>
					
					<div class="form-group row">
						<div class="col-xs-5">
						    <?php //$vehicle = array('1' => "KM" , '2' => "Hour", '3' => "Day"); ?>
						    <?php $vehicle = array(); ?>
							<label for="Password">Select Vehicle Type</label>
							<?= $this->Form->control('vehicle_type', ['required'=>true,'options'=>$vehicle,'label'=>false,'class'=>'form-control typo','empty'=>'Select Vehicle Type']);?>
						
							
						
						
						</div>
						<div class="col-xs-5">
							<label for="Password">Select Vehicle List</label>
							<?php 
								echo $this->Form->input('vehicle_id', array(
												'type'=>'select', 'class' => "form-control schedule" ,'required'=>true,'id'=>'scheduleId' , 'label' => false,
												'empty'=>__('Select Vehicle List')));
							?>
						</div>
					</div>
					
					<div class="form-group row">
						<div class="col-xs-5">
							<label for="Name" class = "avail-val">Total Value</label>
							<?= $this->Form->control('total_value', ['placeholder'=>'Total Value','label'=>false,'type'=>'text','class'=>'form-control', "onkeypress"=>"return NumericValidation(event)",'required'=>true]);?>
						</div>
						<div class="col-xs-5">
							<label for="Name">Select Food Products</label> 
							<?= $this->Form->control('product_ids', ['options'=>$products, 'label'=>false,'class'=>'form-control','id'=>'multi-select-demo', 'multiple' => true,"empty"=>false]);?>
						</div>
					</div>
		    <?php  
				if(!empty($additionalCharge)){
			?>
					
					<label for="Name">Additional Charges</label>
					<div class="form-group row">
					<?php
						foreach($additionalCharge as $key =>$cardData){  
							$cusIdchk  = 'charg_'.$cardData->id;
					?>
							
								<div class="col-xs-5">
									<div class="custom-control custom-radio">
										<input id="<?= $cusIdchk ?>" name="addicharg" type="checkbox" class="custom-control-input" atr_values = "<?= $cardData->id ?>" >
										&nbsp;&nbsp;&nbsp;<label class="custom-control-label" for="<?= $cusIdchk ?>"><?= $cardData->title ?></label>
									</div>
								
									<?php 
										$clss = 'form-control input-lg '.$cusIdchk;
										
										
										
										
										$adc = 'additional_charge['.$cardData->id.']';
										echo $this->Form->input($adc,['placeholder'=>__('Additional Charge'),'label'=>false,'type'=>'text','class'=>$clss,'disabled'=>true,"onkeypress"=>"return NumericValidation(event)"]);
									?>
								</div>
			<?php			
						}
					echo '</div>';
				}
				//print_r($vehicle);
			?> 	
				</div><!-- /.box-body -->

				<div class="box-footer"> 
					<?= $this->Form->button(__('Submit'),['class'=>'btn btn-primary']) ?>
				</div>
				<?= $this->Form->end() ?>
			</div><!-- /.box -->
			
		</div>   <!-- /.row -->
	</div>   <!-- /.row -->
	
</section><!-- /.content --> 
<!-- Modal -->
<div class="modal fade  modalFormClss" id="modalForm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Add New Customer</h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body" style="width: 700px !important;">
                <p class="statusMsg"></p>
                <form role="form" id="modalForm">
                    <div class="form-group row">
					    <div class="col-xs-5">
							<label for="Name">Company Name</label>
							<?= $this->Form->control('company_name', ['placeholder'=>'Company Name','label'=>false,'required'=>true,'class'=>'form-control']);?>
						</div>
						<div class="col-xs-5">
							<label for="Name">Email</label>
							<?= $this->Form->control('email', ['placeholder'=>'Email','required'=>true,'label'=>false,'class'=>'form-control']);?>
						</div>
				   </div>
				   <div class="form-group row"> 
					    <div class="col-xs-5">
							<label for="Name">First Name</label>
							<?= $this->Form->control('first_name', ['placeholder'=>'First Name','required'=>true,'label'=>false,'class'=>'form-control']);?>
						</div>
						<div class="col-xs-5">
							<label for="Last Name">Last Name</label>
							<?= $this->Form->control('last_name', ['placeholder'=>'Last Name','required'=>true,'label'=>false,'class'=>'form-control']);?>
						</div>
				   </div>
				   
				   <div class="form-group row">
					    <div class="col-xs-5">
							<label for="Name">Phone</label> 
							<?= $this->Form->control('phone', ['placeholder'=>'Phone','label'=>false,'required'=>true,'class'=>'form-control','onkeypress'=>"return NumericValidation(event)",'maxlength'=>10]);?>
						</div>
						<div class="col-xs-5">
							<label for="Last Name">Gst Number</label>
							<?= $this->Form->control('gstn_number', ['placeholder'=>'Gst Number','label'=>false,'class'=>'form-control']);?>
						</div>
				   </div>
				   
				    <div class="form-group row">
					    <div class="col-xs-8">
							<label for="Last Name">Address</label> 
							<?= $this->Form->control('address', ['placeholder'=>'Address','required'=>true,'type'=>'textarea','label'=>false,'class'=>'form-control']);?>
						</div>
				    </div>
					<div class="modal-footer" style="border-top: 0px !important;padding-right: 107px !important;" > 
					     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<?= $this->Form->button(__('Submit'),['type'=>'button','class'=>'btn btn-primary submitBtn',"onclick"=>"return submitContactForm()"]) ?>
					</div>
                </form>
            </div>
            
            <!-- Modal Footer -->
            <!--div class="modal-footer">
               
                <button type="button" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button>
            </div-->
        </div>
    </div>
</div>

<?php echo $this->Html->script('ckeditor/ckeditor');?>  

   
<!-- jQuery library -->

<?php echo $this->Html->script('../plugins/jQuery/js/jquery.validate.js');?> <!-- auto complete-->
<script type="text/javascript">
	$(document).ready(function(){
		  var url 	= '<?php echo Router::url('/', true).'/admin/orders/customerList';?>';
		  $("#txtpname").autocomplete({
			    source: url,
				minLength:1,
				select: function(event,ui){
					var code = ui.item.id;
					$("#user_id").val(code);
				},
		  });
	});

    $("#inline_content input[name='addicharg']").click(function(){
		var ids = $(this).attr('id');
		var atr_values = $(this).attr('atr_values');
		$('.'+ids).prop('disabled',!$(this).is(':checked'));
		$('.'+ids).val('',!$(this).is(':checked'));
		$('.'+ids).attr('required',true);
	});

    
	$(document).ready(function() {
        $('#multi-select-demo').multiselect();
    });
	
	
    function NumericValidation(e) {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if (unicode != 8) {
            if ((unicode < 48 || unicode > 57) && unicode != 46) {
                return false;
            }
        }
    }
	
	$('.typo').change(function(){
		var t_id = $(this).val();
		var cat_id = $('#category :selected').val();
		var contant = 'Total Value';
		if(t_id !=''){
			if(t_id == 1){
				contant = 'Total KM';
			}
			if(t_id == 2){
				contant = 'Total Hour';
			}
			if(t_id == 3){
				contant = 'Total Days';
			}
			
		}
		
		$("#total-value").attr("placeholder",contant);
		
		$(".avail-val").text(contant);
		
		if(t_id =='' &&cat_id ==''){
			return false;
		}
		
		ajaxrunvehicle(t_id,cat_id);	 
	});
	
	function ajaxrunvehicle(t_id,cat_id){
		if(t_id != '' && cat_id !=''){
			var url = '<?php echo Router::url('/', true).'admin/orders/vehicleList';?>';
			var csrfToken = $("[name='_csrfToken']").val();
			$.ajax({
				type:'POST',
				data:{_csrfToken:csrfToken,t_id:t_id,cat_id:cat_id},
				url:url,
				success:function(data) {
					var datas =jQuery.parseJSON(data);
					console.log(datas);
						var selectoptoon = "<option value=''>Select Vehicle</option>";
							$('.schedule').html(selectoptoon);
							$.each(datas, function( key, value ) {
							var option = '<option value="'+value.id+'">'+value.name+'</option>';
							$('.schedule').append(option);
							}); 
				}
				
			});	
		}
		else{
				var selectoptoon = "<option value=''>Select Vehicle</option>";
				$('.schedule').html(selectoptoon);
		}
		

	}
	
	$('.cat-change').change(function(){
		var cat_val = $(this).val();
		//alert(cat_val);
		if(cat_val >0){
			var datas = { 1: 'KM', 2: 'Hour', 3: 'Days'};
			var selectoptoon = "<option value=''>Select Vehicle Type</option>"; 
			$('.typo').html(selectoptoon);
			$.each(datas, function( key, value ) {
				var option = '<option value="'+key+'">'+value+'</option>';
				$('.typo').append(option);
			});
		}
		else{
			var selectoptoon = "<option value=''>Select Vehicle Type</option>"; 
			$('.typo').html(selectoptoon); 
		}
		
	});


    function submitContactForm(){
		var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		var email = $('#email').val();
		var first_name = $('#first-name').val();
		var last_name = $('#last-name').val();
		var phone = $('#phone').val();
		var company_name = $('#company-name').val();
		var gstn_number = $('#gstn-number').val();
		var address = $('#address').val();
		
		if(email.trim() == '' ){
			$('.statusMsg').html('<span style="color:red;">Please enter your email.</p>');
			$('#email').focus();
			setTimeout(function() {
				$('.statusMsg').html(false);
			}, 3000);
			return false;
		}else if(email.trim() != '' && !reg.test(email)){
			$('.statusMsg').html('<span style="color:red;">Please enter valid email.</p>');
			$('#email').focus();
			setTimeout(function() {
				$('.statusMsg').html(false);
			}, 3000);
			return false;
		}else if(first_name.trim() == '' ){
			$('.statusMsg').html('<span style="color:red;">Please enter your first name.</p>');
			$('#first-name').focus();
			setTimeout(function() {
				$('.statusMsg').html(false);
			}, 3000);
			return false;
		}else if(last_name.trim() == '' ){
			$('.statusMsg').html('<span style="color:red;">Please enter your last name.</p>');
			$('#last-name').focus();
			setTimeout(function() {
				$('.statusMsg').html(false);
			}, 3000);
			return false;
		}
		else if(phone.trim() == '' ){
			$('.statusMsg').html('<span style="color:red;">Please enter your phone number.</p>');
			$('#phone').focus();
			setTimeout(function() {
				$('.statusMsg').html(false);
			}, 3000);
			return false;
		}
		else if(address.trim() == '' ){
			$('.statusMsg').html('<span style="color:red;">Please enter your address.</p>');
			$('#address').focus();
			setTimeout(function() {
				$('.statusMsg').html(false);
			}, 3000);
			return false;
		}
		else{
			var url = '<?php echo Router::url('/', true).'admin/orders/customerAdd';?>';
			var csrfToken = $("[name='_csrfToken']").val();
			$.ajax({
				type:'POST',
				data:{_csrfToken:csrfToken,company_name:company_name,email:email,first_name:first_name,last_name:last_name,phone:phone,gstn_number:gstn_number,address:address},
				url:url,
				success:function(data) {
					var datas =jQuery.parseJSON(data);
					if(datas == 1){
						$('.statusMsg').html('<span style="color:green;">Customer Add Successfully.</p>');
						setTimeout(function() {
							$('.statusMsg').html(false);
							$('.modalFormClss').modal('toggle');
						}, 2000);
					}
					else if(datas == 2){
						$('.statusMsg').html('<span style="color:red;">Email allready exist, please try again.</p>');
						setTimeout(function() {
							$('.statusMsg').html(false);
						}, 3000);
					}
					else if(datas == 3){
						$('.statusMsg').html('<span style="color:red;">Phone number allready exist, please try again.</span>');
						setTimeout(function() {
							$('.statusMsg').html(false);
						}, 3000);
					}
					else{
						$('.statusMsg').html('<span style="color:red;">Some problem occurred, please try again.</span>');
						setTimeout(function() {
							$('.statusMsg').html(false);
						}, 2000);
					}
					
					
	
				}
			});	 
			
			
		}	
			
	}
	
</script>
	
	
	
	
	