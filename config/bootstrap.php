<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

/*
 * Configure paths required to find CakePHP + general filepath constants
 */
require __DIR__ . '/paths.php';

/*
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CORE_PATH . 'config' . DS . 'bootstrap.php';

use Cake\Cache\Cache;
use Cake\Console\ConsoleErrorHandler;
use Cake\Core\App;
use Cake\Core\Configure;

use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;
use Cake\Database\Type;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorHandler;
use Cake\Http\ServerRequest;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Utility\Inflector;
use Cake\Utility\Security; 
use Cake\ORM\TableRegistry;

/**
 * Uncomment block of code below if you want to use `.env` file during development.
 * You should copy `config/.env.default to `config/.env` and set/modify the
 * variables as required.
 */
// if (!env('APP_NAME') && file_exists(CONFIG . '.env')) {
//     $dotenv = new \josegonzalez\Dotenv\Loader([CONFIG . '.env']);
//     $dotenv->parse()
//         ->putenv()
//         ->toEnv()
//         ->toServer();
// }

/*
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

/*
 * Load an environment local configuration file.
 * You can use a file like app_local.php to provide local overrides to your
 * shared configuration.
 */
//Configure::load('app_local', 'default');

/*
 * When debug = true the metadata cache should only last
 * for a short time.
 */
if (Configure::read('debug')) {
    Configure::write('Cache._cake_model_.duration', '+2 minutes');
    Configure::write('Cache._cake_core_.duration', '+2 minutes');
    // disable router cache during development
    Configure::write('Cache._cake_routes_.duration', '+2 seconds');
}

/*
 * Set the default server timezone. Using UTC makes time calculations / conversions easier.
 * Check http://php.net/manual/en/timezones.php for list of valid timezone strings.
 */
date_default_timezone_set(Configure::read('App.defaultTimezone'));

/*
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/*
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
ini_set('intl.default_locale', Configure::read('App.defaultLocale'));

/*
 * Register application error and exception handlers.
 */
$isCli = PHP_SAPI === 'cli';
if ($isCli) {
    (new ConsoleErrorHandler(Configure::read('Error')))->register();
} else {
    (new ErrorHandler(Configure::read('Error')))->register();
}

/*
 * Include the CLI bootstrap overrides.
 */
if ($isCli) {
    require __DIR__ . '/bootstrap_cli.php';
}

/*
 * Set the full base URL.
 * This URL is used as the base of all absolute links.
 *
 * If you define fullBaseUrl in your config file you can remove this.
 */
if (!Configure::read('App.fullBaseUrl')) {
    $s = null;
    if (env('HTTPS')) {
        $s = 's';
    }

    $httpHost = env('HTTP_HOST');
    if (isset($httpHost)) {
        Configure::write('App.fullBaseUrl', 'http' . $s . '://' . $httpHost);
    }
    unset($httpHost, $s);
}

Cache::setConfig(Configure::consume('Cache'));
ConnectionManager::setConfig(Configure::consume('Datasources'));
Email::setConfigTransport(Configure::consume('EmailTransport'));
Email::setConfig(Configure::consume('Email'));
Log::setConfig(Configure::consume('Log'));
Security::setSalt(Configure::consume('Security.salt'));

/*
 * The default crypto extension in 3.0 is OpenSSL.
 * If you are migrating from 2.x uncomment this code to
 * use a more compatible Mcrypt based implementation
 */
//Security::engine(new \Cake\Utility\Crypto\Mcrypt());

/*
 * Setup detectors for mobile and tablet.
 */
ServerRequest::addDetector('mobile', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isMobile();
});
ServerRequest::addDetector('tablet', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isTablet();
});

/*
 * Enable immutable time objects in the ORM.
 *
 * You can enable default locale format parsing by adding calls
 * to `useLocaleParser()`. This enables the automatic conversion of
 * locale specific date formats. For details see
 * @link https://book.cakephp.org/3.0/en/core-libraries/internationalization-and-localization.html#parsing-localized-datetime-data
 */
Type::build('time')
    ->useImmutable();
Type::build('date')
    ->useImmutable();
Type::build('datetime')
    ->useImmutable();
Type::build('timestamp')
    ->useImmutable();

/*
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 */
//Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
//Inflector::rules('irregular', ['red' => 'redlings']);
//Inflector::rules('uninflected', ['dontinflectme']);
//Inflector::rules('transliteration', ['/å/' => 'aa']);

