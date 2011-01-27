<?php
require_once 'AbstractControllerTestCase.php';

class ErrorControllerTest extends AbstractControllerTestCase 
{
    public function testErrorActionIsReachable()
    {
        $this->dispatch('/error/error/');

        $this->assertModule('default');
        $this->assertController('error');
        $this->assertAction('error');
        $this->assertResponseCode(200);
    }

    public function testExceptionNoActionCauses404Error()
    {
        $this->getResponse()
             ->setException(new Zend_Controller_Action_Exception('Test exception', 404));

        $this->dispatch('/');

        $this->assertModule('default');
        $this->assertController('error');
        $this->assertAction('error');
        $this->assertResponseCode(404);
    }

    public function testExceptionNoControllerCauses404Error()
    {
        $this->getResponse()
             ->setException(new Zend_Controller_Dispatcher_Exception('Test exception'));

        $this->dispatch('/');

        $this->assertModule('default');
        $this->assertController('error');
        $this->assertAction('error');
        $this->assertResponseCode(404);
    }

    public function testExceptionNoRouteCauses404Error()
    {
        $this->getResponse()
             ->setException(new Zend_Controller_Router_Exception('Test exception', 404));

        $this->dispatch('/');

        $this->assertModule('default');
        $this->assertController('error');
        $this->assertAction('error');
        $this->assertResponseCode(404);
    }

    public function testExceptionOtherCauses500Error()
    {
        $this->getResponse()
             ->setException(new Zend_Exception('Test exception'));

        $this->dispatch('/');
        
        $this->assertModule('default');
        $this->assertController('error');
        $this->assertAction('error');
        $this->assertResponseCode(500);
    }
}
