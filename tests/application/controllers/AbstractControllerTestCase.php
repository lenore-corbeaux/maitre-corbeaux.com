<?php
require_once 'Zend/Application.php';
require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';

abstract class AbstractControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
    protected $_application;

    public function setUp()
    {
        $application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        $this->_application = $application;

        $this->bootstrap = function() use ($application)
        {
            $application->bootstrap();

            $front = Zend_Controller_Front::getInstance();
            $front->setParam('bootstrap', $application->getBootstrap());
        };

        parent::setUp();
    }
}
