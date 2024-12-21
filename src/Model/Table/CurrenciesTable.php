<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Groups Model
 *
 * @property \Cake\ORM\Association\HasMany $Roles
 * @property \Cake\ORM\Association\HasMany $Users
 *
 * @method \App\Model\Entity\Group get($primaryKey, $options = [])
 * @method \App\Model\Entity\Group newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Group[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Group|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Group patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Group[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Group findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CurrenciesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

		$this->setTable('currencies'); 
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
            ->requirePresence('title', 'Title cannot be empty','create')
            ->notEmpty('title','Title cannot be empty');
			
		
		
		$validator 
            ->requirePresence('country_id', 'country cannot be empty','create')
            ->notEmpty('country_id','country cannot be empty');
		
		$validator 
            ->requirePresence('code', 'code cannot be empty','create')
            ->notEmpty('code','code cannot be empty')
			->add('code', 'unique', ['rule' => ['validateUnique'], 'provider' => 'table','message' => 'code already exists']);
		
		
        $validator
            ->requirePresence('exchange_charge','exchange charge cannot be empty')
            ->notEmpty('exchange_charge','exchange charge cannot be empty');
			
		$validator  
            ->requirePresence('status', 'create')
            ->notEmpty('status','Status cannot be empty');

        return $validator;
    }
	
}
