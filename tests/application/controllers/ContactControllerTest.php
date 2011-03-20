<?php
require_once 'AbstractControllerTestCase.php';

class ContactControllerTest extends AbstractControllerTestCase
{
    public function testIndexActionIsReachable()
    {
        $params = array('action' => 'index',
                        'controller' => 'contact',
                        'module' => 'default');

        $url = $this->url($this->urlizeOptions($params));
        $this->dispatch($url);
        
        $this->assertModule($params['module']);
        $this->assertController($params['controller']);
        $this->assertAction($params['action']);
    }

    public function testConfirmActionIsReachable()
    {
        $params = array('action' => 'confirm',
                        'controller' => 'contact',
                        'module' => 'default');

        $url = $this->url($this->urlizeOptions($params));
        $this->dispatch($url);

        $this->assertModule($params['module']);
        $this->assertController($params['controller']);
        $this->assertAction($params['action']);
    }
}