// settings
$data = TableRegistry::get('Settings');
$query = $data->find('all');
 
$results = $query->toArray();

if(!empty($results)){
	foreach($results as $result){  
		Configure::write("App.".$result->slug,$result->value);
		 
		Configure::write($result->slug,$result->value);
	}
}  

Configure::write('Paypal.mode', array(
		'sandbox' => 1,"live"=>2
	));
	
//Configure::write('currency','AED');
Configure::write('currency','$');

define('SKUNO','7');

define('CURRENCY','$');


define('RECTANGULAR','1');
define('ROUNDTYPE','2');
define('RUNNER','3');
define('SQUARE','4');
define('SPECIALSIZES','5');
define('Octagon','6');
define('Oval','7');
Configure::write("OverstockStyle", array(
						"Traditional"=>"Traditional",
						"Transitional"=>"Transitional",
						"Contemporary"=>"Contemporary",
				));		

Configure::write("Order.status",array('Pending'=>'0','Canceled'=>'1','Processing'=>'2','Completed'=>'3','Return'=>'4','Shipped'=>'5'));

Configure::write('size.type', [
	RECTANGULAR	=>	'Rectangular',
	ROUNDTYPE	=>	'Round',
	SQUARE		=>	'Square',
	RUNNER		=>	'Runner',
	SPECIALSIZES => 'Odd & Special Sizes',
	Octagon => 'Octagon',
	Oval => 'Oval'
]);

define('Active','1');
define('Inactive','2');



define('ACTIVE','1');
define('INACTIVE','2');
 
define('ADMIN','1');
//define('FRONT','2');
define('FRONT','3');

Configure::write('price_type',array('$'=>1));
Configure::write('status', array(
	ACTIVE	=>	'Active',
	INACTIVE=>	'Inactive'
));
Configure::write('user_role', [
	ADMIN	=>	'Admin User',
	FRONT	=>	'Front User'
]);

// Configure::write('rug_type', [
// 	'Hand Woven'	=>	'Hand Woven',
// 	'Hand Knotted'	=>	'Hand Knotted',
// 	'Hand Stitched'=>'Hand Stitched',
// 	'Tufted'=>'Tufted',
// 	'Hand Loomed'=>'Hand Loomed'	
// ]);

//use in filter as construction
Configure::write('rug_type', array("Braided"=>"Braided",
								"Flatweave"=>"Flat Weave",
								"Hand-Hooked"=>"Hand Hooked",
								"Hand-Knotted"=>"Hand Knotted",
								"Hand-Tufted"=>"Hand Tufted",
								"Hand-Woven"=>"Hand Woven",
								"Machine-Made"=>"Machine Made" 
							)
						);
