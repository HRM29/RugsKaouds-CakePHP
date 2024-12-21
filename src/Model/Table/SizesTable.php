<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;



class SizesTable extends Table
{
 
	public function initialize(array $config)
	{
		$this->setTable('sizes');
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
            ->maxLength('size', 255)
            ->requirePresence('size')
            ->notEmpty('size')
			->add('size', 'unique', ['rule' => ['validateUnique'], 'provider' => 'table','message' => 'size already exists']);
		
		$validator 
            ->maxLength('code', 255)
            ->requirePresence('code')
            ->notEmpty('code')
			->add('code', 'unique', ['rule' => ['validateUnique'], 'provider' => 'table','message' => 'code already exists']);
			
		$validator 
            ->requirePresence('status')
            ->notEmpty('status');
					
        return $validator;
    }
	
}
?>