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
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
		 
		$this->addAssociations([
			'hasMany' => [
				'UserDetails' => [
					'className' => 'App\Model\Table\UserDetailsTable',
					'foreignKey'=> 'user_id',
					'dependent' => true,
					'cascadeCallbacks' => true,
					'saveStrategy' => 'replace'
				]
			]
		]);
 
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationRegister(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');
			 
        $validator
            ->email('email','Email should be unique')
            ->requirePresence('email', 'Email cannot be empty','create')
            ->notEmpty('email','Email cannot be empty')
			->add('email', 'unique', ['rule' => ['validateUnique'], 'provider' => 'table','message' => 'email already exists']);
        
		$validator 
            ->maxLength('first_name', 64)
            ->requirePresence('first_name','First Name cannot be empty', 'create')
            ->notEmpty('first_name','First Name cannot be empty');
			
		$validator 
            ->maxLength('last_name', 64)
            ->requirePresence('last_name','Last Name cannot be empty', 'create')
            ->notEmpty('last_name','Last Name cannot be empty');
			
		$validator
            ->minLength('contact_no', 10)
            ->maxLength('contact_no', 20)
            ->requirePresence('contact_no','Phone cannot be empty', 'create')
            ->notEmpty('contact_no','Phone cannot be empty')
			->add('contact_no', 'unique', ['rule' => ['validateUnique'], 'provider' => 'table','message' => 'phone already exists']);			
		
			
		$validator->requirePresence('password')
            ->notEmpty('password', 'please enter  password.')
			->add('password',[
                    'matches'=> [
                        'rule' => function($value, $stuff) {
                                return $value === $stuff['data']['password'];
                            },
                        'message' => 'Password does not match.'
                    ],
                    'mycapitalrule' => [
                        'rule' => [$this,'registerPasswordValidation'],
                        'message' => 'Your password must be 6-20 characters with 1 uppercase, 1 lowercase and 1 number.'
                    ]
                ]
            );
			
		$validator->requirePresence('confirmpassword', 'please enter confirm password.')
            ->notEmpty('confirmpassword', 'please enter confirm password.')
			->add('confirmpassword',[
                    'matches'=> [
                        'rule' => function($value, $stuff) {
                                return $value === $stuff['data']['password'];
                            },
                        'message' => 'Password does not match.'
                    ],
                    'mycapitalrule' => [
                        'rule' => [$this,'registerPasswordValidation'],
                        'message' => 'Your Confirm password must be 6-20 characters with 1 uppercase, 1 lowercase and 1 number.'
                    ]
                ]
            );
	

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }
	
	/**
     * Driver validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDriverProfile(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');
			 

        $validator
            ->email('email','Email should be unique')
            ->requirePresence('email', 'Email cannot be empty','create')
            ->notEmpty('email','Email cannot be empty');

			
		$validator 
            ->maxLength('first_name', 64)
            ->requirePresence('first_name','First Name cannot be empty', 'create')
            ->notEmpty('first_name','First Name cannot be empty');
			
		$validator 
            ->maxLength('last_name', 64)
            ->requirePresence('last_name','Last Name cannot be empty', 'create')
            ->notEmpty('last_name','Last Name cannot be empty');
			
			
		$validator
            ->minLength('phone', 10)
            ->maxLength('phone', 20)
            ->requirePresence('phone','Phone cannot be empty', 'create')
            ->notEmpty('phone','Phone cannot be empty')
			->add('phone', 'unique', ['rule' => ['validateUnique'], 'provider' => 'table','message' => 'phone already exists']);			
		
		$validator  
            ->requirePresence('status','Status cannot be empty', 'create')
            ->notEmpty('status','Status cannot be empty');

        return $validator;
    }
	
	public function registerPasswordValidation($check){


        if(empty($check)){
            return false;
        }
        else if( strlen($check) < 6 || strlen($check) > 20 ){
            return false;
        }
        else if(!$this->mycapitalrule($check)){
            return false;
        }
        else if(!$this->mysmallrule($check)){
            return false;
        }
        else if(!$this->mynumberrule($check)){
            return false;
        }
        else{
            return true;
        }
    }
	
	public function mycapitalrule($check) {
        $output = 0;
        $output = preg_match_all('/[A-Z]/', $check, $matches, PREG_OFFSET_CAPTURE);
        if($output >= 1){
            return true;
        }
        else{
            return false;
        }
    }
    public function mysmallrule($check) {
        $output = 0;
        $output = preg_match_all('/[a-z]/', $check, $matches, PREG_OFFSET_CAPTURE);
        if($output >= 1){
            return true;
        }
        else{
            return false;
        }
    }
	public function mynumberrule($check) {
        $output = 0;
        $output = preg_match_all('/[0-9]/', $check, $matches, PREG_OFFSET_CAPTURE);
        if($output >= 1){
            return true;
        }
        else{
            return false;
        }
    }
    
	public function mydobrule($check) {
		$then = strtotime($check);
		$min = strtotime('+18 years', $then);
		if(time() < $min){
			return false;
		}
		else{
			return true;
		}
    }
}
