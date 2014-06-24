<?php
define('DS',  DIRECTORY_SEPARATOR);
define('PUBLIC_PATH', (__FILE__));
define('APPLICATION_PATH', realpath(dirname(PUBLIC_PATH)) . DS . 'application' );
define('CONTROLLER_PATH', APPLICATION_PATH . DS . 'controllers');
define('MODEL_PATH', APPLICATION_PATH . DS . 'models');
define('VIEW_PATH', APPLICATION_PATH . DS . 'views');
define('LAYOUT_PATH', APPLICATION_PATH . DS . 'layouts');
define('LIBRARY_PATH', APPLICATION_PATH . DS . 'libraries');


require_once LIBRARY_PATH . DS . 'Conf.php';
require_once LIBRARY_PATH . DS . 'Session.php';
require_once LIBRARY_PATH . DS . 'Form.php';
require_once LIBRARY_PATH . DS . 'Request.php';
require_once LIBRARY_PATH . DS . 'Response.php';
require_once LIBRARY_PATH . DS . 'Router.php';
require_once LIBRARY_PATH . DS . 'Dispatcher.php';
require_once LIBRARY_PATH . DS . 'View.php';
require_once LIBRARY_PATH . DS . 'Controller.php';
require_once LIBRARY_PATH . DS . 'Model.php';
require_once LIBRARY_PATH . DS . 'Layout.php';

$request = new Request;
$response = new Response;

$router = new Router($request);
$router->route();

$dispatcher = new Dispatcher($request, $response);
$dispatcher->dispatch();

$response->send();



