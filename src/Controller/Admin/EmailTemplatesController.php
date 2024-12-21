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
//use Cake\Utility\Inflector;

use Cake\Utility\Text;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class EmailTemplatesController extends AppController
{

    
	public function initialize()
	{
		parent::initialize(); 
		$this->viewBuilder()->setLayout('admin'); 
	}
	
	public function beforeFilter(Event $event) {
		$action = $this->request->getParam('action'); 
	
        if (in_array($action, ['deleteAllEmail'])) {
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
        $EmailTemplatesTable = TableRegistry::get('EmailTemplates');
        if ($this->request->is(['post', 'put'])) {
            $params = array();
             
			if (!empty($this->request->getData()['status_id'])) {
                $params['status_id'] = base64_encode($this->request->getData()['status_id']);
            }
			
            if (!empty($this->request->getData()['subject'])) {
                $params['subject'] = base64_encode($this->request->getData()['subject']);
            }

			if (!empty($this->request->getData()['name'])) {
                $params['name'] = base64_encode($this->request->getData()['name']);
            } 
			 
            $order['id'] = 'DESC';
            return $this->redirect([
				'controller' => 'EmailTemplates', 'action' => 'index',
				'?' => $params
            ]);
        } else {
            $filters = array();
		
            $order = array();
             
			if (isset($this->request->getQuery()['name'])) {
                $name = base64_decode($this->request->getQuery()['name']);
                $filters['EmailTemplates.name Like'] = '%' . $name . '%';
                $savesearch['name'] = $name;
            }
			
            if (isset($this->request->getQuery()['subject'])) {
                $subject = base64_decode($this->request->getQuery()['subject']);
                $filters['EmailTemplates.subject'] = $subject;
                $savesearch['subject'] = $subject;
            } 
			
			if (isset($this->request->getQuery()['status_id'])) {
                $status_id = base64_decode($this->request->getQuery()['status_id']);
                $filters['EmailTemplates.status'] = $status_id;
                $savesearch['status_id'] = $status_id;
            } 
            $EmailTemplate = $this->paginate($EmailTemplatesTable, [
				'limit' => Configure::read('pageRecord'),
				'conditions' => [$filters],
				'order' => $order
            ]);
        }
		
		
         
        $this->set(compact('EmailTemplate', 'savesearch','title'));
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
     * @param string|null $id project id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $EmailTemplate = $this->EmailTemplates->get($id);

        $this->set('EmailTemplate', $EmailTemplate);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $EmailTemplate = $this->EmailTemplates->newEntity();
        if ($this->request->is('post')) {
            $EmailTemplate = $this->EmailTemplates->patchEntity($EmailTemplate, $this->request->getData());
			 
			// 
			if (!$EmailTemplate->getErrors()) {
				
               
				$EmailTemplate->slug = Text::slug($this->request->getData('name'));
				//pr($EmailTemplate); die;
				if ($this->EmailTemplates->save($EmailTemplate)) { 
					$this->Flash->set('The EmailTemplate has been saved.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else { 
					$this->Flash->set('The EmailTemplate could not be saved. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				} 
			}else{ 
                //pr($project->errors());die;
				$this->Flash->set('project not added.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
        }
        
        $this->set(compact('EmailTemplate'));
    }

    /**
     * Edit method
     *
     * @param string|null $id project id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $EmailTemplate = $this->EmailTemplates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $EmailTemplate = $this->EmailTemplates->patchEntity($EmailTemplate, $this->request->getData());
			if (!$EmailTemplate->getErrors()) 
			{
				if ($this->EmailTemplates->save($EmailTemplate)) 
				{ 
					$this->Flash->set('The EmailTemplates has been updated.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('The EmailTemplates could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]); 
				}
			}
			else
			{
				$this->Flash->set('The EmailTemplates could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
        }
        
        $this->set(compact('EmailTemplate'));
    }

	
	/**
     * Delete method
     *
     * @param string|null $id project id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $EmailTemplate = $this->EmailTemplates->get($id); 
        if ($this->EmailTemplates->delete($EmailTemplate)) 
		{
			
			$this->Flash->set('The EmailTemplates has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
        } else {
			$this->Flash->set('The EmailTemplates could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
        }
        return $this->redirect(['action' => 'index']);
    }
	
	
	
	
	public function deleteAllEmailTemplates(){
		
		$this->autoRender = false;
		$tbl = TableRegistry::get('EmailTemplates');
		  
		if ($this->request->is(['post', 'put'])) 
		{    
			$newRecord = $this->request->getData()['project_chk'];
			foreach($newRecord as $tempId)
			{
				if($tempId > 0){
					$data = $tbl->get($tempId);  
                    $tbl->delete($data);
				}
			} 
			$this->Flash->set('Record deleted successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);                   
			$this->redirect(array('controller'=>'EmailTemplates','action'=>'index'));  
		}
    }


}
