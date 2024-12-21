<div class="box-footer clearfix">
	<div class="col-sm-5">
		<div><?php echo $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></div>
	</div>
	<div class="col-sm-7">
		  <ul class="pagination pagination-sm no-margin pull-right">
			<?php echo $this->Paginator->first('<< ' . __('First')) ?>
			<?php echo $this->Paginator->prev('< ' . __('Previous')) ?>
			<?php echo $this->Paginator->numbers() ?>
			<?php echo $this->Paginator->next(__('Next') . ' >') ?>
			<?php echo $this->Paginator->last(__('Last') . ' >>') ?>
		  </ul>
	</div>
</div>