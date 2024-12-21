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
						<label for="email">Users</label>
						<?= $this->Form->control('user_id', ['empty'=>'Select Users','options' => $users,'label'=>false,'class'=>'form-control','value'=>isset($savesearch['user_id'])?$savesearch['user_id']:'','required' => false,'options'=>$users]);?> 
                    </div> 
					<div class="col-sm-3">
						<label for="status">Status</label>
						<?php  
						$status = array(Active => "Active" , Inactive => "Inactive");
						echo $this->Form->control('status_id', ['options' => $status,'label'=>false,'class'=>'form-control','value'=>isset($savesearch['status_id'])?$savesearch['status_id']:'','empty'=>'Select Status']);
						?>
                    </div>
					<div class="col-sm-3">
						<label for="button">&nbsp;</label><br>
						<button type="submit" class="btn btn-primary">Search</button>&nbsp;
						<a href="<?= Router::url('/', true).'/admin/reviews/clearSearch';?>" class="btn btn-primary clear">Clear</a>
					</div> 
                  </div><!-- /.box-body --> 
                <?php echo $this->Form->end()?>    
			</div>
		</div>
		<div class="col-xs-12"> 
		  <div class="box">
			<div class="box-header">
			  <h3 class="box-title"><?= $title ?> List</h3>
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
					<th><?= $this->Paginator->sort('Users') ?></th>
					<th><?= $this->Paginator->sort('way') ?></th>
					<th><?= $this->Paginator->sort('ip') ?></th>
					<th><?= $this->Paginator->sort('status') ?></th>
					<th><?= $this->Paginator->sort('created') ?></th>
				</tr>
				<?php foreach ($contents as $key => $data): ?>
				<tr>
					<td><?= $this->Number->format(++$key) ?></td>
					<td><?= $this->General->getUsers($data->user_id) ?></td>
					<td><?= $this->General->getWay($data->way) ?></td>
					<td><?= h($data->ip) ?></td>
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