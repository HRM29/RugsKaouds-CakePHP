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
class CategoriesController extends AppController {
	
	public function initialize() {
		parent::initialize();
		$this->loadComponent('Flash');
		$this->loadComponent('Paginator');
	}
	
    public function beforeFilter(Event $event) {
		$this->viewBuilder()->setLayout('admin'); 
		parent::beforeFilter($event);
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
     * @return \Cake\Network\Response|null
     */
    public function index() {
		$title		=	'Category List';
		$categoriesTable = TableRegistry::get('Categories');
		$savesearch=array();
		if($this->request->is(['post','put'])){
			$params = array();
			/* if(!empty($this->request->getData()['title'])){
				$params['title'] = base64_encode($this->request->getData()['title']);
			} */
			 if(!empty($this->request->getData()['parent_id'])){
				  $params['parent_id'] = base64_encode($this->request->getData()['parent_id']);
			  }
			if(!empty($this->request->getData()['status_id'])){
				$params['status_id'] = base64_encode($this->request->getData()['status_id']);
			}
			 
			$order['id'] = 'DESC';
            return $this->redirect([
				'controller' => 'categories', 'action' => 'index',
				'?' => $params
            ]);
		}else{
			$filters = array();
			$order = array('id'=>'DESC');
			$limit = Configure::read('pageRecord');
            
			 if(isset($this->request->getQuery()['parent_id'])){
				 $parent_id = base64_decode($this->request->getQuery()['parent_id']);
				   $filters['id'] = $parent_id;
				 $savesearch['parent_id'] = $parent_id;
			  }
			if(isset($this->request->getQuery()['status_id'])){
				$status = base64_decode($this->request->getQuery()['status_id']);
				$filters['status'] = $status;
				$savesearch['status_id'] = $status;
			}
			 
			$categories = $this->paginate($categoriesTable, [
				'limit' => $limit,
				'conditions' => [$filters],
				'order' => $order
			]);
		}
		  $categoryOption = parent::categoryList();
		$this->set(compact('categories','categoryOption','savesearch','title'));
    }
	
	public function add(){
		$title		=	'Add Category';
		$categories		=	TableRegistry::get('Categories');
		$category		=	$categories->newEntity();
		$categoryList	=	parent::categoryList();
		
		if($this->request->is('post')) {
			$this->request->data['term']	=	Inflector::slug($this->request->getData()['title']);
			$categories->patchEntity($category,$this->request->getData());
			// pr($category);die;
			if(!$category->getErrors()) {
				$imageData	=	isset($this->request->getData()['image']) ? $this->request->getData()['image'] : '';
				if(!empty($imageData)) {
					if(isset($this->request->getData()['image']['name']) && $this->request->getData()['image']['name'] != '') {
						$img			=	$this->My->uploadfile($imageData, 'category');
						$category->image=	$img;
					}
				}
				if($categories->save($category)) {
					$this->Flash->set('The Category has been saved.',['key'=>'positive','params'=>['class' => 'alert alert-success']]);
					$this->redirect(['controller'=>'categories','action'=>'index']);
				} else {
					$this->Flash->set('The category could not be saved. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				}
			} else {
				$this->Flash->set($this->errorMessage($category->getErrors()), ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
		} 
		$this->set(compact('categoryList','category','title'));
	}
	
	public function edit($id=null){
		$title			=	'Edit Category';
		$categoryTable	=	TableRegistry::get('Categories');
		$category		=	$categoryTable->get($id);
		$categoryList	=	parent::categoryList();
		if($this->request->is(['patch', 'put', 'post'])) {
			if(isset($this->request->getData()['parent_cat']) && $this->request->getData()['parent_cat'] !=''){
				$this->request->data['parent_cat']	=	$this->request->getData()['parent_cat'];
			} else {
				$this->request->data['parent_cat']	=	0;
			}
			if(!empty($this->request->getData()['image']['name'])) {
				if(!empty($category->image)) {
					$original		=	WWW_ROOT . 'uploads' . DS . 'category' . DS . $category->image;
					$originalThumb	=	WWW_ROOT . 'uploads' . DS . 'category'. DS .'thumb' . DS . $category->image;
					if(file_exists($original)) {
						unlink($original);
					}
					if(file_exists($originalThumb)) {
						unlink($originalThumb);
					}
				}
				$imageData	=	$this->request->getData()['image'];
				$img		=	$this->My->uploadfile($imageData, 'category');
				$this->request->data['image']	=	$img;
			} else {
				$this->request->data['image']	=	!empty($category->image) ? $category->image : '';
			}
			$categoryTable->patchEntity($category, $this->request->getData());
			if(!$category->errors()) {
				if($categoryTable->save($category)) {
					$this->Flash->set('category has been updated successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action'=>'index']);
				} else {
					$this->Flash->set('Failed to update category.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				}
			} else {
				$this->Flash->set($this->errorMessage($category->errors()), ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
		}
		$this->set(compact('category','categoryList','title'));
	}
	
	public function view($id = null){
		$title		=	'view Category';
		$categoryTbl=	TableRegistry::get('Categories');
		$category	=	$categoryTbl->get($id);
		$this->set('category', $category);
		$this->set(compact('title'));
	}
	
	public function delete($id = null){
		$categoryTable	=	TableRegistry::get('Categories');
		$aCategory		=	$categoryTable->get($id);
		if($categoryTable->delete($aCategory)){
			$this->Flash->set('The category has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
        } else {
			$this->Flash->set('The category could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
        }
        return $this->redirect(['action' => 'index']);
	}
	
	public function deleteAll(){
		$this->autoRender	=	false;
		$categoryTable		=	TableRegistry::get('Categories');
		if($this->request->is(['post','put'])) {
			$newRecord	=	$this->request->getData()['user_chk'];
			foreach($newRecord as $ids) {
				if($ids > 0) {
					$catData	=	$categoryTable->get($ids);
					if($categoryTable->delete($catData)){
						$this->Flash->set('The category has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					} else {
						$this->Flash->set('The category could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
					}
				}
			}
			return $this->redirect(['action' => 'index']);
		}
	}
	public function returnPageUrl()
    {
        $this->request->allowMethod(['post', 'put']); // Only POST and PUT requests are allowed
        $this->autoRender =    false;
        $collectionTable =    TableRegistry::getTableLocator()->get('Categories');
        if ($this->request->is(['post', 'put'])) {
            $postData    =    $this->request->getData();
            $returnData = ['status' => false, 'message' => '', "value" => ''];
            if (!empty($postData['linkValue'])) {
                $pageURl = Text::slug($postData['linkValue']);
                $existingURl_Count = $collectionTable->find('all')
                    ->select(['id'])
                    ->where([
                        'Categories.page_link' => $pageURl
                    ])
                    ->count();
                if ($existingURl_Count > 0) {
                    $returnData["status"] = false;
                    $returnData["message"] = "URL Already exist.";
                } else {
                    $returnData["status"] = true;
                    $returnData["value"] = strtolower($pageURl);
                }
            }
            // // Encode the data to JSON
            $jsonData = json_encode($returnData);

            // // Return the response with proper JSON headers
            $this->response = $this->response->withType('json')
                ->withStringBody($jsonData);

            return $this->response;
        }
    }
	
}
