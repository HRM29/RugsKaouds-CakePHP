<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CitiesTable extends Table
{
	
    public function initialize(array $config){
		$this->setTable('cities');
        $this->addBehavior('Timestamp');
		
		$this->belongsTo('Countries',['foreignKey' => 'con_id']);
		$this->belongsTo('States',['foreignKey' => 'sta_id']);
    }
}
?>