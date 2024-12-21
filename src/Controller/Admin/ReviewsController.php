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
class ReviewsController extends AppController {
	
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
		$title = 'Reviews';
		$Table = TableRegistry::get('Reviews');
		if ($this->request->is(['post', 'put'])) {
            $params = array();
            
			if (!empty($this->request->getData()['user_id'])) {
                $params['user_id'] = $this->request->getData()['user_id'];
            }
			
			if (!empty($this->request->getData()['product_id'])) {
                $params['product_id'] = $this->request->getData()['product_id'];
            }
			
			if (!empty($this->request->getData()['status'])) {
                $params['status'] = $this->request->getData()['status'];
            }
			
            $order['id'] = 'DESC';
            return $this->redirect([
				'controller' => 'Reviews', 'action' => 'index',
				'?' => $params
            ]);
        } else {
            $filters = array();
            $order = array();
            
			if (isset($this->request->getQuery()['user_id'])) {
                $user_id = $this->request->getQuery()['user_id'];
                $filters['Reviews.user_id'] = $user_id;
                $savesearch['user_id'] = $user_id;
            }
			
			if (isset($this->request->getQuery()['product_id'])) {
                $product_id = $this->request->getQuery()['product_id'];
                $filters['Reviews.product_id'] = $product_id;
                $savesearch['product_id'] = $product_id;
            }
			
			if (isset($this->request->getQuery()['status'])) {
                $status = $this->request->getQuery()['status'];
                $filters['Reviews.status'] = $status;
                $savesearch['status'] = $status;
            }
			
            $contents = $this->Paginator->paginate($Table, [
				'limit' => Configure::read('pageRecord'),
				'conditions' => [$filters],
				'order' => $order
            ]);
				
        }
		
		$users = $states = json_decode(parent::users());
		$products = []; 
		$this->set(compact('contents', 'savesearch','title','users','products'));
        $this->set('_serialize', ['contents']);
    }
	
	
	
	public function clearSearch($action=null){
		$this->autoRender = false;
		$url = $_SERVER['HTTP_REFERER'];
		$newUrl = explode('?',$url);	
		$this->redirect($newUrl[0]); 
    }
	
}