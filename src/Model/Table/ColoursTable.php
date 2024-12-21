<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;




class ColoursTable extends Table
{
	
    public function initialize(array $config)
    {
		$this->setTable('colours');
        $this->addBehavior('Timestamp'); 
		
    }  
    
	public function validationDefault(Validator $validator)
    {
		$validator
            ->integer('id')
            ->allowEmpty('id', 'create');
			
		
		$validator
                ->requirePresence('name')
				->notEmpty('name', 'No name found.')
				->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table','message' => 'name already exists']);


		$validator  
            ->requirePresence('status', 'create')
            ->notEmpty('status','status can not be empty');
			
		return $validator;
    }
    
	
  
    
    
    
   

}
?>