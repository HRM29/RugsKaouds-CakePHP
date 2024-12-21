<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class VehiclesTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('vehicles');
        $this->primaryKey('id');
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
				
				
		$validator
                ->requirePresence('charges', 'create')
                ->notEmpty('charges');
						
        return $validator;
    }
	
	 public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['name'],['message' => 'Vehicle name is already in use.']));

        return $rules;
    }
}
