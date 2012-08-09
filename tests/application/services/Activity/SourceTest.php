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
        
        $mapper = $this->getMock(
            'MaitreCorbeaux_Model_Mapper_Activity_Source'
        );
                
        $this->_service = new MaitreCorbeaux_Service_Activity_Source();
        $this->_service->setMapper($mapper);
    }

    public function testFetchAll()
    {
        $expected = new MaitreCorbeaux_Model_Collection_Activity_Source();
        $mapper = $this->_service->getMapper();
        $mapper->expects($this->once())
               ->method('fetchAll')
               ->will($this->returnValue($expected));
               
        $actual = $this->_service->fetchAll();
        $this->assertSame($expected, $actual);
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