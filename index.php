<?php
// Set the initial include_path. You may need to change this to ensure that
// Zend Framework is in the include_path; additionally, for performance
// reasons, it's best to move this to your web server configuration or php.ini
// for production.
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(dirname(__FILE__) . '/library'),
    get_include_path(),
)));

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

require_once 'Zend/Application.php'; 

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$FrontController = Zend_Controller_Front::getInstance();
$plugin = new Zend_Controller_Plugin_ErrorHandler();
$plugin->setErrorHandlerController('index');
$plugin->setErrorHandlerAction('index');
$FrontController->registerPlugin($plugin);
//*/
$application->bootstrap();
Bootstrap::loadConfig();
$server_name = $_SERVER['SERVER_NAME'];

$host_r=Bootstrap::parseHost($server_name);
if (! isset($host_r['a'])) {
	header("Location: http://www.$server_name".$_SERVER['REQUEST_URI']);
	exit;
} //else (not needed)

$useragent = $_SERVER['HTTP_USER_AGENT'];
if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
	$browser_version=$matched[1];
	$browser = 'IE';
} elseif (preg_match( '|Opera ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
	$browser_version=$matched[1];
	$browser = 'Opera';
} elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
	$browser_version=$matched[1];
	$browser = 'Firefox';
} elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
	$browser_version=$matched[1];
	$browser = 'Safari';
} else {
	// browser not recognized!
	$browser_version = 0;
	$browser= 'other';
}


define('BROWSER', $browser);
define('BROWSERV', (int)str_replace('.','',$browser_version));

$application->run();
//*/

