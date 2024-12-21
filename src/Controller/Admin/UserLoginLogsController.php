<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;
use Cake\Core\Configure;
use Cake\Auth\DefaultPasswordHasher;
use Cake\View\Helper\SessionHelper;
use Cake\Controller\Component\PaginatorComponent;
use Cake\Network\Request;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Utility\Security;
use Cake\Datasource\ConnectionManager;


/**
 * ResidentClubs Controller
 *
 * @property \App\Model\Table\NotificationTable $Notification
 */
class UserLoginLogsController extends AppController {
	
	public function initialize() {
		parent::initialize();
		$this->loadComponent('Flash');
		$this->loadComponent('Paginator');
	}
	
	public function beforeFilter(Event $event){
		$this->viewBuilder()->setLayout('admin'); 
        parent::beforeFilter($event);
    }
	
    public function index()
    {
		$title = "User Login Logs";
       
		$Table = TableRegistry::get('UserLoginLogs');
		if ($this->request->is(['post', 'put'])) {
			$params = array();
			if (!empty($this->request->getData()['status'])) {
                $params['status'] = base64_encode($this->request->getData()['status']);
            }
			if (!empty($this->request->getData()['user_id'])) {
                $params['user_id'] = base64_encode($this->request->getData()['user_id']);
            }
			
			$order['id'] = 'DESC';
			return $this->redirect([
					  'controller' => 'UserLoginLogs', 'action' => 'index',
					  '?' => $params
				  ]);
		}else{
			$filters = array(); 
			$order = array();
			
			if (isset($this->request->getQuery()['user_id'])) {
                $user_id = base64_decode($this->request->getQuery()['user_id']);
                $filters['user_id'] = $user_id;
                $savesearch['user_id'] = $user_id;
            }
			
			if (isset($this->request->getQuery()['status'])) {
                $status = base64_decode($this->request->getQuery()['status']);
                $filters['status'] = $status;
                $savesearch['status'] = $status;
            }
			 
			$contents = $this->paginate($Table, [
						'limit' => Configure::read('pageRecord'),
						'conditions' => [$filters],
						'recursive' => 2,
						'order'=>$order
					]);
		}
		 
		$users = $states = json_decode(parent::users());
		$this->set(compact('contents', 'savesearch','title','users'));
        $this->set('_serialize', ['contents']);
    }
	
	public function clearSearch($action=null){
		$this->autoRender = false;
		$url = $_SERVER['HTTP_REFERER'];
		$newUrl = explode('?',$url);	
		$this->redirect($newUrl[0]); 
    }
}