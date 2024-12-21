<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class StatesTable extends Table
{
	
    public function initialize(array $config){
		$this->setTable('states');
        $this->addBehavior('Timestamp');
		$this->belongsTo('Countries',['foreignKey' => 'country_id']);
    }
	
	public function validationDefault(Validator $validator){ 	
		
		$validator
            ->integer('id')
            ->allowEmpty('id', 'create');
			
				
        
		$validator
                ->requirePresence('region_name')
				->notEmpty('region_name', 'No region name found.')
				->add('region_name', 'unique', ['rule' => ['validateUnique'], 'provider' => 'table','message' => 'region name name already exists']);	
				
        return $validator;
    }
	
}
?>