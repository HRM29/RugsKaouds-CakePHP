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
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class SettingsController extends AppController{
    
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize(){
        parent::initialize();			
		$this->loadComponent('Flash');
        $this->loadComponent('Paginator');
		
    }
    
    public function beforeFilter(Event $event){
		$this->viewBuilder()->setLayout('admin'); 
        parent::beforeFilter($event);
    }
	
	public function isAuthorized($user) {
	    

		if($this->request->getParam('prefix') == 'admin' && $user['role_id'] == ADMIN) { 
			if(isset($user['status']) && $user['status'] != ACTIVE){ 
				$this->Flash->set('Your account not activated yet,please activate your account.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				return $this->redirect($this->Auth->logout());
			}else{
				return true;
			}
        }else{ 
			$this->Flash->set('Not authorized to access this module,please try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
			return $this->redirect($this->Auth->logout());
        }
        //return false;
    }
	public function clearSearch($action=null){
	$this->autoRender = false;
	$url = $_SERVER['HTTP_REFERER'];
	$newUrl = explode('?',$url);	
	$this->redirect($newUrl[0]);

    }
	
    /**
    * @index
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
    
    public function index(){
		$title='Setting';
		//$this->viewBuilder()->setLayout('admin');
		$sptconfigs = TableRegistry::get('Settings');
		$query = $this->Settings->find('all');
		$row = $query->all();
		$this->set('data', $row,'title');
    }
    
    /**
    * @update
    *
    * @throws MethodNotAllowedException
    * @throws NotFoundException
    * @param integer $id
    * @return void
    */
    
    public function update(){
		$sptconfigs = TableRegistry::get('Settings');
		if ($this->request->is(['post', 'put'])) { 
			$inputval 				= $this->request->getData()['inputval'];
			$id 			= $this->request->getData()['id'];
			$data = $sptconfigs->get($id);
			if(empty($data)){
				throw new NotFoundException;
			}
			$data->value = $inputval;
			$sptconfigs->save($data);
			echo "Record updated successfully.";
			exit;
		}
    }
}
