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
class CmsPagesController extends AppController
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
	public function clearSearch($action = null)
	{
		$this->autoRender = false;
		$url = $_SERVER['HTTP_REFERER'];
		$newUrl = explode('?', $url);
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


	public function index()
	{
		$title = 'Cms-List';
		$dataList = TableRegistry::get('CmsPages');

		if ($this->request->is(['post', 'put'])) {
			$params = array();
			if (!empty($this->request->getData()['alt'])) {
				$params['alt'] = base64_encode($this->request->getData()['alt']);
			}
			if (!empty($this->request->getData()['status_id'])) {
				$params['status_id'] = base64_encode($this->request->getData()['status_id']);
			}
			$order['id'] = 'DESC';
			return $this->redirect([
				'controller' => 'CmsPages',
				'action' => 'index',
				'?' => $params
			]);
		} else {
			$filters = array();
			$order = array();
			if (isset($this->request->getQuery()['alt'])) {
				$alt = base64_decode($this->request->getQuery()['alt']);
				$filters['title Like'] = '%' . $alt . '%';
				$savesearch['alt'] = $alt;
			}
			if (isset($this->request->getQuery()['status_id'])) {
				$status_id = base64_decode($this->request->getQuery()['status_id']);
				$filters['status'] = $status_id;
				$savesearch['status_id'] = $status_id;
			}

			$data = $this->paginate($dataList, [
				'limit' => Configure::read('pageRecord'),
				'conditions' => [$filters],
				'recursive' => 2,
				'order' => $order
			]);
		}
		$this->set(compact('data', 'savesearch', 'title'));
	}




	/**
	 * @view
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param integer $id
	 * @return void
	 */

	public function view($id = null)
	{
		$title = 'Cms Pages';
		//$this->viewBuilder()->setLayout('admin');
		$cmsTable = TableRegistry::get('CmsPages');
		$pageId = base64_decode($id);
		if (empty($pageId)) {
			throw new NotFoundException;
		}
		$data = $cmsTable->get($pageId);
		$this->set(compact('data', $data, 'title'));
	}




	/**
	 * @add
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param integer $id
	 * @return void
	 */

	public function add()
	{
		$title = 'Add Cms';
		$cmsTable = TableRegistry::get('CmsPages');
		$data = $cmsTable->newEntity();

		if ($this->request->is(['post', 'put'])) {
			$errorInputs = [];

			if (empty($data)) {
				throw new NotFoundException;
			}
			$postData = $this->request->getData();



			$postData['slug'] = strtolower(Text::slug($this->request->getData('title')));

			$data = $cmsTable->patchEntity($data, $postData, ['validate' => 'default']);
			if (!$data->getErrors()) {
				if ($templat = $cmsTable->save($data)) {

					$this->Flash->set('CMS page added successfully.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
					$this->redirect(array('controller' => 'CmsPages', 'action' => 'index'));
				}
			} else {
				$this->Flash->set($this->errorMessage($data->getErrors()), ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
			}
		}
		$this->set(compact('data', $data, 'title'));
	}


	/**
	 * @edit
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param integer $id
	 * @return void
	 */

	public function edit($id = null)
	{
		$title = 'Edit Cms';
		$pageId = base64_decode($id);

		$cmsTable = TableRegistry::get('CmsPages');

		$data = $cmsTable->get($pageId);


		$errorInputs = [];
		if ($this->request->is(['post', 'put'])) {

			$data = $cmsTable->patchEntity($data, $this->request->getData(), ['validate' => 'default']);
			if (!$data->getErrors()) {

				//$data->slug = Inflector::slug($this->request->getData()['title']);;
				if ($templat = $cmsTable->save($data)) {
					$this->Flash->set('CMS page updated successfully.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				}
			} else {
				$this->Flash->set($this->errorMessage($data->getErrors()), ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
			}
		}

		$this->set(compact('data', 'title'));
	}



	/**
	 * @delete
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param integer $id
	 * @return void
	 */

	public function delete($id = null)
	{
		$cmsTable = TableRegistry::get('CmsPages');

		$pageId = base64_decode($id);
		if (empty($pageId)) {
			throw new NotFoundException;
		}

		$data = $cmsTable->get($pageId);

		if ($cmsTable->delete($data)) {
			$this->Flash->set('The page has been deleted.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
		} else {
			$this->Flash->set('The page could not be deleted. Please, try again.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
		}
		return $this->redirect(['action' => 'index']);
	}

	public function deleteAllCMS()
	{

		$this->autoRender = false;
		$cmsTable = TableRegistry::get('CmsPages');
		$temp = $this->request->getData()['ID'];
		$newRecord = json_decode($temp);


		if (empty($temp)) {
			throw new NotFoundException;
		}
		if ($this->request->is(['post', 'put'])) {
			foreach ($newRecord as $tempId) {
				$data = $cmsTable->get($tempId);
				$cmsTable->delete($data);
			}
			echo "Record deleted successfully.";
			exit;
		}
	}
}
