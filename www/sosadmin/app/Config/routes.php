<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	//Router::parseExtensions('html', 'rss', 'json');


    // Router::connect('/', array('controller' => 'index', 'action' => 'index'));
	// Router::connect('/contatos', array('controller' => 'contatos', 'action' => 'index'));


    //// CONSTRUTOR
    Router::connect('/_constructor/*', array('controller' => 'construct', 'action' => 'criartabelas', 'admin' => false));

    //// SOS-ADMIN
    Router::connect('/', array('controller' => 'index', 'action' => 'index', 'sos_admin' => true));
    Router::connect('/como-funciona', array('controller' => 'comoFunciona', 'action' => 'index', 'sos_admin' => true));
    Router::connect('/termo-de-uso', array('controller' => 'termoDeUso', 'action' => 'index', 'sos_admin' => true));
    Router::connect('/sobre', array('controller' => 'sobre', 'action' => 'index', 'sos_admin' => true));




	//// ADMIN
    Router::connect('/admin', array('controller' => 'index', 'action' => 'index', 'admin' => true));
	Router::connect('/admin/user/login', array('controller' => 'user', 'action' => 'login', 'admin' => true));
	//
    // Router::connect('/admin', array('controller' => 'index', 'action' => 'index', 'admin' => true));
	// Router::connect('/admin/user/login', array('controller' => 'user', 'action' => 'login', 'admin' => true));





    /**
     * ...and connect the rest of 'Pages' controller's urls.
     */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

    /**
     * Load all plugin routes.  See the CakePlugin documentation on
     * how to customize the loading of plugin routes.
     */
	CakePlugin::routes();

    /**
     * Load the CakePHP default routes. Remove this if you do not want to use
     * the built-in default routes.
     */
	require CAKE . 'Config' . DS . 'routes.php';
