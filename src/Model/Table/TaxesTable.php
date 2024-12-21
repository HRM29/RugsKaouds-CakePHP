<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class TaxesTable extends Table
{
	
    public function initialize(array $config)
    {   
	    parent::initialize($config);
        $this->setTable('taxes');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }
    
	public function validationDefault(Validator $validator)
    {
		$validator
            ->integer('id')
            ->allowEmpty('id', 'create');
			
		$validator
            ->requirePresence('title', 'Tax cannot be empty','create')
            ->notEmpty('name','Tax cannot be empty');		
			
			
        $validator 
            ->requirePresence('type', 'type')
            ->notEmpty('type','Please Select Type');	

        $validator 
            ->requirePresence('amount', 'amount')
            ->notEmpty('amount','amount can not be empty');
			
			

        
		$validator  
            ->requirePresence('status', 'create')
            ->notEmpty('status','status can not be empty');
		
		return $validator;
    }
    
	
    public function buildRules(RulesChecker $rules){
        $rules->add($rules->isUnique(['title']));
        return $rules;
    }
    
    
    
   

}
?>