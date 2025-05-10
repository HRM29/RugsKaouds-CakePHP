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
use Cake\View\ViewBuilder;
use Cake\I18n\Date;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HeaderFooterController extends AppController
{


	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('My');
		$this->loadComponent('Cookie');
		$this->viewBuilder()->setLayout('admin');
	}

	public function manageFooter()
	{
		$HeaderFooterConfigurations = TableRegistry::getTableLocator()->get('HeaderFooter');
		$footer = $HeaderFooterConfigurations->find()->where(['type' => 'footer', 'status' => 'active'])->first();
		if (empty($footer)) {
			$footer = $HeaderFooterConfigurations->newEntity();
		}
		if ($this->request->is(['post', 'put'])) {
			$post_data = $this->request->getData();

			$mapped_data = [];
			$mapped_data = $post_data;
			$mapped_data['type'] = 'footer';
			$mapped_data['status'] = 'active';

			$footer = $HeaderFooterConfigurations->patchEntity($footer, $mapped_data);

			if (!$footer->getErrors()) {

				$imageData = $this->request->getData()['background_image'];
				if (!empty($imageData['name'])) {
					$processedImageData = $this->My->processMediaUpload($imageData, 'header_footer', 'footer-file');
					$footer->background_image = $processedImageData['file_name'];
				} else if (empty($footer->background_image) && empty($imageData['name'])) {
					$this->Flash->set('Upload a Background Image.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
					return $this->redirect(['action' => 'manageFooter']);
				}
				if ($HeaderFooterConfigurations->save($footer)) {
					$this->Flash->set('Footer configuration saved successfully.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'manageFooter']);
				}
			} else {
				$this->Flash->set($this->errorMessage($footer->getErrors()), ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
			}

			$this->Flash->error(__('Unable to save footer configuration.'));
		}

		$this->set(compact('footer'));
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
		$HeaderFooterConfigurations = TableRegistry::getTableLocator()->get('HeaderFooter');

		$footer_image = $HeaderFooterConfigurations->get($id);


		$removeImage = $footer_image[$fieldName];

		$original = WWW_ROOT . 'uploads' . DS . 'header_footer' . DS . $removeImage;

		if (file_exists($original)) {
			unlink($original);
		}

		$footer_image[$fieldName] = '';

		if ($HeaderFooterConfigurations->save($footer_image)) {
			$result =  1;
		}
		echo $result;
	}
}
