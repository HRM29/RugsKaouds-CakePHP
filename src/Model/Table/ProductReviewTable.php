<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;




class ProductReviewTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('tblproduct_review');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('review_text', 'Review description is required')
            ->minLength('review_text', 10, 'Review description must be at least 10 characters long')

            ->notEmpty('rating', 'Rating is required')
            ->integer('rating', 'Rating must be a valid integer')
            ->range('rating', [1, 5], 'Rating must be between 1 and 5')
            ->allowEmpty('reviewer_image', 'Reviewer image is optional') // Allow empty if no file is uploaded
            ->add('reviewer_image', 'fileType', [
                'rule' => function ($value, $context) {
                    // Check if the file is uploaded and validate its mime type
                    if (!empty($value['tmp_name'])) {
                        return in_array(mime_content_type($value['tmp_name']), ['image/jpeg', 'image/png']);
                    }
                    return true; // If no file is uploaded, return true (valid)
                },
                'message' => 'Reviewer image must be a JPEG or PNG file',
            ])

            ->notEmpty('status', 'Status is required')
            ->inList('status', ['pending', 'approved', 'rejected'], 'Invalid status value')

            ->integer('user_id', 'User ID must be a valid integer')
            ->greaterThanOrEqual('user_id', 0, 'User ID must be 0 or greater');

        return $validator;
    }
}
