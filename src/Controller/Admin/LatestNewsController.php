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
class LatestNewsController extends AppController
{

    
	public function initialize()
	{
		parent::initialize(); 
		$this->viewBuilder()->setLayout('admin'); 
	}
	
	public function beforeFilter(Event $event) {
		$action = $this->request->param('action'); 
	
        if (in_array($action, ['deleteAllNotification'])) {
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
        $Table = TableRegistry::get('LatestNews');
        if ($this->request->is(['post', 'put'])) {
            $params = array();
             
			if (!empty($this->request->getData()['status_id'])) {
                $params['status_id'] = base64_encode($this->request->getData()['status_id']);
            }
			
			if (!empty($this->request->getData()['start_date'])) {
                $params['start_date'] = base64_encode($this->request->getData()['start_date']);
            }

            if (!empty($this->request->getData()['end_date'])) {
                $params['end_date'] = base64_encode($this->request->getData()['end_date']);
            }

			if (!empty($this->request->getData()['title'])) {
                $params['title'] = base64_encode($this->request->getData()['title']);
            } 
			 
            $order['id'] = 'DESC';
            return $this->redirect([
				'controller' => 'LatestNews', 'action' => 'index',
				'?' => $params
            ]);
        } else {
            $filters = array();
		
            $order = array();
             
			if (isset($this->request->getQuery()['title'])) {
                $title = base64_decode($this->request->getQuery()['title']);
                $filters['LatestNews.title Like'] = '%' . $title . '%';
                $savesearch['title'] = $title;
            }
			if (isset($this->request->getQuery()['end_date'])) {
                $end_date = base64_decode($this->request->getQuery()['end_date']);
                $filters['LatestNews.end_date'] = $end_date;
                $savesearch['end_date'] = $end_date;
            } 

            if (isset($this->request->getQuery()['start_date'])) {
                $start_date = base64_decode($this->request->getQuery()['start_date']);
                $filters['LatestNews.fund_amount'] = $start_date;
                $savesearch['start_date'] = $start_date;
            } 
			
			if (isset($this->request->getQuery()['status_id'])) {
                $status_id = base64_decode($this->request->getQuery()['status_id']);
                $filters['LatestNews.status'] = $status_id;
                $savesearch['status_id'] = $status_id;
            } 
            $latestnews = $this->paginate($Table, [
				'limit' => Configure::read('pageRecord'),
				'conditions' => [$filters],
				'order' => $order
            ]);
        }
		
		
         
        $this->set(compact('latestnews', 'savesearch','title'));
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
        $project = $this->Projects->get($id);

        $this->set('project', $project);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $data = $this->LatestNews->newEntity();
        if ($this->request->is('post')) {
            $data = $this->LatestNews->patchEntity($data, $this->request->getData());
			 
			if (!$data->errors()) {
				if ($this->LatestNews->save($data)) { 
					$this->Flash->set('The Latest News has been saved.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else { 
					$this->Flash->set('The Latest News could not be saved. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				} 
			}else{ 
                //pr($project->errors());die;
				$this->Flash->set('Latest News not added.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
        }
       
        $this->set(compact('data'));
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
        $data = $this->LatestNews->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->LatestNews->patchEntity($data, $this->request->getData());
			if (!$data->errors()) 
			{
				
				if ($this->LatestNews->save($data)) 
				{ 
					$this->Flash->set('The Latest News has been updated.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('The Latest News could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]); 
				}
			}
			else
			{
				$this->Flash->set('The Latest News could not be updated. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			}
        }
       
        $this->set(compact('data','categoryOption'));
    }

    
	/**
     * Delete method
     *
     * @param string|null $id LatestNews id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $data = $this->LatestNews->get($id); 
        if ($this->LatestNews->delete($data)) 
		{
	    	$this->Flash->set('The LatestNews has been deleted.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);
        } else {
			$this->Flash->set('The LatestNews could not be deleted. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
        }
        return $this->redirect(['action' => 'index']);
    }
	
	
	
	
	public function deleteAllLatestNews(){
		
		$this->autoRender = false;
		$tbl = TableRegistry::get('LatestNews');
		  
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
			$this->redirect(array('controller'=>'Projects','action'=>'index'));  
		}
    }


}
