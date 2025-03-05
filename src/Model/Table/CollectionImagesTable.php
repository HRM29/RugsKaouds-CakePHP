<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;


class CollectionImagesTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('collection_images');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        
        $this->belongsTo('Collections', [
            'foreignKey' => 'associated_id',
            'joinType' => 'INNER',
            'cascadeCallbacks' => true, // Enables cascading delete
        ]);
        
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

        return $validator;
    }
}
