<?php
require_once 'AbstractControllerTestCase.php';

class ContactControllerTest extends AbstractControllerTestCase
{
    public function testIndexActionIsReachable()
    {
        $this->dispatch('/contact');
        
        $this->assertModule('default');
        $this->assertController('contact');
        $this->assertAction('index');
        $this->assertResponseCode(200);
    }

    public function testConfirmActionIsReachable()
    {
        $this->dispatch('/contact/confirm');

        $this->assertModule('default');
        $this->assertController('contact');
        $this->assertAction('confirm');
        $this->assertResponseCode(200);
    }
}





