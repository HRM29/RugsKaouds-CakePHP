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

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
{


	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('My');
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
		$title = 'Orders';
		$table = TableRegistry::get('Orders');

		if ($this->request->is(['post', 'put'])) {

			//pr($this->request->data); die;
			$params = array();

			if (!empty($this->request->getData()['user_id'])) {
				$params['user_id'] = base64_encode($this->request->getData()['user_id']);
			}


			if (!empty($this->request->getData()['order_number'])) {
				$params['order_number'] = base64_encode($this->request->getData()['order_number']);
			}

			if (!empty($this->request->getData()['status_id'])) {
				$params['status_id'] = $this->request->getData()['status_id'];
			}

			$order['id'] = 'DESC';
			return $this->redirect([
				'controller' => 'Orders',
				'action' => 'index',
				'?' => $params
			]);
		} else {
			$filters = array();
			$order = array('id' => 'DESC');

			if (isset($this->request->getQuery()['user_id'])) {
				$user_id = base64_decode($this->request->getQuery()['user_id']);
				$filters['Orders.user_id'] = $user_id;
				$savesearch['user_id'] = $user_id;
			}


			if (isset($this->request->getQuery()['order_number'])) {
				$order_number = base64_decode($this->request->getQuery()['order_number']);
				$filters['Orders.id'] = $order_number;
				$savesearch['order_number'] = $order_number;
			}
			if (isset($this->request->getQuery()['status_id'])) {
				$status_id = $this->request->getQuery()['status_id'];
				if ($status_id == "start") {
					$filters['Orders.order_status'] = 0;
				} else {
					$filters['Orders.order_status'] = $status_id;
				}
				$savesearch['status_id'] = $status_id;
			}

			$data = $this->paginate($table, [
				'limit' => Configure::read('pageRecord'),
				'conditions' => [$filters],
				'contain' => ['Users'],
				'recursive' => 2,
				'order' => $order
			]);
		}

		$customer = json_decode($this->My->customerList());

		$this->set(compact('data', 'savesearch', 'title', 'customer'));
	}

	public function clearSearch($action = null)
	{
		$this->autoRender = false;
		$url = $_SERVER['HTTP_REFERER'];
		$newUrl = explode('?', $url);
		$this->redirect($newUrl[0]);
	}


	public function edit($id = null)
	{
		$table = TableRegistry::get('Orders');
		$order = $table->get(base64_decode($id), [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$user_id = $order->user_id;
			$order = $table->patchEntity($order, $this->request->getData());

			if (!$order->getErrors()) {

				if ($table->save($order)) {
					$this->Flash->set('The Order has been updated.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->set('The Order could not be updated. Please, try again.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
				}
			} else {
				$this->Flash->set('The Order could not be updated. Please, try again.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
			}
		}


		$this->set(compact('order'));
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
		$id = base64_decode($id);
		$table = TableRegistry::get('Orders');
		$orders = $table->get($id, ['contain' => ['OrderDetails']]);

		$this->set('orders', $orders);
	}


	public function delete($id = null)
	{
		$table = TableRegistry::get('Orders');
		$order = $table->get(base64_decode($id));
		if ($table->delete($order)) {
			if (!empty($order->image)) {
				$original = WWW_ROOT . 'uploads' . DS . 'orders' . DS . $order->image;
				if (file_exists($original)) {
					unlink($original);
				}

				$original_thumb = WWW_ROOT . 'uploads' . DS . 'orders/thumb' . DS . $order->image;
				if (file_exists($original_thumb)) {
					unlink($original_thumb);
				}
			}
			$this->Flash->set('The order has been deleted.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
		} else {
			$this->Flash->set('The order could not be deleted. Please, try again.', ['key' => 'positive', 'params' => ['class' => 'alert alert-danger']]);
		}
		return $this->redirect(['action' => 'index']);
	}


	/**
	 * Ceustomer List
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function customerList()
	{
		$userdata = array();
		$this->autoRender = false;
		$return_arr = array();
		if (isset($_GET['term'])) {
			$name = $_GET['term'];
		}
		$userTable = TableRegistry::get('Users');
		$userdata = $userTable->find('all', [
			'conditions' => ['Users.role_id' => 2, 'Users.full_name Like' => '%' . $name . '%'],
			//'keyField' =>'id',
			//'valueField' => 'name'
		])->limit(10)->toArray();

		$a_json = array();
		if (!empty($userdata)) {
			$a_json_row = array();
			foreach ($userdata as $key => $value) {
				$id    = $value->id;
				$name  = $value->full_name;
				$email = $value->email;
				$phone = $value->phone;


				$a_json_row["id"]    = $id;
				$a_json_row["value"] = $name . ' [' . $phone . ']';
				$a_json_row["label"] = $name . ' [' . $phone . ']';
				array_push($a_json, $a_json_row);
			}
		}

		$userdata = json_encode($a_json);
		echo $userdata;
		exit;
	}

	/**
	 * vehicle List
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */



	/**
	 * check invoice number
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */

	/* public function check_invoice_number(){
		$invoice_number = rand(rand(100000000,99999999), 999999999);
		
		$OrdersTables = TableRegistry::get('Orders');							
									
		$InvoiceData = $OrdersTables->find('all', array('conditions' => array('Orders.order_number' => $invoice_number)))->toArray();
										
	
		if(!empty($InvoiceData)){
			$this->check_invoice_number();
		}	 
		return $invoice_number;
	} */


	/**
	 * View method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	/*  public function invoice($id = null)
    {
		$id = base64_decode($id);
        $OrdersTables = TableRegistry::get('Orders');
		$OrderData = $OrdersTables->find('all')->contain(['Users','Vehicles','OrderProducts'])->where(['Orders.id'=>$id])->First();
		
		//pr($OrderData); die;
		$this->set(compact('OrderData'));
    } */


	/* public function cal_productCharges($data){
		
		//pr($data); die;
		$prod_ids = $data['product_ids'];
		$user_id = $data['user'];
		$invouce_id = $data['invouce_id'];
		
		$vehicleData =[];
		$productsTables = TableRegistry::get('Products');
		$order_products = TableRegistry::get('OrderProducts');	
			$total_product_charge = 0.00;
			foreach($prod_ids as $p_id){
				
				$productData = $productsTables->find('all', array('conditions' => array('Products.id' => $p_id,'Products.status' => 1)))->First();
				
				$product_charge = $productData->price;
				
			// order product 

				$order_product = $order_products->newEntity();
				
				$order_product->user_id    = $user_id;
				$order_product->order_id   = $invouce_id;
				$order_product->product_id = $p_id;
				$order_product->amount 	   = $product_charge;
				
				
				//pr($order_product); die;
				$order_products->save($order_product);
				
				$total_product_charge += $product_charge;
			}
			
			return $total_product_charge;
	}

	 */
}
