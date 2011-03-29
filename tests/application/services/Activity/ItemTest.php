<?php
/**
 * Test class for MaitreCorbeaux_Service_Activity_Item
 * 
 */
class MaitreCorbeaux_Service_Activity_ItemTest
extends PHPUnit_Framework_TestCase
{
    /**
     * Activity Item service
     * 
     * @var MaitreCorbeaux_Service_Activity_Item
     */
    protected $_service;
    
    /**
     * Initialize the TestCase
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();        
        $this->_service = new MaitreCorbeaux_Service_Activity_Item();
    }

    public function testImportActivityItem()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    public function testFetchLast()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * TestCase tear down
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->_service);
    }
}