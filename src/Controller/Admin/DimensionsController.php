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
class DimensionsController extends AppController {
	
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
		$title		=	'Dimensions List';
		$dimensionTable=	TableRegistry::get('Dimensions');
		if($this->request->is(['post', 'put'])) {
			$params	=	array();
			if(!empty($this->request->getData()['status'])) {
				$params['status']	=	base64_encode($this->request->getData()['status']);
			}
			if(!empty($this->request->getData()['type'])) {
				$params['type']	=	base64_encode($this->request->getData()['type']);
			}
			
			if(!empty($this->request->getData()['large_runner'])) {
				$params['large_runner']	=	base64_encode($this->request->getData()['large_runner']);
			}
			
			if(!empty($this->request->getData()['name'])) {
				$params['name']		=	base64_encode($this->request->getData()['name']);
			}
			$order['id'] = 'DESC';
			return $this->redirect([
				'controller' => 'Dimensions', 'action' => 'index',
				'?' => $params
			]);
		} else {
			$filters=	[];
			$order	=	[];
			 
			if(isset($this->request->getQuery()['name'])) {
				$name	=	base64_decode($this->request->getQuery()['name']);
				$filters['Dimensions.title Like']	=	'%'. $name .'%';
				$savesearch['name']		=	$name;
			}
			if(isset($this->request->getQuery()['status'])) {
				$status	=	base64_decode($this->request->getQuery()['status']);
				$filters['Dimensions.status']	=	$status;
				$savesearch['status']		=	$status;
			} 
			if(isset($this->request->getQuery()['type'])) {
				$type	=	base64_decode($this->request->getQuery()['type']);
				$filters['Dimensions.type']	=	$type;
				$savesearch['type']		=	$type;
			} 
			if(isset($this->request->getQuery()['large_runner'])) {
				$large_runner	=	base64_decode($this->request->getQuery()['large_runner']);
				$filters['Dimensions.is_large_runner']	=	$large_runner;
				$savesearch['large_runner']		=	$large_runner;
			} 
			$dimensions = $this->paginate($dimensionTable, [
				'conditions'=>	[$filters],
				'limit'		=>	Configure::read('pageRecord'),
				'order'		=>	['created'=>'DESC']
			]);
		}
		
		$this->set(compact('dimensions', 'savesearch','title'));
	}
	
	/**
	 * Add method
	 *
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$title	=	'Add Dimension';
		if ($this->request->is('post')) {
			$dimension	=	$this->Dimensions->newEntity();
			$this->request->data['slug']	=	Inflector::slug($this->request->getData()['title']);
			// $this->request->data['slug']	=	str_replace(' ','_',strtolower($this->request->data['title']));
			$this->Dimensions->patchEntity($dimension, $this->request->getData());
			if(!$dimension->errors()) {
				if($this->Dimensions->save($dimension)) {
					$this->Flash->set('Dimension has been saved successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('Dimension could not be saved. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				}
			} else {
				foreach($dimension->errors() as $key => $value) {
					$messageerror	=	[];
					foreach($value as $key2 => $value2) {
						$messageerror[]	=	$value2;
					}
					$errorInputs[$key]	=	implode(",", $messageerror);
				}
				$this->Flash->set($this->errorMessage($dimension->errors()), ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				// $this->Flash->set('Dimension not added.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
		}
		$this->set(compact('user','title'));
	}
	
	/**
	 * View method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null) {
		$title		=	'View Dimension';
		$dimension	=	$this->Dimensions->get($id);
		$this->set(compact('dimension','title'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null) {
		$title	=	'Edit Dimension';
		$dimension	=	$this->Dimensions->get($id);
		// pr($dimension);
		// die;
		if ($this->request->is(['patch', 'post', 'put'])) {
			if (!$dimension->errors()) {
				$dimension	=	$this->Dimensions->patchEntity($dimension, $this->request->getData());
				if ($this->Dimensions->save($dimension)) { 
					$this->Flash->set('Dimension has been updated.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('Dimension could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]); 
				}
			} else {
				$this->Flash->set($this->errorMessage($dimension->errors()), ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				// $this->Flash->set('Dimension could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
		}
		$this->set(compact('dimension','title'));
	}
	
	/**
	 * Delete method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null) {
		$dimension	=	$this->Dimensions->get($id);
		if($this->Dimensions->delete($dimension)) {
			$this->Flash->set('Dimension has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
		} else {
			$this->Flash->set('Dimension could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
		}
		return $this->redirect(['action' => 'index']);
	}
	
	public function deleteAll() {
		$this->autoRender	=	false;
		$tbl	=	TableRegistry::get('Dimensions');
		if($this->request->is(['post', 'put'])) {
			$newRecord	=	$this->request->data['user_chk'];
			foreach($newRecord as $tempId) {
				if($tempId > 0) {
					$dimension	=	$tbl->get($tempId);
					$tbl->delete($dimension); 
				}
			}
			$this->Flash->set('Records deleted successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
		}
	}
	
}
