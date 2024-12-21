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
class OrdersTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->getTable('orders'); 
        $this->getPrimaryKey('id');	
		$this->hasMany('OrderDetails',['foreignKey' => 'order_id']);
		$this->belongsTo('Users',['foreignKey'=>'user_id']);
		$this->addAssociations([
			'hasMany' => [
				'OrderDetails' => [
					'className' => 'App\Model\Table\OrderDetailsTable',
					'foreignKey'=> 'order_id',
					'dependent' => true,
					'cascadeCallbacks' => true,
					'saveStrategy' => 'replace'
				]
			]
		]);
        $this->addBehavior('Timestamp');
 
    }
	
	/**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
	public function validationReview(Validator $validator)
	{
		/* $validator = $this->validationDefault($validator);

		return $validator; */
	}
	 var $validate =array(
        'creditcard_number' => array (
                        'notEmpty' => array(
                                'rule' => 'notEmpty',
                                'last' => true,
                                'message' => 'Invalid Credit Card number.'
                        ),
                        'isCC' => array (
                                'rule' => array('cc', 'fast', true, null),
                                'last' => true,
                                'message' => 'Invalid Credit Card number.'
                        )
                ),
                'creditcard_code' => array (
						'notEmpty' => array(
                                'rule' => 'notEmpty',
                                'last' => true,
                                'message' => 'Invalid CVV number.'
                        ),
                        'numeric' => array (
                                'rule' => 'numeric',
                                'allowEmpty' => true,
                                'last' => true,
                                'message' => 'CVV must be numeric.'
                        ),
                        'between' => array(
                                'rule' => array('between', 3, 4),
                                'allowEmpty' => true,
                                'last' => true,
                                'message' => 'CVV either 3 or 4 digits.'
                        )
                ),
                'creditcard_year' => array (
                        'notEmpty' => array(
                                'rule' => 'notEmpty',
                                'last' => true,
                                'message' => 'Expiration date cannot be left blank.'
                        ),
                        'date' => array (
                                'rule' => array('date', 'y'),
                                'last' => true,
                                'message' => 'Expiration date must be a valid date.'
                        ),
                        'inFuture' => array(
                                'rule' => array('validateCCExpiration', 'creditcard_year'),
                                'last' => true,
                                'message' => 'Expiration date must not be in the past.'
                        )
                )
		
        
    ) ;
	public function validateCCExpiration ($data, $fieldName) {
                if (
                        is_array($data[$fieldName]) && 
                        !empty($data[$fieldName]['year']) && 
                        !empty($data[$fieldName]['month'])
                ) {
                        $entered = strtotime($data[$fieldName]['year'] . '-' . $data[$fieldName]['month'] . '-01');
                } elseif (is_string($data[$fieldName])) {
                        $entered = strtotime($data[$fieldName]);
                } else {
                        return false;
                }
                
                $validStarting = strtotime(date('Y', time()) . '-' . date('m', time()) . '-01');
                
                if ($entered < $validStarting) {
                        return false;
                }
                
                return true;
                
        }
}
