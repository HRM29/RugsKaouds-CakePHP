<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;



class CountriesTable extends Table
{
 
	public function initialize(array $config)
	{
		$this->setTable('countries');
		$this->setPrimaryKey('id');
		$this->addBehavior('Timestamp');
	} 
	
	/**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');
 
		$validator
                ->requirePresence('country_name')
				->notEmpty('country_name', 'No country_name found.')
				->add('country_name', 'unique', ['rule' => ['validateUnique'], 'provider' => 'table','message' => 'country name already exists']);	

        $validator
                ->requirePresence('code')
				->notEmpty('code', 'No code found.')
				->add('code', 'unique', ['rule' => ['validateUnique'], 'provider' => 'table','message' => 'code already exists']);	
		
		$validator  
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }
	
}
?>