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
class ShippingChargesController extends AppController
{

    
	public function initialize()
    {
        parent::initialize();
		$this->loadComponent('Flash');
        $this->loadComponent('Paginator');
		
    }
    
    public function beforeFilter(Event $event)
    {
		$this->viewBuilder()->setLayout('admin');
        parent::beforeFilter($event);
        
    }

	
	
	/**
    * @List
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
    
   
	public function index(){
	    $title= 'ShippingCharges'; 
		$table = TableRegistry::get('ShippingCharges');
		
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
					  'controller' => 'ShippingCharges', 'action' => 'index',
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
                $filters['ShippingCharges.status'] = $status_id;
                $savesearch['status_id'] = $status_id;
            } 
			 
			$data = $this->paginate($table, [
						'limit' => Configure::read('pageRecord'),
						'conditions' => [$filters],
						'recursive' => 2,
						'order'=>$order
					]);
		}
		
		$country = json_decode(parent::countryList());
		$this->set(compact('data','savesearch','title','country'));
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
		$title = "Shipping Charges";
		$table = TableRegistry::get('ShippingCharges');
        $data  = $table->get(base64_decode($id));
        $this->set(compact('data','title'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$title = "Shipping Charges";
		$table = TableRegistry::get('ShippingCharges');
        $data = $table->newEntity();
        if ($this->request->is(['post', 'put'])) {
		  //pr($this->request->getData()); die;
            $data = $table->patchEntity($data,$this->request->getData(),['validate'=>'Default']);
		    
			//pr($shippingcharges->getError()); die;
			if (!$data->getErrors()) {
				
				if ($table->save($data)) { 
					$this->Flash->set('The shipping charges has been saved.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else { 
					$this->Flash->set('The shipping charges could not be saved. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				} 
			}else{ 
                
				$this->Flash->set($this->errorMessage($data->getErrors()),['key' => 'positive','params'=>['class' => 'alert alert-danger']]);
			}
        }
		$country = json_decode(parent::countryList());
        $this->set(compact('data','country','title'));
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
		$title = "Shipping Charges";
		$table = TableRegistry::get('ShippingCharges');
        $ShippingCharges = $table->get(base64_decode($id));
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ShippingCharges = $table->patchEntity($ShippingCharges, $this->request->getData(),['validate'=>'Default']);
			if (!$ShippingCharges->getErrors()) 
			{
				if ($table->save($ShippingCharges)) 
				{ 
					$this->Flash->set('The Shipping Charges has been updated.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('The Shipping Charges could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]); 
				}
			}
			else
			{
				$this->Flash->set($this->errorMessage($ShippingCharges->getErrors()),['key' => 'positive','params'=>['class' => 'alert alert-danger']]);
			}
        }
		$country = json_decode(parent::countryList());
        $this->set(compact('ShippingCharges','country','title'));
    }

    
	
	/**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
		$table = TableRegistry::get('ShippingCharges');
        $ShippingCharges = $table->get(base64_decode($id)); 
        if ($table->delete($ShippingCharges)) 
		{
			$this->Flash->set('The Shipping Charges has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
        } else {
			$this->Flash->set('The Shipping Charges could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
        }
        return $this->redirect(['action' => 'index']);
    }
	
	public function deleteAllCharges(){
		
		$this->autoRender = false;
		$Table = TableRegistry::get('ShippingCharges');
		$temp = $this->request->getData()['ID'];
		$newRecord = json_decode($temp);
		
		
		if(empty($temp)){
			throw new NotFoundException;
		}
		if ($this->request->is(['post', 'put'])) {  
			foreach($newRecord as $tempId){
				$data =$Table->get($tempId); 
				$Table->delete($data);
			}
			echo "Record deleted successfully."; 
			exit;
		}
    }
    
}
