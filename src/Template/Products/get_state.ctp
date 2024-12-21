 <?php 
	if($targetDiv == 'billing_state'){
		if(isset($states) && !empty($states)) { 
			echo $this->Form->select('billing_state',$states, ['empty'=>'Select State','label'=>false,'class'=>'form-control border-form-control' ]); 
		} else { 
			echo $this->Form->control('billing_state', ['type'=>'text','placeholder'=>'Billing State','label'=>false,'class'=>'form-control border-form-control' ]);
		}
	}
	else
	{
		if(isset($states) && !empty($states)) { 
			echo $this->Form->select('delivery_state',$states, ['empty'=>'Select State','label'=>false,'class'=>'form-control border-form-control' ]); 
		} else { 
			echo $this->Form->control('delivery_state', ['type'=>'text','placeholder'=>'Delivery State','label'=>false,'class'=>'form-control border-form-control' ]);
		}
	} 
?>