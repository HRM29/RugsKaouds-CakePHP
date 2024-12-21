
<?php use Cake\Routing\Router;?>

<?php //echo $this->Html->css(array('../plugins/timepicker/css/bootstrap-timepicker.min.css')) ?>
<script>
    /* $(".timepicker").timepicker({
          showInputs: false
    });  */
 </script>

<section class="content-header">
  <h1>
	Manage Captions
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Edit Captions</li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title">Edit Captions</h3>
                </div><!-- /.box-header -->
                <?= $this->Form->create($data, ['type' => 'file']) ?>
				<div class="box-body">
				    <div class="form-group row">
					    <div class="col-xs-5">
							<label for="Name">Title</label>
							<?= $this->Form->control('title', ['placeholder'=>'Title','type'=>'text','label'=>false,'class'=>'form-control']);?>
						</div>
						<div class="col-xs-5">
							  <label for="normal" class="control-label">Image</span></label>
							  <div class="controls">
								<?php
									if (!empty($data->image)) {
										$original = WWW_ROOT . 'uploads/Caption/thumb' . DS . $data->image;
										if (file_exists($original)) { ?>
											<?php 
												echo $this->Html->image('../uploads/Caption/thumb/' . $data->image, array('width' => '100px', 'class' => 'img-responsive imgbdr remove_image'));
												echo $this->Html->link('Remove', 'javascript:;', array('data' => $data->id, 'class' => 'remove_image', 'atrValue'=>'image'));
											?>	 
									<?php 
										}else{
											echo $this->Form->control('image',['type'=>'file','label'=>false]);
										}
									}else{
											echo $this->Form->control('image',['type'=>'file','label'=>false]);
										} 
									?>
							  </div>
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
  
<script>
	function clear_form_elements(jquery_obj) {
	  jquery_obj.find(':input').each(function() {
		$(this).timepicker({
			  showInputs: false
		});
		/* $(this).timepicker({
			  showInputs: false
		});  */
		switch(this.type){
			case 'password':
			case 'text':
			case 'number':
			case 'textarea':
			case 'file':      
				$(this).attr("value","");
				break;
			case 'select-one':
				$(this).find("option").each(function (){
					$(this).attr("selected",false);
				});
				break;
			case 'checkbox':
			case 'radio':
				this.checked = false;
		}
	  });
	}
	
	$('.remove_image').on('click', function(){
		var id = $(this).attr('data');
		var FieldName = $(this).attr('atrValue');
		var csrfToken = $("[name='_csrfToken']").val();
		if(confirm('Are you sure Remove Promo Image?'))
		{
			$.ajax({
				dataType: "html",
				type: "POST",
				evalScripts: true,
				url: '<?php echo Router::url(['controller'=>'Captions','action'=>'deleteImg']);?>',
				data: ({_csrfToken:csrfToken,id:id,FieldName:FieldName}),
				success: function (data){
					location.reload();
				}
			});
		}
	});

</script>