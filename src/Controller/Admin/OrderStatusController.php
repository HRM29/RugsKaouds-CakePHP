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
class OrderStatusController extends AppController
{

    
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('Cookie'); 
        $this->viewBuilder()->setLayout('admin');
		//$this->Auth->allow(['logout','passwordForget','resetpassword']);
	}
	
	/* public function beforeFilter(Event $event) {
		$action = $this->request->getParam('action'); 
	
        if (in_array($action, ['deleteAllUsers','removeImageUser'])) {
            $this->eventManager()->off($this->Csrf);
        } 
	} */

	
	
	/**
    * @List
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
    
   
	public function index(){
	    $title= 'Order Status'; 
		$table = TableRegistry::get('OrderStatus');
		
		if ($this->request->is(['post', 'put'])) {
			$params = array();
			if(!empty($this->request->getData()['title'])){ 
			  $params['title'] = base64_encode($this->request->getData()['title']);
			}	
			
			if (!empty($this->request->getData()['status_id'])) {
                $params['status_id'] = base64_encode($this->request->getData()['status_id']);
            }
			
			$order['id'] = 'DESC';
			return $this->redirect([
					  'controller' => 'OrderStatus', 'action' => 'index',
					  '?' => $params
				  ]);
		}else{
			$filters = array(); 
			$order = array();
			if(isset($this->request->getQuery()['title'])){
				$title = base64_decode($this->request->getQuery()['title']);
				$filters['name Like'] = '%'.$title.'%';
				$savesearch['title'] = $title;
				
			}
			if (isset($this->request->getQuery()['status_id'])) {
                $status_id = base64_decode($this->request->getQuery()['status_id']);
                $filters['OrderStatus.status'] = $status_id;
                $savesearch['status_id'] = $status_id;
            } 
			
			$data = $this->paginate($table, [
						'limit' => Configure::read('pageRecord'),
						'conditions' => [$filters],
						'recursive' => 2,
						'order'=>$order
					]);
		}
		$this->set(compact('data','savesearch','title'));
	}
	
	public function clearSearch($action=null){
		$this->autoRender = false;
		$url = $_SERVER['HTTP_REFERER'];
		$newUrl = explode('?',$url);	
		$this->redirect($newUrl[0]); 
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $data = $this->OrderStatus->get(base64_decode($id));
        $this->set('data', $data);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $data = $this->OrderStatus->newEntity();
        if ($this->request->is('post')) { 
		  
            $data = $this->OrderStatus->newEntity($this->request->getData());
		    
			if (!$data->getErrors()) {
				
				if ($this->OrderStatus->save($data)) { 
					$this->Flash->set('The Order Status has been saved.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else { 
					$this->Flash->set('The Order Status could not be saved. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				} 
			}else{ 
                
				$this->Flash->set($this->errorMessage($data->getErrors()),['key' => 'positive','params'=>['class' => 'alert alert-danger']]);
			}
        }
        $this->set(compact('data'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $data = $this->OrderStatus->get(base64_decode($id));
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->OrderStatus->patchEntity($data, $this->request->getData());
			if (!$data->getErrors()) 
			{
				if ($this->OrderStatus->save($data)) 
				{ 
					$this->Flash->set('The Order Status has been updated.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('The Order Status could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]); 
				}
			}
			else
			{
				$this->Flash->set($this->errorMessage($data->getErrors()),['key' => 'positive','params'=>['class' => 'alert alert-danger']]);
			}
        }
        $this->set(compact('data'));
    }

    
	
	/**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $data = $this->OrderStatus->get(base64_decode($id)); 
        if ($this->OrderStatus->delete($data)) 
		{
			$this->Flash->set('The Order Status has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
        } else {
			$this->Flash->set('The Order Status could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
        }
        return $this->redirect(['action' => 'index']);
    }

}
