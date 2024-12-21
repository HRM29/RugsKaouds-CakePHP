<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\ArticlesTable|\Cake\ORM\Association\HasMany $Articles
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('products'); 
        $this->setPrimaryKey('id');
		
		/* $this->hasMany('ProductImages', [
            'foreignKey' => 'product_id'
        ]);
        $this->addBehavior('Timestamp'); */
		$this->addBehavior('Timestamp');
		$this->hasMany('ProductImages');
		$this->belongsTo('Categories');
		$this->belongsTo('Piles');
		$this->belongsTo('Foundations');
		$this->belongsTo('Dimensions');
		$this->belongsTo('Colors');
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
		
		/* $validator 
            ->maxLength('product_type', 255)
            ->requirePresence('product_type', 'Product Type cannot be empty','create')
            ->notEmpty('product_type','Product Type cannot be empty');
			
		
		$validator 
            ->maxLength('materials', 255)
            ->requirePresence('materials', 'Product Materials cannot be empty','create')
            ->notEmpty('materials','Product Materials cannot be empty');
			
		
		$validator 
            ->requirePresence('sku', 'sku cannot be empty','create')
            ->notEmpty('sku','sku cannot be empty')
			->add('sku', 'unique', ['rule' => ['validateUnique'], 'provider' => 'table','message' => 'sku already exists']); */
			
		$validator 
            ->requirePresence('category_id', 'Category cannot be empty','create')
            ->notEmpty('category_id','category cannot be empty');
		
		/* $validator 
            ->requirePresence('sub_category_id', 'Sub Category cannot be empty','create')
            ->notEmpty('sub_category_id','sub category cannot be empty');
		
		$validator 
            ->requirePresence('size_id', 'size cannot be empty','create')
            ->notEmpty('size_id','size cannot be empty');
		
		$validator 
            ->requirePresence('total_quantity', 'Total Quantity cannot be empty','create')
            ->notEmpty('total_quantity','total quantity cannot be empty');
		
        $validator
            ->requirePresence('price','Product Amount cannot be empty')
            ->notEmpty('price','Product Amount cannot be empty');
		
		$validator
            ->requirePresence('mrp','Product Mrp Price cannot be empty')
            ->notEmpty('price','Product Mrp Price cannot be empty'); */
		
		
		/* $validator
                ->requirePresence('image', 'create')
                ->notEmpty('image'); */
			
		$validator  
            ->requirePresence('status', 'create')
            ->notEmpty('status','Status cannot be empty');

        return $validator;
    }
 
}
