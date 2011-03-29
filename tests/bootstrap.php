<?php
define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));
define('APPLICATION_PATH', BASE_PATH . '/application');
define('TEST_PATH', BASE_PATH . '/tests');
define('APPLICATION_ENV', 'testing');

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(BASE_PATH . '/library'),
    TEST_PATH,
    get_include_path(),
)));

require_once 'Zend/Application.php';
$application = new Zend_Application(APPLICATION_ENV,
                                    APPLICATION_PATH
                                    . '/configs/application.ini');

$application->bootstrap();