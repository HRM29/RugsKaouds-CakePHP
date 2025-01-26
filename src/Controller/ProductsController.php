<?php

namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Mailer\TransportFactory;
use Cake\Network\Exception;
use Cake\Network\Exception\NotFoundException;
use Cake\Datasource\ConnectionManager;
use Cake\View\View;

use Cake\Routing\Router;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Mailer\Email;
use Cake\Controller\Component\PaginatorComponent;
//use Cake\Mailer\Email;







/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		//$this->loadComponent('PaypalPro');
		$this->loadComponent('SquarePayment');
		$this->Auth->allow(['index', 'getFilterParam', 'search', 'rugs', 'rugStyle', 'rugSize', 'rugColor', 'productView', 'addToCart', 'checkCartButton', 'cart', 'checkoutnew', 'deleteCart', 'updateCart', 'removeProduct', 'applyCoupon', 'searchProducts', 'itemUpdate', 'address', 'getstate', 'orderreview', 'orderPlaced', 'getstates', 'insertProductIntoDBJson', 'insertProductIntoDBXml', 'insertProductIntoDBJsonNew', 'shopping', 'addToFaviourite', 'removeFromFaviourite', 'getState', 'checkout', 'removeCoupon']);
		$this->loadComponent('Paginator');
		$this->viewBuilder()->setLayout('frontend');
	}
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$action = $this->request->getParam('action');
		if (in_array($action, ['addToCart', 'checkCartButton', 'cart'])) {
			$this->getEventManager()->off($this->Csrf);
		}
		if ($this->Auth->user('role_id') == 1) {
			$this->Auth->logout();
			return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
		}
	}

	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|void
	 */
	public function search()
	{

		$result	= [];
		$title  = '';
		if ($this->request->is(['post', 'put'])) { //die('jsk');
			$serchData = $this->request->data['search_details'];
			$params['slug']	= $this->request->getData()['search_details'];

			return $this->redirect([
				'controller' => 'Products',
				'action' => 'search',
				'?' => $params
			]);
		} else {
			$filters = [];
			$search_details = '';

			if (isset($this->request->getQuery()['slug'])) {
				$search_details	=	$this->request->getQuery()['slug'];

				$color_id = $this->checkColor($search_details);
				$style_id = $this->checkStyle($search_details);

				if ($style_id > 0 && !empty($style_id)) {
					$filters['OR'][]['Products.category_id'] = $style_id;
					$filters['OR'][]['Products.sub_category LIKE'] = "%$style_id%";
					$filters['OR'][]['Products.sub_category LIKE'] = "%,$style_id%";
					$filters['OR'][]['Products.sub_category LIKE'] = "%$style_id,%";
					$filters['OR'][]['Products.sub_category LIKE'] = "%,$style_id,%";
				}

				if ($color_id > 0 && !empty($color_id)) {
					$filters['OR'][]['Products.color_id'] = $color_id;
				}

				$filters['OR'][]['Products.sku_no LIKE'] = "%$search_details%";
				$filters['OR'][]['Products.title LIKE'] = "%$search_details%";

				$productTable	=	TableRegistry::getTableLocator()->get('Products');
				$result	=	$this->paginate($productTable, [
					'conditions' => [$filters],
					'order'		=>	['id' => 'DESC'],
					'contain'	=>	['ProductImages'],
					'limit'		=>	Configure::read('App.totalRecord')
				]);

				$savesearch['search_details']			=	$search_details;
			} else {
				return $this->redirect(['controller' => 'Users', 'action' => 'index']);
			}
		}

		$this->set(compact('result', 'title', 'savesearch'));
	}


	public function checkColor($color = null)
	{
		$c_id = 0;

		$dataArray = [];
		$colors = [];

		$colorval = explode(' ', $color);
		$colorsTable	=	TableRegistry::getTableLocator()->get('Colors');
		if (!empty($colorval)) {
			foreach ($colorval as $key => $val) {
				$filters['Colors.status'] = 1;
				$filters['OR'][]['Colors.name LIKE'] = "$val";
				/*$filters['OR'][]['Colors.name LIKE'] = "%,$val%";
    		    $filters['OR'][]['Colors.name LIKE'] = "%$val,%";
    		    $filters['OR'][]['Colors.name LIKE'] = "%,$val,%";*/


				$dataArray	=	$colorsTable->find(
					'all',
					[
						'fields' => ['id'],
						'conditions' => [$filters]
					]
				)->toArray();
			}

			if (!empty($dataArray)) {
				foreach ($dataArray as $val) {
					$colors[] = $val->id;
				}
			}
		}


		return $colors;
	}

	public function checkStyle($style = null)
	{
		// Configure::write('debug', 2);
		$dataArray = [];
		$styleval = explode(' ', $style);

		$style = [];
		$StyleTable	=	TableRegistry::getTableLocator()->get('Categories');
		if (!empty($styleval)) {
			foreach ($styleval as $key => $val) {
				$filters['OR'][]['Categories.term LIKE'] = "%$val%";
				$filters['OR'][]['Categories.term LIKE'] = "%,$val%";
				$filters['OR'][]['Categories.term LIKE'] = "%$val,%";
				$filters['OR'][]['Categories.term LIKE'] = "%,$val,%";

				$filters['Categories.status'] = 1;

				$dataArray	=	$StyleTable->find(
					'all',
					[
						'fields' => ['id'],
						'conditions' => [$filters]
					]
				)->toArray();
			}


			if (!empty($dataArray)) {
				foreach ($dataArray as $val) {
					$style[] = $val->id;
				}
			}
		}

		return $style;
	}



	public function productView($product_id = null)
	{

		$sku = base64_decode($product_id);
		$productId		=	base64_decode($product_id);
		$productDetail	=	$this->Products->find('all')->where(['sku_no' => $sku])->contain(['ProductImages'])->first();
		// echo $productDetail->seo_title;		
		// echo "<pre>";print_r($productDetail);

		$session = $this->request->getSession();
		$authUser = $session->read('Auth');

		$FavouritesTable = TableRegistry::getTableLocator()->get('Favourites');
		if (!empty($authUser['User']['id'])) {
			$user_id = $authUser['User']['id'];
			$favouriteData = $FavouritesTable->find()->where(['user_id' => $authUser['User']['id'], 'sku' => $sku])->first();
		} else {
			$user_id = 0;
			$favouriteData = "";
		}
		$ProductsTable = TableRegistry::getTableLocator()->get('Products');
		$featuredProductData = $ProductsTable->find('all')->where(['Products.is_future' => 1, 'sku_no !=' => $sku])->contain(['ProductImages'])->toArray();
		$sku_no = $productDetail->sku_no;


		$this->set('title_for_layout', $productDetail->seo_title);
		$this->set('keyword_for_layout', $productDetail->seo_keywords);
		$this->set('description_for_layout', $productDetail->seo_description);

		$this->set(compact('productDetail', 'title', 'featuredProductData', 'favouriteData', 'user_id'));

		//echo "<pre>";print_r($productDetail);die;
	}
	public function shopping()
	{
		$this->viewBuilder()->setLayout('front');
		$seoTitle = "Best Place To Get Carpet & Rugs Online in Wilton - Kaouds";
		$this->set('title_for_layout', $seoTitle);
		$filterDataOptions = $this->returnFilterDataOptions();
		if (!empty($filterDataOptions)) {
			$enabledCategories = $filterDataOptions['enabledCategories'];
			$totalCategoriesCount = $filterDataOptions['totalCategoriesCount'];
			$enabledDimentions = $filterDataOptions['enabledDimentions'];
		}

		$queryParam = $this->request->getQuery(); // Retrieve query parameters
		$conditions = []; // Initialize conditions array

		if (!empty($queryParam)) {
			$sizes = $queryParam['sizes'] ?? '';
			$prices = $queryParam['price'] ?? '';
			$sorting = $queryParam['sort'] ?? '';
			if (!empty($sizes)) {
				$sizeArray = explode('~', $sizes);
				$dimensionsTable = TableRegistry::getTableLocator()->get('Dimensions');
				$dimensionIds = $dimensionsTable->find()
					->select(['id'])
					->where(['slug IN' => $sizeArray])
					->extract('id')
					->toArray();

				if (!empty($dimensionIds)) {
					$conditions['Products.dimension_id IN'] = $dimensionIds;
				}
				$this->set('size_range', $sizeArray);
			}

			if (!empty($prices)) {
				$priceRanges = explode('~', $prices);
				$priceConditions = [];
				foreach ($priceRanges as $range) {
					if (strpos($range, '-') !== false) { // Ensure valid range format
						list($min, $max) = explode('-', $range);
						$priceConditions[] = [
							'Products.everyday_price >=' => (float)$min,
							'Products.everyday_price <=' => (float)$max,
						];
					} else {
						$priceConditions[] = [
							'Products.everyday_price >=' => (float)$range
						];
					}
				}
				if (!empty($priceConditions)) {
					$conditions['OR'] = $priceConditions;
				}
				$this->set('price_range', $priceRanges);
			}

			if ($sorting == 'latest') {
				$order['id'] = 'DESC';
			} elseif ($sorting == 'low-to-high') {
				$order['everyday_price'] = 'ASC';
			} elseif ($sorting == 'high-to-low') {
				$order['everyday_price'] = 'DESC';
			} else {
				$order['id'] = 'DESC';
			}
		}

		$filters = [
			'Products.status' => 1,
			'Products.sold_status' => 0,
		];
		$finalConditions = array_merge($conditions, $filters);


		$ProductsTable = TableRegistry::getTableLocator()->get('Products');

		$ProductData = $this->paginate($ProductsTable, [
			'limit' => Configure::read('App.pageRecord'),
			'conditions' => [$finalConditions],
			'contain' => ['ProductImages'],
			'order' => $order
		]);
		$cartItems = $this->checkCartButton();
		$this->set(compact('ProductData', 'enabledCategories', 'totalCategoriesCount', 'enabledDimentions', 'cartItems'));
	}

	public function updateRecentView()
	{
		$this->viewBuilder()->setLayout(false);
		$productId	=	$this->request->data['product_id'];
		$table		=	TableRegistry::getTableLocator()->get('RecentlyViewedProducts');
		$entity		=	$table->newEntity();
		$entity->product_id	=	$productId;
		$table->save($entity);
		exit;
	}
	//Cart Operations Start
	public function addToCart()
	{
		$this->autoRender = false;
		$ProductsTable = TableRegistry::getTableLocator()->get('Products');

		if ($this->request->is(['post', 'put'])) {
			$product_id = $this->request->getData()['product_id'];

			$productdetail = $ProductsTable->find()->select(['id', 'title', 'sku_no', 'selling_price', 'everyday_price', 'category_id', 'shipping_price'])->where(['id' => $product_id])->enableHydration(false)->first();

			$productdetail['product_qty']  = 1;
			$productdetail['sub_total'] = $productdetail['price'];
			$session = $this->request->getSession();

			if (empty($session->read('cart'))) {
				$product[] = $productdetail;
				$session->write('cart', $product);
				$cartValue = $session->read('cart');
			} else {
				$dataInsession = $session->read('cart');
				$datsession[] = $productdetail;
				$newD = array_merge($dataInsession, $datsession);
				$input = array_map("unserialize", array_unique(array_map("serialize", $newD)));
				$session->delete('cart');
				$session->write('cart', $input);
				$cartValue = $session->read('cart');
			}
			if ($session->check('coupon')) {
				$couponData = $session->read('coupon');
				$couponCode = $couponData['code'];
				$couponLogic = $this->couponLogicReturn($couponCode);
			}
			echo json_encode($cartValue);
		}
	}

	public function checkCartButton()
	{

		$session = $this->request->getSession();
		$datases = $session->read('cart');
		$productcart = array();
		if ($this->request->is(['post', 'put'])) {
			$this->autoRender = false;
			$pr_id = $this->request->getData()['pr_id'];
			if (!empty($datases)) {
				foreach ($datases as $new) {
					$productcart[] = $new['id'];
				}
				if (in_array($pr_id, $productcart)) {
					$exiting_cart = 1;
				} else {
					$exiting_cart = 0;
				}
			} else {

				$exiting_cart = 0;
			}

			print_r($exiting_cart);
		} else {
			if (!empty($datases)) {
				foreach ($datases as $new) {
					$productcart[] = $new['id'];
				}
			}
			return $productcart;
		}
	}

	public function cart()
	{
		$this->viewBuilder()->setLayout('front');
		$session = $this->request->getSession();
		$cardData = $session->read('cart');
		if (empty($cardData)) {
			return $this->redirect(Router::url('/', true));
		}
		$session = $this->request->getSession();
		$authUser = $session->read('Auth');
		$userTable = TableRegistry::getTableLocator()->get('Users');
		$userData = $userTable->find('all')->where(['id' => $authUser['User']['id']])->first();

		$paypalemail = Configure::read("App.PaypalEmailFrom");

		$countries = parent::countryLists();
		$states = parent::statesList();
		//pr($states);die;
		$this->set(compact('cardData', 'paypalemail', 'userData', 'countries', 'states'));
	}

	public function login()
	{
		$this->autoRender = false;
		$session	=	$this->request->session();
		$authUser	=	$session->read('Auth.front');
		if (!empty($authUser)) {
			return $this->redirect(['action' => 'index']);
		}
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();


			if (!empty($user)) {
				$this->Auth->setUser($user);
				return $this->redirect(['controller' => 'Products', 'action' => 'cart']);
				//return $this->redirect($this->Auth->redirectUrl());
			} else {   //die('jss');
				$this->Flash->set('Invalid username or password, try again.', ['key' => 'positivee', 'params' => ['class' => 'alert alert-danger']]);
				return $this->redirect(['controller' => 'Products', 'action' => 'cart']);
				//	$this->Flash->error('Your username or password is incorrect.');
			}
		}
	}
	/* public function checkoutnew(){
        $this->autoRender = false;	
		$userTable = TableRegistry::get('Users');
		$ProductsTable = TableRegistry::get('Products');
		$user = $userTable->newEntity();
		
		$orders = TableRegistry::get('Orders');
		$order = $orders->newEntity();
		
		if($this->request->is('ajax')){
				
			$order = $orders->patchEntity($order, $this->request->getData());
			
			$order->payment_status = 0;
			$order->order_status = 0;
			//$order->created = date("Y-m-d");
			//$order->modified = date("Y-m-d");
		
				$order->payment_method = "paypal";
				//Order save to orders table	
				
				if($last_id = $orders->save($order)->id){
				
					$OrderProducts = TableRegistry::get('orderDetails');
					
					
					$session = $this->request->getSession();
					$cartdta = $session->read('cart');
					
					$price = 0;
					$quantity = 0;
					
					$product_details = array();
					foreach($cartdta as $proSub) { 
						$OrderProduct = $OrderProducts->newEntity();
						
						$product_details['order_id'] = $last_id;
						$product_details['product_name'] = $proSub['title'];
						$product_details['product_sku'] = $proSub['sku_no'];
						$product_details['product_id'] = $proSub['id'];
						$product_details['qty'] = $proSub['product_qty'];
						$product_details['price'] = $proSub['selling_price'];
						
						$orderDetails = $OrderProducts->patchEntity($OrderProduct, $product_details);
						//Order details save to database
						$OrderProducts->save($orderDetails);
					}
					 echo $last_id;

				}else{
					 echo 0;
					
				}
			
		}			
		
	} */
	/* public function checkoutnew(){
        $this->autoRender = false;	
		$userTable = TableRegistry::get('Users');
		$ProductsTable = TableRegistry::get('Products');
		$user = $userTable->newEntity();
		
		$orders = TableRegistry::get('Orders');
		$order = $orders->newEntity();
		
		
		if($this->request->is('ajax')){
			$data = $this->request->getData();
			
			$session = $this->request->getSession();
			$shop = $session->read('cart');
			$invnum = mt_rand(100000,999999);
			$_SESSION['invnum'] = $invnum;
			###### call paypal api
			$ff = $this->PaypalPro->doDirectPayment($data,$shop); 
			 
			if($ff['ACK'] == 'Success' || $ff['ACK'] == 'SuccessWithWarning'){
				$order = $orders->patchEntity($order, $this->request->getData());
			
				$order->payment_status = 1;
				$order->order_status = 0;
				$order->trans_id = $ff['TRANSACTIONID'];
				//$order->created = date("Y-m-d");
				//$order->modified = date("Y-m-d");
		
				$order->payment_method = "Card";
				//Order save to orders table	
				
				$tr_id = array( "tr_id" => $ff['TRANSACTIONID'],"status" => $ff['ACK'] );
				
				$session->write('tr_id',$tr_id); 
				
				if($last_id = $orders->save($order)->id){
				
					$OrderProducts = TableRegistry::get('orderDetails');
					
					
					$session = $this->request->getSession();
					$cartdta = $session->read('cart');
					
					$price = 0;
					$quantity = 0;
					
					$product_details = array();
					foreach($cartdta as $proSub) { 
						$OrderProduct = $OrderProducts->newEntity();
						
						$product_details['order_id'] = $last_id;
						$product_details['product_name'] = $proSub['title'];
						$product_details['product_sku'] = $proSub['sku_no'];
						$product_details['product_id'] = $proSub['id'];
						$product_details['qty'] = $proSub['product_qty'];
						$product_details['price'] = $proSub['selling_price'];
						
						$orderDetails = $OrderProducts->patchEntity($OrderProduct, $product_details);
						//Order details save to database
						$OrderProducts->save($orderDetails);
					}
					
					$email_billing = $orders->find('all')->select(['billing_first_name','billing_last_name','billing_email',])->where(['id'=>$last_id])->First();
					
					$message = 'Thank you for your order';
					$subject = 'Order Details at www.rugsnc.com';
					$email = new Email();
					
					$email->transport('default');
					$to  = $email_billing->billing_email;
					$cc  = Configure::read("App.EmailFrom");
					if (empty($cc) || !filter_var($cc, FILTER_VALIDATE_EMAIL)) {
						$cc = 'default@example.com'; // Fallback email address
					}
				
					$result = $email->setFrom(Configure::read("App.EmailFrom"))
					->setTo($to)
					->setCc($cc)
					->emailFormat('html')
					->template('orderemail')
					->viewVars(['content' => $cartdta,'order_id' => $last_id,'user_info' => $email_billing])
					->setSubject($subject)
					->send($message);
				}
				
				echo "success";
			}else{
				echo '"'.$ff['L_LONGMESSAGE0'].'"';
				
			}
			
		}			
		
	} */

	public function checkoutnew()
	{
		$this->autoRender = false;
		$userTable = TableRegistry::getTableLocator()->get('Users');
		$ProductsTable = TableRegistry::getTableLocator()->get('Products');
		$user = $userTable->newEntity();

		$orders = TableRegistry::getTableLocator()->get('Orders');
		$order = $orders->newEntity();


		if ($this->request->is('post')) {
			$postdata = $this->request->getData();
			$session = $this->request->getSession();
			$shop = $session->read('cart');
			$invnum = mt_rand(100000, 999999);
			$_SESSION['invnum'] = $invnum;

			if (!empty($postdata)) {
				$mappedData = [];
				$mappedData['billing_first_name'] = $postdata['billing-first-name'];
				$mappedData['billing_last_name'] = $postdata['billing-last-name'];
				$mappedData['billing_phone'] = $postdata['billing-phone'];
				$mappedData['billing_email'] = $postdata['billing-email'];
				$mappedData['billing_street_address'] = $postdata['billing-address-name'];
				$mappedData['billing_city'] = $postdata['billing-city-name'];
				$mappedData['billing_state'] = $postdata['billing-states-name'];
				$mappedData['billing_country'] = $postdata['billing-country-code'];
				$mappedData['billing_zip'] = $postdata['billing-zipcode'];
				$mappedData['checkout_option'] = $postdata['checkout_option'];
				if (isset($postdata['shipping-delivery-note'])) {
					$mappedData['delivery_note'] = $postdata['shipping-delivery-note'];
				}
				if (null !== $session->read('Auth.User.id')) {
					$mappedData['user_id'] = $session->read('Auth.User.id');
				} else {
					$mappedData['user_id'] = 0;
				}

				if ($postdata['ship-to-different'] == 0) {
					$mappedData['delivery_first_name'] = $postdata['billing-first-name'];
					$mappedData['delivery_last_name'] = $postdata['billing-last-name'];
					$mappedData['delivery_phone'] = $postdata['billing-phone'];
					$mappedData['delivery_email'] = $postdata['billing-email'];
					$mappedData['delivery_street_address'] = $postdata['billing-address-name'];
					$mappedData['delivery_city'] = $postdata['billing-city-name'];
					$mappedData['delivery_state'] = $postdata['billing-states-name'];
					$mappedData['delivery_country'] = $postdata['billing-country-code'];
					$mappedData['delivery_zip'] = $postdata['billing-zipcode'];
				} else {
					$mappedData['delivery_first_name'] = $postdata['billing-first-name'];
					$mappedData['delivery_last_name'] = $postdata['billing-last-name'];
					$mappedData['delivery_phone'] = $postdata['billing-phone'];
					$mappedData['delivery_email'] = $postdata['billing-email'];
					$mappedData['delivery_street_address'] = $postdata['billing-address-name'];
					$mappedData['delivery_city'] = $postdata['billing-city-name'];
					$mappedData['delivery_state'] = $postdata['billing-states-name'];
					$mappedData['delivery_country'] = $postdata['billing-country-code'];
					$mappedData['delivery_zip'] = $postdata['billing-zipcode'];
				}
				$mappedData['date_purchased'] = date('Y-m-d H:i:s');
				$mappedData['schedule_date'] = date('Y-m-d H:i:s');
				$mappedData['created_by'] = $postdata['user_id'] ?? 0;
				$mappedData['updated_by'] = 0;
				$mappedData['reference_id'] = 0;

				$returnCartDetails = $this->returnCartDetails();
				if (!empty($returnCartDetails)) {
					$mappedData['total_qty'] = $returnCartDetails['cartQty'];
					$mappedData['sub_total'] = $returnCartDetails['cartTotal'];
					$mappedData['total_price'] = $returnCartDetails['cartGrandTotal'];
					if ($returnCartDetails['cartDiscount'] > 0) {
						$mappedData['discount_amount'] = $returnCartDetails['cartDiscount'];
						$mappedData['discount_code'] = $postdata['coupon-code'];
					}
				}

				/*
				foreach ($data['datax'] as $val) {
					if ($val['name'] != '_method' && $val['name'] != 'nds-pmd') {
						$data[$val['name']] = $val['value'];
					}
				}

				unset($data['datax']);

				$result = $this->SquarePayment->doDirectPayment($data, $shop);
				*/
				$result['status'] = 'Success';
				$result['txn_id'] = rand(100000, 999999);

				//echo "<pre>";print_r($result['status']);die;

				if ($result['status'] == 'Success') {
					$order = $orders->patchEntity($order, $mappedData);

					$order->payment_status = 1;
					$order->order_status = 0;
					$order->trans_id = $result['txn_id'];
					if ($postdata['checkout_option'] == 2) {
						$order->payment_method = "Card";
					} elseif ($postdata['checkout_option'] == 1) {
						$order->payment_method = "Paypal";
					}
					//Order save to orders table	

					$tr_id = array("tr_id" => $result['txn_id'], "status" => $result['status']);

					$session->write('tr_id', $tr_id);

					if ($last_id = $orders->save($order)->id) {

						$OrderProducts = TableRegistry::getTableLocator()->get('orderDetails');


						$session = $this->request->getSession();
						$cartdta = $session->read('cart');


						$product_details = array();
						foreach ($cartdta as $proSub) {
							$OrderProduct = $OrderProducts->newEntity();

							$product_details['order_id'] = $last_id;
							$product_details['product_name'] = $proSub['title'];
							$product_details['product_sku'] = $proSub['sku_no'];
							$product_details['product_id'] = $proSub['id'];
							$product_details['qty'] = $proSub['product_qty'];
							$product_details['price'] = $proSub['selling_price'];
							$product_details['user_id'] = $mappedData['user_id'];
							$product_details['unit'] = 'pcs';
							$product_details['size'] = '';

							$orderDetails = $OrderProducts->patchEntity($OrderProduct, $product_details);
							//Order details save to database
							$OrderProducts->save($orderDetails);


							// update product table
							//$ProductsTable->updateAll(['sold_status' => 2], ['id' => $proSub['id']]);
						}

						$email_billing = $orders->find('all')->select(['billing_first_name', 'billing_last_name', 'billing_email',])->where(['id' => $last_id])->First();

						$message = 'Thank you for your order';
						$subject = 'Order Details at Kaouds.com';
						$email = new Email();

						try {
							// Set email transport configuration
							$email->setTransport('default');

							// Recipient email
							$to = $email_billing->billing_email;
							if (empty($to) || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
								throw new \InvalidArgumentException('Invalid recipient email address');
							}

							// CC email with fallback
							$cc = 'mathharshit2916@gmail.com'; // Default fallback email
							if (!empty(Configure::read("App.EmailFrom")) && filter_var(Configure::read("App.EmailFrom"), FILTER_VALIDATE_EMAIL)) {
								$cc = 'mathharshit2916@gmail.com';
							}

							// Set email parameters
							$email->setFrom(Configure::read("App.EmailFrom"))
								->setTo($to)
								->setCc($cc)
								->setEmailFormat('html')
								->setTemplate('orderemail')
								->setViewVars([
									'content' => $cartdta,
									'order_id' => $last_id,
									'user_info' => $email_billing,
								])
								->setSubject($subject);

							// Send the email
							$result = $email->send($message);

							$response = array(
								"msg" => "Payment successfull.",
								"status" => "Success",
								'data' => $result['data'],
								"code" => 200
							);
						} catch (\InvalidArgumentException $e) {
							// Log and handle invalid email errors
							$this->log('Email sending error: ' . $e->getMessage(), 'error');
							$this->Flash->error(__('Invalid email address. Unable to send email.'));
							$response = array(
								"msg" => "Payment successfull. Failed to Send Mail.",
								"status" => "Success",
								'data' => $result['data'],
								"code" => 200
							);
						} catch (\Exception $e) {
							// Log and handle general email sending errors
							$this->log('Email sending error: ' . $e->getMessage(), 'error');
							$this->Flash->error(__('Unable to send email. Please try again later.'));
							$response = array(
								"msg" => "Payment successfull. Failed to Send Mail.",
								"status" => "Success",
								'data' => $result['data'],
								"code" => 200
							);
						}
					}
				} else {
					$response = array(
						"msg" => "Received a non-POST request",
						"status" => "Fail",
						"data" => $result['data'],
						"code" => 405
					);
				}
			} else {
				$response = array(
					"msg" => "Received a non-POST request",
					"status" => "Fail",
					"code" => 405
				);
			}

			echo json_encode($response);
			die;
		}
	}

	public function deleteCart()
	{
		$this->autoRender = false;
		if ($this->request->is(['post', 'put'])) {
			$product_id = $this->request->getData()['id'];
			$session = $this->request->getSession();
			$datases = $session->read('cart');

			foreach ($datases as $key => $new) {
				if ($new['id'] == $product_id) {
					unset($datases[$key]);
				}
			}

			$session->delete('cart');
			$session->write('cart', $datases);
			if ($session->check('coupon')) {
				$couponData = $session->read('coupon');
				$couponCode = $couponData['code'];
				$couponLogic = $this->couponLogicReturn($couponCode);
			}
		}
	}

	public function addToFaviourite()
	{
		$this->autoRender = false;
		$favouritesTable = TableRegistry::getTableLocator()->get('Favourites');
		$favourite = $favouritesTable->newEntity();
		if ($this->request->is(['post', 'put'])) {
			$user_id = $this->request->getData()['user_id'];
			$product_id = $this->request->getData()['product_id'];
			$favouriteList = $favouritesTable->find('all')->where(['user_id' => $user_id, 'product_id' => $product_id])->First();
			if ($favouriteList == "") {
				$favourite = $favouritesTable->patchEntity($favourite, $this->request->getData());
				//$product_id = $this->request->getData()['pr_id'];
				if ($favouritesTable->save($favourite)) {
					echo 1;
				} else {
					echo 0;
				}
			}
		}
	}
	public function removeFromFaviourite()
	{
		$this->autoRender = false;
		$favouritesTable = TableRegistry::getTableLocator()->get('Favourites');
		$query = $favouritesTable->query();
		$query->delete()
			->where(['sku' => $this->request->getData()['sku'], 'user_id' => $this->request->getData()['user_id']])
			->execute();
		if ($query) {
			echo 1;
		} else {
			echo 0;
		}
	}
	//Cart Operations End
	public function updateCart()
	{
		$this->viewBuilder()->setLayout(false);
		$session	=	$this->request->getSession();
		$authUser	=	$session->read('Auth');
		$responseData = [];
		$cartProducttable	=	TableRegistry::getTableLocator()->get('CartProducts');
		$producttable		=	TableRegistry::getTableLocator()->get('Products');
		if ($this->request->is(['put', 'post'])) {
			$postdata = $this->request->getData();
			$cartData = $session->read('cart');

			foreach ($postdata as $productKey => $productVal) {
				$product_id = explode('_', $productKey)[0];
				foreach ($cartData as $carKey => $cartValue) {
					if ($product_id == $cartValue['id']) {
						$cartData[$carKey]['product_qty'] = $productVal;
						$cartData[$carKey]['sub_total'] = $cartData[$carKey]['everyday_price'] * $productVal;
					}
				}
			}
			$session->delete('cart');
			$session->write('cart', $cartData);
			$subtotal = 0;
			foreach ($cartData as $carKey => $cartValue) {
				$subtotal += $cartValue['sub_total'];
			}
			$responseData['subtotal'] = $subtotal;
			if ($session->check('coupon')) {
				$couponData = $session->read('coupon');
				$couponCode = $couponData['code'];
				$couponLogic = $this->couponLogicReturn($couponCode);
			}

			return $this->response
				->withType('application/json')
				->withStringBody(json_encode($responseData));
		}
	}

	public function removeProduct()
	{
		$this->viewBuilder()->setLayout(false);
		$productId	=	$this->request->data['product_id'];
		$session	=	$this->request->getSession();
		if (!empty($session->read('Config.Cart'))) {
			$cardData	=	$session->read('Config.Cart');
			$userId = $this->Auth->user('id');
			foreach ($cardData as $key => $products) {
				if ($products->id == $productId) {
					$cart_prod_Table = TableRegistry::getTableLocator()->get('CartProducts');

					$Cartdata = $cart_prod_Table->find('all')->where(['product_id' => $productId, 'user_id' => $userId])->first();
					if (!empty($Cartdata)) {
						$cart_prod_Table->delete($Cartdata);
					}
					unset($cardData[$key]);
					break;
				}
			}
			$session->write('Config.Cart', array_values($cardData));
			$response	=	[
				'status'	=>	1,
				'count'		=>	count(array_values($cardData)),
				'message'	=>	'Product deleted successfully.'
			];
		} else {
			$response	=	[
				'status'	=>	0,
				'count'		=>	0,
				'message'	=>	'Product not deleted.'
			];
		}
		echo json_encode($response);
		exit;
	}

	public function applyCoupon()
	{
		$this->viewBuilder()->setLayout(false);
		$couponCode	=	$this->request->getData('coupon_code');
		$response = $this->couponLogicReturn($couponCode);
		echo json_encode($response);
		exit;
	}

	public function searchProducts()
	{
		if ($this->request->is(['post', 'put'])) {

			pr($this->request->getData());
			$collectionArr 	= $this->request->getData('collection');
			$sizeArr 		= $this->request->getData('size');
			$colourArr 		= $this->request->getData('color');
			$shapeArr 		= $this->request->getData('shapes');
			// get collection arry value 	
			$newColArr = [];
			foreach ($collectionArr as $key => $colVal) {
				if (!is_numeric($colVal)) {
					$newColArr[] = $colVal;
				}
			}

			// get size arry value 	
			$newsizeArr = [];
			foreach ($sizeArr as $key => $sizeVal) {
				if (!is_numeric($sizeVal)) {
					$newsizeArr[] = $sizeVal;
				}
			}

			// get colour arry value 	
			$newcolourArr = [];
			foreach ($colourArr as $key => $colourVal) {
				if (!is_numeric($colourVal)) {
					$newcolourArr[] = $colourVal;
				}
			}

			// get  shape arry value 	
			$newshapeArr = [];
			foreach ($shapeArr as $key => $shapeVal) {
				if (!is_numeric($shapeVal)) {
					$newshapeArr[] = $shapeVal;
				}
			}

			pr($newColArr);
			pr($newsizeArr);
			pr($newcolourArr);
			pr($newshapeArr);

			die;
		}
	}

	public function itemUpdate()
	{
		$this->viewBuilder()->setLayout(false);
		pr($this->request->data);
		$checkRug	=	$this->request->data['check_rug'];
		$productId	=	$this->request->data['product_id'];
		$session	=	$this->request->getSession();
		$cartData	=	$session->read('Config.Cart');
		if (!empty($cartData)) {
			foreach ($cartData as $key => $product) {
				if ($product->id == $productId) {
					$cartData[$key]->check_rug	=	$checkRug;
				}
			}
		}
		$session->write('Config.Cart', $cartData);
		exit;
	}

	public function address()
	{
		$title	=	'Checkout Process';
		$session		=	$this->request->getSession();
		if ($this->request->is(['post', 'put'])) {
			$orderArr = [];
			$order_checkout = $session->read('order_checkout');
			$CartData       = $session->read('Config.Cart');
			$ses_user		= $session->read('Auth.Front');


			$this->request->data['customer_id'] 	= $ses_user['id'];
			$this->request->data['customer_email'] 	= $ses_user['email'];
			$this->request->data['customer_name'] 	= $ses_user['first_name'] . ' ' . $ses_user['last_name'];
			$this->request->data['order_subtotal'] 	= $order_checkout['sub_total'];
			$this->request->data['order_total'] 	= $order_checkout['sub_total']; //$order_checkout['total_price'];
			$this->request->data['order_status'] 	= 1;
			$this->request->data['coupon_code'] 	= $order_checkout['coupon_code'];
			$this->request->data['coupon_price'] 	= $order_checkout['coupon_price'];
			$this->request->data['discount'] 		= $order_checkout['coupon_disount'];


			$this->request->data['delivery_name']   = $this->request->data['delivery_first_name'] . ' ' . $this->request->data['delivery_last_name'];
			$this->request->data['billing_name']    = $this->request->data['billing_first_name'] . ' ' . $this->request->data['billing_last_name'];

			$orderArr['order'] = $this->request->getData();
			$orderArr['order']['product'] = $CartData;
			$orderArr['order']['order_checkout'] = $order_checkout;

			$order_checkout = $session->write('orders', $orderArr);
			$this->redirect(['controller' => 'products', 'action' => 'orderreview']);
		}

		$country = parent::countryList();

		$states = parent::statesList();
		$this->set(compact('country', 'states', 'title'));
	}

	/* public function getstate(){
		$this->viewBuilder()->layout(false);
		$cid = $_POST['cid'];
		
		if($cid > 0){
			$statesTable	=	TableRegistry::get('States');
			$result			=	$statesTable->find('list', ['keyField' => 'id', 'valueField' => 'region_name'])->where(['country_id'=>$cid])->order(['region_name'=>'ASC'])->toArray();
		}
	
		echo json_encode($result,true);
		
		exit;
	} */

	/* public function getstates(){
		$this->viewBuilder()->layout(false);
		$cid = $_POST['cid'];
		
		if($cid > 0){
			$statesTable	=	TableRegistry::get('States');
			$result			=	$statesTable->find('list', ['keyField' => 'id', 'valueField' => 'region_name'])->where(['country_id'=>$cid])->order(['region_name'=>'ASC'])->toArray();
		}
	
	    foreach($result as $key => $name){
	        echo "<option value='$key'>$name</option>";
	    }
	   
		exit;
	} */

	public function orderreview()
	{
		$title	=	'Order Review';
		//Configure::write('debug', 2);
		$session 	  =	$this->request->getSession();
		$result  	  = $session->read('orders');
		$orders_Table = TableRegistry::getTableLocator()->get('Orders');
		$order		  =	$orders_Table->newEntity();

		//echo '<pre>'; print_r($result); die; 
		if ($this->request->is(['post', 'put'])) {
			if (!empty($result)) {
				$result['order']['order_number'] = $this->uniqOrderNumber();
				$result['order']['order_status'] = 2;
				$orderData = $orders_Table->patchEntity($order, $result['order']);


				$order_lst = $orders_Table->save($orderData);
				$order_id = $order_lst->id;
				$productArr = $result['order']['product'];
				if ($order_id > 0) {
					$order_products_Table = TableRegistry::getTableLocator()->get('OrderProducts');
					foreach ($productArr as $key => $product) {
						$productId = $product->id;
						$rug_check = $this->rugCheckAvail($result['order']['order_checkout']['rug_pad'], $productId);

						$order_product					 =	$order_products_Table->newEntity();
						$order_product->order_id 		 = $order_id;
						$order_product->product_id       = $productId;
						$order_product->product_name 	 = $product->title;
						$order_product->product_price 	 = $product->selling_price;
						$order_product->product_quantity = 1;
						$order_product->size   	    	 = $product->size;
						if ($rug_check == 1) {
							$order_product->include_pad 	 = 1;
							$order_product->pad_price   	 = $product->rug_pad;
						} else {
							$order_product->include_pad 	 = 0;
						}

						$order_products_Table->save($order_product);
					}

					$mail_respons = $this->order_mail($result, $order_id);
					$session->delete('Config.Cart');
					$session->delete('orders');
					$session->delete('order_checkout');
					//pr($session->read()); die;
					return $this->redirect(array('controller' => 'products', 'action' => 'order_placed'));
				}
			}
		}

		//echo '<pre>'; print_r($result); die;
		$this->set(compact('result', 'title'));
	}

	public function orderPlaced() {}

	public function rugCheckAvail($dataArr, $pro_id)
	{
		$result = 0;
		if (!empty($dataArr && $pro_id)) {
			foreach ($dataArr as $r_key => $rugData) {
				if ($pro_id == $r_key) {
					if ($rugData['value'] == true) {
						$result = 1;
					}
				}
			}
		}
		return $result;
	}

	public function order_mail($result, $order_id)
	{
		//Configure::write('debug', 2);

		if (!empty($result['order']['billing_email'])) {
			$cc  = $result['order']['billing_email'];
		} elseif (!empty($result['order']['delivery_email'])) {
			$cc  = $result['order']['delivery_email'];
		} else {
			$cc  = Configure::read('AdminEmail');
		}

		$message = 'Thank you for order';
		$subject = 'Order-Invoice';
		$email = new Email();
		$email->transport('default');
		$to  = Configure::read('AdminEmail');   //
		//$to  = 'nitin@mailinator.com';
		//$cc  = $result['order']['billing_email'] ? $result['order']['billing_email'] : '';
		$result = $result = $email->setFrom([Configure::read('EmailFrom')])
			->setTo($to)
			->setCc($cc)
			->emailFormat('html')
			->template('invoice')
			->viewVars(['content' => $result])
			->setSubject($subject)
			->send($message);
	}

	function orderMails()
	{

		$email = new Email('default');
		$email->setFrom(['app@mailinator.com' => 'My Site'])
			->setTo('developer.noto@gmail.com')
			->setSubject('About')
			->send('My message');
		echo '<pre>';
		print_r($email);
		echo 'hi';
		die;
	}

	public function uniqOrderNumber()
	{
		$token = mt_rand(100000, 999999);
		if (!empty($token)) {
			$token = $token;
			$OrdersTable = TableRegistry::getTableLocator()->get('Orders');
			$check_exist_ordernumber = $OrdersTable->find()->select(['id'])
				->where(['order_number' => $token])->first();

			if (!empty($check_exist_ordernumber)) {
				$this->uniqOrderNumber();
			} else {
				return $token;
			}
		} else {
			$this->uniqOrderNumber();
		}
	}

	public function rugStyle($style)
	{
		$title  = '';
		$result = [];
		$categoriesTable	=	TableRegistry::getTableLocator()->get('Categories');
		if (!empty($style)) {

			$category	=	$categoriesTable->find('all')
				->where(['term LIKE' => $style, 'status' => 1])->first();
			if (!empty($category)) {
				$collections[] = $category->id;
				$title = $category->title;

				if (!empty($collections)) {
					$filters['Products.category_id'] = $category->id;
					$new_implode = implode(",", $collections);
					$filters['Products.sub_category LIKE'] = "%$new_implode%";


					$productTable	=	TableRegistry::getTableLocator()->get('Products');
					$query = $productTable->find()
						->where([
							'OR' => [
								['category_id' => $category->id],
								['sub_category LIKE' => "%$new_implode%"],
								['sub_category LIKE' => "%,$new_implode%"],
								['sub_category LIKE' => "%,$new_implode,%"],
								['sub_category LIKE' => "%$new_implode,%"],
							],
							'Products.status' => 1,
							'Products.sold_status' => 0,

						])->contain(['ProductImages']);

					$result	= $this->paginate($query, ['limit' => Configure::read('App.pageRecord')]);
					//pr(); die;
					/* $result	=	$this->paginate($productTable, [
					    'conditions' => [$filters],
						'order'		=>	['id'=>'DESC'],
						'contain'	=>	['ProductImages'],
						'limit'		=>	Configure::read('App.totalRecord')
					]); */
				}
			}
		}

		$this->set(compact('result', 'title'));
	}

	public function rugSize($type, $size)
	{
		$title  = '';
		$result = [];
		$dimensionsTable	=	TableRegistry::getTableLocator()->get('Dimensions');
		if (!empty($type && $size)) {

			$options	=	Configure::read('size.type');
			foreach ($options as $o_key => $val) {
				if ($val == $type) {
					$op_val = $o_key;
				}
			}

			$Dimension	=	$dimensionsTable->find('all')
				->where(['slug LIKE' => $size, 'type' => $op_val, 'status' => 1])->first();

			if (!empty($Dimension)) {
				$collections = $Dimension->id;
				$title = $type . ' ' . $Dimension->title;

				if (!empty($collections)) {
					$filters['Products.dimension_id'] = $collections;
					$productTable	=	TableRegistry::getTableLocator()->get('Products');
					$filters['Products.status'] = 1;
					$filters['Products.sold_status'] = 0;
					$result	=	$this->paginate($productTable, [
						'conditions' => [$filters],
						'order'		=>	['id' => 'DESC'],
						'contain'	=>	['ProductImages'],
						'limit'		=>	Configure::read('App.totalRecord')
					]);
				}
			}
		}
		$this->set(compact('result', 'title'));
	}

	public function rugColor($color)
	{
		$title  = '';
		$result = [];
		$colorsTable	=	TableRegistry::getTableLocator()->get('Colors');
		if (!empty($color)) {

			$Color	=	$colorsTable->find('all')
				->where(['slug LIKE' => $color, 'status' => 1])->first();
			if (!empty($Color)) {
				$collections = $Color->id;
				$title = $Color->name;

				if (!empty($collections)) {
					$filters['Products.color_id'] = $collections;
					$productTable	=	TableRegistry::getTableLocator()->get('Products');
					$filters['Products.status'] = 1;
					$filters['Products.sold_status'] = 0;
					$result	=	$this->paginate($productTable, [
						'conditions' => [$filters],
						'order'		=>	['id' => 'DESC'],
						'contain'	=>	['ProductImages'],
						'limit'		=>	Configure::read('App.totalRecord')
					]);
				}
			}
		}
		$this->set(compact('result', 'title'));
	}

	public function getFilterParam()
	{

		$this->autoRender = false;
		$urlParam = '';
		$data = $this->request->data;
		if (!empty($data)) {
			$result = [];
			if (!empty($data['collections'])) {
				foreach ($data['collections'] as $key => $dataVal) {
					if ($dataVal != '0') {
						$result['collection'][] = $dataVal;
					}
				}
			}
			if (!empty($data['size'])) {
				foreach ($data['size'] as $key => $dataVal) {
					if ($dataVal != '0') {
						$result['size'][] = $dataVal;
					}
				}
			}
			if (!empty($data['speceialSize'])) {
				$result['size'][] = $data['speceialSize'];
			}
			if (!empty($data['color'])) {
				foreach ($data['color'] as $key => $dataVal) {
					if ($dataVal != '0') {
						$result['color'][] = $dataVal;
					}
				}
			}

			if (!empty($data['price'])) {
				foreach ($data['price'] as $key => $dataVal) {
					if ($dataVal != '0') {
						$result['price'][] = $dataVal;
					}
				}
			}

			if (!empty($data['price_sort'])) {
				foreach ($data['price_sort'] as $key => $dataVal) {
					if ($dataVal != '0') {
						$result['price_sort'][] = $dataVal;
					}
				}
			}
			if (!empty($data['style'])) {
				foreach ($data['style'] as $key => $dataVal) {
					if ($dataVal != '0') {
						$result['style'][] = $dataVal;
					}
				}
			}

			if (!empty($data['search_details'])) {
				$result['slug'][] = $data['search_details'];
			}

			if (!empty($data['price_min']) && !empty($data['price_max'])) {
				$result['price'][] = $data['price_min'] . '-' . $data['price_max'];
			}
			if (!empty($data['pattern'])) {
				foreach ($data['pattern'] as $key => $dataVal) {
					if ($dataVal != '0') {
						$result['pattern'][] = $dataVal;
					}
				}
			}
			if (!empty($data['design'])) {
				foreach ($data['design'] as $key => $dataVal) {
					if ($dataVal != '0') {
						$result['design'][] = $dataVal;
					}
				}
			}
			if (!empty($data['material'])) {
				foreach ($data['material'] as $key => $dataVal) {
					if ($dataVal != '0') {
						$result['material'][] = $dataVal;
					}
				}
			}
			if (!empty($data['constr'])) {
				foreach ($data['constr'] as $key => $dataVal) {
					if ($dataVal != '0') {
						$result['constr'][] = $dataVal;
					}
				}
			}

			if (!empty($result)) {
				$arr = [];
				foreach ($result as $rkey => $Data) {
					$arr['key'][] = $rkey;
					$arr['value'][] = implode('~', $Data);
				}
				if (!empty($arr)) {
					$keyString = implode(',', $arr['key']);
					$valueString = implode(',', $arr['value']);

					if ($keyString != '' && $valueString != '') {
						$urlParam =  $valueString . '/' . $keyString;
					}
				}
			}
		}
		echo $urlParam;
		exit;
	}

	function flatten(array $array)
	{
		$return = array();
		array_walk_recursive($array, function ($a) use (&$return) {
			$return[] = $a;
		});
		return $return;
	}

	public function rugs($categorySlug = null)
	{
		$categoriesTable	=	TableRegistry::getTableLocator()->get('Categories');
		$dimensionsTable	=	TableRegistry::getTableLocator()->get('Dimensions');
		$colorsTable	=	TableRegistry::getTableLocator()->get('Colors');

		$this->viewBuilder()->setLayout('front');
		$arrParms = array();
		$title = '';
		$filterDataOptions = $this->returnFilterDataOptions();

		if (!empty($categorySlug)) {
			$queryParam = $this->request->getQuery(); // Retrieve query parameters
			$conditions = []; // Initialize conditions array

			if (!empty($queryParam)) {
				// Extract sizes and prices
				$sizes = $queryParam['sizes'] ?? '';
				$prices = $queryParam['price'] ?? '';
				$sorting = $queryParam['sort'] ?? '';

				// Parse sizes into an array
				if (!empty($sizes)) {
					$sizeArray = explode('~', $sizes);
					$conditions['Products.dimension_id IN'] = $sizeArray;
					$this->set('size_range', $sizeArray);
				}

				// Parse price ranges into conditions
				if (!empty($prices)) {
					$priceRanges = explode('~', $prices);
					$priceConditions = [];
					foreach ($priceRanges as $range) {
						if (strpos($range, '-') !== false) { // Ensure valid range format
							list($min, $max) = explode('-', $range);
							$priceConditions[] = [
								'Products.everyday_price >=' => (float)$min,
								'Products.everyday_price <=' => (float)$max,
							];
						} else {
							$priceConditions[] = [
								'Products.everyday_price >=' => (float)$range
							];
						}
					}
					if (!empty($priceConditions)) {
						$conditions['OR'] = $priceConditions;
					}
					$this->set('price_range', $priceRanges);
				}

				if ($sorting == 'latest') {
					$order['Products.id'] = 'DESC';
				} elseif ($sorting == 'low-to-high') {
					$order['Products.everyday_price'] = 'ASC';
				} elseif ($sorting == 'high-to-low') {
					$order['Products.everyday_price'] = 'DESC';
				} else {
					$order['Products.id'] = 'DESC';
				}
			}

			// Additional filters
			$filters = [
				'Products.status' => 1,
				'Products.sold_status' => 0,
				'Categories.page_link' => $categorySlug,
			];

			// Merge additional filters with conditions
			$finalConditions = array_merge($conditions, $filters);

			// Fetch Products table
			$productTable = TableRegistry::getTableLocator()->get('Products');

			// Fetch paginated results
			$result = $this->paginate($productTable, [
				'conditions' => $finalConditions,
				'order' => $order,
				'contain' => ['ProductImages', 'Categories'],
				'limit' => Configure::read('App.pageRecord')
			]);
			if (!empty($filterDataOptions)) {
				$enabledCategories = $filterDataOptions['enabledCategories'];
				$totalCategoriesCount = $filterDataOptions['totalCategoriesCount'];
				$enabledDimentions = $filterDataOptions['enabledDimentions'];
				$this->set(compact('enabledCategories', 'totalCategoriesCount', 'enabledDimentions'));
			}
			if (!empty($enabledCategories)) {
				foreach ($enabledCategories as $categoriesData) {
					if ($categoriesData['page_link'] == $categorySlug) {
						$title = $categoriesData['title'];
					}
				}
			}
			$valueArr = $this->flatten($arrParms);
			$cartItems = $this->checkCartButton();
			$this->set(compact('result', 'title', 'valueArr', 'cartItems'));
		} else {
			return $this->redirect(array('controller' => 'Products', 'action' => 'shopping'));
		}
	}


	public function insertProductIntoDBJson()
	{

		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 3000); //3000 seconds = 50 minutes

		$start_date = date('Y-m-d', strtotime("-2 days"));
		$end_date = date("Y-m-d");

		$context =	stream_context_create(array('https' => array('header' => 'Accept: application/json')));
		$url	=	'https://shrugs.com/suppliers/orcFeed/json/' . $start_date . '/' . $end_date;
		//$url	=	'https://shrugs.com/suppliers/orcFeed/json';
		$str	=	file_get_contents($url, false, $context);

		$json = json_decode($str, true); // decode the JSON into an associative array

		//echo '<pre>' . print_r($json, true) . '</pre>';die;

		$productTable	=	TableRegistry::getTableLocator()->get('Products');
		$productImagesTable	=	TableRegistry::getTableLocator()->get('ProductImages');
		$categoryTable	=	TableRegistry::getTableLocator()->get('Categories');
		$saveData	=	[];
		$error	=	[];
		$skus	=	[];
		// echo "<pre>";
		// print_r($json); die('printing top json');

		if (!empty($json)) {
			$counter = 0;
			foreach ($json as $data) {
				$counter++;
				if ($data['category'] > 0 && !empty($data['category'])) {

					if ($data['category'] == 82 || strstr($data['subcategory'], "82")) {
						$price = 0;
					} else {
						$price = $data['price'] * 3;
					}


					$orc_price = $data['price'] - $price;


					//$category		=	$categoryTable->get($data['category']);
					// echo "<pre>";print_r($category);
					// die('gdfgddfg'); 

					$skuNo			=	str_replace('sh', '', strtolower($data['sku']));
					$newSkuNo		=	'GOR' . ($skuNo * 7);
					$rugImperialSize = $data['rug_dimension_1_feet'] . "'" . $data['rug_dimension_1_inches'] . '" x ' . $data['rug_dimension_2_feet'] . "'" . $data['rug_dimension_2_inches'] . '"';
					$productName	=	$data['style'] . ' ' . $data['overstock_material'] . " " . $data['overstock_weavetype'] . ' Area Rug ' . $rugImperialSize;
					// $sellingPrice	=	3.2 * $orc_price;
					$checksku  = '';
					//$checksku  = $this->checkAvailSku($newSkuNo);


					$Productdata = $productTable->find('all')->where(['sku_no' => $newSkuNo])->first();
					if (!empty($Productdata)) {
						$checksku = $Productdata->id;
						// echo "<br>";
					}

					if (!empty($checksku) && $checksku > 0) {
						//$saveData['id']				=	$checksku;
						$entity			=	$productTable->get($checksku);
					} else {
						$entity			=	$productTable->newEntity();
					}
					//$entity			=	$productTable->newEntity();

					$saveData['size']				=	$data['OddSize'];
					$saveData['sku_no']				=	$newSkuNo;
					$saveData['title']				=	$productName;
					$saveData['rug_type']			=	$data['type'];
					$saveData['age']				=	$data['age'];


					if ($data['general_dimensions'] == 20)
						$saveData['dimension_id'] = $data['product_sub_dimension'];
					else
						$saveData['dimension_id'] = $data['general_dimensions'];

					$saveData['dimension_1_feet']	=	$data['rug_dimension_1_feet'];
					$saveData['dimension_1_inches']	=	$data['rug_dimension_1_inches'];
					$saveData['dimension_2_feet']	=	$data['rug_dimension_2_feet'];
					$saveData['dimension_2_inches']	=	$data['rug_dimension_2_inches'];
					$saveData['selling_price']		=	round($data['price'] * 3);
					$saveData['everyday_price']		=	round($data['price'] * 4);
					$saveData['rug_pad']			=	$data['rug_pad'];
					$saveData['total_square_ft']	=	$data['total_square_ft'];
					$saveData['shipping_price']		=	$data['shipping_price'];
					$saveData['color_id']			=	$data['field_color'];
					$saveData['border_color']		=	$data['border_color'];
					$saveData['other_colors']		=	$data['other_colors'];
					$saveData['foundation_id']		=	$data['foundation'];
					$saveData['pile_id']			=	$data['pile'];
					//	$saveData['dimension_id']		=	$data['general_dimensions'];
					$saveData['category_id']		=	$data['category'];
					$saveData['sub_category']		=	$data['subcategory'];
					$saveData['style']				=	$data['style'];
					$saveData['available_shape']	=	$data['available_shape'];
					$saveData['available_sizes']	=	$data['available_sizes'];
					$saveData['overstock_style']	=	$data['overstock_style'];
					$saveData['overstock_origin']	=	$data['overstock_origin'];
					$saveData['overstock_weavetype'] =	$data['overstock_weavetype'];
					$saveData['vendor_rn']			=	strtolower($data['sku']);
					$saveData['pattern']			=	$data['overstock_pattern'];
					$saveData['rug_design']			=	$data['ebay_regional_design'];
					$saveData['material']			=	$data['overstock_material'];
					$saveData['field_color_exact']	=	$data['product_rugfield_color']; //$this->rugColor($data['product_rugfield_color']);  
					$saveData['location']			=	"Wilmington, NC";

					$saveData['status']				=	$data['status'];
					$saveData['sold_status']		=	$data['sold_status'];
					$saveData['product_images']		=	[];







					$newdata   = $productTable->patchEntity($entity, $saveData);


					if ($counter == 200) {
						sleep(10);
						$counter = 0;
					}



					if ($productData = $productTable->save($newdata)) {

						if (!empty($data['pictures'])) {
							$productImagesTable->deleteAll(array('product_id' => $productData->id));
							foreach ($data['pictures'] as $pictures) {
								$imageentity = $productImagesTable->newEntity();
								$imageentity->product_id = $productData->id;
								$imageentity->image = $pictures;
								// $saveData['product_images'][]['image_url']	=	$pictures;
								$images = $productImagesTable->save($imageentity);
							}
						}

						$skus[] = $saveData['sku_no'];
					} else {
					}
				}

				// echo "<pre>";
				// print_r($saveData);
				// die(" CP1 ");

			} // closing for loop

			// start  : email 


			date_default_timezone_set("Asia/Calcutta");


			$message        =   'Rugsnc Cron Executed on ' . date_default_timezone_get() . " is " . date("d/m/Y H:i:s");
			$subject        =    'Rugsnc Cron Executed on ' . date_default_timezone_get() . " is " . date("d/m/Y H:i:s");
			$email          =   new Email();
			$email->transport('default');
			$to             =   "vipin2vipin@gmail.com";

			//echo Configure::read('EmailFrom'); die(" this is to");
			$results = $email->setFrom(['info@rugsnc.com' => 'Gallery Of Oriental Rugs'])
				->setTo($to)
				->setSubject($subject)
				->send($message);
			// end   : email 



		}
		// 
		echo "<pre>";
		print_r($skus);
		exit();
	}

	public function insertProductIntoDBJsonNew()
	{

		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 3000); //3000 seconds = 50 minutes

		$start_date = date('Y-m-d', strtotime("-2 days"));
		$end_date = date("Y-m-d");

		$context =	stream_context_create(array('https' => array('header' => 'Accept: application/json')));
		//$url	=	'https://shrugs.com/suppliers/orcFeed/json/'.$start_date.'/'.$end_date;
		$url	=	'https://shrugs.com/suppliers/orcFeed/json';
		$str	=	file_get_contents($url, false, $context);

		$json = json_decode($str, true); // decode the JSON into an associative array

		//echo '<pre>' . print_r($json, true) . '</pre>';die;

		$productTable	=	TableRegistry::getTableLocator()->get('Products');
		$categoryTable	=	TableRegistry::getTableLocator()->get('Categories');
		$saveData	=	[];
		$error	=	[];
		$skus	=	[];
		/* echo "<pre>";
		print_r($json);
		die('gdfgddfg'); */
		if (!empty($json)) {
			$counter = 0;
			foreach ($json as $data) {

				$arr = array('sh51524', 'sh51411', 'sh51407', 'sh51405', 'sh51008', 'sh51611', 'sh51593', 'sh50881', 'sh50877', 'sh45899', 'sh50695', 'sh51540', 'sh51241', 'sh50421', 'sh50423', 'sh51648', 'sh50391', 'sh50367', 'sh50370', 'sh50214', 'sh51585', 'sh51575', 'sh51545', 'sh50144', 'sh50142', 'sh51449', 'sh51707', 'sh51682', 'sh51696', 'sh51543', 'sh51539', 'sh51541');
				if (in_array($data['sku'], $arr)) {
					//echo $data['sku']."<br />";die("ggg");
					$counter++;
					if ($data['category'] > 0 && !empty($data['category'])) {

						//echo $data['store_price'] . "---".$data['sku']."<br>" ;
						$store_price  = round($data['store_price'], 2);
						$price  = $store_price;


						if ($data['category'] == 82 || strstr($data['subcategory'], "82")) {
							//$price = $store_price;    //commented in 29 april 2024
							$price = $price;
						} else {
							//$price = $store_price - ($store_price * 0.3);      //commented in 29 april 2024
							$price = round($price - ($price * 0.3));
						}





						//	$orc_price = $data['price'] - $price;
						//echo $data['category'];

						$category		=	$categoryTable->get($data['category']);
						//pr($category);
						$skuNo			=	str_replace('sh', '', strtolower($data['sku']));
						$newSkuNo		=	'GOR' . ($skuNo * SKUNO);
						$productName	=	(!empty($category->title) ? $category->title : ' ') . 'Rugs ' . $newSkuNo;
						$sellingPrice	=	$price;
						//echo $data['price']." ".$newSkuNo."<br />"; round($price * 2.5);
						$checksku  = '';
						//$checksku  = $this->checkAvailSku($newSkuNo);


						$Productdata = $productTable->find('all')->where(['sku_no' => $newSkuNo])->first();
						if (!empty($Productdata)) {
							echo $checksku = $Productdata->id;
							echo "<br>";
						}

						if (!empty($checksku) && $checksku > 0) {
							//$saveData['id']				=	$checksku;
							$entity			=	$productTable->get($checksku);
						} else {
							$entity			=	$productTable->newEntity();
						}
						//$entity			=	$productTable->newEntity();

						$saveData['size']				=	$data['OddSize'];
						$saveData['sku_no']				=	$newSkuNo;
						$saveData['title']				=	$productName;
						$saveData['rug_type']			=	$data['type'];
						$saveData['age']				=	$data['age'];
						$saveData['status']				=	$data['status'];
						$saveData['sold_status']		=	$data['sold_status'];
						$saveData['dimension_1_feet']	=	$data['rug_dimension_1_feet'];
						$saveData['dimension_1_inches']	=	$data['rug_dimension_1_inches'];
						$saveData['dimension_2_feet']	=	$data['rug_dimension_2_feet'];
						$saveData['dimension_2_inches']	=	$data['rug_dimension_2_inches'];
						$saveData['selling_price']		=	round($price * 2.5);;
						$saveData['everyday_price']		=	round($price * 4);
						$saveData['rug_pad']			=	$data['rug_pad'];
						$saveData['total_square_ft']	=	$data['total_square_ft'];
						$saveData['shipping_price']		=	$data['shipping_price'];
						$saveData['color_id']			=	$data['field_color'];
						$saveData['border_color']		=	$data['border_color'];
						$saveData['other_colors']		=	$data['other_colors'];
						$saveData['foundation_id']		=	$data['foundation'];
						$saveData['pile_id']			=	$data['pile'];
						$saveData['dimension_id']		=	$data['general_dimensions'];
						$saveData['category_id']		=	$data['category'];
						$saveData['sub_category']		=	$data['subcategory'];
						$saveData['style']				=	$data['style'];
						$saveData['available_shape']	=	$data['available_shape'];
						$saveData['available_sizes']	=	$data['available_sizes'];
						$saveData['overstock_style']	=	$data['overstock_style'];
						$saveData['overstock_origin']	=	$data['overstock_origin'];
						$saveData['product_images']		=	[];

						/* if(!empty($data['pictures'])) {
							foreach($data['pictures'] as $pictures) {
								$saveData['product_images'][]['image_url']	=	$pictures;
							}
						} */




						$newdata   = $productTable->patchEntity($entity, $saveData);
						//pr($newdata);
						//echo "<pre>";print_r($newdata);
						if ($counter == 200) {
							sleep(10);
							$counter = 0;
						}

						if ($productTable->save($newdata)) {
							$skus[] = $saveData['sku_no'];
						} else {
						}
					}
				}
			}
		}
		// 
		echo "<pre>";
		print_r($skus);
		exit();
	}

	public function checkAvailSku($newSkuNo = null)
	{
		$p_id = '';
		$prod_Table = TableRegistry::getTableLocator()->get('Products');
		$Productdata = $prod_Table->find('all')->where(['sku_no' => $newSkuNo])->first();
		if (!empty($Productdata)) {
			$p_id = $Productdata->id;
		}

		return $p_id;
	}

	public function insertProductIntoDBXml()
	{
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 3000); //3000 seconds = 50 minutes
		// $get	=	file_get_contents('product_data.xml');
		// $arr	=	simplexml_load_string($get, null, LIBXML_NOCDATA);
		// $arr	=	simplexml_load_file("product_data.xml", null, LIBXML_NOCDATA );

		$context =	stream_context_create(array('https' => array('header' => 'Accept: application/xml')));
		$url	=	'https://shrugs.com/suppliers/orcFeed/xml/';
		$xml	=	file_get_contents($url, false, $context);
		$xml	=	simplexml_load_string($xml, null, LIBXML_NOCDATA);

		$productTable	=	TableRegistry::getTableLocator()->get('Products');
		$categoryTable	=	TableRegistry::getTableLocator()->get('Categories');
		$saveData	=	[];

		if (!empty($xml->rug)) {

			foreach ($xml->rug as $data) {
				if ($data->category > 0 && !empty($data->category)) {


					if ($data['category'] == 82 || strstr($data['subcategory'], "82")) {
						$price = 0;
					} else {
						$price = $data->price * 0.3;
					}


					$orc_price = $data->price - $price;

					$category		=	$categoryTable->get($data->category);

					$skuNo			=	str_replace('sh', '', strtolower($data->sku));
					$newSkuNo		=	'ORC' . ($skuNo * SKUNO);
					$productName	=	(!empty($category->title) ? $category->title : '') . ' Rugs ' . $newSkuNo;
					$sellingPrice	=	3.2 * $orc_price;

					$checksku  = '';
					$checksku  = $this->checkAvailSku($newSkuNo);

					if (!empty($checksku) && $checksku > 0) {
						//$saveData['id']				=	$checksku;
						$entity			=	$productTable->get($checksku);
					} else {
						$entity			=	$productTable->newEntity();
					}
					//$entity			=	$productTable->newEntity();

					$saveData['size']				=	$data->OddSize;
					$saveData['sku_no']				=	$newSkuNo;
					$saveData['title']				=	$productName;
					$saveData['rug_type']			=	$data->type;
					$saveData['age']				=	$data->age;
					$saveData['status']				=	(string) $data->status;
					$saveData['sold_status']		=	(string) $data->sold_status;
					$saveData['dimension_1_feet']	=	(int) $data->rug_dimension_1_feet;
					$saveData['dimension_1_inches']	=	(int) $data->rug_dimension_1_inches;
					$saveData['dimension_2_feet']	=	(int) $data->rug_dimension_2_feet;
					$saveData['dimension_2_inches']	=	(int) $data->rug_dimension_2_inches;
					$saveData['selling_price']		=	$sellingPrice;
					$saveData['everyday_price']		=	$sellingPrice / 0.4;
					$saveData['rug_pad']			=	$data->rug_pad;
					$saveData['total_square_ft']	=	$data->total_square_ft;
					$saveData['shipping_price']		=	$data->shipping_price;
					$saveData['color_id']			=	(int) $data->field_color;
					$saveData['border_color']		=	$data->border_color;
					$saveData['other_colors']		=	$data->other_colors;
					$saveData['foundation_id']		=	(int) $data->foundation;
					$saveData['pile_id']			=	(int) $data->pile;
					$saveData['dimension_id']		=	(int) $data->general_dimensions;
					$saveData['category_id']		=	(int) $data->category;
					$saveData['sub_category']		=	$data->subcategory;
					$saveData['style']				=	$data->style;
					$saveData['available_shape']	=	$data->available_shape;
					$saveData['available_sizes']	=	$data->available_sizes;
					$saveData['overstock_style']	=	$data->overstock_style;
					$saveData['overstock_origin']	=	$data->overstock_origin;
					$saveData['product_images']		=	[];

					/*if(!empty($data->pictures->picture)) {
						foreach($data->pictures->picture as $pictures) {
							$saveData['product_images'][]['image_url']	=	$pictures->large;
						}
					}*/




					$newdata   = $productTable->patchEntity($entity, $saveData);



					$productTable->save($newdata);
				}
			}
		}
		// 
		$this->Flash->set('Products data imported Successfully.', ['key' => 'positive', 'params' => ['class' => 'alert alert-success']]);
		return $this->redirect(['controller' => 'users', 'action' => 'index']);
	}


	public function getState()
	{
		$this->viewBuilder()->setLayout(false);
		if ($this->request->is(['post', 'put'])) {
			$country = $this->request->getData()['country'];
			$targetDiv = $this->request->getData()['targetDiv'];
			$Table = TableRegistry::getTableLocator()->get('States');
			$query = $Table->find('list', [
				'keyField' => 'id',
				'valueField' => 'state'
			])->where(['ccode_id' => $country])->order(['state' => 'ASC']);
			$states = $query->toArray();



			$this->set(compact('states', 'targetDiv'));
		}
	}

	private function returnFilterDataOptions()
	{
		$returnArr = ['enabledDimentions' => [], 'enabledCategories' => [], 'totalCategories' => []];

		$CategoryTable = TableRegistry::getTableLocator()->get('Categories');
		$DimensionsTable = TableRegistry::getTableLocator()->get('Dimensions');
		$CategoryQuery = $CategoryTable->find()
			->innerJoinWith('Products', function ($q) {
				return $q->where(['Products.status' => 1]);
			})
			->distinct(['Categories.id']) // Ensure unique categories
			->select(['Categories.id', 'Categories.title', 'Categories.page_link', 'total_products' => $CategoryTable->find()->func()->count('Products.id')])
			->group(['Categories.id', 'Categories.name'])
			->where(['Categories.status' => 1])
			->order(['Categories.title']);

		$enabledCategories = $CategoryQuery->enableHydration(false)->all();
		$returnArr['enabledCategories'] = $enabledCategories;
		$totalCategoriesCount = $CategoryTable->find()
			->innerJoinWith('Products', function ($q) {
				return $q->where(['Products.status' => 1]); // Condition for products status
			})
			->where(['Categories.status' => 1]) // Condition for categories status
			->select(['total' => $CategoryTable->find()->func()->count('Products.id')]) // Count all products
			->first()
			->total;
		$returnArr['totalCategoriesCount'] = $totalCategoriesCount;

		$DimensionsQuery = $DimensionsTable->find()
			->innerJoinWith('Products', function ($q) {
				return $q->where(['Products.status' => 1]);
			})
			->select([
				'Dimensions.slug',
				'id' => 'MAX(Dimensions.id)',
				'title' => 'MAX(Dimensions.title)',
				'type' => 'MAX(Dimensions.type)'
			])
			->where(['Dimensions.status' => 1])
			->group(['Dimensions.slug'])
			->order(['MAX(Dimensions.title)']);

		$enabledDimentions = $DimensionsQuery->enableHydration(false)->all();
		$returnArr['enabledDimentions'] = $enabledDimentions;

		return $returnArr;
	}

	public function checkout()
	{
		$this->viewBuilder()->setLayout('front');
		$session = $this->request->getSession();
		$cardData = $session->read('cart');
		if (empty($cardData)) {
			return $this->redirect(Router::url('/', true));
		}
		if ($session->check('Auth.User')) {
			$authUser = $session->read('Auth.User');
			$userTable = TableRegistry::getTableLocator()->get('Users');
			$userData = $userTable->find()
				->select(['Users.id', 'Users.role_id', 'Users.first_name', 'Users.last_name', 'Users.email', 'Users.phone', 'UserDetails.company', 'UserDetails.address', 'UserDetails.country', 'UserDetails.state', 'UserDetails.city', 'UserDetails.postal_code'])
				->contain(['UserDetails'])
				->where(['Users.id' => $authUser['id']])
				->first();
			$this->set(compact('userData'));
		}
		$countries = parent::countryLists();
		$states = parent::statesList();
		$newsletterData = $this->returnNewsletterData();
		$this->set(compact('countries', 'states', 'newsletterData', 'cardData'));
	}

	private function returnNewsletterData()
	{
		$newsletterTable = TableRegistry::getTableLocator()->get('ContactNewsletter');
		$newsletterData = $newsletterTable->find('list', [
			'keyField' => 'id',
			'valueField' => 'email'
		])
			->where(['ContactNewsletter.status' => 1, 'ContactNewsletter.type' => 'newsletter'])
			->enableHydration(false)
			->toArray();
		return $newsletterData;
	}

	private function updateCartDiscount($couponData)
	{
		$session = $this->request->getSession();
		$cartData = $session->read('cart');
		$returnArr = ['discount' => 0];

		if (!empty($cartData)) {
			$total_quanty = 0;
			$total_price = 0;
			foreach ($cartData as $item) {
				$total_quanty += $item['product_qty'];
				$total_price += round($item['everyday_price'] * $item['product_qty'], 2);
			}
			if ($couponData['type'] == '2') {
				$discount = ($couponData['discount'] / 100) * $total_price;
			} else {
				$discount = $couponData['discount'];
			}
			$total_price = $total_price - $discount;
			$returnArr = ['discount' => $discount, 'total_price' => $total_price];
		}
		return $returnArr;
	}
	public function removeCoupon()
	{
		$this->viewBuilder()->setLayout(false);
		$session = $this->request->getSession();
		if ($session->check('coupon')) {
			$session->delete('coupon');
			$response = [
				'status' => 1,
				'message' => 'Coupon code removed successfully.'
			];
		} else {
			$response = [
				'status' => 0,
				'message' => 'No coupon code found.'
			];
		}
		echo json_encode($response);
		exit;
	}

	private function couponLogicReturn($couponCode)
	{
		$couponTable =	TableRegistry::getTableLocator()->get('Coupons');
		$curentDate	=	date('Y-m-d');
		$result		=	$couponTable->find('all')
			->where(['code LIKE' => $couponCode, 'status' => ACTIVE, 'start_date <=' => $curentDate, 'valid_date >=' => $curentDate, 'use_count < redemption'])->first();

		if (!empty($result)) {
			$session = $this->request->getSession();
			$cartData = $session->read('cart');
			$discount = 0;

			$cartDiscount = $this->updateCartDiscount($result->toArray());

			if (!empty($cartDiscount) && $cartDiscount['discount'] > 0) {
				$session->delete('coupon');
				$discount = $cartDiscount['discount'];
				$discountData = [
					'code' => $couponCode,
					'cart_discount' => $discount,
					'discount_type' => $result->type == 2 ? 'percentage' : 'fixed',
					'discount_value' => $result->discount,
					'coupon_id' => $result->id
				];
				$session->write('coupon', $discountData);
			}

			$response	=	[
				'status'	=>	1,
				'message'	=>	'Coupon code applied successfully.',
				'data'		=>	$discountData
			];
		} else {
			$response	=	[
				'status'	=>	0,
				'message'	=>	'Invalid coupon code.',
				'data'		=>	''
			];
		}

		return $response;
	}

	private function returnCartDetails()
	{
		$session = $this->request->getSession();
		$cartData = $session->read('cart');
		$cartTotal = 0;
		$cartQty = 0;
		$cartDiscount = 0;
		$cartSubTotal = 0;
		$cartShipping = 0;
		$cartTax = 0;
		$cartGrandTotal = 0;
		$cartDiscountData = $session->read('coupon');
		if (!empty($cartData)) {
			foreach ($cartData as $item) {
				$cartQty += $item['product_qty'];
				$cartTotal += round($item['everyday_price'] * $item['product_qty'], 2);
			}
			if (!empty($cartDiscountData)) {
				$cartDiscount = $cartDiscountData['cart_discount'];
			}
			$cartSubTotal = $cartTotal - $cartDiscount;
			$cartShipping = 0;
			$cartTax = 0;
			$cartGrandTotal = $cartSubTotal + $cartShipping + $cartTax;
		}
		$cartDetails = [
			'cartQty' => $cartQty,
			'cartTotal' => $cartTotal,
			'cartDiscount' => $cartDiscount,
			'cartSubTotal' => $cartSubTotal,
			'cartShipping' => $cartShipping,
			'cartTax' => $cartTax,
			'cartGrandTotal' => $cartGrandTotal
		];
		return $cartDetails;
	}
}
