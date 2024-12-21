<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class OrderStatusTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('order_status');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {

		$validator
            ->requirePresence('name', 'Name cannot be empty','create')
            ->notEmpty('name','Name cannot be empty');		
							
        return $validator;
    }
	
	 public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['name'],['message' => 'Name is already in use.']));

        return $rules;
    }
}
