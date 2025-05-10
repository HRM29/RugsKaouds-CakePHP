<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;




class ProjectsTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('project_images');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');


        $validator
            ->requirePresence('label')
            ->notEmpty('label', 'No name found.');


        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status', 'status can not be empty');
            
        return $validator;
    }
}
