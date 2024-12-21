<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ShippingChargesTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->getTable('shipping_charges');
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
            ->requirePresence('amount', 'amount cannot be empty','create')
            ->notEmpty('amount','amount cannot be empty');	

		$validator
            ->requirePresence('country_id', 'Country cannot be empty','create')
            ->notEmpty('country_id','country cannot be empty');	
				
						
        return $validator;
    }
	
	 public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['country_id'],['message' => 'country name is already in use.']));

        return $rules;
    }
}
