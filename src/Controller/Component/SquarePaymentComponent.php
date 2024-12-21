<?php
namespace App\Controller\Component;
 
use Cake\Core\App;
use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\Core\Configure;
use Cake\Network\Email\Email;
use Cake\Utility\Security;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Client;

class SquarePaymentComponent extends Component {
 
	public $square_access_token = null;
	public $square_app_id = null;
	public $square_location_id = null;

	private $square_endpoint = 'https://connect.squareup.com';
	private $square_endpoint_test = 'https://connect.squareupsandbox.com';

	public $amount = null;
	public $ipAddress = '';
	public $creditCardType = '';
	public $creditCardNumber = '';
	public $creditCardExpires = '';
	public $creditCardCvv = '';
	
	public $customerFirstName = '';
	public $customerLastName = '';
	public $customerEmail = '';

	public $billingAddress1 = '';
	public $billingAddress2 = '';
	public $billingCity = '';
	public $billingState = '';
	public $billingCountryCode = '';
	public $billingZip = '';

	protected $_controller = null;

////////////////////////////////////////////////////////////

	public function __construct() {
		$this->ipAddress = $_SERVER['REMOTE_ADDR'];
	}

	public function doDirectPayment($data,$shop) {
		
		
		$testmode=true ;    
		if( Configure::read('App.PaypalAccountMode') == Configure::read('Paypal.mode.live') ){   
			$testmode = false ;       
		}
		if($testmode) {
			$this->square_endpoint = 'https://connect.squareupsandbox.com';
			$this->square_access_token = 'EAAAEDxwpYsIGVRAmPHRXoV-kAanwpkEof43PZJJzgLMKYQoRD8hGRzJNgmRRISP';
			$this->square_app_id = 'sandbox-sq0idb-oVE_8fXmElchrJT-NV-RkA';
			$this->square_location_id = '84FXVDJJ8VXK2'; 
		}
		else
		{
			$this->square_endpoint = 'https://connect.squareup.com';
			$this->square_access_token = 'EAAAELdzY8m1PE2GTlIVkfzLeXH-VDih_GfmNQRUgA-IXjj02hEjD8IOYyl3p08l';
			$this->square_app_id = 'sq0idp-ADsOz8H5WYn9bsF5MTGPAg';
			$this->square_location_id = 'FX8EDKJKAWSAM';
		}
	 
		require_once(ROOT . DS  . 'vendor' . DS  . 'square' . DS . 'autoload.php');
		 
		$api_config = new \SquareConnect\Configuration(); 

		# dotenv is used to read from the '.env' file created for credentials
		/* $dotenv = Dotenv\Dotenv::create(APP . 'Vendor' . DS . 'square');
		$dotenv->load();

		# Replace these values. You probably want to start with your Sandbox credentials
		# to start: https://developer.squareup.com/docs/testing/sandbox

		# The access token to use in all Connect API requests. Use your *sandbox* access
		# token if you're just testing things out.
		$access_token = ($_ENV["USE_PROD"] == 'true')  ?  $_ENV["PROD_ACCESS_TOKEN"]
													   :  $_ENV["SANDBOX_ACCESS_TOKEN"];

		# Set 'Host' url to switch between sandbox env and production env
		# sandbox: https://connect.squareupsandbox.com
		# production: https://connect.squareup.com
		$host_url = ($_ENV["USE_PROD"] == 'true')  ?  "https://connect.squareup.com"
												   :  "https://connect.squareupsandbox.com"; 	   
		$api_config->setHost($host_url);  
		$api_config->setAccessToken($access_token);
		*/			   
 
		$api_config->setHost($this->square_endpoint);
		# Initialize the authorization for Square 
		$api_config->setAccessToken($this->square_access_token);
		$api_client = new \SquareConnect\ApiClient($api_config);
		
		
		
		# Fail if the card form didn't send a value for `nonce` to the server
		$nonce = $data['nonce'];
		$note = isset($data['note'])?$data['note']:'Rug Purchase';
		if (is_null($nonce)) { 
			$response = array(
				"msg"=>"Invalid card data. nonce not found.",
				"status" => "Fail",
				"code"=>422
			); 
		}else{
			$payments_api = new \SquareConnect\Api\PaymentsApi($api_client);
			$email = isset($data['billing_email'])?$data['billing_email']:'';
			$request_body = array (
				"source_id" => $nonce,
				# Monetary amounts are specified in the smallest unit of the applicable currency.
				# This amount is in cents. It's also hard-coded for $1.00, which isn't very useful.
				"amount_money" => array (
					"amount" => round($data['total_price']*100),
					"currency" => "USD"
				),
				"buyer_email_address"=>$email,
				"billing_address" => array (
					"first_name" => $data['billing_first_name'],
					"last_name" => $data['billing_last_name'], 
					"country" => 'US',//$data['billing_country'],
					"administrative_district_level_1" => $data['billing_state'],
					"locality" => $data['billing_city'],
					"address_line_1" =>  $data['billing_street_address'],
					"postal_code" => $data['billing_zip'],
					"phone" => $data['billing_phone']
				),
				"shipping_address" => array (
					"first_name" => $data['delivery_first_name'],
					"last_name" => $data['delivery_last_name'], 
					"country" => 'US',//$data['delivery_country'],
					"administrative_district_level_1" => $data['delivery_state'],
					"locality" => $data['delivery_city'],
					"address_line_1" =>  $data['delivery_street_address'],
					"postal_code" => $data['delivery_zip'],
					"phone" => $data['delivery_phone']
				),
				'note' => $note,
				"source_type" => "CARD",
				# Every payment you process with the SDK must have a unique idempotency key.
				# If you're unsure whether a particular payment succeeded, you can reattempt
				# it with the same idempotency key without worrying about double charging
				# the buyer.
				"idempotency_key" => uniqid()
			);

			# The SDK throws an exception if a Connect endpoint responds with anything besides
			# a 200-level HTTP code. This block catches any exceptions that occur from the request.
			try {
				$result = $payments_api->createPayment($request_body);
				 
				$txnId = $result->getPayment()->getId();
				
				if($txnId != ''){
					$response = array(
						"msg"=>"Payment complete successfully!",
						"txn_id" => $txnId,
						"status" => "Success",
						"code"=>200
					);
				}else{
					$response = array(
						"msg"=>"Error", 
						"status" => "Fail",
						"data" => "Payment Failed. Please try again.",
						"code"=>400
					);
				}
				
				
			} catch (\SquareConnect\ApiException $e) {
				$response = $e->getResponseBody();
				$error_string = "";
				foreach($response->errors as &$error) {
					$error_string .= $error->detail . "<br>";
				} 
				/* echo "Caught exception!<br/>".$e->getCode();
				print_r("<strong>Response body:</strong><br/>");
				echo "<pre>"; print_r($e->getResponseBody()); echo "</pre>";
				echo "<br/><strong>Response headers:</strong><br/>";
				echo "<pre>"; var_dump($e->getResponseHeaders()); echo "</pre>"; */ 
				
				$response = array(
					"msg"=>"Caught exception!",
					"status" => "Fail",
					"data" => $error_string,
					"code"=>400
				);
			}
		}
		 
		return $response;die;  
		 
		
	}
	 
}