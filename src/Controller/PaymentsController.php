<?php

namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
//use Cake\Network\Email\Email;
use Cake\Controller\Component\PaginatorComponent;
use Cake\Mailer\Email;
use Cake\Mailer\TransportFactory;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PaymentsController extends AppController
{

	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['success', 'cancel']);

		$this->viewBuilder()->setLayout('front');
	}
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$action = $this->request->getParam('action');
		if (in_array($action, [''])) {
			$this->getEventManager()->off($this->Csrf);
		}
	}


	public function success()
	{
		$OrderProductsTable = TableRegistry::get('OrderDetails');

		$ProductsTable = TableRegistry::get('Products');
		$session = $this->request->getSession();
		$cartitems = $session->read('cart');
		$tr_data = $session->read('tr_id');
		$is_success = $session->read('is_success');
		$payment_status = $tr_data['status'];
		$orderstable = TableRegistry::getTableLocator()->get("Orders");

		if (!empty($tr_data) && $is_success == 1) {

			//Order Email to user -- start//
			$session = $this->request->getSession();
			$cartdta = $session->read('cart');
			/* if(!empty($cartdta)){
				$email_billing = $orderstable->find('all')->select(['billing_first_name','billing_last_name','billing_email',])->where(['id'=>$data['cm']])->First();
				
				$message = 'Thank you for order';
				$subject = 'Order Details at www.silverstarjewellery.com';
				$email = new Email();
				$email->transport('default');
				$to  = $email_billing->billing_email;
				$cc  = Configure::read("App.EmailFrom");
			
				$result = $email->setFrom('info@silverstarjewellery.com')
				->setTo($to)
				->cc($cc)
				->emailFormat('html')
				->template('orderemail')
				->viewVars(['content' => $cartdta,'getcur' => $getcur,'amount' => $datt,'order_id' => $data['cm'],'user_info' => $email_billing])
				->setSubject($subject)
				->send($message);
			} */
			$session->delete('cart');
			$session->delete('coupon');
			$session->delete('is_success');

			$ordersData = $orderstable->find()->where(['trans_id' => $tr_data['tr_id']])->first();

			$orderitems = $OrderProductsTable->find()->where(['order_id' => $ordersData->id])->contain(['products' => ['ProductImages']])->toArray();

			$totalPrice = $orderstable->find()->select(['total_price'])->where(['id' => $ordersData->id])->first();

			$this->set(compact('ordersData', 'orderitems', 'totalPrice', 'payment_status'));
		} else {
			$this->redirect(['controller' => 'products', 'action' => 'shopping']);
		}
	}
	public function cancel() {
		$this->redirect(['controller' => 'products', 'action' => 'shopping']);
	}
}
