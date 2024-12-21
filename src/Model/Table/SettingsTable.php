<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class SettingsTable extends Table
{
	
    public function initialize(array $config)
    { 
		$this->setTable('settings');
        $this->addBehavior('Timestamp');
       
    }
    
  
    
    
    
   

}
?>