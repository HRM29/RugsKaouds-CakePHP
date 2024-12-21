<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;




class ProductImagesTable extends Table
{
	
    public function initialize(array $config)
    {
		$this->setTable('product_images');
        $this->addBehavior('Timestamp'); 
		
		$this->addBehavior('Timestamp');
		$this->belongsTo('Products');
		
    }  
}
?>