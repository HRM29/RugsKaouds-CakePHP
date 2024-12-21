<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class EmailTemplatesTable extends Table
{
	
    public function initialize(array $config)
    {
		$this->setTable('email_templates');
        $this->addBehavior('Timestamp');
       
    }
}
?>