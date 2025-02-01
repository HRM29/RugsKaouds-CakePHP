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

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Utility\Security;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('My');

        if (null !== $this->request->getParam('prefix') && $this->request->getParam('prefix') == 'admin') {
            $this->loadComponent('Auth', [
                'authenticate' => [
                    'Form' => [
                        'fields' => [
                            'username' => 'email',
                            'password' => 'password'
                        ]
                    ]
                ],
                'loginAction' => [
                    'controller' => 'Users',
                    'action' => 'login'
                ],
                //use isAuthorized in Controllers
                'authorize' => ['Controller'],
                // If unauthorized, return them to page they were just on
                'unauthorizedRedirect' => $this->referer()
            ]);
        } else {
            $this->loadComponent('Auth', [
                'authenticate' => [
                    'Form' => [
                        'fields' => [
                            'username' => 'email',
                            'password' => 'password'
                        ]
                    ]
                ],
                'loginAction' => [
                    'controller' => 'Users',
                    'action' => 'login'
                ],
                //use isAuthorized in Controllers
                'authorize' => ['Controller'],
                // If unauthorized, return them to page they were just on
                'unauthorizedRedirect' => $this->referer()
            ]);
        }
        if (null !== $this->request->getParam('prefix')) {
            $allCategories            =    $this->getCategory();
            //$getBannes			    =	$this->getBannes(); 
            $cartData                =    $this->getcartdata();
            $extralongreturn        =    $this->getExtralongreturn();

            /* $allSizes			    =	$this->getAllSize();
			$specialdimension	    =	$this->getspecialDimensions();
			$specialdimensionNav	=	$this->getspecialDimensionsNav();
			$specialSizes			=	$this->getSpecialSize(); */
            $allColors                =    $this->getAllColors();
            $allCms                    =    $this->getCmsPage();
            $allPrice                =    $this->getFilterPrice();
            $allPriceSort            =    $this->getFilterPriceSort();
            //	echo '<pre>'; print_r($specialdimension); die;
            $this->set(compact('allCategories', 'allSizes', 'allColors', 'allCms', 'specialSizes', 'allPrice', 'allPriceSort', 'extralongreturn', 'specialdimension', 'specialdimensionNav', 'cartData'));
        }
        // Allow the display action so our PagesController
        // continues to work. Also enable the read only actions.
        $this->Auth->allow(['display', 'login', 'register', 'home', 'listing', 'details', 'addCart', 'ApplyCoupon', 'productRemove']);

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }


    /**
     * Before filter callback.
     *
     * @param \Cake\Event\Event $event The beforeFilter event.
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        /* $wishListTbl = TableRegistry::get('wish_lists');
		$wishlists = $wishListTbl->find('all')->where(['user_id'=>$this->Auth->user('id')])->toArray();
		if(!empty($wishlists)){
			$session = $this->request->session();
			foreach($wishlists as $wishlistsData){
				$wishID[] = $wishlistsData->product_id;
			}
			$session->write('Config.wishlistdatas',$wishID);
		} */


        if (null !== $this->request->getParam('prefix')) {
            $categories        =    $this->getCategory();
            $latestProducts    =    $this->getLatestProducts();
            $is_future        =    $this->getFutureProducts();
            $is_special        =    $this->getspecialProducts();
            $is_best        =    $this->getBestProducts();
            $new_arival        =    $this->getNewArivalProducts();
            $newProducts    =    $this->getNewProducts();
            $captionFront    =    $this->getCaptionFront();
            $captionBack    =    $this->getCaptionBack();
            $bannersList    =    $this->getBannersList();
            $MostViewsList    =    $this->getMostViewsList();
            $categoryList    =    $this->getCategoryList();
            $hot_sale        =    $this->getHotSalesProducts();
            $cmspage        =    $this->getCmspage();
            //$sizesLIst	    =	$this->getSizesLIst();
            $rememberMeCookie = $this->request->getCookie('RememberMe');
            if (empty($authUser) && $rememberMeCookie) {
                // Decrypt the user ID from the cookie
                $userId = Security::decrypt($rememberMeCookie, Security::getSalt());
                $this->loadModel('Users');
                if ($userId) {
                    // Find the user in the database
                    $user = $this->Users->get($userId); // Replace `Users` with your user table

                    if ($user) {
                        $this->Auth->setUser($user->toArray());
                    }
                }
            }
            $this->set(compact('categories', 'latestProducts', 'is_future', 'is_special', 'is_best', 'new_arival', 'newProducts', 'captionFront', 'captionBack', 'bannersList', 'MostViewsList', 'hot_sale', 'cmspage'));
        }
    }




    public function isAuthorized($user)
    {

        // Only for ACL setup
        //return true;

        if (null !== $this->request->getParam('prefix') && $this->request->getParam('prefix') == 'admin') {
            if (isset($user['role_id']) && $user['role_id'] === 1) {
                return true;
            } else {
                return false;
            }
        } else {

            if (isset($user['role_id']) && $user['role_id'] === 3) {
                return true;
            } else {
                return false;
            }
        }
    }


    public function emailSetting()
    {
        $data = TableRegistry::get('Settings');
        $query = $data->find('all');
        $result = $query->where(['slug' => 'AdminEmail']);
        $result = $result->toArray();
        return $result;
    }


    /* public function sendMailTo($to, $subject, $message){
        $email = new Email();
        $email->setTransport('default'); 
        //pr(Configure::read('App.EmailFrom'));die;  
        $result = $email->setFrom([Configure::read('App.EmailFrom') => $subject])
        ->setTo($to)
        ->setEmailFormat('html')
        ->setSubject($subject)
        ->send($message);
       
         //pr($result); die;
       
        return $result;

         
           $headers = "MIME-Version: 1.0" . "\r\n";
		  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		  $headers .= "From: ni3pdidwania@gmail.com" . "\r\n";
		   
		  
			$to      = 'app@mailinator.com';
			$subject = 'the subject';
			$message = 'hello';
			$headers = 'From: no-reply@babalifestyle.com' . "\r\n" .
			'Reply-To: webmaster@example.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

			mail($to, $subject, $message, $headers);
			if(mail($to,$subject,$message,$headers)){
			  echo 'send';
			}else{
			  echo 'not send';
			} 
		  
		  die;
   } */
    public function sendMailTo($to, $subject, $message)
    {
        $email = new Email('default');
        $email
            ->setTransport('default')
            ->setFrom(Configure::read("App.EmailFrom"))
            ->setTo($to)
            ->setSubject($subject)
            ->setEmailFormat('html')
            ->send($message);

        return 1;
    }

    function convert_multi_array($array)
    {
        $out = implode("&", array_map(function ($a) {
            return implode("~", $a);
        }, $array));
        return $out;
    }


    function errorMessage($array)
    {
        $errors = [];

        foreach ($array as $item) {
            if (is_array($item)) {
                $errors[] = $this->errorMessage($item);
            } else {
                $errors[] = $item;
            }
        }

        return implode(',', array_unique($errors));
    }

    /**
     * @users 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function users()
    {
        $userTable = TableRegistry::get('Users');
        $query = $userTable->find('list', [
            'keyField' => 'id',
            'valueField' => 'first_name'
        ])->where(['role_id' => 2, 'status' => 1])->order(['id' => 'ASC']);
        $user = $query->all();

        return json_encode($user);
        exit;
    }

    /**
     * @Country List 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function countryList()
    {
        $Table = TableRegistry::get('Countries');
        $query = $Table->find('list', [
            'keyField' => 'id',
            'valueField' => 'country'
        ])->where(['status' => 1])->order(['country' => 'ASC']);
        $country = $query->all();

        return json_encode($country);
        exit;
    }
    public function countryLists()
    {
        $countryTable    =    TableRegistry::get('Countries');
        //$result			=	$countryTable->find('list', ['keyField' => 'ccode', 'valueField' => 'country'])->toArray();
        $result            =    $countryTable->find('list', ['keyField' => 'ccode', 'valueField' => 'country'])->order(['country' => 'ASC'])->toArray();
        return $result;
    }

    /**
     * @States List 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function statesList()
    {
        $Table = TableRegistry::getTableLocator()->get('States');
        $query = $Table->find('list', [
            'keyField' => 'id',
            'valueField' => 'state'
        ])->order(['state' => 'ASC']);
        $states = $query->enableHydration(false)->toArray();
        return $states;
        exit;
    }

    /**
     * @States List by country id 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function statesByCon($c_id)
    {
        $Table = TableRegistry::get('States');
        $query = $Table->find('list', [
            'keyField' => 'id',
            'valueField' => 'region_name'
        ])->where(['status' => 1, 'country_id' => $c_id])->order(['region_name' => 'ASC']);
        $states = $query->all();

        return json_encode($states);
        exit;
    }

    /**
     * @States generate unique number 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function generateUniqueNumber($length = 10)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @getCategory 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function getCategory()
    {
        $catTable = TableRegistry::get('Categories');
        $categories = $catTable->find('all')->where(['status' => 1, 'parent_cat' => 0])->order(['title' => 'ASC'])->toArray();

        return $categories;
    }

    public function categoryList()
    {
        $table    =    TableRegistry::getTableLocator()->get('Categories');
        $result    =    $table->find('list', ['keyField' => 'id', 'valueField' => 'title'])->where(['status' => ACTIVE])->toArray();
        return $result;
    }
    /**
     * @getCmsPage 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    /**
     * @getLatestProducts 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function getLatestProducts()
    {
        $productTable = TableRegistry::getTableLocator()->get('Products');
        $latestProducts = $productTable->find('all')->where(['status' => 1])->contain(['ProductImages'])->limit(5)->order(['id' => 'DESC'])->toArray();
        return $latestProducts;
    }

    /**
     * @getRelatedProducts 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */
    public function getRelatedProducts($categories)
    {
        $productTable = TableRegistry::getTableLocator()->get('Products');
        $relatedProducts = $productTable->find('all')->where(['status' => 1, 'category_id IN' => $categories, 'sold_status' => 0])->contain(['ProductImages'])->limit(5)->order(['id' => 'DESC'])->toArray();
        return $relatedProducts;
    }
    /**
     * @getFutureProducts 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function getFutureProducts()
    {
        $productTable = TableRegistry::get('Products');
        // get isFeture Product 
        //$is_future = $productTable->find('all')->where(['status' => 1])->contain(['ProductImages'])->limit(10)->order(['title'=>'ASC'])->toArray();
        $is_future = '';
        return $is_future;
    }

    /**
     * @getspecialProducts 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function getspecialProducts()
    {
        $productTable = TableRegistry::get('Products');

        //$is_special = $productTable->find('all')->where(['status' => 1,'is_special'=>1])->contain(['ProductImages'])->limit(10)->order(['id'=>'ASC'])->toArray();
        $is_special = '';
        return $is_special;
    }

    /**
     * @getBestProducts 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function getBestProducts()
    {
        $productTable = TableRegistry::get('Products');
        //$is_best = $productTable->find('all')->where(['status' => 1,'total_quantity <='=>6 ])->contain(['ProductImages'])->limit(10)->order(['title'=>'ASC'])->toArray();
        $is_best = '';
        return $is_best;
    }

    /**
     * @getHotSalesProducts 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function getHotSalesProducts()
    {
        $productTable = TableRegistry::get('Products');
        //$is_best = $productTable->find('all')->where(['status' => 1,'is_special'=>1,'is_future'=>1])->contain(['ProductImages'])->limit(10)->order(['title'=>'ASC'])->toArray();
        $is_best = '';
        return $is_best;
    }


    /**
     * @getNewArivalProducts 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function getNewArivalProducts()
    {
        $productTable = TableRegistry::get('Products');
        // get new arival Product 
        //	$new_arival = $productTable->find('all')->where(['status' => 1])->contain(['ProductImages'])->order(['id'=>'ASC'])->toArray();
        $new_arival = '';
        return $new_arival;
    }

    /**
     * @getNewProducts 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function getNewProducts()
    {
        $productTable = TableRegistry::get('Products');
        // get new Product
        //$newProducts = $productTable->find('all')->where(['status' => 1])->contain(['ProductImages'])->limit(10,10)->order(['id'=>'DESC'])->toArray();
        $newProducts = '';
        return $newProducts;
    }

    /**
     * @getCaptionFront 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function getCaptionFront()
    {
        // caption List	
        $captionsTable = TableRegistry::get('Captions');
        $captionFront   =  $captionsTable->find('all')->where(['status' => 1])->limit(4)->order(['id' => 'ASC'])->toArray();

        return $captionFront;
    }

    /**
     * @getCaptionBack 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function getCaptionBack()
    {
        // caption List	
        $captionsTable = TableRegistry::get('Captions');

        $captionBack   =  $captionsTable->find('all')->where(['status' => 1])->limit(2)->order(['id' => 'DESC'])->toArray();

        return $captionBack;
    }

    /**
     * @getBannersList 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function getBannersList()
    {
        // caption List	
        // Banner List	 

        $bannerTable   = TableRegistry::get('Banners');
        $bannersList   =  $bannerTable->find('all')->where(['status' => 1])->limit(1)->order(['id' => 'DESC'])->toArray();

        return $bannersList;
    }


    /**
     * @getMostViewsList 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function getMostViewsList()
    {

        $Table   = TableRegistry::get('MostViews');


        $startData    =    date('Y-m-d') . ' 00:00:00';
        $endData    =    date('Y-m-d') . ' 23:59:59';
        $result = $Table->find()
            ->select([
                'MostViews.product_id',
                'total_views' => $Table->query()->func()->count('*'),
            ])
            ->where([
                'MostViews.created >=' => $startData,
                'MostViews.created <=' => $endData
            ])
            ->group('MostViews.product_id')
            ->contain([
                'Products' => function ($q) {
                    return $q->contain(['ProductImages']);
                }
            ])
            ->toArray();


        //$MostViewsList   =  $mostViewTable->find('all')->contain([''])->order(['id'=>'DESC'])->toArray();
        return $result;
    }


    /**
     * @getCategoryList 
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param integer $id
     * @return void
     */

    public function getCategoryList()
    {
        $catTable = TableRegistry::get('Categories');
        $categoryList = $catTable->find('list')->where(['status' => 1])->order(['title' => 'ASC'])->toArray();
        return $categoryList;
    }
    public function getAllSize()
    {
        $table    =    TableRegistry::get('Dimensions');
        /* $result	=	$table->find('all')->where(['status'=>ACTIVE])->order(['Dimensions.type' => 'ASC','Dimensions.title' => 'DESC'])->toArray(); */
        /* $result	=	$table->find('threaded')->where(['status'=>ACTIVE,'is_large_runner'=>0])->order(['Dimensions.type' => 'ASC','Dimensions.slug' => 'DESC'])->toArray(); */
        //$result	=	$table->find('threaded')->where(['status'=>ACTIVE,'is_large_runner'=>0])->order(['Dimensions.order_type' => 'ASC'])->toArray();
        $order = array("Dimensions.type" => "ASC", "CAST( Dimensions.slug AS UNSIGNED ) ASC");
        $result    =    $table->find('threaded')->where(['status' => ACTIVE, 'is_large_runner' => 0])->order($order)->toArray();
        return $result;
    }
    public function getcartdata()
    {
        $session = $this->request->getSession();
        return $cardData = $session->read('cart');
    }
    public function getExtralongreturn()
    {
        $table    =    TableRegistry::get('Dimensions');
        $result    =    $table->find('threaded')->where(['status' => ACTIVE, 'is_large_runner' => 1, 'parent_id' => 0])->order(['Dimensions.slug' => 'ASC'])->toArray();
        return $result;
    }
    public function getspecialDimensions()
    {
        $table    =    TableRegistry::get('Dimensions');
        $result    =    $table->find('threaded')->where(['status' => ACTIVE, 'parent_id' => 20])->order(['Dimensions.order_type' => 'ASC'])->toArray();
        return $result;
    }
    public function getspecialDimensionsNav()
    {
        $conn = ConnectionManager::get('default');
        $stmt = $conn->execute("SELECT Dimensions.id,Dimensions.title,Dimensions.type,Dimensions.slug,Dimensions.term,CONVERT(SUBSTRING_INDEX(LOWER(Dimensions.title),'x',1),UNSIGNED INTEGER) as fr,CONVERT(SUBSTRING_INDEX(LOWER(Dimensions.title),'x',-1),UNSIGNED INTEGER) as sr FROM dimensions as Dimensions where Dimensions.status=1 and Dimensions.parent_id=20 order by fr asc, sr asc");
        $result = $stmt->fetchAll('assoc');
        return $result;
    }
    public function getSpecialSize()
    {
        $table    =    TableRegistry::get('Dimensions');
        $result    =    $table->find('all')->where(['status' => ACTIVE, 'parent_id' => 20])->toArray();

        //pr($result); die;
        return $result;
    }
    public function getAllColors()
    {
        $table    =    TableRegistry::get('Colors');
        $result    =    $table->find('all')->where(['status' => ACTIVE])->order(['Colors.name' => 'ASC'])->toArray();
        return $result;
    }
    public function getFilterPrice()
    {
        $prizeArray = array();

        // $prizeArray = array('75-200' =>'$75 - $200','200-500' =>'$200 - $500','500-750' =>'$500 - $750','750-1500' =>'$750 - $1500','1500-3000' =>'$1500 - $3000','3000' =>'$3000+');
        $prizeArray = array(
            "1-900" => "Under $900",
            "1000-2999" => "$1000-$2999",
            "3000-4999" => "$3000-$4999",
            "5000-6999" => "$5000-$6999",
            "7000-8999" => "$7000-$8999",
            "9000-10999" => "$9000-$10999",
            "11000-14999" => "$11000-$14999",
            "15000" => "Over $15000",
        );

        return $prizeArray;
    }
    public function getFilterPriceSort()
    {
        $prizesortArray = array();
        //price_sort
        $prizesortArray = array('high' => 'High to Low', 'low' => 'Low to High');

        return $prizesortArray;
    }
    public function getCmspage()
    {
        $cmspageTable = TableRegistry::get('CmsPages');
        $cmspage = $cmspageTable->find('all')->where(['slug' => 'About-us'])->orWhere(['slug' => 'Contact-us'])->toArray();
        return $cmspage;
    }
    /* public function getCmsPage(){
		$cmsPageTable = TableRegistry::get('CmsPages');
            
		$static_pages = $cmsPageTable->find('all')
		->select(['id','title','slug'])
		->where(['CmsPages.status'=>1])
		->order(['CmsPages.id'=>'ASC'])
		->limit(6);
		
		return $static_pages;
	} */
    public function returnCollectionCategory()
    {
        $collectionsTable = TableRegistry::getTableLocator()->get('Collections');
        $collectionCategory = $collectionsTable->find('all')
            ->select(['id', 'title'])
            ->where(['collection_type' => 'category', 'status' => 1])
            ->distinct(['title'])
            ->toList();

        $collectionCategoryArray = [];
        foreach ($collectionCategory as $item) {
            $collectionCategoryArray[$item->id] = $item->title;
        }

        return $collectionCategoryArray;
    }

    public function returnCollectionImages($id)
    {
        $collectionsImagesTable = TableRegistry::getTableLocator()->get('collection_images');
        $collectionImages_SQL = $collectionsImagesTable->find('all')
            ->select(['id', 'file_path', 'image_type', 'associated_id'])
            ->where(['associated_id' => $id]);
        if ($collectionImages_SQL->count() > 0) {
            $collectionImages = $collectionImages_SQL->enableHydration(false)->toList();
            return $collectionImages;
        }
        return [];
    }
    public function checkCartAddedProducts()
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
}
