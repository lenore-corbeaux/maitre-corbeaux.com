<?php
require_once 'AbstractControllerTestCase.php';

/**
 * Test class for ActivityController
 *
 */
class ActivityControllerTest extends AbstractControllerTestCase
{
    public function testIndexActionIsReachableWithoutPage()
    {
        $this->dispatch('/activity');

        $this->assertRoute('activity');
        $this->assertModule('default');
        $this->assertController('activity');
        $this->assertAction('index');
        $this->assertResponseCode(200);
    }

    public function testIndexActionIsReachableWithPage()
    {
        $this->dispatch('/activity/3');

        $this->assertRoute('activity');
        $this->assertModule('default');
        $this->assertController('activity');
        $this->assertAction('index');
        $this->assertResponseCode(200);
    }
}