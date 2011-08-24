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
        $mapper = $this->getMock('MaitreCorbeaux_Model_Mapper_Activity_Item');
        $this->_service = new MaitreCorbeaux_Service_Activity_Item();
        $this->_service->setMapper($mapper);
    }

    public function testImportActivityItem()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    public function testFetchLast()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    public function testPaginateAll()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    public function testPaginateAllIn()
    {
        $this->markTestIncomplete('Not yet implemented');
    }
    
    public function testFetchAllCallMapperFetchAll()
    {
        $items = new MaitreCorbeaux_Model_Collection_Activity_Item();
        
        $this->_service
             ->getMapper()
             ->expects($this->once())
             ->method('fetchAll')
             ->will($this->returnValue($items));
             
        $newItems = $this->_service->fetchAll();
        $this->assertSame($items, $newItems);
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