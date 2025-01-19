<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {

    //$routes->connect('/', ['prefix' => 'admin','controller' => 'Users', 'action' => 'login']);
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */

    $routes->connect('/', ['controller' => 'Pages', 'action' => 'home']);
    $routes->connect('/Products/', ['controller' => 'Products', 'action' => 'search']);
    $routes->connect(
        '/:slug',
        ['controller' => 'Pages', 'action' => 'display'],
        [
            'pass' => ['slug'],
            //'slug' => '[^\/]+' // Taken from your example
        ]
    );

    $routes->connect('/product-category/*', ['controller' => 'Products', 'action' => 'rugs']);

    $routes->connect('/rug-style/*', ['controller' => 'Products', 'action' => 'rugStyle']);
    $routes->connect('/rug-size/*', ['controller' => 'Products', 'action' => 'rugSize']);
    $routes->connect('/rug-color/*', ['controller' => 'Products', 'action' => 'rugColor']);
    $routes->connect('/contact/', ['controller' => 'Pages', 'action' => 'contactUs']);

    $routes->connect('/collections', ['controller' => 'Pages', 'action' => 'collectionMenu']);

    $routes->connect(
        '/collections/:slug',
        ['controller' => 'Pages', 'action' => 'collectionMenu'],
        ['pass' => ['slug'], 'slug' => '.*'] 
    );

    $routes->connect('/shop/', ['controller' => 'Products', 'action' => 'shopping']);
    $routes->connect('/completed-projects/', ['controller' => 'Pages', 'action' => 'projects']);
    $routes->connect('/about-us/:slug', ['controller' => 'Pages', 'action' => 'display'], ['pass' => ['slug'],'slug' => 'kaoud-carpets-rugs|our-brands-inventory|community|asid']);
    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */

    $routes->fallbacks(DashedRoute::class);
});

Router::prefix('admin', function ($routes) {
    $routes->connect('/', ['controller' => 'Users', 'action' => 'login']);

    $routes->connect('/forgot', ['controller' => 'Users', 'action' => 'forgot']);
    $routes->connect('/users/dashboard', ['controller' => 'Users', 'action' => 'index']);
    $routes->fallbacks('DashedRoute');
});
