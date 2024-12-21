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
//require __DIR__ . '/../bootstrap.php';
use PayPal\Api\Amount;
use PayPal\Rest\ApiContext;
use PayPal\Api\CreditCard;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
 

use PayPal\Api\OpenIdTokeninfo;
use PayPal\Api\OpenIdUserinfo;

use PayPal\Exception\PayPalConnectionException;

class PaypalProComponent extends Component {

////////////////////////////////////////////////////////////
	
	public $paypal_username = null;
	public $paypal_password = null;
	public $paypal_signature = null;

	private $paypal_endpoint = 'https://api-3t.paypal.com/nvp';
	private $paypal_endpoint_test = 'https://api-3t.sandbox.paypal.com/nvp';

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
			$this->paypal_endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
			$this->paypal_username = 'denail.seller_api1.gmail.com';
			$this->paypal_password = '1406786079';
			$this->paypal_signature = 'An5ns1Kso7MWUdW4ErQKJJJ4qi4-AXjOhpXqcrBtZUWzZDP0AqA5j7D3';
		 }
		else
		{
			$this->paypal_endpoint = 'https://api-3t.paypal.com/nvp';
			$this->paypal_username = 'timothygardner1971_api1.hotmail.com';
			$this->paypal_password = 'HM6EDNA65E2WA6E3';
			$this->paypal_signature = 'AyepxAnv8MPNcyKCg5cfRWxYxPO7ABY90gL4s4SX2G2iGsYxs14wkjsZ';
		} 
		//$this->initialize();
		$doDirectPaymentNvp = array(
			/* 'METHOD' => 'DoDirectPayment',
			'VERSION' => '85.0',
			'PAYMENTACTION' => 'Sale',
			'IPADDRESS' => $this->ipAddress,
			'RETURNFMFDETAILS' => 1,

			'ACCT' => $data['creditcard_number'],
			'EXPDATE' => $data['creditcard_month'].$data['creditcard_year'],
			'CVV2' => $data['creditcard_code'],
			'CREDITCARDTYPE' => 'Visa',

			'FIRSTNAME' => $data['billing_first_name'],
			'LASTNAME' => $data['billing_last_name'],
			'EMAIL' => $data['billing_email'],

			'STREET' => $data['billing_street_address'],
			'STREET2' => '',
			'CITY' => $data['billing_city'],
			'STATE' => $data['billing_state'],
			'COUNTRYCODE' => 'IN',
			'ZIP' => $data['billing_zip'],
			'AMT' => round($data['total_price']),
			'ITEMAMT' => round($data['total_price']),
			'INVNUM' =>$_SESSION['invnum'],
			'CURRENCYCODE' => 'USD',

			'USER' => $this->paypal_username,
			'PWD' => $this->paypal_password,
			'SIGNATURE' => $this->paypal_signature,
			'SHIPTONAME' => $data['delivery_first_name'].' '.$data['delivery_last_name'],
			'SHIPTOSTREET' => $data['delivery_street_address'],
			'SHIPTOCITY' => $data['delivery_city'],
			'SHIPTOSTATE' => $data['delivery_state'],
			'SHIPTOCOUNTRY' => $data['delivery_country'],
			'SHIPTOZIP' => $data['delivery_zip'],
			'SHIPTOPHONENUM' => $data['delivery_phone'] */
			
			 'METHOD' => 'DoDirectPayment', 
             'USER' => $this->paypal_username,
			 'PWD' => $this->paypal_password,
			 'SIGNATURE' => $this->paypal_signature,
			 'VERSION' => 85.0, 
			 'PAYMENTACTION' => 'Sale',                   
			 'IPADDRESS' => $_SERVER['REMOTE_ADDR'],
			 'CREDITCARDTYPE' => 'Visa', 
			 'ACCT' => str_replace(' ', '', $data['creditcard_number']),                     
			 'EXPDATE' => $data['creditcard_month'].$data['creditcard_year'],    
			 'CVV2' => $data['creditcard_code'],
			 'FIRSTNAME' => $data['billing_first_name'],
			 'LASTNAME' => $data['billing_last_name'],
			 'STREET' => $data['billing_street_address'],
			 'CITY' => $data['billing_city'],
			 'STATE' => $data['billing_state'],
			 'COUNTRYCODE' => 'IN',
			 'ZIP' => $data['billing_zip'],
			 'AMT' => $data['total_price'],
			 'CURRENCYCODE' => 'USD'
             //'DESC' => 'Testing Payments Pro' 
		);
		
		// pr($shop);
		$i = 0; 
		foreach ($shop as $ccitem) {
			 
			$ccitem['product_name'] = $ccitem['title']." $".$ccitem['selling_price']; 
			
			$ccitem['selling_price'] = $ccitem['selling_price'];
			 
			$doDirectPaymentNvp['L_NAME'.$i] = $ccitem['product_name'];
			$doDirectPaymentNvp['L_NUMBER'.$i] = $ccitem['sku_no'];
			$doDirectPaymentNvp['L_AMT'.$i] = round($ccitem['selling_price'],2);
			$doDirectPaymentNvp['L_QTY'.$i] = $ccitem['product_qty'];
			$i++;
		} 
		/* echo "<pre>";
		print_r($doDirectPaymentNvp);
		die('fgh'); */
		$nvp_string = '';
		$j =1;
		foreach($doDirectPaymentNvp as $var=>$val)
		{	
			if($j == 1){
				$nvp_string .= $var.'='.urlencode($val);
			}else{
				$nvp_string .= '&'.$var.'='.urlencode($val);
			}				
			$j++;
		}
		
		$ch = curl_init();


		curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $this->paypal_endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvp_string);


		$result = curl_exec($ch);

		curl_close($ch);
				
		//$NVPString = parse_str($result);
		
		//$NVPString ="TIMESTAMP=2019%2d08%2d05T06%3a10%3a54Z&CORRELATIONID=3459e46168a38&ACK=Success&VERSION=85&BUILD=53305045&AMT=1042%2e00&CURRENCYCODE=USD&AVSCODE=Y&CVV2MATCH=S&TRANSACTIONID=92057542SR622803B";
		$proArray = array();
		// Function to convert NTP string to an array
		function NVPToArray($NVPString)
		{
			$proArray = array();
			while(strlen($NVPString))
			{
				// name
				$keypos= strpos($NVPString,'=');
				$keyval = substr($NVPString,0,$keypos);
				// value
				$valuepos = strpos($NVPString,'&') ? strpos($NVPString,'&'): strlen($NVPString);
				$valval = substr($NVPString,$keypos+1,$valuepos-$keypos-1);
				// decoding the respose
				$proArray[$keyval] = urldecode($valval);
				$NVPString = substr($NVPString,$valuepos+1,strlen($NVPString));
			}
			
			return $proArray;
		}
		return NVPToArray($result);
		
	}
	
	
	
	

////////////////////////////////////////////////////////////

}