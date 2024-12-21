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
 
 * @property \App\Model\Table\promoCodesTable 
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContactUsController extends AppController
{

    
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('Cookie'); 
		//$this->viewBuilder()->setLayout('admin');
        $this->viewBuilder()->setLayout('admin');
        if($this->Auth->User('role_id') == 3){
	        $this->Flash->set('You are now logged out', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
		    return $this->redirect($this->Auth->logout());
	    }  
        //$this->Auth->allow(['logout','passwordForget','resetpassword','edit']);
	}
	
	public function beforeFilter(Event $event) {
		$action = $this->request->getParam('action'); 
		$this->Auth->allow(['edit']);
        if (in_array($action, ['deleteAllUsers','removeImageUser','edit'])) {
            $this->eventManager()->off($this->Csrf);
        } 
	}

	
	/**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $contactqueryTable = TableRegistry::get('ContactUs');
		// $contactquerys = $contactqueryTable->find('all', array('order' => 'id DESC'));
        // echo "<pre.";print_r($contactquerys);
			$filters = array();

			$order = array('id'=>'DESC');

			$limit = Configure::read('pageRecord');
		
			$contactquerys = $this->paginate($sizesTable, [

				'limit' => $limit,

				'conditions' => [$filters],

				'order' => $order

			]);
		
        $this->set(compact('contactquerys'));
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
        $contactview = $this->ContactUs->get($id);

        $this->set('contactview', $contactview);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $currencysadd = $this->Currencys->newEntity();
        if ($this->request->is('post')) {
            $currencysadd = $this->Currencys->patchEntity($currencysadd, $this->request->getData());
			if (!$currencysadd->errors()) {
				if ($this->Currencys->save($currencysadd)) {
					$this->Flash->set('Currencys has been saved.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('Currencys could not be saved. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				}
			}else{
				$this->Flash->set('Currencys not added.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
        }
		
        $this->set(compact('currencysadd'));
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
        $currencysEdit = $this->Currencys->get($id);
        
    if ($this->request->is(['POST', 'PUT'])) {
       
     
            $currencysEdit = $this->Currencys->patchEntity($currencysEdit, $this->request->getData());
 			if (!$currencysEdit->errors()) 
 			{
 				if ($this->Currencys->save($currencysEdit)) 
 				{ 
 					$this->Flash->set('Currencys has been updated.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
 					return $this->redirect(['action' => 'index']);
 				} else {
 					$this->Flash->set('Currencys could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
 				}
 			} 			else
			{
				$this->Flash->set('Currencys could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
        }
		
        $this->set(compact('currencysEdit'));
    }

	/**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        // $currencysDelete = $this->Currencys->get($id); 
		$contactDelete = $this->ContactUs->get($id);
		
        if ($this->ContactUs->delete($contactDelete)) 
		{
			$this->Flash->set('Record has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
        } else {
			$this->Flash->set('Record could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
        }
        return $this->redirect(['action' => 'index']);
    }
	
	public function deleteAll(){

		$this->autoRender = false;

		// $sizesTable = TableRegistry::get('Contactquery');
		$contactqueryTable = TableRegistry::get('ContactUs');
		 

		if($this->request->is(['post','put'])){

			$newRecord = $this->request->getData()['user_chk'];

			

			foreach($newRecord as $ids){ 

				if($ids > 0){ 

					$sizes = $contactqueryTable->get($ids);

					//$categoryTable->removeFromTree($catData);

					if($contactqueryTable->delete($sizes)){

						$this->Flash->set('The Query has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);

					} else {

						$this->Flash->set('The Query could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);

					}

				}

			}

			return $this->redirect(['action' => 'index']);

		}

	}
}