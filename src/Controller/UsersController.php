<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Routing\Router;
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
use Cake\Validation\Validation;


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
		$this->Auth->allow(['logout','index','signup','forgotPassword','resetPassword','login','recaptcha','gLogin','socialFacebook','createusername','makesession','activate','addToCart']);
	}
	
	 public function register(){
		$userTable = TableRegistry::get('Users');
		$user = $userTable->newEntity();
		if($this->request->is(['post','put'])){
			$user = $userTable->patchEntity($user, $this->request->getData());
			$user->status = 2;
			if(!$user->getErrors()) {
				
				$user->role_id = 3;
				unset($user->confirm_password);
				//echo '<pre>';print_r($user);die;
				
				if ($userTable->save($user)) {
					
					$emailId = $this->request->getData()["email"] ;
					$username = ucfirst($user->first_name);
					$activation_link = Router::url('/', true).'users/activate/'.base64_encode($user->id);
					$EmailTemplates= TableRegistry::get('EmailTemplates');
					$query = $EmailTemplates->find('all')->where(['EmailTemplates.slug' => 'user_registration']);
				    
					$template = $query->first();
					$userEmail = $user->email;
					
					try {
						$mailMessage = str_replace(array('{{username}}', '{{activation_link}}', '{{email}}', '{{id}}'), array($username,$activation_link,$userEmail,$user->id),$template->description);
						$to = $userEmail;
						$subject = $template->subject;
						$message = $mailMessage;
						if(parent::sendMailTo($to, $subject, $message)){
							$this->Flash->set('Please check your email for Account Activation!', ['key' => 'positive_register','params' => ['class' => 'alert alert-success']]);
						}
						$this->Flash->set('Please check your email for Account Activation!', ['key' => 'positive_register','params' => ['class' => 'alert alert-success']]);
						$this->redirect(array('action'=>'login'));
					}catch (Exception $e) {
						$this->Flash->set('Enter_correct_email.', ['key' => 'positive_register','params' => ['class' => 'alert alert-danger']]);
						$this->redirect(array('action'=>'index'));
					}

				} else { 
					$this->Flash->set('The user could not be saved. Please, try again.', ['key' => 'positive_register','params' => ['class' => 'alert alert-danger']]);
				} 
			}else{
				$this->Flash->set($this->errorMessage($user->getErrors()), ['key' => 'positive_register', 'params' => ['class' => 'alert alert-danger']]);
			}
			
		}
		
		$this->set(compact('user'));
		$this->redirect(['action' => 'login']);
	}
	public function login() {
		$this->viewBuilder()->setLayout('front');
		$session	=	$this->request->session();
		$authUser	=	$session->read('Auth.front');
		if(!empty($authUser)) {
			return $this->redirect(['action' => 'index']);
		}
		if($this->request->is('post')) {
			$user = $this->Auth->identify();
		
			if(empty($user)) { 
				$this->Flash->set('Invalid username or password, try again.', ['key' => 'positive_login', 'params' => ['class' => 'alert alert-danger']]);		
			}else if($user['status'] == 2){
				$this->Flash->set('Account is not Activated.', ['key' => 'positive_login', 'params' => ['class' => 'alert alert-danger']]);
			}				
			else {
				$this->Flash->success('Successfully Loggedin.');
				$this->Auth->setUser($user); 
				return $this->redirect(['controller' => 'Pages','action' => 'home']);
			} 
		}
		$this->set(compact('userlogin'));
	}
	
	/**
	 * LOgout method
	 *
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	
	public function logout(){ 
		$this->Flash->set('You are now logged out', ['key' => 'positive_login','params' => ['class' => 'alert alert-success']]);
		return $this->redirect($this->Auth->logout());
	}
	
	public function forgotPassword()
    {  
		$this->viewBuilder()->setLayout('front');
		$userTable = TableRegistry::get('Users');
		$user ='';
        if($this->request->is(['post', 'put'])) { 
            $emailId = $this->request->getData()["email"] ;
			$results = $userTable->find('all')->where(['email'=>$emailId])->first();
		
            if(!empty($results)){
				
                $username = ucfirst($results->first_name);
                $activation_link = Router::url('/', true).'users/resetPassword/'.base64_encode($results->id);
                $EmailTemplates= TableRegistry::get('EmailTemplates');
                $query = $EmailTemplates->find('all')
						->where(['EmailTemplates.slug' => 'forgot_password']);
                $template = $query->first();
                $userEmail = $results->email;
                try {
					$mailMessage = str_replace(array('{{username}}', '{{activation_link}}', '{{email}}','{{password}}'), array($username,$activation_link,$userEmail),$template->description);
					$to = $userEmail;
					$subject = $template->subject;
					$message = $mailMessage;
					 
					if(parent::sendMailTo($to, $subject, $message)){
						$this->Flash->set('Please check your email for reset Password!', ['key' => 'positive_forgot','params' => ['class' => 'alert alert-success']]); 
					}
					                
					$this->redirect(array('controller'=>'users','action'=>'forgotPassword'));
						
                }catch (Exception $e) {
					$this->Flash->set('Enter_correct_email.', ['key' => 'positive_forgot','params' => ['class' => 'alert alert-danger']]);
					$this->redirect(array('controller'=>'users','action'=>'forgotPassword'));
                } 
            }else{
				$this->Flash->set('Email not exist!', ['key' => 'positive_forgot','params' => ['class' => 'alert alert-danger']]);
                $this->redirect(array('controller'=>'users','action'=>'forgotPassword'));
            }
        }
     $this->set(compact('user','title'));
    }
	
	public function resetPassword($id = null) {
		$initial_id = $id;
		$this->viewBuilder()->setLayout('front');
		$title	=	'Reset Password';
		if($this->request->is(['post'])) {
			$id	=	base64_decode($id);
			
			if($this->request->getData()['password'] == $this->request->getData()['password2']){
				$hasher	=	new DefaultPasswordHasher();
				$password	=	$hasher->hash($this->request->getData()['password']);
				
				$query		=	$this->Users->query();
				$query->update()
					->set(['password' => $password])
					->where(['id' => $id]);
					
				$query->execute();
				$this->Flash->set('Password Updated successfully.', ['key' => 'positive_reset', 'params' => ['class' => 'alert alert-success']]);
				$this->redirect(['controller'=>'users', 'action' => 'login']);
			} else {
			    $this->Flash->set('Password Does not Match.', ['key' => 'positive_reset', 'params' => ['class' => 'alert alert-danger']]);
				//$this->redirect(array('controller'=>'users','action'=>'resetPassword/'.$initial_id));
				$this->redirect(Router::url( $this->here, true ));
			}
		}
 		$this->set(compact('initial_id','title'));
	}
	
	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|void
	 */
	public function index() { //print_r($this->request->query); die;
	    $title='OrcRugs';
		$session	=	$this->request->getSession();
		$authUser	=	$session->read('Auth');
		// pr($authUser);
		$productTable	=	TableRegistry::get('Products');
		
	   // $orderBy	=   ['short_orders'=>'ASC'];	
		//$orderBy	=   ["FIELD(`sku_no`,'ORC407187','ORC394542','ORC395046','ORC374256','ORC400716','ORC283194','ORC393975','ORC401589','ORC368505','ORC405162','ORC402858','ORC406764') DESC, FIELD(Products.dimension_id,25) DESC"];
		$orderBy	=   ['short_orders'=>'ASC',"FIELD(Products.dimension_id,25) DESC"];
		$filters = array('status'=>'1','sold_status !='=>'2');
		
//	echo '<pre>'; 	print_r($orderBy); die;
		$result	=	$this->paginate($productTable, [
			'conditions' => [$filters],
			'order'		=>	$orderBy,
			'contain'	=>	['ProductImages'],
			'group' => ['sku_no'],
			'whitelist' => ['short'],
			'limit'		=>	Configure::read('App.totalRecord')
		]); 
		
		$this->set(compact('result','title'));
	}
	
	/**
	 * View method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null) {
		$user = $this->Users->get($id, [
			'contain' => ['Articles']
		]);

		$this->set('user', $user);
	}
	
	/**
	 * Add method
	 *
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The user has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The user could not be saved. Please, try again.'));
		}
		$this->set(compact('user'));
	}
	
	/**
	 * Edit method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null) {
		$user = $this->Users->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The user has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The user could not be saved. Please, try again.'));
		}
		$this->set(compact('user'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$user = $this->Users->get($id);
		if ($this->Users->delete($user)) {
			$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
	
	public function recaptcha(){
		$response	=	array();
		$key		=	$this->request->data['key'];
		if(Configure::read('debug') == true) {
			$secret		=	'6LcxWKAUAAAAAJKne5gRCDDahOwagi4sOVN85KWB';
		} else {
			$secret		=	'6LcxWKAUAAAAAJKne5gRCDDahOwagi4sOVN85KWB';
		}
		
		$verifyResponse	=	file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$key);
		$responseData	=	json_decode($verifyResponse);
		
		if($responseData->success == 1){
			$response	=	array('code'=>200,'type'=>'success','match'=>true,'message'=>'Captcha Match');
		}else{
			$response=array('code'=>404,'type'=>'error','match'=>false,'message'=>'Captcha Not Macth');
		}
		
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		echo json_encode($response);
		exit;
	}
	
	public function gLogin(){
		$this->viewBuilder()->layout(false);
		$userTable		=	TableRegistry::get("Users");
		$client_id		=	GOOGLE_CLIENT_KEY; 
		$client_secret	=	GOOGLE_SECRET; 
		$redirect_uri	=	Router::url('/', true).'users/gLogin';
		$session	    =	$this->request->session(); 
		$user		    =	'';
		$authUrl	    =	'';
		$client		    =	new \Google_Client();
		
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);
		$client->addScope("email");
		$client->addScope("profile");
		
		$service	=	new \Google_Service_Oauth2($client);
		if($this->request->query('code')) {
			$client->authenticate($this->request->query('code'));
			$session->write('access_token',$client->getAccessToken());
		}
		if($session->read('access_token') != "") {
			$client->setAccessToken($_SESSION['access_token']);
			$data	=	$service->userinfo->get();
			if(!empty($data['id'])) {
				$flag	=	0;
				$email	=	"";
				if($data['email'] != "") {
					$email	=	$data['email'];
				}
				$user	=	$userTable->find()->where(['OR'=>array('email'=>$email,'google_social_id'=>$data['id'])])->first();
				
				//echo '<pre>'; print_r($user); die; 
				if(!$user){
					$user	=	$userTable->newEntity();
					$flag	=	1;
				}
				$username	=	str_replace(' ','',$data['name']);
				if(!$user) {
					$count	=	$userTable->find()->where(['name'=>$username])->count();
					if($count == 0) {
						$flag	=	3;
					} else {
						$flag	=	2;
					}
				} else {
					if($user->name=="" || $user->name==null){
						$flag	=	2;
					}
				}
				// $this->request->data	=	array();
				$this->request->data['role_id']		=	$user->role_id		=	FRONT;
				$this->request->data['status']		=	$user->status		=	ACTIVE;
				$this->request->data['way_to_login']=	$user->way_to_login	=	GOOGLE;
				$this->request->data['google_social_id'] = $user->google_social_id = $data['id'];
				// if($flag==3) {
					// $this->request->data['name']	=	$user->name	=	$username; 
				// }
				if(!empty($data['name'])) {
					$nameArr	=	explode(' ',$data['name']);
					$firstName	=	$nameArr[0];
					$lastName	=	$nameArr[1];
					$this->request->data['first_name']	=	$user->first_name	=	$firstName;
					$this->request->data['last_name']	=	$user->last_name	=	$lastName;
				}
				$this->request->data['email']	=	$user->email	=	$data['email'];
				$this->request->data['is_login']=	$user->is_login	=	1;
				
				$user	=	$userTable->patchEntity($user,$this->request->data,['validate'=>false]);
				if($userTable->save($user)){
					$session->write('Auth.front',$user);
					$this->Auth->setUser($user);
					if($flag == 2) {
						return $this->redirect(array('controller'=>'users','action'=>'index'));
						// return $this->redirect(array('controller'=>'orders','action'=>'index'));
					} else {
						$this->redirect(array('controller'=>'users','action'=>'makesession'));
					} 
				} else {
					$this->Flash->error('Sorry Some Problem Occur.');
					return $this->redirect(array('controller'=>'users','action'=>'login'));
				}
			} else {
				$this->Flash->error('Sorry Some Problem Occur.');
				return $this->redirect(array('controller'=>'users','action'=>'login'));
			}
		} else {
			$authUrl	=	$client->createAuthUrl();
			$this->redirect($authUrl);
		}
	}
	
	/**
     * @socialFacebook
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
	 */
	public function socialFacebook(){
		$this->autoRender	=	false;
		$userTable			=	TableRegistry::get("Users");
		
		FacebookSession::setDefaultApplication(FB_APPID,FB_SECRET);
		$helper	=	new FacebookRedirectLoginHelper(Router::url('/', true).'users/socialFacebook');
		
		session_start();
		try {
			$session	=	$helper->getSessionFromRedirect();
		} catch( FacebookRequestException $ex ) {
			// When Facebook returns an error
			$this->Flash->error('Sorry Some Problem Occur.');
			return $this->redirect(array('controller'=>'users','action'=>'login'));
		} catch( Exception $ex ) {
		 // When validation fails or other local issues
			$this->Flash->error('Sorry Some Problem Occur.');
			return $this->redirect(array('controller'=>'users','action'=>'login'));
		}
		if(isset($session)) {
			$request	=	new FacebookRequest( $session, 'GET', '/me?fields=id,name,email');
			$response	=	$request->execute();
			$graphObject=	$response->getGraphObject();
			$id			=	$graphObject->getProperty('id'); 
			if(!empty($id)) {
				$flag	=	0;
				$email	=	"";
				if($graphObject->getProperty('email')	!=	"") {
					$email	=	$graphObject->getProperty('email');
				}
				$user	=	$userTable->find()->where(['OR'=>array('email'=>$email,'fb_social_id'=>$graphObject->getProperty('id'))])->first();
				if(!$user) {
					$user	=	$userTable->newEntity();
					$flag	=	1;
				}
				$username	=	str_replace(' ','',$graphObject->getProperty('name'));
				if(!$user) {
					$count	=	$userTable->find()->where(['name'=>$username])->count();
					if($count == 0) {
						$flag	=	3;
					} else {
						$flag	=	2;
					}
				} else {
					if($user->name == "" || $user->name == null) {
						$flag	=	2;
					}
				}
				$this->request->data	=	array();
				$this->request->data['role_id']		=	$user->role_id		=	FRONT;
				$this->request->data['status']		=	$user->status		=	ACTIVE;
				$this->request->data['way_to_login']=	$user->way_to_login	=	FACEBOOK;
				$this->request->data['fb_social_id']=	$user->fb_social_id	=	$graphObject->getProperty('id');
				if($flag == 3) {
					$this->request->data['name']	=	$user->name	=	$username;
				}
				$firstName	=	$lastName	=	'';
				if(!empty($graphObject->getProperty('name'))) {
					$nameArray	=	explode(' ',$graphObject->getProperty('name'));
					if(count($nameArray) == 3) {
						$firstName	=	$nameArray[0].' '.$nameArray[1];
						$lastName	=	$nameArray[2];
					} else if(count($nameArray) == 2) {
						$firstName	=	$nameArray[0];
						$lastName	=	$nameArray[1];
					}
					$this->request->data['first_name']	=	$user->first_name	=	$firstName;
					$this->request->data['last_name']	=	$user->last_name	=	$lastName;
				}
				if(!empty($graphObject->getProperty('email'))) {
					$this->request->data['email']	=	$user->email=	$graphObject->getProperty('email');
					$this->request->data['name']	=	$user->name	=	$graphObject->getProperty('name');
				} else {
					if($flag == 1) {
						$flag	=	2;
					}
				}
				
				$user	=	$userTable->patchEntity($user,$this->request->data,['validate'=>false]);
				if($userTable->save($user)) {
					$session=	$this->request->session();
					$session->write('Auth.front',$user);
					if($flag == 2) {
						$this->redirect(array('controller'=>'users','action'=>'index'));
					} else {
						$this->redirect(array('controller'=>'users','action'=>'makesession'));
					}
				} else {
					$this->Flash->error('Sorry Some Problem Occur.');
					return $this->redirect(array('controller'=>'users','action'=>'login'));
				}
			} else {
				$this->Flash->error('Sorry Some Problem Occur.');
				return $this->redirect(array('controller'=>'users','action'=>'login'));
			}
		} else {
			$loginUrl	=	$helper->getLoginUrl(array(
				'scope'	=>	'public_profile,email'
			));
			$this->redirect($loginUrl);
		}
	}
	
	public function makesession(){
		$ses	=	$this->request->session();
		$session=	$ses->read('Auth.front');
		$this->Auth->setUser($ses->read('Auth.front')); 	
		if(isset($_COOKIE['redirect_link'])) {
			$this->Flash->error('Successfully Loggedin.');
			$this->redirect(base64_decode($_COOKIE['redirect_link']));
		} else {
			$this->Flash->error('Successfully Loggedin.');
			$this->redirect(array('controller'=>'users','action'=>'index'));
		}
	}
	
	
	public function orders(){
		$result = [];
		$userId = $this->Auth->user('id');
		if(empty($userId)) {
			return $this->redirect('/users/login');
		}
		
		$orderTable	=	TableRegistry::get('Orders');
		
		$result		=	$orderTable->find('all')
						->where(['customer_id'=>$userId])->contain(['OrderProducts'=>['Products'=>['ProductImages']]])->order(['Orders.id' => 'DESC'])->toArray();
		
		$this->set(compact('result'));
	}
	
	
	public function ordersView($id){
		$result = [];
		$id = base64_decode($id);
		$userId = $this->Auth->user('id');
		if(!empty($id)){
			$orderTable	=	TableRegistry::get('Orders');
			$result		=	$orderTable->find('all')
						->where(['id'=>$id,'customer_id'=>$userId])->contain(['OrderProducts'=>['Products'=>['ProductImages']]])->order(['Orders.id' => 'DESC'])->First();
		}
		
		
		$this->set(compact('result'));
	}
	
	
	/**
     * EditProfile method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function editProfile() {
		//$this->viewBuilder()->layout('front');
        
		$userId = $this->Auth->user('id');
		if(empty($userId)) {
			return $this->redirect('/users/login');
		}
		
        $usersTable = TableRegistry::get('Users');
		$user = $usersTable->get($userId, ['contain' => ['UserDetails']]);
		
        if($this->request->is(['patch', 'post', 'put'])) {
			
			$user->name = $this->request->data['first_name'].' '.$this->request->data['first_name'];
            $usersTable->patchEntity($user, $this->request->data, ['validate' => 'EditProfile','associate'=>['UserDetails']]);
			
			
            if (!$user->errors()) {
                /* if (empty($this->request->data['profile_pic']['name'])) {
                    unset($user->profile_pic);
                } else {
                    $imageData = $this->request->data['profile_pic'];
                    $img = $this->My->uploadfile($imageData, 'user');
                    $user->profile_pic = $img;
                } */
				
				
                if ($usersTable->save($user)) {
                    $this->Flash->set('The user has been updated.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
                    return $this->redirect(['action' => 'editProfile']);
                } else {
                    $this->Flash->set('The user could not be updated. Please, try again.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
                    return $this->redirect(['action' => 'editProfile']);
                }
            } else {
                $this->Flash->set('The user could not be updated. Please, try again.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
                return $this->redirect(['action' => 'editProfile']);
            } 
        }
		$country = parent::countryList();
		
		$c_id = isset($user->user_detail->country) ? $user->user_detail->country : '';
		$states = [];
		if($c_id > 0){
			$statesTable	=	TableRegistry::get('States');
			$states			=	$statesTable->find('list', ['keyField' => 'id', 'valueField' => 'region_name'])->where(['country_id'=>$c_id])->toArray();
		
		}
        $this->set(compact('user','country','states'));
    }
    
    
    public function activate($id = null) {
        $this->autoRender = false;
        $usersTable = TableRegistry::get('Users');
        $query = $usersTable->query();
        $id = base64_decode($id);
        $searchResult = $usersTable->find('all')->Where(['id' => $id])->first();
        $count = count($searchResult);
		
        if (!empty($searchResult)) {
            $query = $usersTable->query();
            $query->update()
                    ->set(['status' => 1])
                    ->where(['id' => $id])
                    ->execute();
            $this->Flash->set('Account has been activated successfully, you can now login.', ['key' => 'positivess', 'params' => ['class' => 'alert alert-success']]);
        } else {
            $this->Flash->set('Account does not exist.', ['key' => 'positivess', 'params' => ['class' => 'alert alert-danger']]);
        }
		
        return $this->redirect(array('controller' => 'users', 'action' => 'login'));
    }
	
	public function myaccount(){
		
		$this->viewBuilder()->setLayout('front');
		$userTable = TableRegistry::get('Users');
		$user = $this->Users->get($this->Auth->user('id'), [
				'contain' => []
			]);
		
		if($this->request->is(['patch', 'post', 'put'])){
			
			$user = $userTable->patchEntity($user, $this->request->getData(), ['validate' => 'UserProfile']);

			if(empty($this->request->getData()['avatar']['name']))
				{
					unset($user->avatar);
				}
				else
				{
					$imageData = $this->request->getData()['avatar'];
					$img = $this->My->uploadfile($imageData, 'user');
					$user->avatar = $img;
				}

			if ($this->Users->save($user)) {  
				$this->Flash->set('The user has been updated.', ['key' => 'positive_myaccount','params' => ['class' => 'alert alert-success']]);

				return $this->redirect(['controller'=>'Users','action'=>'myaccount']);
			}else{ 
				$this->Flash->set('Your profile not updated!', ['key' => 'positive_myaccount','params' => ['class' => 'alert alert-danger']]);
				return $this->redirect(['controller'=>'Users','action'=>'myaccount']);
			}
		}
		
		$this->set(compact('user'));
	}
	public function myOrder(){
		$this->viewBuilder()->setLayout('front');
		$session = $this->request->getSession();
		$action = $this->request->getParam('action');
		$controller = $this->request->getParam('controller');
		$authUser = $session->read('Auth');

		$orderTable = TableRegistry::get('Orders');
		$totalOrders = $orderTable->find()->where(['user_id'=>$authUser['User']['id']])->contain(['OrderDetails'])->order(['id'=>'desc'])->toArray();
		
		$filters = [];
		$filters['user_id'] = $authUser['User']['id'];
		$OrderListing	=	$this->paginate($orderTable,[
						'conditions' => [$filters],
						'order'		=>	['id'=>'DESC'],
						'contain'	=>	['OrderDetails'],
						'limit'		=>	6
					]);
		$CompleteListing = $orderTable->find()->where(['user_id'=>$authUser['User']['id'],'payment_status'=>1])->toArray();
		$PendingListing = $orderTable->find()->where(['user_id'=>$authUser['User']['id'],'payment_status'=>0])->toArray();
		
		$this->set(compact('totalOrders','OrderListing','CompleteListing','PendingListing'));
	}
	public function orderDetail($id = null){
		$this->viewBuilder()->setLayout('front');
		$session = $this->request->getSession();
		$cartitems = $session->read('cart'); 
		$orderTable = TableRegistry::get('Orders');
		
		$orderProductsTable = TableRegistry::get('OrderDetails');
		$OrderDetail = $orderProductsTable->find()->where(['order_id'=>$id])->contain(['products'])->toArray();	
		$OrderStatus = $orderTable->find()->select(['payment_status'])->where(['id'=>$id])->first();
	
		$this->set(compact('OrderDetail','OrderStatus'));
	}	
	public function changePassword(){
		$this->viewBuilder()->setLayout('front');
		$usersTable = TableRegistry::get('Users');
		$user = $usersTable->get($this->Auth->user('id'));
		if($this->request->is(['patch', 'post', 'put'])){
			
			if($this->request->getData()['new_pswd'] == $this->request->getData()['confirm_password']){
				$password = $usersTable->patchEntity($user,$this->request->getData());
				$password->password = $this->request->getData()['confirm_password'];
				$password->confirm_password = $this->request->getData()['confirm_password'];
				
				if(!$user->getErrors()) {
					unset($password->confirm_password);
					if($usersTable->save($password)){
						$this->Flash->set('Password changed successfully!', ['key' => 'positive_changepass','params' => ['class' => 'alert alert-success']]);
					}
				}else{
						$this->Flash->set($user->getErrors(), ['key' => 'positive_changepass','params' => ['class' => 'alert alert-danger']]);
				}
			}else{
					$this->Flash->set('Password and confirm password not match!.', ['key' => 'positive_changepass','params' => ['class' => 'alert alert-warning']]);
			}

		}
	$this->set(compact('user'));
	}
	public function wishlist(){
		$this->viewBuilder()->setLayout('front');
		$session = $this->request->getSession();
		$authUser = $session->read('Auth');
		$favouritesTable = TableRegistry::get('Favourites');
		$ProductsTable = TableRegistry::get('Products');
		$favouritesData = $favouritesTable->find('all')->where(['user_id'=>$authUser['User']['id']])->toArray();
		foreach($favouritesData as $favourites => $data){
			$favouritesDatas[] = $ProductsTable->find('all')->where(['id'=>$data['product_id']])->first();
		}
		
		$this->set(compact('favouritesDatas')); 
	}
	public function deleteWishlistItem(){
		$this->autoRender = false;
		if ($this->request->is(['post', 'put'])) { 
			$product_id = $this->request->getData()['id'];
			
			$session = $this->request->getSession();
			$authUser = $session->read('Auth');
			
			$favouritesTable = TableRegistry::get('Favourites');
			$query = $favouritesTable->query();
			$query->delete()
				->where(['product_id' => $product_id,'user_id' => $authUser['User']['id']])
				->execute();
		}
	}
	//Cart Operations Start
	public function addToCart() {
		$this->autoRender = false;
		$ProductsTable = TableRegistry::get('Products');
		
		$session = $this->request->getSession();
		$authUser = $session->read('Auth');
		
		if ($this->request->is(['post', 'put'])) { 
            $product_id = $this->request->getData()['product_id'];
			 
			$productdetail = $ProductsTable->find()->select(['id','title','sku_no','selling_price','everyday_price','category_id'])->where(['id'=>$product_id])->enableHydration(false)->first();
			
			$productdetail['product_qty']  = 1;
			$productdetail['sub_total']= $productdetail['price'];
			$session = $this->request->getSession();
			
			if(empty($session->read('cart'))){
				$product[]=$productdetail;
				$session->write('cart',$product);  
				$cartValue = $session->read('cart'); 
			}else{
				$dataInsession= $session->read('cart');
				$datsession[]= $productdetail;
				$newD=array_merge($dataInsession, $datsession);
				$input = array_map("unserialize", array_unique(array_map("serialize", $newD)));
				$session->delete('cart'); 
				$session->write('cart',$input);
				$cartValue = $session->read('cart'); 
			}
			if(!empty($authUser['User']['id'])){
				$favouritesTable = TableRegistry::get('Favourites');
				$query = $favouritesTable->query();
				$query->delete()
					->where(['product_id' => $product_id,'user_id' => $authUser['User']['id']])
					->execute();
			}
			echo json_encode($cartValue);
		}
	}
}
