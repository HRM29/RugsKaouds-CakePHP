<?php use Cake\Routing\Router;?> 
<section class="content-header">
<?php 

//echo $contactview->enquiry; 
?>

</section>
<section class="content">
	<div class="row">
		<div class="col-xs-9"> 
			<div class="box">
				<div class="box-header with-border">
					
					<div class="box-tools pull-right">
						
						<?php 
							echo $this->Html->link('<i class="fa fa-reply"></i> Back',
								array('controller' => 'ContactUs','action'=>'index'),
								array('escape' => false,'class'=>"btn bg-navy btn-sm","title"=>__("Back",true))
							);
						?>	
					</div>
				</div><!-- /.box-header -->
			
				<div class="box-body table-responsive"> 
					<div class="col-md-9">
					  <div class="box box-warning">
						<div class="box-header with-border">
						  <h3 class="box-title">Query</h3>
						  <div class="box-tools pull-right">
							<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						  </div><!-- /.box-tools -->
						</div><!-- /.box-header -->
						<div class="box-body" style="display: block;">
						  <?= h(htmlspecialchars($contactview->message)); ?>
						</div><!-- /.box-body -->
					  </div><!-- /.box -->
					</div>
				
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
	</div>
</section><!-- /.content -->  