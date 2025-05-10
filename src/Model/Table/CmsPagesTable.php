<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
class CmsPagesTable extends Table
{
	
    public function initialize(array $config)
    {
		$this->setTable('cms_pages');
		
        $this->addBehavior('Timestamp'); 
    }
    
      public function validationDefault(Validator $validator)
      {
            $validator
                  ->integer('id')
                  ->allowEmpty('id', 'create');
                  
            $validator 
                  ->maxLength('title', 255)
                  ->requirePresence('title', 'create')
                  ->notEmpty('title')
                  ->add('title', 'unique', [
                        'rule' => 'validateUnique',
                        'provider' => 'table',
                        'message' => 'The title must be unique'
                  ]);
                  
            $validator 
                  ->maxLength('meta_title', 255)
                  ->requirePresence('meta_title', 'create')
                  ->notEmpty('meta_title');	
            
            $validator 
                  ->maxLength('meta_key', 255)
                  ->requirePresence('meta_key', 'create')
                  ->notEmpty('meta_key');
                  
            $validator 
                  ->maxLength('meta_descritption', 1000)
                  ->requirePresence('meta_descritption', 'create')
                  ->notEmpty('meta_descritption');
 
            $validator  
                  ->requirePresence('status', 'create')
                  ->notEmpty('status');
            
            $validator->requirePresence('content')
                  ->notEmpty('content', 'Please enter content');
            
            $validator 
                  ->maxLength('slug', 255)
                  ->requirePresence('slug', 'create')
                  ->notEmpty('slug')
                  ->add('slug', 'unique', [
                        'rule' => 'validateUnique',
                        'provider' => 'table',
                        'message' => 'The slug must be unique'
                  ]);
            
            return $validator;
      }
    
	
  
    
    
    
   

}
?>