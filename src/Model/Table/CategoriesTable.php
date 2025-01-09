<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;



class CategoriesTable extends Table
{
 
	public function initialize(array $config)
	{
		$this->setTable('categories');
		$this->setPrimaryKey('id');
		$this->addBehavior('Timestamp');
		$this->addBehavior('Tree');
		$this->hasMany('Projects');
		$this->hasMany('SubCategories', [
            'foreignKey' => 'parent_id'
        ]);
		$this->hasMany('Products', [
            'foreignKey' => 'category_id',
        ]);
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
            ->notEmpty('title')
			->add('title', 'unique', ['rule' => ['validateUnique'], 'provider' => 'table','message' => 'title already exists']);  
			
		$validator  
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }
	
}
?>