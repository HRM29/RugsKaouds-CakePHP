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
 * @property \App\Model\Table\UsersTable $Users
 */
class SubscribesController extends AppController {
	
	public function initialize() {
		parent::initialize();
		$this->loadComponent('Flash');
		$this->loadComponent('Paginator');
	}
	
	public function beforeFilter(Event $event){
		$this->viewBuilder()->setLayout('admin'); 
        parent::beforeFilter($event);
    }
	/**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
	public function index() {
		$title = 'Subscribes';
		$Table = TableRegistry::get('Subscribes');
		if ($this->request->is(['post', 'put'])) {
            $params = array();
            if (!empty($this->request->getData()['email'])) {
                $params['email'] = $this->request->getData()['email'];
            }
			
            $order['id'] = 'DESC';
            return $this->redirect([
				'controller' => 'Subscribes', 'action' => 'index',
				'?' => $params
            ]);
        } else {
            $filters = array();
            $order = array();
            
			if (isset($this->request->getQueryParams()['email'])) {
                $email = $this->request->getQueryParams()['email'];
                $filters['Subscribes.email_address Like'] = '%' . $email . '%';
                $savesearch['email'] = $email;
            }
			
            $contents = $this->Paginator->paginate($Table, [
				'limit' => Configure::read('pageRecord'),
				'conditions' => [$filters],
				'order' => $order
            ]);
			
			//pr($contents); die;
        }
		
		
		$this->set(compact('contents', 'savesearch','title'));
        $this->set('_serialize', ['contents']);
    }
	
	
	
	public function clearSearch($action=null){
		$this->autoRender = false;
		$url = $_SERVER['HTTP_REFERER'];
		$newUrl = explode('?',$url);	
		$this->redirect($newUrl[0]); 
    }
	
}