Configure::write('dimension1_feet',[
    '0'	=>	'0',
	'1'	=>	'1',
	'2'	=>	'2',
	'3'	=>	'3',
	'4'	=>	'4',
	'5'	=>	'5',
	'6'	=>	'6',
	'7'	=>	'7',
	'8'	=>	'8',
	'9'	=>	'9',
	'10'	=>	'10',
	'11'	=>	'11',
	'12'	=>	'12',
	'13'	=>	'13',
	'14'	=>	'14',
	'15'	=>	'15',
	'16'	=>	'16',
	'17'	=>	'17',
	'18'	=>	'18',
	'19'	=>	'19',
	'20'	=>	'20',
	'21'	=>	'21',
	'22'	=>	'22',
	'23'	=>	'23',
	'24'	=>	'24',
	'25'	=>	'25',
	'26'	=>	'26',
	'27'	=>	'27',
	'28'	=>	'28',
	'29'	=>	'29',
	'30'	=>	'30',
	'31'	=>	'31',
	'32'	=>	'32',
	'33'	=>	'33',
	'34'	=>	'34',
	'35'	=>	'35',
	'36'	=>	'36',
	'37'	=>	'37',
	'38'	=>	'38',
	'39'	=>	'39',
	'40'	=>	'40'
]);
Configure::write('dimension2_feet',[
    '0'	=>	'0',
	'1'	=>	'1',
	'2'	=>	'2',
	'3'	=>	'3',
	'4'	=>	'4',
	'5'	=>	'5',
	'6'	=>	'6',
	'7'	=>	'7',
	'8'	=>	'8',
	'9'	=>	'9',
	'10'	=>	'10',
	'11'	=>	'11',
	'12'	=>	'12',
	'13'	=>	'13',
	'14'	=>	'14',
	'15'	=>	'15',
	'16'	=>	'16',
	'17'	=>	'17',
	'18'	=>	'18',
	'19'	=>	'19',
	'20'	=>	'20',
	'21'	=>	'21',
	'22'	=>	'22',
	'23'	=>	'23',
	'24'	=>	'24',
	'25'	=>	'25',
	'26'	=>	'26',
	'27'	=>	'27',
	'28'	=>	'28',
	'29'	=>	'29',
	'30'	=>	'30',
	'31'	=>	'31',
	'32'	=>	'32',
	'33'	=>	'33',
	'34'	=>	'34',
	'35'	=>	'35',
	'36'	=>	'36',
	'37'	=>	'37',
	'38'	=>	'38',
	'39'	=>	'39',
	'40'	=>	'40'
]);
Configure::write('dimension1_inches',[
    '0'	=>	'0',
	'1'	=>	'1',
	'2'	=>	'2',
	'3'	=>	'3',
	'4'	=>	'4',
	'5'	=>	'5',
	'6'	=>	'6',
	'7'	=>	'7',
	'8'	=>	'8',
	'9'	=>	'9',
	'10'	=>	'10',
	'11'	=>	'11' 
]);
Configure::write('dimension2_inches',[
    '0'	=>	'0',
	'1'	=>	'1',
	'2'	=>	'2',
	'3'	=>	'3',
	'4'	=>	'4',
	'5'	=>	'5',
	'6'	=>	'6',
	'7'	=>	'7',
	'8'	=>	'8',
	'9'	=>	'9',
	'10'	=>	'10',
	'11'	=>	'11' 
]);

Configure::write('style',[
	'Casual'	=>	'Casual',
	'Classic'	=>	'Classic',
	'Contemporary'	=>	'Contemporary',
	'Country'	=>	'Country',
	'Formal'	=>	'Formal',
	'Holiday'	=>	'Holiday',
	'Kids & Tween'	=>	'Kids & Tween',
	'Novelty'	=>	'Novelty',
	'Patterned'	=>	'Patterned',
	'Shag'	=>	'Shag',
	'Southwestern'	=>	'Southwestern',
	'Sports & Collegiate'	=>	'Sports & Collegiate',
	'Traditional'	=>	'Traditional',
	'Transitional'	=>	'Transitional',
	'Vintage'	=>	'Vintage' 
]);


Configure::write('speceialSizeWidth_drop', array(1=>"1",
												2=>"2",
												3=>"3",
												4=>"4",
												5=>"5",
												6=>"6",
												7=>"7",
												8=>"8",
												9=>"9",
												10=>"10",
												11=>"11",
												12=>"12",
												13=>"13",
												14=>"14",
												15=>"15",
												16=>"16",
												17=>"17",
												18=>"18",
												19=>"19",
												20=>"20",
												21=>"21",
												22=>"22"
											)
						);
Configure::write('speceialSizeHeight_drop', array(1=>"1",
												2=>"2",
												3=>"3",
												4=>"4",
												5=>"5",
												6=>"6",
												7=>"7",
												8=>"8",
												9=>"9",
												10=>"10",
												11=>"11",
												12=>"12",
												13=>"13",
												14=>"14",
												15=>"15",
												16=>"16",
												17=>"17",
												18=>"18",
												19=>"19",
												20=>"20",
												21=>"21",
												22=>"22"
											)
						);
						
