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
use Cake\Utility\Inflector;
/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 *
 * @method \App\Model\Entity\project[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CurrenciesController extends AppController
{
		public function initialize()
		{
			parent::initialize(); 
			$this->viewBuilder()->setLayout('admin'); 
		}
		
		public function index()
		{	
			$title = "Currencies";
			$Table = TableRegistry::get('Currencies');
			if ($this->request->is(['post', 'put'])) {
				$params = array();
				if (!empty($this->request->getData()['country_id'])) {
					$params['country_id'] = base64_encode($this->request->getData()['country_id']);
				}
				if (!empty($this->request->getData()['status_id'])) {
					$params['status_id'] = base64_encode($this->request->getData()['status_id']);
				}
				if (!empty($this->request->getData()['title'])) {
					$params['title'] = base64_encode($this->request->getData()['title']);
				} 
				$order['id'] = 'DESC';
				return $this->redirect([
					'controller' => 'Currencies', 'action' => 'index',
					'?' => $params
				]);
			} else {
				$filters = array();
			
				$order = array();
				 
				if (isset($this->request->getQuery()['title'])) {
					$title = base64_decode($this->request->getQuery()['title']);
					$filters['Currencies.title Like'] = '%' . $title . '%';
					$savesearch['title'] = $title;
				}
			    
				if (isset($this->request->getQuery()['country_id'])) {
					$country_id = base64_decode($this->request->getQuery()['country_id']);
					$filters['Currencies.country_id'] = $country_id;
					$savesearch['country_id'] = $country_id;
				} 
				
				if (isset($this->request->getQuery()['status_id'])) {
					$status_id = base64_decode($this->request->getQuery()['status_id']);
					$filters['Currencies.status'] = $status_id;
					$savesearch['status_id'] = $status_id;
				} 
				$data = $this->paginate($Table, [
					'limit' => Configure::read('pageRecord'),
					'conditions' => [$filters],
					'order' => $order
				]);
			}
			
		 
			$country = json_decode(parent::countryList());
			$this->set(compact('data', 'savesearch','title','country'));
    }
		
	public function clearSearch($action=null){
		$this->autoRender = false;
		$url = $_SERVER['HTTP_REFERER'];
		$newUrl = explode('?',$url);	
		$this->redirect($newUrl[0]); 
    }

	 public function view($id = null)
    {
		$title = "Currencies";
		$table = TableRegistry::get('Currencies');
        $data = $table->get($id);
	 
        $this->set(compact('data','title'));
    }	
	 
	public function add(){
		$title = "Currencies";
		$Table = TableRegistry::get('Currencies');
		$currency = $Table->newEntity();
        if ($this->request->is('post')) {
			 
            $currency = $Table->patchEntity($currency, $this->request->getData(),['validate'=>'default']);
			 
			if (!$currency->getErrors()) {
				if ($Table->save($currency)) { 
					$this->Flash->set('The currency has been saved.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else { 
					$this->Flash->set('The currency could not be saved. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				} 
			}else{ 
                
				$this->Flash->set('currency not added.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
        }
		
		$country = json_decode(parent::countryList());	
        $this->set(compact('currency','title','country'));
    }
	
	public function edit($id=null){
		$title = "Currencies";
		$Table = TableRegistry::get('Currencies');
		$currency = $Table->get($id);
		 
		if($this->request->is(['patch', 'put', 'post']))
		{   //pr($this->request->getData());die;
			 
			$currency = $Table->patchEntity($currency, $this->request->getData(),['validate'=>'default']);
			//pr($currency->getErrors()); die;
			if (!$currency->getErrors()) 
			{
				if ($Table->save($currency)) 
				{ 
					$this->Flash->set('The currency has been updated.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('The currency could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]); 
				}
			}
			else
			{
				$this->Flash->set($this->errorMessage($user->getErrors()),['key' => 'positive','params'=>['class' => 'alert alert-danger']]);
			}
		}
		 
		$country = json_decode(parent::countryList());			
		$this->set(compact('currency','country','title'));
	}
	
	/* public function delete($id = null) {
        $products = $this->Products->get($id); 
        if ($this->Products->delete($Currencies)) 
		{
			 
			$this->Flash->set('The Food Product has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
        } else {
			$this->Flash->set('The Food Product could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
        }
        return $this->redirect(['action' => 'index']);
    } */
	
	/* public function deleteAll(){
		$this->autoRender = false;
		$tbl = TableRegistry::get('Currencies');
		  
		if ($this->request->is(['post', 'put'])) 
		{    
			$newRecord = $this->request->getData()['user_chk'];
			foreach($newRecord as $tempId)
			{
				if($tempId > 0){
					$data = $tbl->get($tempId);  
                    $tbl->delete($data);
                     
				}
			} 
			$this->Flash->set('Records deleted successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);                   
			$this->redirect(array('controller'=>'Products','action'=>'index')); 
             			
		}
    }		 */
}