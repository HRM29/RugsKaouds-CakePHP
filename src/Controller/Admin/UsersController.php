<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email; 
use Cake\Core\Configure;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Controller\Component\PaginatorComponent;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Utility\Security;
use Cake\View\ViewBuilder;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {
	
	public function initialize() {
		parent::initialize();
		$this->loadComponent('Cookie');
		$this->viewBuilder()->setLayout('admin');
		$this->Auth->allow(['logout','passwordForget','resetpassword']);
	}
	
	public function beforeFilter(Event $event) {
		$action	=	$this->request->getParam('action'); 
		if(in_array($action, ['deleteAllUsers','removeImageUser'])) {
			$this->eventManager()->off($this->Csrf);
		} 
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
		 
	$Orderstable = TableRegistry::get('Orders'); 
	$Orders=$Orderstable->find()->count(); 
	
	$Productstable = TableRegistry::get('Products');
	$Products=$Productstable->find()->count(); 
	
	$Userstable = TableRegistry::get('Users');	
	$Users=$Userstable->find()->where(['role_id'=>3])->count(); 
	
	$Bannerstable = TableRegistry::get('Banners');	
	$Banners=$Bannerstable->find()->count(); 
		
		 
		
	$this->set(compact('Orders','Products','Users','Banners'));
	$this->set('title','Dashboard');
		 
	}
	
	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|void
	 */
	public function userList() {
		$title	=	'User List';
		$usersTable	=	TableRegistry::get('Users');
		if($this->request->is(['post', 'put'])) {
			$params	=	array();
			if(!empty($this->request->getData()['status_id'])) {
				$params['status_id']	=	base64_encode($this->request->getData()['status_id']);
			}
			if (!empty($this->request->getData()['first_name'])) {
				$params['first_name']	=	base64_encode($this->request->getData()['first_name']);
			}
			if(!empty($this->request->getData()['email'])) {
				$params['email']		=	base64_encode($this->request->getData()['email']);
			} 
			 
			$order['id'] = 'DESC';
			return $this->redirect([
				'controller' => 'Users', 'action' => 'userList',
				'?' => $params
			]);
		} else {
			$filters	=	array();
			//$filters['Users.id !=']	=	'1';
			$order	=	array();
			 
			if (isset($this->request->getQuery()['first_name'])) {
				$title	=	base64_decode($this->request->getQuery()['first_name']);
				$filters['Users.first_name Like']	=	'%' . $title . '%';
				$savesearch['first_name']			=	$title;
			}
			if (isset($this->request->getQuery()['email'])) {
				$title	=	base64_decode($this->request->getQuery()['email']);
				$filters['Users.email Like']	=	'%' . $title . '%';
				$savesearch['email']			=	$title;
			}
			if (isset($this->request->getQuery()['status_id'])) {
				$status_id	=	base64_decode($this->request->getQuery()['status_id']);
				$filters['Users.status']	=	$status_id;
				$savesearch['status_id']	=	$status_id;
			}
			$filters['role_id']	=	ADMIN;
			$users = $this->paginate($usersTable, [
				'limit' => Configure::read('pageRecord'),
				'conditions' => [$filters],
				'order' => $order
			]);
		}
		
		$this->set(compact('users', 'savesearch','title'));
	}
	
	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|void
	 */
	public function customerList() {
		$title	=	'customer List';
		$usersTable	=	TableRegistry::get('Users');
		if($this->request->is(['post', 'put'])) {
			$params	=	array();
			if(!empty($this->request->getData()['status_id'])) {
				$params['status_id']	=	base64_encode($this->request->getData()['status_id']);
			}
			if (!empty($this->request->getData()['first_name'])) {
				$params['first_name']	=	base64_encode($this->request->getData()['first_name']);
			}
			if(!empty($this->request->getData()['email'])) {
				$params['email']		=	base64_encode($this->request->getData()['email']);
			} 
			 
			$order['id'] = 'DESC';
			return $this->redirect([
				'controller' => 'Users', 'action' => 'customerList',
				'?' => $params
			]);
		} else {
			$filters	=	array();
			$filters['Users.id !=']	=	'1';
			$order	=	array();
			 
			if (isset($this->request->getQuery()['first_name'])) {
				$title	=	base64_decode($this->request->getQuery()['first_name']);
				$filters['Users.first_name Like']	=	'%' . $title . '%';
				$savesearch['first_name']			=	$title;
			}
			if (isset($this->request->getQuery()['email'])) {
				$title	=	base64_decode($this->request->getQuery()['email']);
				$filters['Users.email Like']	=	'%' . $title . '%';
				$savesearch['email']			=	$title;
			}
			if (isset($this->request->getQuery()['status_id'])) {
				$status_id	=	base64_decode($this->request->getQuery()['status_id']);
				$filters['Users.status']	=	$status_id;
				$savesearch['status_id']	=	$status_id;
			}
			$filters['role_id']	=FRONT;
			$users = $this->paginate($usersTable, [
				'limit'		=>	Configure::read('pageRecord'),
				'conditions'=>	[$filters],
				'order'		=>	$order
			]);
		}
		
		$this->set(compact('users', 'savesearch','title'));
	}
	
	/**
	 * View method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null) {
		$title	=	'View User';
		$user	=	$this->Users->get($id);
		$this->set(compact('user','title'));
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$title	=	'Add User';
		$user	=	$this->Users->newEntity();
		$countryLists	=	parent::countryLists();
		if ($this->request->is('post')) {
			$user	=	$this->Users->patchEntity($user, $this->request->getData(),['associated'=>['UserDetails']]);
			if(!$user->getErrors()) {
				$imageData	=	isset($this->request->getData()['avatar']) ? $this->request->getData()['avatar']:'';
				if(!empty($imageData)){
					if(isset($this->request->getData()['avatar']['name']) && $this->request->getData()['avatar']['name'] != ''){ 
						$img			=	$this->My->uploadfile($imageData, 'user');
						$user->avatar	=	$img;
					}
				}
				if($this->Users->save($user)) {
					$this->Flash->set('The user has been saved.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					if($user->role_id == ADMIN) {
						return $this->redirect(['action' => 'userList']);
					} else {
						return $this->redirect(['action' => 'customerList']);
					}
				} else {
					$this->Flash->set('The user could not be saved. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				} 
			} else { 
				$this->Flash->set('User not added.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
		}
		$this->set(compact('user','title','countryLists'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null) {
		$title		=	'Edit User';
		$countryLists=	parent::countryLists();
		$user		=	$this->Users->get($id,['contain'=>['UserDetails']]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$user	=	$this->Users->patchEntity($user, $this->request->getData(),['validate' => 'UserProfile',['associated'=>['UserDetails']]]);
			
			// $user	=	$this->Users->patchEntity($user, $this->request->getData());
			if (!$user->errors()) {
				if(empty($this->request->getData()['avatar']['name'])) {
					unset($user->avatar);
				} else {
					$imageData	=	$this->request->getData()['avatar'];
					$img		=	$this->My->uploadfile($imageData, 'user');
					$user->avatar	=	$img;
				}
				if ($this->Users->save($user)) { 
					$this->Flash->set('The user has been updated.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'user-list']);
				} else {
					$this->Flash->set('The user could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]); 
				}
			} else {
				$this->Flash->set('The user could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
		}
		$this->set(compact('user','title','countryLists'));
	}

	/**
	 * removeImageUser method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
   function removeImageUser() {
		$this->autoRender	=	false;
		$Table		=	TableRegistry::get('Users');
		if ($this->request->is(['post', 'put'])) { 
			$pageId	=	$this->request->getData()['id'];
			if (empty($pageId)) {
				throw new NotFoundException;
			}
			$data		=	$Table->get($pageId);
			$original	=	WWW_ROOT . 'uploads' . DS . 'user' . DS . $data['avatar'];
			$thumb		=	WWW_ROOT . 'uploads' . DS . 'user' . DS . 'thumb' . DS . $data['avatar'];
			if (file_exists($original)) {
				unlink($original);
			}
			if (file_exists($thumb)) {
				unlink($thumb);
			}
			$Table->updateAll(['avatar' => ''], ['id' => $pageId]);
			exit;
		}
	}
	
	/**
	 * Delete method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null) {
		$user	=	$this->Users->get($id);
		if ($this->Users->delete($user)) {
			if(!empty($user->avatar)) {
				$original	=	WWW_ROOT . 'uploads' . DS . 'user' . DS . $user->avatar;
				if (file_exists($original)) {
					unlink($original);
				}
				$original_thumb	=	WWW_ROOT . 'uploads' . DS . 'user/thumb' . DS . $user->avatar;
				if (file_exists($original_thumb)) {
					unlink($original_thumb);
				}
			}
			$this->Flash->set('The user has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
		} else {
			$this->Flash->set('The user could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
		}
		return $this->redirect(['action' => 'user-list']);
	}
	
	public function login() {
		$this->viewBuilder()->setLayout('admin_login');
		$title	=	'Login';
		$user	=	$this->Users->newEntity();		
		if($this->request->is('post')) {
			$user	=	$this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user); 
				if($this->request->getData()['remember_me'] == 1){
					unset($this->request->getData()['remember_me']);
					$this->Cookie->write('remember_me_cookie', $this->request->getData(), true, '2 weeks');
				} else {
					$this->Cookie->delete('remember_me_cookie');
				}
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->set('Your username or password is incorrect', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			} 
		}
		
		$cookie	=	$this->Cookie->read('remember_me_cookie');
		if(!empty($cookie) and !$this->request->is('post')) {
			$cookie['remember_me']	=	1;
			$data					=	$this->request->getData();
			$data['remember_me']	=	$cookie; 
			$user	=	$this->Users->newEntity($this->request->getData());
		}
		$this->set('user',$user);
		$this->set(compact('title'));
	}
	
	public function logout() { 
		$this->Flash->set('You are now logged out', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
		return $this->redirect($this->Auth->logout());
	}
	
	/**
	 * @forgot
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param integer $id
	 * @return void
   */
	public function passwordForget() {
		$title				=	'Forgot Password';
		$this->autoRender	=	false;
		$userTable		=	TableRegistry::get('Users');
		$EmailTemplates	=	TableRegistry::get('EmailTemplates');
		$user			=	'';
		if($this->request->is(['post', 'put'])) { 
			$emailId	=	$this->request->getData()["email"] ;
			$results	=	$userTable->find('all')->where(['email'=>$emailId])->first();
			
			if(!empty($results)) {
				$username		=	ucfirst($results->first_name);
				$activation_link=	Router::url('/', true).'admin/users/resetpassword/'.base64_encode($results->id);
				
				$template	=	$EmailTemplates->find('all')->where(['EmailTemplates.slug' => 'forgot_password'])->first();
				$userEmail	=	$results->email;
				try {
					$mailMessage=	str_replace(array('{{username}}', '{{activation_link}}', '{{email}}','{{password}}'), array($username,$activation_link,$userEmail),$template->description);
					$to			=	$userEmail;
					$subject	=	$template->subject;
					$message	=	$mailMessage;
					
					if(parent::sendMailTo($to, $subject, $message)){
						$this->Flash->set('Please check your email for reset Password!', ['key' => 'positive','params' => ['class' => 'alert alert-success']]); 
					}
									
					$this->redirect(array('controller'=>'users','action'=>'login'));
				} catch (Exception $e) {
					$this->Flash->set('Enter_correct_email.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
					$this->redirect(array('controller'=>'users','action'=>'login'));
				}
			} else {
				$this->Flash->set('Please write correct admin email!', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				$this->redirect(array('controller'=>'users','action'=>'login/forgot'));
			}
		}
		$this->set(compact('user','title'));
	}
	
	public function resetpassword($id = null) {
		$this->viewBuilder()->setLayout('admin_login');
		$title	=	'Reset Password';
		if ($this->request->is(['post'])) {
			$id	=	base64_decode($id);
			if($this->request->getData()['password'] == $this->request->getData()['confirm_password']){
				$hasher	=	new DefaultPasswordHasher();
				
				$password	=	$hasher->hash($this->request->getData()['password']);
				$query		=	$this->Users->query();
				$query->update()
					->set(['password' => $password])
					->where(['id' => $id]);
					
				$query->execute();
				$this->Flash->set('Password Updated successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
				return $this->redirect(['controller'=>'users', 'action' => 'login']);
			}else{
				$this->Flash->set('Password and Confirm Password not matched!', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
				$this->redirect(array('controller'=>'users','action'=>'resetpassword/'.base64_encode($id)));
			}
		}
		$this->set(compact('id', base64_encode($id),'title'));
	}
	
	public function deleteAllUsers(){
		$this->autoRender	=	false;
		$tbl	=	TableRegistry::get('Users');
		
		if ($this->request->is(['post', 'put'])) {    
			$newRecord	=	$this->request->getData()['user_chk'];
			foreach($newRecord as $tempId) {
				if($tempId > 0) {
					$data	=	$tbl->get($tempId);  
					$tbl->delete($data); 
				}
			} 
			$this->Flash->set('Record deleted successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);                   
			$this->redirect(array('controller'=>'users','action'=>'userList'));  
		}
	}
	
}
