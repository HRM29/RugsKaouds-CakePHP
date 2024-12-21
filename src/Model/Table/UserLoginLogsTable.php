<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class UserLoginLogsTable  extends Table
{
    public function initialize(array $config)
    {
		$this->setTable('user_login_logs');
		
		$this->addBehavior('Timestamp');
	}
}

?>

