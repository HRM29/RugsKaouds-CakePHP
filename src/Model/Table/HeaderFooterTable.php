<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class HeaderFooterTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('header_footer_configuration'); // Table name
        $this->setPrimaryKey('id'); // Primary key
        $this->addBehavior('Timestamp'); // Auto-manage created_at and updated_at timestamps
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type', 'Type is required.')
            ->add('type', 'validValue', [
                'rule' => ['inList', ['header', 'footer']],
                'message' => 'Type must be either "header" or "footer".'
            ]);

        $validator
            ->requirePresence('heading', 'create')
            ->notEmpty('heading', 'Heading is required.');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description', 'Description is required.');

        // File validation for background_image
        $validator
            ->allowEmpty('background_image') // Allow empty file in case of edit
            ->add('background_image', [
                'mimeType' => [
                    'rule' => ['mimeType', ['image/jpeg', 'image/png', 'image/gif']],
                    'message' => 'Only JPEG, PNG, and GIF files are allowed.',
                ],
                'fileSize' => [
                    'rule' => ['fileSize', '<=', '2MB'],
                    'message' => 'Image size must be less than 2MB.',
                ],
            ]);

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status', 'Status is required.')
            ->add('status', 'validValue', [
                'rule' => ['inList', ['active', 'inactive']],
                'message' => 'Status must be either "active" or "inactive".'
            ]);

        return $validator;
    }
}
