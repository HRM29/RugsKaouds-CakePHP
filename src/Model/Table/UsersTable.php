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
	public function initialize(array $config) {
		parent::initialize($config);

		$this->setTable('users');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');
		$this->addAssociations([
			'hasOne' => [
				'UserDetails' => [
					'className' => 'App\Model\Table\UserDetailsTable',
					'foreignKey'=> 'id'
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
	public function validationDefault(Validator $validator) {
		$validator
			->integer('id')
			->allowEmpty('id', 'create');

		$validator
			->email('email')
			->requirePresence('email', 'create')
			->notEmpty('email')
			->add('email',[
				'unique'=>[
                    'rule' => 'validateUnique',
                    'message' => 'email already exist',
                    'provider' => 'table'

                ]
			]);

		/* $validator
			->scalar('password')
			->maxLength('password', 255)
			->requirePresence('password', 'create')
			->notEmpty('password'); */
		/* $validator
			->scalar('confirm_password')
			->maxLength('confirm_password', 255)
			->requirePresence('confirm_password', 'create')
			->notEmpty('confirm_password');
		
		$validator
		->scalar('password')
		->maxLength('password', 255)
		->requirePresence('password', 'create')
		->notEmpty('password')
			->add('confirm_password', [
				'password' => [
					'rule' => function ($value, $context) {
						return $value === $context['password'];
					},
					'message' => __("Your password confirm must match with your password.")
				]
			]); */
			
		$validator->requirePresence('password')
            ->notEmpty('password', 'please enter  password.')
			->add('password',[
                    'matches'=> [
                        'rule' => function($value, $stuff) {
                                return $value === $stuff['data']['password'];
                            },
                        'message' => 'Password does not match.'
                    ]
                ]
            );
			
		$validator->requirePresence('confirm_password', 'please enter confirm password.')
            ->notEmpty('confirm_password', 'please enter confirm password.')
			->add('confirm_password',[
                    'matches'=> [
                        'rule' => function($value, $stuff) {
                                return $value === $stuff['data']['password'];
                            },
                        'message' => 'Password does not match.'
                    ]
                ]
            );	
			
		$validator 
			->maxLength('first_name', 64)
			->requirePresence('first_name', 'create')
			->notEmpty('first_name');
			
		$validator 
			->maxLength('last_name', 64)
			->requirePresence('last_name', 'create')
			->notEmpty('last_name');
			
		$validator 
			->minLength('phone', 10)
			->maxLength('phone', 20)
			->requirePresence('phone', 'create')
			->notEmpty('phone');
			
		$validator  
			->requirePresence('status', 'create')
			->notEmpty('status');

		return $validator;
	}
	
	public function validationAppReg(Validator $validator){
		$validator
			->integer('id')
			->allowEmpty('id', 'create');
				
		$validator
			->requirePresence('first_name', 'create')
			->notEmpty('first_name','Please enter first name.');
			
		$validator
			->requirePresence('last_name', 'create')
			->notEmpty('last_name','Please enter last name.');
			
		$validator
			->email('email')
			->requirePresence('email', 'create')
			->notEmpty('email','Please enter email address.')
			->add('email',[
				'unique'=>[
					'rule' => 'validateUnique',
					'message' => 'email already exist',
					'provider' => 'table'
                ]
			]);
			
		$validator->requirePresence('password')
            ->notEmpty('password', 'please enter  password.')
			->add('password',[
				'matches'=> [
					'rule' => function($value, $stuff) {
							return $value === $stuff['data']['password'];
						},
					'message' => 'password does not match.'
				],
				'mycapitalrule' => [
					'rule' => [$this,'registerPasswordValidation'],
					'message' => 'Your password must be 6-20 characters with 1 uppercase, 1 lowercase and 1 number.'
				]
			]);
			
		$validator->requirePresence('confirm_password', 'please enter confirm password.')
			->notEmpty('confirm_password', 'please enter confirm password.')
			->add('confirm_password',[
				'matches'=> [
					'rule' => function($value, $stuff) {
							return $value === $stuff['data']['password'];
						},
					'message' => 'password does not match.'
				],
				'mycapitalrule' => [
					'rule' => [$this,'registerPasswordValidation'],
					'message' => 'Your Confirm password must be 6-20 characters with 1 uppercase, 1 lowercase and 1 number.'
				]
			]);
			
		//$validator->notEmpty('status');
		
		return $validator;
	}
	/**
	 * signup validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationSignup(Validator $validator) {
		$validator
			->integer('id')
			->allowEmpty('id', 'create');
			
		$validator
			->requirePresence('first_name', 'create')
			->notEmpty('first_name','Please enter first name.');
			
		$validator
			->requirePresence('last_name', 'create')
			->notEmpty('last_name','Please enter last name.');
			
		$validator
			->email('email')
			->requirePresence('email', 'create')
			->notEmpty('email','Please enter email address.')
			->add('email',[
				'unique'=>[
					'rule' => 'validateUnique',
					'message' => 'email already exist',
					'provider' => 'table'
                ]
			]);
			
		$validator->requirePresence('password')
            ->notEmpty('password', 'please enter  password.')
			->add('password',[
				'matches'=> [
					'rule' => function($value, $stuff) {
							return $value === $stuff['data']['password'];
						},
					'message' => 'password does not match.'
				],
				'mycapitalrule' => [
					'rule' => [$this,'registerPasswordValidation'],
					'message' => 'Your password must be 6-20 characters with 1 uppercase, 1 lowercase and 1 number.'
				]
			]);
			
		$validator->requirePresence('confirm_password', 'please enter confirm password.')
			->notEmpty('confirm_password', 'please enter confirm password.')
			->add('confirm_password',[
				'matches'=> [
					'rule' => function($value, $stuff) {
							return $value === $stuff['data']['password'];
						},
					'message' => 'password does not match.'
				],
				'mycapitalrule' => [
					'rule' => [$this,'registerPasswordValidation'],
					'message' => 'Your Confirm password must be 6-20 characters with 1 uppercase, 1 lowercase and 1 number.'
				]
			]);
			
		$validator->notEmpty('status');
		
		return $validator;
	}
	public function validationUserProfile(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

		$validator 
            ->maxLength('first_name', 64)
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');
			
		$validator 
            ->maxLength('last_name', 64)
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name');
			
		$validator 
            ->minLength('phone', 10)
            ->maxLength('phone', 20)
            ->requirePresence('phone', 'create')
            ->notEmpty('phone');
		
		
		
        return $validator;
    }
	public function validationLogin(Validator $validator)
    {

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmpty('password');
		

        return $validator;
    }
	
	/**
	 * Forgot Password validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationForgotPassword(Validator $validator) {
		$validator
			->notEmpty('email','Please enter email.')
			->add('email',[
				'valid'	=>[
					'rule'		=>	'email',
					'message'	=>	'Please enter valid email.'
				],
			]);
			
		return $validator;
	}
	
	
	
	/**
	 * Returns a rules checker object that will be used for validating
	 * application integrity.
	 *
	 * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
	 * @return \Cake\ORM\RulesChecker
	 */
	public function buildRules(RulesChecker $rules) {
		$rules->add($rules->isUnique(['email']));

		return $rules;
	}
	
	public function registerPasswordValidation($check) {
		if(empty($check)){
			return false;
		}
		else if( strlen($check) < 6 || strlen($check) > 20 ){
			return false;
		}
		else if(!$this->myCapitalRule($check)){
			return false;
		}
		else if(!$this->mySmallRule($check)){
			return false;
		}
		else if(!$this->myNumberRule($check)){
			return false;
		}
		else{
			return true;
		}
	}
	
	public function myCapitalRule($check) {
		$output = 0;
		$output = preg_match_all('/[A-Z]/', $check, $matches, PREG_OFFSET_CAPTURE);
		if($output >= 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function mySmallRule($check) {
		$output = 0;
		$output = preg_match_all('/[a-z]/', $check, $matches, PREG_OFFSET_CAPTURE);
		if($output >= 1){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function myNumberRule($check) {
		$output = 0;
		$output = preg_match_all('/[0-9]/', $check, $matches, PREG_OFFSET_CAPTURE);
		if($output >= 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function validationEditProfile(Validator $validator) {
        $validator
                ->integer('id')
                ->allowEmpty('id', 'create');
				
		$validator->requirePresence('first_name')
            ->notEmpty('name', 'you must enter your first name.')
            ->add('name', 'validFormat',[
                'rule' => array('custom', '|^[a-zA-Z ]*$|'),
                'message' => 'name must contain letters and spaces only.'
			]);
			
		$validator->requirePresence('last_name')
            ->notEmpty('last_name', 'you must enter your last name.')
            ->add('last_name', 'validFormat',[
                'rule' => array('custom', '|^[a-zA-Z ]*$|'),
                'message' => 'name must contain letters and spaces only.'
			]);
			
	/* 	$validator->requirePresence('zip')
            ->notEmpty('zip', 'you must enter Zip.')
            ->add('zip', [
					'length' => [
						'rule' => 'numeric',
						'message' => 'Invalid Zip Code'
					],
					'minLength' => [
						'rule' => ['minLength', 5],
						'message' => 'Zip Code should be minimum length 5 digit.'
					]

				]); */

		$validator->requirePresence('phone')
				->notEmpty('phone[]','you must enter your contact number')
				->add('phone[]', [
					'length' => [
						'rule' => 'numeric',
						'message' => 'Invalid Contact Number'
					],
					'minLength' => [
						'rule' => ['minLength', 10],
						'message' => 'Contact number minimum length 10 digit.'
					]

				]);
	
		
	
        return $validator;
    }
	

}
