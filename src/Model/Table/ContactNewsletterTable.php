<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;




class ContactNewsletterTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('contact_newsletter');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmpty('name', 'Name is required')
            ->notEmpty('email', 'Email is required')
            ->email('email', 'Please provide a valid email address')
            ->notEmpty('type', 'Type is required');

        return $validator;
    }
}
