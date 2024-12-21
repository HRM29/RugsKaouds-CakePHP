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
class TaxesController extends AppController
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
	    $title= 'Taxes'; 
		$table = TableRegistry::get('Taxes');
		
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
					  'controller' => 'Taxes', 'action' => 'index',
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
                $filters['Taxes.status'] = $status_id;
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
        $data = $this->Taxes->get(base64_decode($id));
        $this->set('data', $data);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $taxes = $this->Taxes->newEntity();
        if ($this->request->is('post')) { 
		  
            $taxes = $this->Taxes->newEntity($this->request->getData());
		    
			//pr($this->request->getData()); die;
			if (!$taxes->getErrors()) {
				
				if ($this->Taxes->save($taxes)) { 
					$this->Flash->set('The Taxes has been saved.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else { 
					$this->Flash->set('The Taxes could not be saved. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				} 
			}else{ 
                
				$this->Flash->set($this->errorMessage($taxes->getErrors()),['key' => 'positive','params'=>['class' => 'alert alert-danger']]);
			}
        }
        $this->set(compact('taxes'));
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
        $taxes = $this->Taxes->get(base64_decode($id));
        if ($this->request->is(['patch', 'post', 'put'])) {
            $taxes = $this->Taxes->patchEntity($taxes, $this->request->getData());
			
			if (!$taxes->getErrors()) 
			{
				if ($this->Taxes->save($taxes)) 
				{ 
					$this->Flash->set('The Taxes has been updated.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('The Taxes could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]); 
				}
			}
			else
			{
				$this->Flash->set($this->errorMessage($taxes->getErrors()),['key' => 'positive','params'=>['class' => 'alert alert-danger']]);
			}
        }
        $this->set(compact('taxes'));
    }

    
	
	/**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $taxes = $this->Taxes->get(base64_decode($id)); 
        if ($this->Taxes->delete($taxes)) 
		{
			$this->Flash->set('The Taxes has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
        } else {
			$this->Flash->set('The Taxes could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
        }
        return $this->redirect(['action' => 'index']);
    }

}
