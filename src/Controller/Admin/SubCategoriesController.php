<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Routing\Router;
use Cake\Event\Event;
use Cake\Utility\Text;


//use Cake\ORM\Behavior\TreeBehavior;
/**
 * Groups Controller
 *
 * @property \App\Model\Table\GroupsTable $Groups
 */
class SubCategoriesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('Flash');
		$this->loadComponent('Paginator');
	
	}
	
	
    public function beforeFilter(Event $event){
		$this->viewBuilder()->setLayout('admin'); 
        parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
	  
    public function index()
    { 	$title = 'SubCategories';
		$subcategoriesTable = TableRegistry::get('SubCategories');
		$categoriesTable = TableRegistry::get('Categories');
		$savesearch=array();
		if($this->request->is(['post','put'])){
			$params = array();
			if(!empty($this->request->getData()['title'])){
				$params['title'] = base64_encode($this->request->getData()['title']);
			}
			if(!empty($this->request->getData()['parent_id'])){
				$params['parent_id'] = base64_encode($this->request->getData()['parent_id']);
			}
			if(!empty($this->request->getData()['status_id'])){
				$params['status_id'] = base64_encode($this->request->getData()['status_id']);
			}
			 
			$order['id'] = 'DESC';
            return $this->redirect([
				'controller' => 'SubCategories', 'action' => 'index',
				'?' => $params
            ]);
		}else{
			$filters = array();
			$order = array('id'=>'DESC');
			$limit = Configure::read('pageRecord');
            if (isset($this->request->getQuery()['title'])) {
                $title = base64_decode($this->request->getQuery()['title']);
                $filters['title Like'] = '%' . $title . '%';
                $savesearch['title'] = $title;
            }
			if(isset($this->request->getQuery()['parent_id'])){
				$parent_id = base64_decode($this->request->getQuery()['parent_id']);
				$filters['parent_id'] = $parent_id;
				$savesearch['parent_id'] = $parent_id;
			}
			if(isset($this->request->getQuery()['status_id'])){
				$status = base64_decode($this->request->getQuery()['status_id']);
				$filters['status'] = $status;
				$savesearch['status_id'] = $status;
			}
			 
			$subcategories = $this->paginate($subcategoriesTable, [
				'limit' => $limit,
				'conditions' => [$filters],
				'order' => $order
			]);
		
		}
		 
		$categoryOption = $categoriesTable->find('list', ['spacer' => '__ ']);
		$this->set(compact('subcategories','categoryOption','savesearch','title'));
		
    }
	
	public function add(){
		$title = 'SubCategories';
		$subcategories = TableRegistry::get('SubCategories');
		$categories = TableRegistry::get('Categories');
		$subcategory = $subcategories->newEntity();
		if($this->request->is('post')){
			
			if(isset($this->request->getData()['parent_id']) && $this->request->getData()['parent_id'] !=''){
				$this->request->getData()['parent_id'] = $this->request->getData()['parent_id'];
			}else{
				$this->request->getData()['parent_id'] = 0;
			}
			

			$subcategory->slug = Text::slug($this->request->getData('title'));
			$subcategory = $subcategories->patchEntity($subcategory,$this->request->getData());
			if (!$subcategory->getErrors()){  
				if($subcategories->save($subcategory)){
					$this->Flash->set('The sub category has been saved.',['key'=>'positive','params'=>['class' => 'alert alert-success']]);
					return $this->redirect(['controller'=>'SubCategories','action'=>'index']);
				}else{
					$this->Flash->set('The sub category could not be saved. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				}
			}
			else{ 
				$this->Flash->set($this->errorMessage($subcategory->getErrors()),['key' => 'positive','params'=>['class' => 'alert alert-danger']]);
			} 
		} 
		
		$categoryOption    = $categories->find('list', ['spacer' => '__ ']);
		$this->set(compact('categoryOption','subcategory','title'));
	}
	
	public function view($id=null){
		$title = 'SubCategories';
		$id = base64_decode($id);
		$categoryTbl =  TableRegistry::get('SubCategories');
		$subcategory = $categoryTbl->get($id);
		$this->set(compact('subcategory','title'));
	}
	
	public function edit($id=null){
		$title = 'SubCategories';
		$id = base64_decode($id);
		$subcategoryTable = TableRegistry::get('SubCategories');
		$categoryTable = TableRegistry::get('Categories');
		$subcategory = $subcategoryTable->get($id);
		 
		if($this->request->is(['patch', 'put', 'post']))
		{   
			if(isset($this->request->getData()['parent_id']) && $this->request->getData()['parent_id'] !=''){
				$this->request->getData()['parent_id'] = $this->request->getData()['parent_id'];
			}else{
				$this->request->getData()['parent_id'] = 0;
			}
			$subcategory = $subcategoryTable->patchEntity($subcategory, $this->request->getData());
			   
			if($subcategoryTable->save($subcategory))
			{ 
				$this->Flash->set('sub category has been updated successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);

				return $this->redirect(['action'=>'index']);
			}
			else
			{
				$this->Flash->set('Failed to update sub category.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
		}
		
		$categoryOption = $categoryTable->find('list', ['spacer' => '__ ']);
					
		$this->set(compact('subcategory','categoryOption','title'));
	}
	
	public function delete($id=null){
		$id = base64_decode($id);
		$subcategoryTable = TableRegistry::get('SubCategories');
		$aCategory = $subcategoryTable->get($id);
		if($subcategoryTable->delete($aCategory)){
			$this->Flash->set('The category has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
        } else {
			$this->Flash->set('The category could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
        }
        return $this->redirect(['action' => 'index']);
	}
	
	 
		
	public function deleteAll(){
		$this->autoRender = false;
		$subcategoryTable = TableRegistry::get('SubCategories');
		 
		if($this->request->is(['post','put'])){
			$newRecord = $this->request->getData()['user_chk'];
			
			foreach($newRecord as $ids){ 
				if($ids > 0){ 
					$catData = $subcategoryTable->get($ids);
					if($subcategoryTable->delete($catData)){
						$this->Flash->set('The sub category has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					} else {
						$this->Flash->set('The sub category could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
					}
				}
			}
			return $this->redirect(['action' => 'index']);
		}
	}
	
	public function clearSearch($action=null){
		$this->autoRender = false;
		$url = $_SERVER['HTTP_REFERER'];
		$newUrl = explode('?',$url);	
		$this->redirect($newUrl[0]); 
    }
     
}
