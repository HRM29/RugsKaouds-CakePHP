<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;



class SubCategoriesTable extends Table
{
 
	public function initialize(array $config)
	{
		$this->setTable('sub_categories');
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
            ->maxLength('title', 255)
            ->requirePresence('title')
            ->notEmpty('title');
			  
			
		$validator  
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }
	
}
?>