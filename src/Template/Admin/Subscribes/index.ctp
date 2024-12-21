<?php use Cake\Core\Configure;?>
<?php use Cake\Routing\Router;?> 

<section class="content-header">
  <h1>
	<?= $title ?> 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo Router::url('/', true); ?>admin/users"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active"><?= __($title.' List') ?></li>
  </ol>
  <?= $this->Flash->render('positive') ?>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Search <?= $title;?></h3>
                </div>
				<?php echo $this->Form->create($contents,array(
						'class' =>'form-horizontal form-label-left',
						'id'=>'demo-form2',
						'inputDefaults' => array(
						'label' => false,
						'div' => false,
						'novalidate' => true
					)));
				?> 
                  <div class="box-body">
                    <div class="col-sm-3">
						<label for="name">Email</label> 
						<?= $this->Form->control('email', ['placeholder'=>'Email','label'=>false,'class'=>'form-control','value'=>isset($savesearch['email'])?$savesearch['email']:'','required' => false]);?>
                    </div>
					<div class="col-sm-3">
						<label for="button">&nbsp;</label><br>
						<button type="submit" class="btn btn-primary">Search</button>&nbsp;
						<a href="<?= Router::url('/', true).'/admin/SubCategories/clearSearch';?>" class="btn btn-primary clear">Clear</a>
					</div> 
                  </div><!-- /.box-body --> 
                <?php echo $this->Form->end()?>    
			</div>
		</div>
		<div class="col-xs-12"> 
		  <div class="box">
			<div class="box-header">
			  <h3 class="box-title">SubCategory List</h3>
			  <div class="box-tools">
					
                    <?php echo $this->Html->link('<i class="fa fa-reply"></i> Back',
					array('controller' => 'users','action'=>'index'),
					array('escape' => false,'class'=>"btn btn-info btn-sm","title"=>__("Back",true))
					);
					?>			  
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
			  <?php echo $this->Form->create('',['url'=>['action'=>'deleteAll'],'id'=>'listForm']); ?>
			  <table class="table table-hover"> 
				<tr>
					<th><?= $this->Paginator->sort('id') ?></th>
					<th><?= $this->Paginator->sort('Email') ?></th>
					<th><?= $this->Paginator->sort('status') ?></th>
					<th><?= $this->Paginator->sort('created') ?></th>
				</tr>
				<?php foreach ($contents as $key => $data): ?>
				<tr>
					<td><?= $this->Number->format(++$key) ?></td>
					<td><?= h($data->email_address) ?></td>
					<td><?= $this->General->getAdminStatus($data->status) ?></td>
					<td><?= h($data->created) ?></td> 
				</tr>
				<?php endforeach; ?> 
			  </table>
			  <?php echo $this->Form->end()?>    
			</div><!-- /.box-body -->
			 
			<div class="box-footer clearfix">
				<div class="col-sm-5">
					<div><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></div>
				</div>
				<div class="col-sm-7">
					  <ul class="pagination pagination-sm no-margin pull-right">
						<?= $this->Paginator->first('<< ' . __('First')) ?>
						<?= $this->Paginator->prev('< ' . __('Previous')) ?>
						<?= $this->Paginator->numbers() ?>
						<?= $this->Paginator->next(__('Next') . ' >') ?>
						<?= $this->Paginator->last(__('Last') . ' >>') ?>
					  </ul>
				</div>
			</div>
		  </div><!-- /.box -->
		</div>
	</div>
</section><!-- /.content --> 