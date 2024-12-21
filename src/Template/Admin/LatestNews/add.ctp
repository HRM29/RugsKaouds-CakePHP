<?php use Cake\Routing\Router;?>
<section class="content-header">
  <h1>
	Notification 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Add Notification</li>
  </ol> 
</section>
<section class="content">
	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary">
                <div class="box-header with-border">
					<h3 class="box-title">Add Notification</h3>
                </div><!-- /.box-header -->
                <?= $this->Form->create($data, ['type' => 'file']) ?>
				
				<div class="box-body">
					<div class="form-group row">
						<div class="col-xs-4">
							<label for="Name">Title</label>
							<?= $this->Form->control('title', ['placeholder'=>'Title','label'=>false,'class'=>'form-control']);?>
						</div>
					
						<div class="col-xs-4">
							<label for="Status">Status</label>
							<?php $options = array(Active => "Active" , Inactive => "Inactive");?>
							<?= $this->Form->control('status', ['options'=>$options,'label'=>false,'class'=>'form-control','empty'=>'Select Status']);?>
						</div>					
                        <!-- Date and time range -->
						<div class="col-xs-4">
							<label>Date range:</label>
							<div class="input-group">
							  <div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							  </div>
							  <?= $this->Form->control('date_range', ['label'=>false,'id'=>'reservation','class'=>'form-control pull-right']);?>
							</div><!-- /.input group -->
						</div><!-- /.form group -->
				    </div>
					
					<div class="form-group">
						<label for="project Description">Description</label>
						<?= $this->Form->control('description', ['placeholder'=>'Description','type'=>'textarea','label'=>false,'class'=>'form-control ckeditor']);?>
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
<script>
		//Date range picker
        $('#reservation').daterangepicker();
       //Date range as a button
        $('#daterange-btn').daterangepicker(
                {
                  ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                  },
                  startDate: moment().subtract('days', 29),
                  endDate: moment()
                },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );
</script>