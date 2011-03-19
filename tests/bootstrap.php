<?php
define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));
define('APPLICATION_PATH', BASE_PATH . '/application');
define('TEST_PATH', BASE_PATH . '/tests');
define('APPLICATION_ENV', 'testing');

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(BASE_PATH . '/library'),
    get_include_path(),
)));
