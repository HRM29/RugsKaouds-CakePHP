<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Routing\Router;
use Cake\Event\Event;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MaterialsController extends AppController {
	
	public function initialize() {
		parent::initialize();
		$this->loadComponent('Flash');
		$this->loadComponent('Paginator');
	}
	
	public function beforeFilter(Event $event) {
		$this->viewBuilder()->setLayout('admin'); 
		parent::beforeFilter($event);
	}
	
	public function clearSearch($action = null){
		$this->autoRender	=	false;
		$url	=	$_SERVER['HTTP_REFERER'];
		$newUrl	=	explode('?',$url);	
		$this->redirect($newUrl[0]); 
	}
	
	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|void
	 */
	public function index() {
		$title		=	'Materials List';
		$materialTable	=	TableRegistry::get('Materials');
		if($this->request->is(['post', 'put'])) {
			$params	=	array();
			if(!empty($this->request->getData()['status'])) {
				$params['status']	=	base64_encode($this->request->getData()['status']);
			}
			if(!empty($this->request->getData()['title'])) {
				$params['title']		=	base64_encode($this->request->getData()['title']);
			}
			$order['id'] = 'DESC';
			return $this->redirect([
				'controller' => 'Materials', 'action' => 'index',
				'?' => $params
			]);
		} else {
			$filters=	[];
			$order	=	[];
			 
			if(isset($this->request->getQuery()['title'])) {
				$title	=	base64_decode($this->request->getQuery()['title']);
				$filters['Materials.title Like']	=	'%'. $title .'%';
				$savesearch['title']		=	$title;
			}
			if(isset($this->request->getQuery()['status'])) {
				$status	=	base64_decode($this->request->getQuery()['status']);
				$filters['Materials.status']	=	$status;
				$savesearch['status']		=	$status;
			} 
			
			//print_r($filters);die;
			$result = $this->paginate($materialTable, [
				'conditions'=>	[$filters],
				'limit'		=>	Configure::read('pageRecord'),
				'order'		=>	['id'=>'DESC']
			]);
		}
		
		$this->set(compact('result', 'savesearch','title'));
	}
	
	/**
	 * Add method
	 *
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$title	=	'Add Material';
		if ($this->request->is('post')) {
			$material	=	$this->Materials->newEntity(); 
			$this->Materials->patchEntity($material, $this->request->getData());
			if(!$material->errors()) {
				if($this->Materials->save($material)) {
					$this->Flash->set('Material has been saved successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('Material could not be saved. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				}
			} else {
				foreach($material->errors() as $key => $value) {
					$messageerror	=	[];
					foreach($value as $key2 => $value2) {
						$messageerror[]	=	$value2;
					}
					$errorInputs[$key]	=	implode(",", $messageerror);
				}
				$this->Flash->set($this->errorMessage($material->errors()), ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				// $this->Flash->set('Material not added.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
		}
		$this->set(compact('material','title'));
	}
	
	/**
	 * View method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null) {
		$title		=	'View Material';
		$result	=	$this->Materials->get($id);
		$this->set(compact('result','title'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null) {
		$title	=	'Edit Material';
		$material	=	$this->Materials->get($id);
		if ($this->request->is(['patch', 'post', 'put'])) {
			if (!$material->errors()) {
				$material	=	$this->Materials->patchEntity($material, $this->request->getData());
				if ($this->Materials->save($material)) { 
					$this->Flash->set('Material has been updated.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('Material could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]); 
				}
			} else {
				$this->Flash->set($this->errorMessage($material->errors()), ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				// $this->Flash->set('Material could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
		}
		$this->set(compact('material','title'));
	}
	
	/**
	 * Delete method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null) {
		$material	=	$this->Materials->get($id);
		if($this->Materials->delete($material)) {
			$this->Flash->set('Material has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
		} else {
			$this->Flash->set('Material could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
		}
		return $this->redirect(['action' => 'index']);
	}
	
	public function deleteAll() {
		$this->autoRender	=	false;
		$tbl	=	TableRegistry::get('Materials');
		if($this->request->is(['post', 'put'])) {
			$newRecord	=	$this->request->data['user_chk'];
			foreach($newRecord as $tempId) {
				if($tempId > 0) {
					$material		=	$tbl->get($tempId);
					$tbl->delete($material); 
				}
			}
			$this->Flash->set('Records deleted successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
		}
	}
	
}
