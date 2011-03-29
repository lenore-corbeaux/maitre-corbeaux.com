<?php
/**
 * Test class for MaitreCorbeaux_Service_Activity_Source
 * 
 */
class MaitreCorbeaux_Service_Activity_SourceTest
extends PHPUnit_Framework_TestCase
{
    /**
     * Activity Item service
     * 
     * @var MaitreCorbeaux_Service_Activity_Source
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
        $this->_service = new MaitreCorbeaux_Service_Activity_Source();
    }

    public function testFetchAll()
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