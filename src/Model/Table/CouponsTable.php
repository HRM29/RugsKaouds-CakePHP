<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;



class CouponsTable extends Table
{
 
	public function initialize(array $config)
	{
		$this->setTable('coupons');
		$this->addBehavior('Timestamp');
	} 
	
	/**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator){ 	
		
		$validator
            ->integer('id')
            ->allowEmpty('id', 'create');
 
		$validator 
            ->maxLength('title', 255)
            ->requirePresence('title')
            ->notEmpty('title');
			
        $validator
          ->requirePresence('code')
          ->notEmpty('code', 'No code found.')
          ->add('code', 'unique', [
              'rule' => function ($value, $context) {
            $existing = $this->find()
                ->where(['LOWER(code) LIKE' => strtolower($value)])
                ->first();
            return empty($existing);
              },
              'message' => 'Code already exists'
          ]);
				
				
            $validator 
                ->requirePresence('discount')
                ->notEmpty('discount')
                ->add('discount', 'validDiscount', [
                  'rule' => function ($value, $context) {
                      if (isset($context['data']['type']) && $context['data']['type'] === '2' && $value > 100) {
                        return false;
                      }
                      return true;
                  },
                  'message' => 'For percentage type, discount should not be more than 100.'
                ]);

            $validator 
                ->requirePresence('type')
                ->notEmpty('type')
                ->add('type', 'validType', [
                  'rule' => ['inList', ['1', '2']],
                  'message' => 'Type must be either Percentage or Fixed.'
                ]);
			
		$validator 
            ->requirePresence('status')
            ->notEmpty('status');
					
        return $validator;
    }
	
}
?>