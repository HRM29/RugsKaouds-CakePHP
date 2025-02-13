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
		$this->Auth->allow(['portfolio1', 'videos', 'frednasseribio', 'businesshighlights', 'awardwinning', 'pairingpatternsorientalrug', 'interiordesign', 'index', 'portfolio', 'privacypolicy', 'contactUs', 'carpet', 'rugcleaning', 'aboutus', 'rugrepair', 'rugappraisal', 'faq', 'returns', 'termsofuse', 'testmail', 'subscribeLetter', 'collectionMenu', 'projects', 'rugsellus', 'viewMediaLib']);


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

		$seoTitle = "Best Place To Get Carpet & Rugs Online in Wilton - Kaouds";
		$seoDescription = "Shop today & buy high-quality, modern, unique Rugs &amp; Carpets online at Kaouds. We also provide hand washing cleaning solutions to get your Carpet & Rug clean.";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
		try {

			$cmsPageTable = TableRegistry::getTableLocator()->get('CmsPages');

			$contentData = $cmsPageTable->find('all')->where(['CmsPages.slug' => $page])->first();

			$seoTitle = !empty($contentData['meta_title']) ? $contentData['meta_title'] : $seoTitle;
			$seoDescription = !empty($contentData['meta_description']) ? $contentData['meta_description'] : $seoDescription;
			$seoKeyword = !empty($contentData['meta_keywords']) ? $contentData['meta_keywords'] : $seoKeyword;

			$this->set('title_for_layout', $seoTitle);
			$this->set('keyword_for_layout', $seoKeyword);
			$this->set('description_for_layout', $seoDescription);
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
		$Table = TableRegistry::getTableLocator()->get('ContactUs');
		$seoTitle = "Contact - Carpets & Rugs";
		// $seoDescription = "If you have any queries about our products or information, you can contact us at 910.392.2605 or send us a message via contact form.";
		// $seoKeyword = "oriental wall to wall carpet in Wilton";
		// $seoH2 = "";
		// $seoH1 = "Contact Us";

		$this->set('title_for_layout', $seoTitle);
		// $this->set('keyword_for_layout', $seoKeyword);
		// $this->set('description_for_layout', $seoDescription);
		// $this->set('h2_for_layout', $seoH2);
		// $this->set('h1_for_layout', $seoH1);
	}

	public function home()
	{

		$seoTitle = "Best Place To Get Carpet & Rugs Online in Wilton - Kaouds";
		$seoDescription = "Shop today & buy high-quality, modern, unique Rugs &amp; Carpets online at Kaouds. We also provide hand washing cleaning solutions to get your Carpet & Rug clean.";
		$seoKeyword = "oriental wall to wall carpet in Wilton";

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
		$cartItems = parent::checkCartAddedProducts();
		$this->set(compact('banners', 'featuredProductData', 'cmspage', 'HomeBlocks', 'cartItems'));
		$this->set('newsletter', $ContactNewsletterTable->newEntity());
	}

	public function aboutus()
	{
		$seoTitle = "Kaoud Carpets & Rugs";
		$seoDescription = "Find at Kaoud Carpets & Rugs the huge variety of designer and handmade rugs in Wilton and North Carolina available at a reasonable price.";
		$seoKeyword = "rugs in north carolina, oriental rugs Wilton nc, interior design oriental rugs Wilton";
		$seoH2 = "";
		$seoH1 = "Oriental Rugs Wilton";

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
		$seoTitle = "Choose Carpet & Stair-Runners | Wall-to-Wall Carpet | Kaoud Carpets & Rugs";
		$seoDescription = "If you are confused about selecting a carpet, so no worries about that. Kaoud Carpets & Rugs provides tips about choosing a Wall-to-Wall Carpet according to home.";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
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
		// $seoKeyword = "area rug cleaning in Wilton, pile oriental rug cleaners Wilton";
		$seoTitle = "Schedule Pickup for Rug Cleaning - Kaoud Carpets & Rugs";
		$seoDescription = "We provide affordable rug cleaning services in Wilton, CT. Schedule your rug cleaning pickup today by filling out this simple form. Visit us here at Kaoud now!";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->viewBuilder()->setLayout('front');
		$states = parent::statesList();
		$this->set(compact('states'));


		if ($this->request->is('post')) {
			$data = $this->request->getData();
			if (!empty($data['email']) && !empty($data['rug_condition'])) {
				$email = new Email('default');
				$email->setFrom([Configure::read("App.EmailFrom") => 'Kaoud Carpets & Rugs'])
					->setTo($data['email'])
					->setSubject('Kaoud Carpets & Rugs - Rug Cleaning Request')
					->setEmailFormat('html')
					->setTemplate('rug_cleaning_customer')
					->setViewVars(['mail_to' => Configure::read("App.EmailFrom"), 'actual_message' => "Thank you for your rug cleaning request. We have received your request and will get back to you shortly.", "header_message" => "Rug Cleaning Request Received"])
					->send();

				$email = new Email();
				$email->setTransport('default')
					->setFrom([Configure::read("App.EmailFrom") => 'Admin'])
					->setTo([Configure::read("App.EmailFrom")])
					->setSubject('Kaoud Carpets & Rugs - Rug Cleaning Request')
					->setEmailFormat('html')
					->setTemplate('rug_cleaning_admin')
					->setViewVars(['data' => $data, 'intro_message' => "A new rug cleaning request has been submitted with the following details:", "header_message" => "New Rug Cleaning Request"]);

				// Check if the file exists before attaching
				if (!empty($data['rug_image']['tmp_name']) && is_uploaded_file($data['rug_image']['tmp_name'])) {
					$email->setAttachments([
						basename($data['rug_image']['name']) => [
							'file' => $data['rug_image']['tmp_name'],
							'mimetype' => mime_content_type($data['rug_image']['tmp_name']) // Auto-detect MIME type
						]
					]);
				}
				$email->send();
				$this->Flash->set('Thank you for your rug cleaning request. We will get back to you shortly!', ['key' => 'positive_forgot', 'params' => ['class' => 'alert alert-success']]);
			} else {
				$this->Flash->set('Please fill all the required fields!', ['key' => 'positive_forgot', 'params' => ['class' => 'alert alert-danger']]);
			}

			return $this->redirect(['action' => 'rugcleaning']);
		}
	}

	public function rugrepair()
	{
		$seoTitle = "Schedule Pickup for Rug Repair- Kaoud Carpets & Rugs";
		$seoDescription = "Schedule pickup for rug repair today and get benefited from our high end services. Feel free to visit us here at Kaoud for getting your rugs cleaned.";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->viewBuilder()->setLayout('front');
		$states = parent::statesList();
		$this->set(compact('states'));

		if ($this->request->is('post')) {
			$data = $this->request->getData();

			if (!empty($data['email']) && !empty($data['rug_condition'])) {

				$clientEmail = new Email('default');
				$clientEmail->setFrom([Configure::read("App.EmailFrom") => 'Kaoud Carpets & Rugs'])
					->setTo($data['email'])
					->setSubject('Kaoud Carpets & Rugs - Rug Repair Request')
					->setEmailFormat('html')
					->setTemplate('rug_cleaning_customer')
					->setViewVars(['mail_to' => Configure::read("App.EmailFrom"), 'actual_message' => "Thank you for your rug repair request. We have received your request and will get back to you shortly.", "header_message" => "Rug Repair Request Received"])
					->send();

				$adminEmail = new Email();
				$adminEmail->setTransport('default')
					->setFrom([Configure::read("App.EmailFrom") => 'Admin'])
					->setTo([Configure::read("App.EmailFrom")])
					->setSubject('Kaoud Carpets & Rugs - Rug Repair Request')
					->setEmailFormat('html')
					->setTemplate('rug_cleaning_admin')
					->setViewVars(['data' => $data, 'intro_message' => "A new rug repair request has been submitted with the following details:", "header_message" => "New Rug Repair Request"]);

				// Check if the file exists before attaching
				if (!empty($data['rug_image']['tmp_name']) && is_uploaded_file($data['rug_image']['tmp_name'])) {
					$adminEmail->setAttachments([
						basename($data['rug_image']['name']) => [
							'file' => $data['rug_image']['tmp_name'],
							'mimetype' => mime_content_type($data['rug_image']['tmp_name']) // Auto-detect MIME type
						]
					]);
				}
				$adminEmail->send();
				$this->Flash->set('Thank you for your rug repair request. We will get back to you shortly!', ['key' => 'positive_forgot', 'params' => ['class' => 'alert alert-success']]);
			} else {
				$this->Flash->set('Please fill all the required fields!', ['key' => 'positive_forgot', 'params' => ['class' => 'alert alert-danger']]);
			}

			return $this->redirect(['action' => 'rugrepair']);
		}
	}

	public function rugappraisal()
	{
		$seoTitle = "Schedule Insurance Appraisal - Carpets & Rugs";
		$seoDescription = "Being one of the best industrial carpet cleaners, we at Kaoud take pride in offering the best possible services. Click here to know more about our services.";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->viewBuilder()->setLayout('front');
		$states = parent::statesList();
		$this->set(compact('states'));

		if ($this->request->is('post')) {
			$data = $this->request->getData();

			if (!empty($data['preferred_date']) && !empty($data['alternate_date']) && !empty($data['rug_request_problem'])) {

				$clientEmail = new Email('default');
				$clientEmail->setFrom([Configure::read("App.EmailFrom") => 'Kaoud Carpets & Rugs'])
					->setTo($data['email'])
					->setSubject('Kaoud Carpets & Rugs - Rug Appraisal Request')
					->setEmailFormat('html')
					->setTemplate('rug_appraisal_customer')
					->setViewVars(['mail_to' => Configure::read("App.EmailFrom"), 'data' => $data])
					->send();

				$adminEmail = new Email();
				$adminEmail->setTransport('default')
					->setFrom([Configure::read("App.EmailFrom") => 'Admin'])
					->setTo([Configure::read("App.EmailFrom"), 'harshit@racknap.com'])
					->setSubject('Kaoud Carpets & Rugs - Rug Appraisal Request')
					->setEmailFormat('html')
					->setTemplate('rug_appraisal_admin')
					->setViewVars(['data' => $data]);

				// Check if the file exists before attaching
				if (!empty($data['rug_image']['tmp_name']) && is_uploaded_file($data['rug_image']['tmp_name'])) {
					$adminEmail->setAttachments([
						basename($data['rug_image']['name']) => [
							'file' => $data['rug_image']['tmp_name'],
							'mimetype' => mime_content_type($data['rug_image']['tmp_name']) // Auto-detect MIME type
						]
					]);
				}
				$adminEmail->send();
				$this->Flash->set('Thank you for your rug appraisal request. We will get back to you shortly!', ['key' => 'positive_forgot', 'params' => ['class' => 'alert alert-success']]);
			} else {
				$this->Flash->set('Please fill all the required fields!', ['key' => 'positive_forgot', 'params' => ['class' => 'alert alert-danger']]);
			}

			return $this->redirect(['action' => 'rugappraisal']);
		}
	}

	public function rugsellus()
	{
		$seoTitle = "Schedule Sell Us - Carpets & Rugs";
		$seoDescription = "Being one of the best industrial carpet cleaners, we at Kaoud take pride in offering the best possible services. Click here to know more about our services.";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->viewBuilder()->setLayout('front');
		$states = parent::statesList();
		$this->set(compact('states'));

		if ($this->request->is('post')) {
			$data = $this->request->getData();
			if (!empty($data['email']) && !empty($data['phone_number'])) {
				$adminEmail = new Email();
				$adminEmail->setTransport('default')
					->setFrom([Configure::read("App.EmailFrom") => 'Admin'])
					->setTo([Configure::read("App.EmailFrom"), 'harshit@racknap.com'])
					->setSubject('Kaoud Carpets & Rugs - Rug Sell Request')
					->setEmailFormat('html')
					->setTemplate('rug_sell_admin')
					->setViewVars(['data' => $data]);

				// Check if the file exists before attaching
				if (!empty($data['rug_image']['tmp_name']) && is_uploaded_file($data['rug_image']['tmp_name'])) {
					$adminEmail->setAttachments([
						basename($data['rug_image']['name']) => [
							'file' => $data['rug_image']['tmp_name'],
							'mimetype' => mime_content_type($data['rug_image']['tmp_name']) // Auto-detect MIME type
						]
					]);
				}
				$adminEmail->send();
				$this->Flash->set('Thank you for your rug selling request. We will get back to you shortly!', ['key' => 'positive_forgot', 'params' => ['class' => 'alert alert-success']]);
			} else {
				$this->Flash->set('Please fill all the required fields!', ['key' => 'positive_forgot', 'params' => ['class' => 'alert alert-danger']]);
			}

			return $this->redirect(['action' => 'rugsellus']);
		}
	}
	public function faq()
	{
		$this->viewBuilder()->setLayout('front');
		$seoTitle = "FAQ | Kaoud Carpets & Rugs";
		$seoDescription = "Kaoud Carpets & Rugs has the exclusive collection of oriental wall to wall carpet in Wilton. Visit here FAQ section & get all information about us.";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
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
		$seoTitle = "Return Policy | Kaoud Carpets & Rugs";
		$seoDescription = "Kaoud Carpets & Rugs offers rugs or carpets for 30 days free home trial on every mat. If you are not happy with the product, you can return it. Browse now!";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
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
		$seoTitle = "Term of Use | Kaoud Carpets & Rugs";
		$seoDescription = "By accessing or using the Services, you agree that you have read, understand, and agree to be bound by these Terms, as altered from time to time.";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
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
		$seoTitle = "Privacy Policy | Kaoud Carpets & Rugs";
		$seoDescription = "We gather personal identification information from Users in many ways, including, but not limited to, when Users visit our site, register on the site.";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
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

		$seoTitle = "Interior Designers | High-Quality Rugs & Carpet | Kaoud Carpets & Rugs";
		$seoDescription = "If you are looking to design a rug or carpet, you have come to the right place. Kaoud Carpets & Rugs provides custom-made rugs for homes and hotels. Explore now!";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
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
		$seoTitle = "Pairing Patterns With An Authentic Oriental Rug | Kaoud Carpets & Rugs";
		$seoDescription = "If you are looking for Pairing Patterns With An Oriental Rug, so you at the perfect place. Kaoud Carpets & Rugs provides tips about Rugs pattern according to home.";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
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
		$seoTitle = "Award Winning | Retailer of the Year Awards | Kaoud Carpets & Rugs";
		$seoDescription = "Check out our award-winning page online at the Kaoud Carpets & Rugs. We are the winner of the Rug Retailer Of The Year Award. Explore now!";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
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
		$seoTitle = "Business Highlights of Rugs & Carpet | Kaoud Carpets & Rugs";
		$seoDescription = "Check out our Business Highlights of certified rugs online at the Kaoud Carpets & Rugs. Obtain information about rugs' business process.";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
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
		$seoTitle = "Fred Nasseri Bio | Kaoud Carpets & Rugs";
		$seoDescription = "Get the information about Mr. Fred Nasseri online at the Kaoud Carpets & Rugs. He's a certified rug appraiser that encourages the client to plan rugs for the home.";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
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
		$seoTitle = "Rug Making & Store Commercial Video | Kaoud Carpets & Rugs";
		$seoDescription = "Check out our videos online at the Kaoud Carpets & Rugs and get information about rugs making and store commercials. Explore now!";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
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
		$EmailTemplates = TableRegistry::getTableLocator()->get('EmailTemplates');
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

	public function subscribeLetter($postData = null)
	{
		$response = [];
		if ($this->request->is('post')) {
			$response = parent::subscribeLetterMethod($this->request->getData());
		}
		// Explicitly return the response as JSON
		$this->response = $this->response->withType('application/json')
			->withStringBody(json_encode($response));
		return $this->response;
	}

	public function collectionMenu($slug = null)
	{
		$this->viewBuilder()->setLayout('front');
		$seoTitle = "Our Collection - Kaoud Carpets & Rugs";
		$seoDescription = "Check out our unique collection of vintage style rugs, outdoor jute rug, stair rug pads, natural stair runners, sisal runner rugs & more here at Kaoud.";
		$seoKeyword = "oriental wall to wall carpet in Wilton";
		$CollectionTable = TableRegistry::getTableLocator()->get('Collections');
		$PageType = 'Collections';
		if ($slug !== null && !empty($slug)) {
			$PageType = 'CollectionPage';
			$collection = $CollectionTable->find()
				->contain(['CollectionImages'])
				->where(['Collections.collection_type' => "2", 'Collections.status' => 1, 'Collections.page_url' => trim($slug)])
				->enableHydration(false)
				->first();
			$seoTitle = !empty($collection['meta_title']) ? $collection['meta_title'] : $seoTitle;
			$seoDescription = !empty($collection['meta_description']) ? $collection['meta_description'] : $seoDescription;
			$seoKeyword = !empty($collection['meta_keywords']) ? $collection['meta_keywords'] : $seoKeyword;
		} else {
			$parentCategoriesData = parent::returnCollectionCategoryData();
			// echo "<pre>parentCategories: ";print_r($parentCategoriesData);echo "</pre>";
			// if(!empty($parentCategoriesData)){


			// }
			$collection = $CollectionTable->find()
				->contain([
					'CollectionImages' => function ($q) {
						return $q->order(['created_at' => 'DESC']); // Fetch only the last image
					},
				])
				->where(['Collections.collection_type' => "2", 'Collections.status' => 1])
				->enableHydration(false)
				->toList();
		}
		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('collection', $collection);
		$this->set('PageType', $PageType);
	}

	public function projects()
	{
		$this->viewBuilder()->setLayout('front');
		$seoTitle = "Projects - Kaoud Carpets & Rugs";
		$seoDescription = "Check out our recently completed jobs of area rugs and carpets for your viewing. To know more and to get a clear idea of our projects, visit us here at Kaoud.";
		$seoKeyword = "oriental wall to wall carpet in Wilton";

		$ProjectsTable = TableRegistry::getTableLocator()->get('Projects');

		$projects = $ProjectsTable->find()->where([
			'status' => "active",
			'image_url !=' => ""
		])
			->enableHydration(false)
			->toList();
		$this->set('title_for_layout', $seoTitle);
		$this->set('keyword_for_layout', $seoKeyword);
		$this->set('description_for_layout', $seoDescription);
		$this->set('projects', $projects);
	}

	public function viewMediaLib($mediaslug, $filename)
	{
		$folder_slug = [
			'media-file' => 'media-library',
			'footer-file' => 'header_footer'
		];
		$filePath = WWW_ROOT . 'uploads' . DS . $folder_slug[$mediaslug] . DS . $filename;
		if (file_exists($filePath)) {
			$this->response = $this->response->withFile($filePath);
			return $this->response;
		} else {
			$this->Flash->error(__('File not found.'));
			return $this->redirect(['action' => 'list']);
		}
	}
}
