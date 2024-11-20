<?php

/**
 * Set error reporting and display errors settings.  You will want to change these when in production.
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Website docroot
 */
define('DOCROOT', realpath(__DIR__.'/../../../docroot/').DIRECTORY_SEPARATOR);
define('APPPATH', realpath(__DIR__.'/../../../configure/').DIRECTORY_SEPARATOR);
define('PKGPATH', realpath(__DIR__.'/../packages/').DIRECTORY_SEPARATOR);
define('VENDORPATH', realpath(__DIR__.'/../vendor/').DIRECTORY_SEPARATOR);
define('COREPATH', realpath(__DIR__).DIRECTORY_SEPARATOR);

// Get the start time and memory for use later
defined('FUEL_START_TIME') or define('FUEL_START_TIME', microtime(true));
defined('FUEL_START_MEM') or define('FUEL_START_MEM', memory_get_usage());

// Load the Composer autoloader if present
defined('VENDORPATH') or define('VENDORPATH', realpath(COREPATH.'..'.DS.'vendor').DS);
if ( ! is_file(VENDORPATH.'autoload.php'))
{
	die('Composer is not installed. Please run "php composer.phar update" in the project root to install Composer');
}
require VENDORPATH.'autoload.php';

if (class_exists('AspectMock\Kernel'))
{
	// Configure AspectMock
	$kernel = \AspectMock\Kernel::getInstance();
	$kernel->init(array(
		'debug' => true,
		'appDir' => __DIR__.'/../',
		'includePaths' => array(
			APPPATH, COREPATH, PKGPATH,
		),
		'excludePaths' => array(
			APPPATH.'tests', COREPATH.'tests',
		),
		'cacheDir' => APPPATH.'tmp/AspectMock',
	));

	// Load in the Fuel autoloader
	$kernel->loadFile(COREPATH.'classes'.DIRECTORY_SEPARATOR.'autoloader.php');
}
else
{
	// Load in the Fuel autoloader
	require COREPATH.'classes'.DIRECTORY_SEPARATOR.'autoloader.php';
}

class_alias('Fuel\\Core\\Autoloader', 'Autoloader');

// Boot the app
require_once APPPATH.'bootstrap.php';

// Set test mode
\Fuel::$is_test = true;

// Ad hoc fix for AspectMock error
if (class_exists('AspectMock\Kernel'))
{
	class_exists('Errorhandler');
}

// Import the TestCase class
import('testcase');
