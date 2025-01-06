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

        // Title validation
        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title', 'Title is required.')
            ->maxLength('title', 255, 'Title cannot exceed 255 characters.')
            ->add('title', 'unique', [
                'rule' => ['validateUnique'],
                'provider' => 'table',
                'message' => 'Name Already Exist.'
            ]);

        // Status validation
        $validator
            ->requirePresence('status', true)
            ->notEmpty('status', 'Status is required.');

        // Page link validation (only for collection-type = page)
        $validator
            ->notEmpty('page_link', 'Page link is required.', function ($context) {
                return isset($context['data']['collection-type']) && $context['data']['collection-type'] === 'page';
            })
            ->add('page_link', 'unique', [
                'rule' => ['validateUnique'],
                'provider' => 'table',
                'message' => 'Page link already exists.'
            ]);

        // Meta title validation (only for collection-type = page)
        $validator
            ->notEmpty('meta_title', 'Meta title is required.', function ($context) {
                return isset($context['data']['collection-type']) && $context['data']['collection-type'] === 'page';
            });

        return $validator;
    }
}
