<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;




class MaterialsTable extends Table
{
	
    public function initialize(array $config)
    {
		$this->setTable('materials');
        $this->addBehavior('Timestamp'); 
		
    }  
    
	public function validationDefault(Validator $validator)
    {
		$validator
            ->integer('id')
            ->allowEmpty('id', 'create');
			
		
		$validator
                ->requirePresence('title')
				->notEmpty('title', 'No title found.')
				->add('title', 'unique', ['rule' => 'validateUnique', 'provider' => 'table','message' => 'Title already exists']);


		$validator  
            ->requirePresence('status', 'create')
            ->notEmpty('status','status can not be empty');
			
		return $validator;
    } 

}
?>