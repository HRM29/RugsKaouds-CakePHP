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
class ColorsController extends AppController {
	
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
		$title		=	'Colors List';
		$colorTable	=	TableRegistry::get('Colors');
		if($this->request->is(['post', 'put'])) {
			$params	=	array();
			if(!empty($this->request->getData()['status'])) {
				$params['status']	=	base64_encode($this->request->getData()['status']);
			}
			if(!empty($this->request->getData()['name'])) {
				$params['name']		=	base64_encode($this->request->getData()['name']);
			}
			$order['id'] = 'DESC';
			return $this->redirect([
				'controller' => 'Colors', 'action' => 'index',
				'?' => $params
			]);
		} else {
			$filters=	[];
			$order	=	[];
			 
			if(isset($this->request->getQuery()['name'])) {
				$name	=	base64_decode($this->request->getQuery()['name']);
				$filters['Colors.name Like']	=	'%'. $name .'%';
				$savesearch['name']		=	$name;
			}
			if(isset($this->request->getQuery()['status'])) {
				$status	=	base64_decode($this->request->getQuery()['status']);
				$filters['Colors.status']	=	$status;
				$savesearch['status']		=	$status;
			} 
			$result = $this->paginate($colorTable, [
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
		$title	=	'Add Color';
		if ($this->request->is('post')) {
			$color	=	$this->Colors->newEntity();
			$this->request->data['slug']	=	Inflector::slug($this->request->getData()['name']);
			$this->Colors->patchEntity($color, $this->request->getData());
			if(!$color->errors()) {
				if($this->Colors->save($color)) {
					$this->Flash->set('Color has been saved successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('Color could not be saved. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				}
			} else {
				foreach($color->errors() as $key => $value) {
					$messageerror	=	[];
					foreach($value as $key2 => $value2) {
						$messageerror[]	=	$value2;
					}
					$errorInputs[$key]	=	implode(",", $messageerror);
				}
				$this->Flash->set($this->errorMessage($color->errors()), ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				// $this->Flash->set('Color not added.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
		}
		$this->set(compact('color','title'));
	}
	
	/**
	 * View method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null) {
		$title		=	'View Color';
		$result	=	$this->Colors->get($id);
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
		$title	=	'Edit Color';
		$color	=	$this->Colors->get($id);
		if ($this->request->is(['patch', 'post', 'put'])) {
			if (!$color->errors()) {
				$color	=	$this->Colors->patchEntity($color, $this->request->getData());
				if ($this->Colors->save($color)) { 
					$this->Flash->set('Color has been updated.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('Color could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]); 
				}
			} else {
				$this->Flash->set($this->errorMessage($color->errors()), ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				// $this->Flash->set('Color could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
		}
		$this->set(compact('color','title'));
	}
	
	/**
	 * Delete method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null) {
		$color	=	$this->Colors->get($id);
		if($this->Colors->delete($color)) {
			$this->Flash->set('Color has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
		} else {
			$this->Flash->set('Color could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
		}
		return $this->redirect(['action' => 'index']);
	}
	
	public function deleteAll() {
		$this->autoRender	=	false;
		$tbl	=	TableRegistry::get('Colors');
		if($this->request->is(['post', 'put'])) {
			$newRecord	=	$this->request->data['user_chk'];
			foreach($newRecord as $tempId) {
				if($tempId > 0) {
					$color		=	$tbl->get($tempId);
					$tbl->delete($color); 
				}
			}
			$this->Flash->set('Records deleted successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
		}
	}
	
}
