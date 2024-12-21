<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;
use Cake\Core\Configure;
use Cake\Auth\DefaultPasswordHasher;
use Cake\View\Helper\SessionHelper;
use Cake\Controller\Component\PaginatorComponent;
use Cake\Network\Request;
use Cake\Utility\Text;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class CitiesController extends AppController
{
    
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
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
    
	 
    
    /* for clear search */ 
    public function clearSearch($action=null){
		$this->autoRender = false;
		$url = $_SERVER['HTTP_REFERER'];
		$newUrl = explode('?',$url);	
		$this->redirect($newUrl[0]); 
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
	    $title= 'Cities'; 
		$dataList = TableRegistry::get('Cities');
		
		if ($this->request->is(['post', 'put'])) {
			$params = array();
			if(!empty($this->request->getData()['title'])){ 
			  $params['title'] = base64_encode($this->request->getData()['title']);
			}	
			if (!empty($this->request->getData()['status'])) {
                $params['status'] = base64_encode($this->request->getData()['status']);
            }
			if (!empty($this->request->getData()['con_id'])) {
                $params['con_id'] = base64_encode($this->request->getData()['con_id']);
            }
			if (!empty($this->request->getData()['sta_id'])) {
                $params['sta_id'] = base64_encode($this->request->getData()['sta_id']);
            }
			$order['id'] = 'DESC';
			return $this->redirect([
					  'controller' => 'Cities', 'action' => 'index',
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
			if (isset($this->request->getQuery()['con_id'])) {
                $con_id = base64_decode($this->request->getQuery()['con_id']);
                $filters['con_id'] = $con_id;
                $savesearch['con_id'] = $con_id;
            }
			if (isset($this->request->getQuery()['sta_id'])) {
                $sta_id = base64_decode($this->request->getQuery()['sta_id']);
                $filters['sta_id'] = $sta_id;
                $savesearch['sta_id'] = $sta_id;
            }
			if (isset($this->request->getQuery()['status'])) {
                $status = base64_decode($this->request->getQuery()['status']);
                $filters['status'] = $status;
                $savesearch['status'] = $status;
            }
			 
			$data = $this->paginate($dataList, [
						'limit' => Configure::read('pageRecord'),
						'conditions' => [$filters],
						'recursive' => 2,
						'order'=>$order
					]);
		}
		$country = json_decode(parent::countryList());
		$states = json_decode(parent::statesList());
		$this->set(compact('data','savesearch','title','country','states'));
	}
	
	
	
	
	/**
    * @view
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
    
	public function view($id=null){
		$title='Cities';
		$Table = TableRegistry::get('Cities');
		$pageId = base64_decode($id);
		if(empty($pageId)){
            throw new NotFoundException;
        }
		$data = $Table->get($pageId);
		$this->set(compact('data',$data,'title'));
	}
	 
	/**
    * @add
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
     
	public function add(){
		$title= 'Cities';
		$Table = TableRegistry::get('Cities');
		$data = $Table->newEntity();
		 
		if ($this->request->is(['post', 'put'])) {
			$errorInputs =[];
			  
			if(empty($data)){
				throw new NotFoundException;
			}
			 
			 
			$data->slug = Text::slug($this->request->getData('name'));
			 
			$data = $Table->patchEntity($data, $this->request->getData(),['validate'=>'default']);
			
			
			if (!$data->getErrors()){
				if ($templat = $Table->save($data)) {
						
					$this->Flash->set('Cities added successfully.',['key' => 'positive','params'=>['class' => 'alert alert-success']]);
					$this->redirect(array('controller'=>'cities','action'=>'index'));
				}
				
			}else{ 
				$this->Flash->set($this->errorMessage($data->getErrors()),['key' => 'positive','params'=>['class' => 'alert alert-danger']]);
			}  
		} 
		$country = json_decode(parent::countryList());
		//$states = json_decode(parent::statesList());
		//$states   = ['0'=>'Select states'];
		$this->set(compact('data',$data,'title','country')); 
	
	} 
	
	
	/**
    * @edit
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
     
	public function edit($id = null){
	    $title='Edit Cities';
		$pageId = base64_decode($id);
		
		$Table = TableRegistry::get('Cities');
		 
		$data = $Table->get($pageId);
		
		
		$errorInputs =[];
		if ($this->request->is(['post', 'put'])) { 
			 
            $data = $Table->patchEntity($data, $this->request->getData(),['validate'=>'default']);
				if (!$data->getErrors()){
					 
					//$data->slug = Inflector::slug($this->request->getData()['title']);;
				if ($templat = $Table->save($data)) {
					$this->Flash->set('Cities updated successfully.',['key' => 'positive','params'=>['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				}
				}else{
					$this->Flash->set($this->errorMessage($data->getErrors()),['key' => 'positive','params'=>['class' => 'alert alert-danger']]);
				}	
			
			
        }
		
		$country = json_decode(parent::countryList());
		$states = json_decode(parent::statesByCon($data->con_id));
        $this->set(compact('data','title','country','states'));
	}
	
	/**
    * @delete
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
	
	public function delete($id = null){
		$Table = TableRegistry::get('Cities');
		 
		$pageId = base64_decode($id);
		if(empty($pageId)){
            throw new NotFoundException;
        }
		
		$data = $Table->get($pageId); 
		
		if ($Table->delete($data)) 
		{ 
			$this->Flash->set('The city has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
        } else {
			$this->Flash->set('The city could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
        }
        return $this->redirect(['action' => 'index']); 
	}
	
	/**
    * @delete All
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
    
	public function deleteAllCities(){
		
		$this->autoRender = false;
		$Table = TableRegistry::get('Cities');
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
    
	/**
    * @get States
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
    public function getstate(){
		
		$states = array();
		$this->autoRender = false;
        $responsetype = 'main';
		$error = 0;
        
		if(!defined($this->request->getData('cid'))){
            $id = $this->request->getData('cid'); 
		} 
		if($id){
			$stateTable = TableRegistry::get('States');
							
			$states = $stateTable->find('list', [
                                    'keyField' => 'region_name',
                                    'valueField' => 'id'])
                                ->where(['States.country_id' => $id])
                                ->order(['States.region_name' => 'ASC'])->toArray();														
			echo json_encode($states); 
		}
		else{
			  return null;
			}
        exit;
	}
    
}
