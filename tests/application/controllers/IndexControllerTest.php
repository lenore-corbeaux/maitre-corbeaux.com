<?php
require_once 'AbstractControllerTestCase.php';

class IndexControllerTest extends AbstractControllerTestCase 
{
    public function testIndexActionIsReachable()
    {
        $this->dispatch('/');

        $this->assertModule('default');
        $this->assertController('index');
        $this->assertAction('index');
        $this->assertResponseCode(200);
    }
}
