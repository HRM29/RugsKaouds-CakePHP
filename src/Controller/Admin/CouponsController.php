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

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CouponsController extends AppController
{


	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('Cookie');
		$this->viewBuilder()->setLayout('admin');
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
		$title = 'Coupons';
		$table = TableRegistry::get('Coupons');

		if ($this->request->is(['post', 'put'])) {
			$params = array();
			if (!empty($this->request->getData()['title'])) {
				$params['title'] = base64_encode($this->request->getData()['title']);
			}

			if (!empty($this->request->getData()['code'])) {
				$params['code'] = base64_encode($this->request->getData()['code']);
			}

			if (!empty($this->request->getData()['status_id'])) {
				$params['status_id'] = base64_encode($this->request->getData()['status_id']);
			}

			$order['id'] = 'DESC';
			return $this->redirect([
				'controller' => 'Coupons',
				'action' => 'index',
				'?' => $params
			]);
		} else {
			$filters = array();
			$order = array();
			if (isset($this->request->getQuery()['title'])) {
				$title = base64_decode($this->request->getQuery()['title']);
				$filters['title Like'] = '%' . $title . '%';
				$savesearch['title'] = $title;
			}
			if (isset($this->request->getQuery()['code'])) {
				$code = base64_decode($this->request->getQuery()['code']);
				$filters['code Like'] = '%' . $code . '%';
				$savesearch['code'] = $code;
			}
			if (isset($this->request->getQuery()['status_id'])) {
				$status_id = base64_decode($this->request->getQuery()['status_id']);
				$filters['Coupons.status'] = $status_id;
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

	public function clearSearch($action = null)
	{
		$this->autoRender = false;
		$url = $_SERVER['HTTP_REFERER'];
		$newUrl = explode('?', $url);
		$this->redirect($newUrl[0]);
	}

	/**
	 * View method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$title = "Coupons";
		$table = TableRegistry::getTableLocator()->get('Coupons');
		$data = $table->get(base64_decode($id));
		$data->from_to_date = $data->start_date . '-' . $data->valid_date;

		$this->set(compact('data', 'title'));
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$title = "Coupons";
		$table = TableRegistry::getTableLocator()->get('Coupons');
		$Coupon = $table->newEntity();
		if ($this->request->is('post')) {
			$user_id =  $this->Auth->user('id');
			$validDate  = $this->request->getData()['from_to_date'];
			$ArrDate 	= explode('-', $validDate);
			$start_date = $ArrDate[0];
			$valid_date = $ArrDate[1];

			$Coupon = $table->newEntity($this->request->getData(), ['validate' => 'default']);

			if (!$Coupon->getErrors()) {
				$Coupon->user_id 	= $user_id;
				$Coupon->start_date = date("Y-m-d", strtotime($start_date));
				$Coupon->valid_date = date("Y-m-d", strtotime($valid_date));
				$Coupon->use_count = 0;

				if ($table->save($Coupon)) {
					$this->Flash->set('The Coupon has been saved.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('The Coupon could not be saved. Please, try again.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
				}
			} else {

				$this->Flash->set($this->errorMessage($Coupon->getErrors()), ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
			}
		}
		$this->set(compact('Coupon', 'title'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$title = "Coupons";
		$table = TableRegistry::getTableLocator()->get('Coupons');
		$Coupon = $table->get(base64_decode($id));
		if ($this->request->is(['patch', 'post', 'put'])) {
			$user_id =  $this->Auth->user('id');
			$validDate  = $this->request->getData()['from_to_date'];
			$couponType  = $this->request->getData()['type'];
			$ArrDate 	= explode('-', $validDate);
			$start_date = $ArrDate[0];
			$valid_date = $ArrDate[1];

			$Coupon = $table->patchEntity($Coupon, $this->request->getData(), ['validate' => 'default']);
			if (!$Coupon->getErrors()) {
				$Coupon->user_id 	= $user_id;
				$Coupon->start_date = date("Y-m-d", strtotime($start_date));
				$Coupon->valid_date = date("Y-m-d", strtotime($valid_date));
				$Coupon->use_count = 0;

				// pr($Coupon); die;
				if ($table->save($Coupon)) {
					$this->Flash->set('The Coupon has been updated.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('The Coupon could not be updated. Please, try again.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
				}
			} else {
				$this->Flash->set($this->errorMessage($Coupon->getErrors()), ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
			}
		}
		$Coupon->from_to_date = $Coupon->start_date . '-' . $Coupon->valid_date;
		$this->set(compact('Coupon', 'title'));
	}



	/**
	 * Delete method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$table = TableRegistry::getTableLocator()->get('Coupons');
		$Coupon = $table->get(base64_decode($id));
		if ($table->delete($Coupon)) {
			$this->Flash->set('The Coupon has been deleted.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
		} else {
			$this->Flash->set('The Coupon could not be deleted. Please, try again.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
		}
		return $this->redirect(['action' => 'index']);
	}

	/**
	 * Delete All method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function deleteAllCoupons()
	{
		$this->autoRender = false;
		$tbl = TableRegistry::getTableLocator()->get('Coupons');
		$temp = $_POST['ID'];
		$newRecord = json_decode($temp);
		if (empty($temp)) {
			throw new NotFoundException;
		}

		if ($this->request->is(['post', 'put'])) {
			foreach ($newRecord as $tempId) {
				$this->delete($tempId);
			}
			echo "Record deleted successfully.";
			//$this->Flash->set('Record deleted successfully.', ['key' => 'positive','params' => ['class' => 'alert alert-success']]);                   
			exit;
		}
	}
}
