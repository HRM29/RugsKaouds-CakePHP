<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;



class CouponsTable extends Table
{
 
	public function initialize(array $config)
	{
		$this->setTable('coupons');
		$this->addBehavior('Timestamp');
	} 
	
	/**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator){ 	
		
		$validator
            ->integer('id')
            ->allowEmpty('id', 'create');
 
		$validator 
            ->maxLength('title', 255)
            ->requirePresence('title')
            ->notEmpty('title');
			
        $validator
                ->requirePresence('code')
				->notEmpty('code', 'No code found.')
				->add('code', 'unique', ['rule' => ['validateUnique'], 'provider' => 'table','message' => 'code already exists']);
				
				
		$validator 
            ->requirePresence('discount')
            ->notEmpty('discount');
		
		$validator 
            ->requirePresence('type')
            ->notEmpty('type');
			
		$validator 
            ->requirePresence('status')
            ->notEmpty('status');
					
        return $validator;
    }
	
}
?>