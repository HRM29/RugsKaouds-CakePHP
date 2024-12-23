<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;




class BannersTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('banners');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');


        $validator
            ->requirePresence('title')
            ->notEmpty('title', 'No name found.')
            ->add('title', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Title already exists']);


        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status', 'status can not be empty');

        $validator
            ->add('banner-link', 'valid', [
                'rule' => 'url',  // Built-in URL validation rule
                'message' => 'Please provide a valid URL',  // Custom error message
            ]);

        return $validator;
    }
}
