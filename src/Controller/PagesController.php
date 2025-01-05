<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
use Cake\View\Helper\SessionHelper;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\Http\Client;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('RequestHandler');
		$this->loadComponent('Flash');
		$this->viewBuilder()->setLayout('front');
	}

	//before filter 
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Auth->allow(['portfolio1', 'videos', 'frednasseribio', 'businesshighlights', 'awardwinning', 'pairingpatternsorientalrug', 'interiordesign', 'index', 'portfolio', 'privacypolicy', 'contactUs', 'carpet', 'rugcleaning', 'aboutus', 'rugrepair', 'rugappraisal', 'faq', 'returns', 'termsofuse', 'testmail', 'subscribeLetter']);


		if ($this->Auth->user('role_id') == 1) {
			$this->Auth->logout();
			return $this->redirect(['action' => 'home']);
		}
	}


	/**
	 * Displays a view
	 *
	 * @param array ...$path Path segments.
	 * @return \Cake\Http\Response|null
	 * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
	 * @throws \Cake\Http\Exception\NotFoundException When the view file could not
	 *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
	 */
	public function display()
	{
		$this->viewBuilder()->setLayout('front');
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}

		try {

			$cmsPageTable = TableRegistry::get('CmsPages');

			$contentData = $cmsPageTable->find('all')
				->where(['CmsPages.slug' => $page])->first();

			if (empty($contentData)) {
				throw new NotFoundException;
			}
			$this->set(compact('contentData', 'page', 'subpage', 'categories'));
		} catch (MissingTemplateException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}

	public function index()
	{
		$this->viewBuilder()->setLayout('front');
	}

	public function contactUs()
	{
		$this->viewBuilder()->setLayout('front');
		$page = 'Contact Us';
		$Table = TableRegistry::get('ContactUs');
		$data = $Table->newEntity();

		// echo "CP1";exit; 
		$seoTitle = "Contact Us | Gallery of Oriental Rugs";
		$seoDescription = "If you have any queries about our products or information, you can contact us at 910.392.2605 or send us a message via contact form.";
		$seoKeyword = "oriental wall to wall carpet in wilmington";
		$seoH2 = "";
		$seoH1 = "Contact Us";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);

		/*	
		if($this->request->is(['post', 'put'])) {
			$data = $Table->patchEntity($data, $this->request->getData(),['validate'=>'default']);
			if (!$data->getErrors()){
				if($Table->save($data)) {
					
					$message        =   'Contact Us Enquiry';
					$subject        =   'Contact Us Enquiry';
					$email          =   new Email();
					$email->transport('default');
					// $to  = Configure::read("App.EmailFrom");
					$to  = "info@rugsnc.com";
					
					$results =  $email
								->setTo($to)
								->emailFormat('html')
								->template('contact_us')
								->viewVars(['data' => $data])
								->setSubject($subject)
								->send($message);
							
					
					
					$this->Flash->set('Your Message successfully Send.',['key' => 'positive','params'=>['class' => 'alert alert-success']]);
					$this->redirect(array('controller'=>'Pages','action'=>'contact-us'));
				}
				else{
					$this->Flash->set('Message could not be send. Please, try again.', ['key' => 'positive','params' => ['class' => 'alert alert-danger']]);
				}
			}
			else{
				$this->Flash->set($this->errorMessage($data->getErrors()),['key' => 'positive','params'=>['class' => 'alert alert-danger']]);
			}
		}
	
		$this->set(compact('data','page'));

	*/
	}

	public function home()
	{

		$seoTitle = "Best Place To Get Carpet & Rugs Online in Wilton - Kaouds";
		$seoDescription = "Shop today & buy high-quality, modern, unique Rugs & Carpets online at Kaouds. We also provide hand washing cleaning solutions to get your Carpet & Rug clean.";
		$seoKeyword = "oriental wall to wall carpet in wilmington";
		$seoH2 = "";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);

		$this->viewBuilder()->setLayout('front');

		$ProductsTable = TableRegistry::getTableLocator()->get('Products');
		$featuredProductData = $ProductsTable->find('all')->where(['Products.is_future' => 1])->toArray();

		$BannerTable = TableRegistry::getTableLocator()->get('Banners');
		$banners = $BannerTable->find('all')->select(['id', 'title', 'description', 'block_type', 'image', 'link', 'link_name', 'status'])->where(['status' => 1])->order(['id' => 'ASC'])->enableHydration(false)->toArray();

		$ProductReviewTable = TableRegistry::getTableLocator()->get('ProductReview');
		$productReviews = $ProductReviewTable->find('all')->where(['status' => 'approved'])->order(['id' => 'ASC'])->enableHydration(false)->toArray();

		$HomeBlocks = [];
		foreach ($banners as $bannerKey => $bannerData) {
			$HomeBlocks['Block' . $bannerData['block_type']][] = $bannerData;
		}
		foreach ($productReviews as $reviewKey => $reviewData) {
			$HomeBlocks['BlockReviews'][$reviewKey] = $reviewData;
		}
		$ContactNewsletterTable = TableRegistry::getTableLocator()->get('ContactNewsletter');

		$cmspage = parent::getCmspage();
		$this->set(compact('banners', 'featuredProductData', 'cmspage', 'HomeBlocks'));
		$this->set('newsletter', $ContactNewsletterTable->newEntity());
	}

	public function aboutus()
	{
		$seoTitle = "GALLERY OF ORIENTAL RUGS";
		$seoDescription = "Find at Gallery of Oriental Rugs the huge variety of designer and handmade rugs in Wilmington and North Carolina available at a reasonable price.";
		$seoKeyword = "rugs in north carolina, oriental rugs wilmington nc, interior design oriental rugs wilmington";
		$seoH2 = "";
		$seoH1 = "Oriental Rugs Wilmington";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);

		$this->viewBuilder()->setLayout('front');
	}

	public function carpet()
	{
		$this->viewBuilder()->setLayout('front');
		$seoTitle = "Choose Carpet & Stair-Runners | Wall-to-Wall Carpet | Gallery of Oriental Rugs";
		$seoDescription = "If you are confused about selecting a carpet, so no worries about that. Gallery of Oriental Rugs provides tips about choosing a Wall-to-Wall Carpet according to home.";
		$seoKeyword = "oriental wall to wall carpet in wilmington";
		$seoH2 = "";
		$seoH1 = "";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);
	}

	public function rugcleaning()
	{

		$seoKeyword = "area rug cleaning in wilmington, pile oriental rug cleaners wilmington";
		$seoTitle = "Oriental Rug Cleaning In Wilmington, Nc | Gallery of Oriental Rugs";
		$seoDescription = "We confer Oriental Rug Cleaning Service in Wilmington, NC. Our professional experts help remove harmful allergens, dust mites, pet stains, and mold at the source.";
		$seoH2 = "";
		$seoH1 = "";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);

		$this->viewBuilder()->setLayout('front');
	}

	public function rugrepair()
	{
		$this->viewBuilder()->setLayout('front');
		$seoTitle = "Oriental Rug Repair & Restoration Services In Wilmington | Gallery of Oriental Rugs";
		$seoDescription = "Are you looking for a Rug Repair service? So, you are at the perfect place. Gallery of Oriental Rugs confers the Carpet Restoration Services in Wilmington, NC. Visit now";
		$seoKeyword = "oriental wall to wall carpet in wilmington";
		$seoH2 = "";
		$seoH1 = "";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);
	}

	public function rugappraisal()
	{
		$seoKeyword = "oriental rug appraiser wilmington";
		$seoTitle = "Oriental Rug Appraiser in Wilmington - Gallery of Oriental Rugs";
		$seoDescription = "Check out the Gallery of Oriental Rugs, we are the ORRA certified oriental rug appraiser in Wilmington. Explore our website to know the details!";
		$seoH2 = "";
		$seoH1 = "Oriental Rugs Wilmington";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);


		$this->viewBuilder()->setLayout('front');
	}

	public function faq()
	{
		$this->viewBuilder()->setLayout('front');
		$seoTitle = "FAQ | Gallery of Oriental Rugs";
		$seoDescription = "Gallery of Oriental Rugs has the exclusive collection of oriental wall to wall carpet in Wilmington. Visit here FAQ section & get all information about us.";
		$seoKeyword = "oriental wall to wall carpet in wilmington";
		$seoH2 = "";
		$seoH1 = "";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);
	}
	public function returns()
	{
		$this->viewBuilder()->setLayout('front');
		$seoTitle = "Return Policy | Gallery of Oriental Rugs";
		$seoDescription = "Gallery of Oriental Rugs offers rugs or carpets for 30 days free home trial on every mat. If you are not happy with the product, you can return it. Browse now!";
		$seoKeyword = "oriental wall to wall carpet in wilmington";
		$seoH2 = "";
		$seoH1 = "";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);
	}
	public function termsofuse()
	{
		$this->viewBuilder()->setLayout('front');
		$seoTitle = "Term of Use | Gallery of Oriental Rugs";
		$seoDescription = "By accessing or using the Services, you agree that you have read, understand, and agree to be bound by these Terms, as altered from time to time.";
		$seoKeyword = "oriental wall to wall carpet in wilmington";
		$seoH2 = "";
		$seoH1 = "";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);
	}
	public function privacypolicy()
	{
		$this->viewBuilder()->setLayout('front');
		$seoTitle = "Privacy Policy | Gallery of Oriental Rugs";
		$seoDescription = "We gather personal identification information from Users in many ways, including, but not limited to, when Users visit our site, register on the site.";
		$seoKeyword = "oriental wall to wall carpet in wilmington";
		$seoH2 = "";
		$seoH1 = "";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);
	}
	public function portfolio()
	{
		$this->viewBuilder()->setLayout('front');
	}
	public function interiordesign()
	{
		$this->viewBuilder()->setLayout('front');

		$seoTitle = "Interior Designers | High-Quality Rugs & Carpet | Gallery of Oriental Rugs";
		$seoDescription = "If you are looking to design a rug or carpet, you have come to the right place. Gallery of Oriental Rugs provides custom-made rugs for homes and hotels. Explore now!";
		$seoKeyword = "oriental wall to wall carpet in wilmington";
		$seoH2 = "";
		$seoH1 = "";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);
	}
	public function pairingpatternsorientalrug()
	{
		$this->viewBuilder()->setLayout('front');
		$seoTitle = "Pairing Patterns With An Authentic Oriental Rug | Gallery of Oriental Rugs";
		$seoDescription = "If you are looking for Pairing Patterns With An Oriental Rug, so you at the perfect place. Gallery of Oriental Rugs provides tips about Rugs pattern according to home.";
		$seoKeyword = "oriental wall to wall carpet in wilmington";
		$seoH2 = "";
		$seoH1 = "";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);
	}
	public function awardwinning()
	{
		$this->viewBuilder()->setLayout('front');
		$seoTitle = "Award Winning | Retailer of the Year Awards | Gallery of Oriental Rugs";
		$seoDescription = "Check out our award-winning page online at the Gallery of Oriental Rugs. We are the winner of the Rug Retailer Of The Year Award. Explore now!";
		$seoKeyword = "oriental wall to wall carpet in wilmington";
		$seoH2 = "";
		$seoH1 = "";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);
	}
	public function businesshighlights()
	{
		$this->viewBuilder()->setLayout('front');
		$seoTitle = "Business Highlights of Rugs & Carpet | Gallery of Oriental Rugs";
		$seoDescription = "Check out our Business Highlights of certified rugs online at the Gallery of Oriental Rugs. Obtain information about rugs' business process.";
		$seoKeyword = "oriental wall to wall carpet in wilmington";
		$seoH2 = "";
		$seoH1 = "";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);
	}
	public function frednasseribio()
	{
		$this->viewBuilder()->setLayout('front');
		$seoTitle = "Fred Nasseri Bio | Gallery of Oriental Rugs";
		$seoDescription = "Get the information about Mr. Fred Nasseri online at the Gallery of Oriental Rugs. He's a certified rug appraiser that encourages the client to plan rugs for the home.";
		$seoKeyword = "oriental wall to wall carpet in wilmington";
		$seoH2 = "";
		$seoH1 = "";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);
	}
	public function videos()
	{
		$this->viewBuilder()->setLayout('front');
		$seoTitle = "Rug Making & Store Commercial Video | Gallery of Oriental Rugs";
		$seoDescription = "Check out our videos online at the Gallery of Oriental Rugs and get information about rugs making and store commercials. Explore now!";
		$seoKeyword = "oriental wall to wall carpet in wilmington";
		$seoH2 = "";
		$seoH1 = "";

		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('h2_for_layout', $seoH2);
		$this->set('h1_for_layout', $seoH1);
	}

	public function portfolio1()
	{
		$this->viewBuilder()->setLayout('front');
	}

	public function testmail()
	{
		$this->autoRender = false;
		$emailId = 'sam@mailinator.com';
		$username = "Sam";
		$activation_link = Router::url('/', true) . 'users/activate/' . base64_encode(12);
		$EmailTemplates = TableRegistry::get('EmailTemplates');
		$query = $EmailTemplates->find('all')->where(['EmailTemplates.slug' => 'user_registration']);

		$template = $query->first();
		$userEmail = 'developer.noto@gmail.com';

		try {
			$mailMessage = str_replace(array('{{username}}', '{{activation_link}}', '{{email}}', '{{id}}'), array($username, $activation_link, $userEmail, '12'), $template->description);
			$to = $userEmail;
			$subject = $template->subject;
			$message = $mailMessage;
			/* $email = new Email('default'); 
			$email->from(['support@rugsnc.com' => 'Rugsnc'])
			->to($to)
			->emailFormat('html')
			->subject($subject)
			->send($message); */




			$email = new Email('default');
			$email
				->transport('default')
				->from(['support@rugsnc.com' => 'Rugsnc'])
				->to($to)
				->subject($subject)
				->emailFormat('html')
				->viewVars(array('msg' => $message))
				->send($message);

			echo "send";
		} catch (Exception $e) {
			echo "<pre>";
			print_r($e);
			echo "not sent";
		}
		exit;
	}

	public function subscribeLetter()
	{
		$this->request->allowMethod(['post']); // Allow only POST requests
		$this->autoRender = false;

		$ContactNewsletterTable = TableRegistry::getTableLocator()->get('ContactNewsletter');
		$data = $ContactNewsletterTable->newEntity();

		$postData = $this->request->getData();
		// Check for duplicate email
		$existingEntry = 0;
		if ($postData['subscribe-type'] == 'newsletter') {
			$existingEntry = $ContactNewsletterTable->find()
				->where([
					'email' => $postData['email'],
					'type' => 'newsletter', // Ensure it's specific to the newsletter
				])
				->count();
			$successMessage =  'Subscribed Successfully!';
			$errorMessage =  'Failed to Subscribe Newsleter!. Please try again.';
		}
		$recaptchaResponse = $postData['g-recaptcha-response'];
		$captchaResponse = $this->verifyRecaptcha($recaptchaResponse);
		if (isset($captchaResponse['success']) && $captchaResponse['success'] == 1) {
		} else {
			$response = [
				'success' => false,
				'message' => 'reCAPTCHA verification failed. Please try again.',
				'data' => ''
			];
			$this->response = $this->response->withType('application/json')
				->withStringBody(json_encode($response));
			return $this->response;
		}
		$mappedData = [
			'name' => $postData['subscriber_name'],
			'email' => $postData['email'],
			'type' => $postData['subscribe-type'],
		];
		$data = $ContactNewsletterTable->patchEntity($data, $mappedData, ['validate' => 'default']);
		if ($existingEntry > 0) {
			if (!$data->getErrors()) {
				if ($ContactNewsletterTable->save($data)) {
					$response = [
						'success' => true,
						'message' => $successMessage,
						'data' => $data
					];
				} else {
					$response = [
						'success' => false,
						'message' => $errorMessage,
						'errors' => $data->getErrors()
					];
				}
			} else {
				$response = [
					'success' => false,
					'message' => $errorMessage,
					'errors' => $data->getErrors()
				];
			}
		} else {
			$response = [
				'success' => false,
				'message' => 'This email is already subscribed to the newsletter.',
				'errors' => ''
			];
		}

		// Explicitly return the response as JSON
		$this->response = $this->response->withType('application/json')
			->withStringBody(json_encode($response));
		return $this->response;
	}

	private function verifyRecaptcha($recaptchaResponse)
	{
		$http = new Client();
		$response = $http->post('https://www.google.com/recaptcha/api/siteverify', [
			'secret' => CAPTCHA_SECRETKEY,
			'response' => $recaptchaResponse,
		]);

		return json_decode($response->getBody()->getContents(), true);
	}
}
