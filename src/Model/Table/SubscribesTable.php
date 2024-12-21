<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;



class SubscribesTable extends Table
{
 
	public function initialize(array $config)
	{
		$this->setTable('subscribes');
 
		$this->addBehavior('Timestamp');
		 
		 
	} 
}
?>