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
//use Cake\Utility\Inflector;
use Cake\Utility\Text;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class SizesController extends AppController
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
	    $title= 'Sizes'; 
		$table = TableRegistry::get('sizes');
		
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
					  'controller' => 'sizes', 'action' => 'index',
					  '?' => $params
				  ]);
		}else{
			$filters = array(); 
			$order = array();
			if(isset($this->request->getQuery()['title'])){
				$title = base64_decode($this->request->getQuery()['title']);
				$filters['sizes Like'] = '%'.$title.'%';
				$savesearch['title'] = $title;
				
			}
			if (isset($this->request->getQuery()['status_id'])) {
                $status_id = base64_decode($this->request->getQuery()['status_id']);
                $filters['sizes.status'] = $status_id;
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
	
	
	
	
	/**
    * @view
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
    
	public function view($id=null){
		$title='Sizes';
		$Table = TableRegistry::get('sizes');
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
		$savestatus = 1;
		$title= 'Sizes';
		$Table = TableRegistry::get('sizes');
		$data = $Table->newEntity();
		 
		if ($this->request->is(['post', 'put'])) {
			$errorInputs =[];
			  
			if(empty($data)){
				throw new NotFoundException;
			}
				
				//$data->slug = Inflector::slug($this->request->getData('name'));
				$data->slug = Text::slug($this->request->getData('size'));
				$data = $Table->patchEntity($data, $this->request->getData(),['validate'=>'default']);
				
				if (!$data->getErrors()){
					
					if($Table->save($data)) {
								$this->Flash->set('sizes added successfully.',['key' => 'positive','params'=>['class' => 'alert alert-success']]);
								$this->redirect(array('controller'=>'sizes','action'=>'index'));
					}
				}
				else{ 
					$this->Flash->set($this->errorMessage($data->getErrors()),['key' => 'positive','params'=>['class' => 'alert alert-danger']]);
				}  
		} 
		$this->set(compact('data',$data,'title')); 
	
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
		$savestatus = 1;
	    $title='Edit sizes';
		$pageId = base64_decode($id);
		
		$Table = TableRegistry::get('sizes');
		$data = $Table->get($pageId);
		
		$errorInputs =[];
		if ($this->request->is(['post', 'put'])) { 
			
				$data = $Table->patchEntity($data, $this->request->getData(),['validate'=>'default']);
				if (!$data->getErrors()){
					if ($Table->save($data)) {
								$this->Flash->set('sizes updated successfully.',['key' => 'positive','params'=>['class' => 'alert alert-success']]);
								$this->redirect(array('controller'=>'sizes','action'=>'index'));
							
					}
					}else{
						$this->Flash->set($this->errorMessage($data->getErrors()),['key' => 'positive','params'=>['class' => 'alert alert-danger']]);
					}	
        }
		 
        $this->set(compact('data','title'));
	}
	
	 
	
	/**
    * @delete
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
	
	/* public function delete($id = null){
		$Table = TableRegistry::get('sizes');
		 
		$pageId = base64_decode($id);
		if(empty($pageId)){
            throw new NotFoundException;
        }
		
		$data = $Table->get($pageId); 
		
		//$this->deleteAllCompanyResult($data->company_result_schedules);
		
		if ($Table->delete($data)) 
		{ 
			$this->Flash->set('The Colours has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
        } else {
			$this->Flash->set('The Colours could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
        }
        return $this->redirect(['action' => 'index']); 
	} */
    
	/* public function deleteAllColours(){
		$this->autoRender = false;
		$tbl = TableRegistry::get('Colours');
		  
		if ($this->request->is(['post', 'put'])) 
		{    
			$newRecord = $this->request->getData()['comp_chk'];
			foreach($newRecord as $tempId)
			{
				if($tempId > 0){
					$data = $tbl->get($tempId);  
                    $tbl->delete($data);
				}
			} 
			$this->Flash->set('Record deleted successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);                   
			$this->redirect(array('controller'=>'brands','action'=>'index')); 
             			
		}
    }
     */
}