/* Configure::write('OverstockPattern', array("Abstract"=>"Abstract",
	"Animal"=>"Animal",
											"Argyle"=>"Argyle",
											"Border"=>"Border",
											"Check"=>"Check",
											"Dots"=>"Dots",
											"Floral"=>"Floral",
											"Geometric"=>"Geometric",											
											"Houndstooth"=>"Houndstooth",
											"Ikat"=>"Ikat",
											"Nature"=>"Nature",
											"Oriental"=>"Oriental",
											"Paisley"=>"Paisley",
											"Plaid"=>"Plaid",											
											"Solid"=>"Solid",
											"Stripe"=>"Stripe"
										)
						); 

Configure::write('rugDesign', array("Abadeh"=>"Abadeh",
											"Afshar"=>"Afshar",
											"Ahar"=>"Ahar",
											"Arak"=>"Arak",
											"Ardebil"=>"Ardebil",
											"Ardekan"=>"Ardekan",
											"Bakhtiari"=>"Bakhtiari",
											"Balouchi"=>"Balouchi",											
											"Bibiabad"=>"Bibiabad",
											"Bijar"=>"Bijar",
											"Darzeguin"=>"Darzeguin",
											"Enjelas"=>"Enjelas",
											"Farahan"=>"Farahan",
											"Gabbeh"=>"Gabbeh",											
											"Goravan"=>"Goravan",
											"Hamadan"=>"Hamadan",
											"Heriz"=>"Heriz",
											"Husseinabad"=>"Husseinabad",
											"Isfahan"=>"Isfahan",
											"Josheghan"=>"Josheghan",
											"Karabagh"=>"Karabagh",
											"Kashan"=>"Kashan",
											"Kashmar"=>"Kashmar",
											"Kerman"=>"Kerman",
											"Kermanshah"=>"Kermanshah",
											"Koliai"=>"Koliai",
											"Lilian"=>"Lilian",
											"Mahabad"=>"Mahabad",
											"Mahal"=>"Mahal",
											"Malayer"=>"Malayer",
											"Mashad"=>"Mashad",
											"Maymeh"=>"Maymeh",
											"Mazlaghan"=>"Mazlaghan",
											"Mehraban"=>"Mehraban",
											"Meshkin"=>"Meshkin",
											"Mianeh"=>"Mianeh",
											"Mood"=>"Mood",
											"Mousel"=>"Mousel",
											"Nahavand"=>"Nahavand",
											"Nain"=>"Nain",
											"Najafabad"=>"Najafabad",
											"Nanadj"=>"Nanadj",
											"Nepalese"=>"Nepalese",
											"Oushak"=>"Oushak",
											"Qashqai"=>"Qashqai",
											"Qum"=>"Qum",
											"Ghom"=>"Ghom",
											"Sarab"=>"Sarab",
											"Saveh"=>"Saveh",
											"Seraband"=>"Seraband",
											"Serapi"=>"Serapi",
											"Shahreza"=>"Shahreza"
										)
						);  
 
Configure::write('rugMaterial', array("Cotton"=>"Cotton",
											"Leather And Suede"=>"Leather And Suede",
											"Sisal And Jute"=>"Sisal And Jute",
											"Synthetic"=>"Synthetic",
											"Wool And Silk"=>"Wool And Silk",
											"Wool And Wool Blend"=>"Wool And Wool Blend"
										)
						); */

$siteFolder	= dirname(dirname($_SERVER['SCRIPT_NAME']));
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . $siteFolder);
define('webroot', SITE_URL.'/webroot/');


/* get pattern data */
$data1 = TableRegistry::get('Patterns');
$query1 = $data1->find('all')->where(['status'=>1])->order(['title'=>'asc']);
$results1 = $query1->toArray();

if(!empty($results1)){
	$arr = array();
	foreach($results1 as $result){  
		$arr[$result->title] = $result->title;
	}
	Configure::write('OverstockPattern',$arr);
}

/* get design data */
$data2 = TableRegistry::get('Designs');
$query2 = $data2->find('all')->where(['status'=>1])->order(['title'=>'asc']);
$results2 = $query2->toArray();

if(!empty($results2)){
	$arr2 = array();
	foreach($results2 as $result){  
		$arr2[$result->title] = $result->title;
	}
	Configure::write('rugDesign',$arr2);
}


/* get material data */
$data3 = TableRegistry::get('Materials');
$query3 = $data3->find('all')->where(['status'=>1])->order(['title'=>'asc']);
$results3 = $query3->toArray();

if(!empty($results3)){
	$arr3 = array();
	foreach($results3 as $result){  
		$arr3[$result->title] = $result->title;
	}
	Configure::write('rugMaterial',$arr3);
}
define('CAPTCHA_SITEKEY','6LfQzK4qAAAAAIpST_YxkEoZ_duvF7P5hEqwi9Yi');
define('CAPTCHA_SECRETKEY','6LfQzK4qAAAAAMIn6p4l4goSoFWsSio6ZSJTpGfJ');
define('KAOUDS_SALT','KAOUDS-RUGS-KEY');