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
class BannersController extends AppController
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
		$title = 'Banners';
		$table = TableRegistry::getTableLocator()->get('Banners');

		if ($this->request->is(['post', 'put'])) {
			$postdata = $this->request->getData();
			$params = array();
			if (!empty($this->request->getData()['title'])) {
				$params['title'] = base64_encode($this->request->getData()['title']);
			}

			if (!empty($this->request->getData()['block_type'])) {
				$params['block_type'] = base64_encode($this->request->getData()['block_type']);
			}

			if (!empty($this->request->getData()['status_id'])) {
				$params['status_id'] = base64_encode($this->request->getData()['status_id']);
			}
			$order['id'] = 'DESC';
			return $this->redirect([
				'controller' => 'Banners',
				'action' => 'index',
				'?' => $params
			]);
		} else {
			$filters = array();
			$order = array();
			if (isset($this->request->getQuery()['title'])) {
				$title = base64_decode($this->request->getQuery()['title']);
				$filters['Banners.title Like'] = '%' . $title . '%';
				$savesearch['title'] = $title;
			}
			if (isset($this->request->getQuery()['block_type'])) {
				$status_id = base64_decode($this->request->getQuery()['block_type']);
				$filters['Banners.block_type'] = $status_id;
				$savesearch['block_type'] = $status_id;
			}

			if (isset($this->request->getQuery()['status_id'])) {
				$status_id = base64_decode($this->request->getQuery()['status_id']);
				$filters['Banners.status'] = (int)$status_id;
				$savesearch['status_id'] = $status_id;
			}

			$data = $this->paginate($table, [
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
		$title = 'Banners';
		$Table = TableRegistry::get('Banners');
		$pageId = base64_decode($id);
		if (empty($pageId)) {
			throw new NotFoundException;
		}
		$data = $Table->get($pageId);
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
		$savestatus = 1;
		$title = 'Banners';
		$Table = TableRegistry::getTableLocator()->get('Banners');
		$data = $Table->newEntity();

		if ($this->request->is(['post', 'put'])) {
			$errorInputs = [];

			if (empty($data)) {
				throw new NotFoundException;
			}
			$postdata = $this->request->getData();
			$mappedData = [
				'title' => $postdata['title'],
				'description' => $postdata['description'],
				'block_type' => $postdata['block_type'],
				'image' => $postdata['image']['name'],
				'link' => $postdata['banner-link'],
				'status' => $postdata['status']
			];
			$data = $Table->patchEntity($data, $mappedData, ['validate' => 'default']);



			if (!$data->getErrors()) {
				if (empty($this->request->getData()['image']['name'])) {
					unset($data->image);
				} else {
					$imageData = $this->request->getData()['image'];
					$img = $this->My->uploadfile($imageData, 'banner');
					$data->image = $img;
				}
				if ($Table->save($data)) {
					$this->Flash->set('Banner added successfully.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
					$this->redirect(array('controller' => 'Banners', 'action' => 'index'));
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
		$savestatus = 1;
		$title = 'Edit Banners';
		$pageId = base64_decode($id);

		$Table = TableRegistry::get('Banners');
		$data = $Table->get($pageId);

		$errorInputs = [];
		if ($this->request->is(['post', 'put'])) {
			$postdata = $this->request->getData();

			$mappedData = [
				'title' => $postdata['title'],
				'description' => $postdata['description'],
				'block_type' => $postdata['block_type'],
				'image' => $postdata['image']['name'],
				'link' => $postdata['banner-link'],
				'status' => $postdata['status']
			];
			$data = $Table->patchEntity($data, $mappedData, ['validate' => 'default']);
			if (!$data->getErrors()) {
				if (empty($this->request->getData()['image']['name'])) {
					unset($data->image);
				} else {
					$image_file = $this->request->getData('image') ? $this->request->getData('image') : '';
					if (!empty($image_file)) {
						$name_ext = explode(".", $image_file['name']);
						$ext = end($name_ext);

						$image_ext = array('jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG');

						if (in_array($ext, $image_ext)) {

							//$img = $this->My->uploadfile($image_file,'banner');
							$img = $this->My->uploadfile($image_file, 'banner', 1, 'banner');

							if ($img == 1) {
								$this->Flash->set('Failed to upload banner images. Image Resoution must be more than 350 x 1300...', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
								return $this->redirect(['action' => 'edit', $id]);
							} else if ($img == 2) {
								$this->Flash->set('Failed to upload banner images. Image Resoution must be more than 350 x 1300...', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
								return $this->redirect(['action' => 'edit', $id]);
							}

							$data->image = $img;
						} else {
							$this->Flash->set('Invalid file format. Please choose an image file with jpg,png or jpeg format.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
							return $this->redirect(['action' => 'edit', $id]);
						}
					}
				}
				if ($Table->save($data)) {
					$this->Flash->set('Banner updated successfully.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
					$this->redirect(array('controller' => 'Banners', 'action' => 'index'));
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
		$Table = TableRegistry::get('Banners');

		$pageId = base64_decode($id);
		if (empty($pageId)) {
			throw new NotFoundException;
		}

		$data = $Table->get($pageId);

		//$this->deleteAllCompanyResult($data->company_result_schedules);

		if ($Table->delete($data)) {

			if (!empty($data->image)) {
				$original = WWW_ROOT . 'uploads' . DS . 'Banner' . DS . $data->image;
				if (file_exists($original)) {
					unlink($original);
				}

				$original_thumb = WWW_ROOT . 'uploads' . DS . 'Banner/thumb' . DS . $data->image;
				if (file_exists($original_thumb)) {
					unlink($original_thumb);
				}
			}
			$this->Flash->set('The Banner has been deleted.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
		} else {
			$this->Flash->set('The Banner could not be deleted. Please, try again.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
		}
		return $this->redirect(['action' => 'index']);
	}

	public function deleteAllCompany()
	{
		$this->autoRender = false;
		$tbl = TableRegistry::get('Companies');

		if ($this->request->is(['post', 'put'])) {
			$newRecord = $this->request->getData()['comp_chk'];


			foreach ($newRecord as $tempId) {
				if ($tempId > 0) {
					$data = $tbl->get($tempId);
					$tbl->delete($data);
					if (!empty($data->image)) {
						$original = WWW_ROOT . 'uploads' . DS . 'company' . DS . $data->image;
						if (file_exists($original)) {
							unlink($original);
						}

						$original_thumb = WWW_ROOT . 'uploads' . DS . 'company/thumb' . DS . $data->image;
						if (file_exists($original_thumb)) {
							unlink($original_thumb);
						}
					}
				}
			}
			$this->Flash->set('Record deleted successfully.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
			$this->redirect(array('controller' => 'Companies', 'action' => 'index'));
		}
	}

	/**
	 * removeImageproject method
	 *
	 * @param string|null $id project id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	function removeImage()
	{
		$this->autoRender = false;
		$Table = TableRegistry::get('Banners');
		if ($this->request->is(['post', 'put'])) {
			$pageId = $this->request->getData()['id'];
			if (empty($pageId)) {
				throw new NotFoundException;
			}
			$data = $Table->get($pageId);
			$original = WWW_ROOT . 'uploads' . DS . 'Banner' . DS . $data['image'];
			$thumb = WWW_ROOT . 'uploads' . DS . 'Banner' . DS . 'thumb' . DS . $data['image'];

			if (file_exists($original)) {
				unlink($original);
			}
			if (file_exists($thumb)) {
				unlink($thumb);
			}
			$Table->updateAll(['image' => ''], ['id' => $pageId]);
			exit;
		}
	}

	public function deleteImg()
	{

		$result =  0;
		$this->autoRender = false;
		$this->viewBuilder()->setLayout(false);

		if ($this->request->is('post')) {
			$fieldName = $this->request->getData('FieldName');
			$id        = $this->request->getData('id');
		}

		$banner_image = $this->Banners->get($id);


		$removeImage = $banner_image[$fieldName];

		$original = WWW_ROOT . 'uploads' . DS . 'banner' . DS . $removeImage;

		if (file_exists($original)) {
			unlink($original);
		}
		$original_thumb = WWW_ROOT . 'uploads' . DS . 'banner/thumb' . DS . $removeImage;
		if (file_exists($original_thumb)) {
			unlink($original_thumb);
		}

		$banner_image[$fieldName] = '';

		if ($this->Banners->save($banner_image)) {
			$result =  1;
		}
		echo $result;
	}
}
