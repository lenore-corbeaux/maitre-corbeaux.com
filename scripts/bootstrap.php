<?php
/**
 * Bootstrap for every cli scripts
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Scripts
 */

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

// Zend_Console_GetOpt is needed to define current environment
require_once 'Zend/Console/Getopt.php';

try {
    $console = new Zend_Console_Getopt(array(
        'environment|e=w' => 'Application environment to use'
    ));

    $env = $console->getOption('e');
} catch (Zend_Console_Getopt_Exception $e) {
    echo $console->getUsageMessage();
    exit;
}

if (null === $env) {
    $env = 'production';
}

define('APPLICATION_ENV', $env);

/** Zend_Application **/
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$resources = isset($resources) ? $resources : null;

$application->bootstrap($resources);
$bootstrap = $application->getBootstrap();