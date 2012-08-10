<?php
/**
 * Test class for MaitreCorbeaux_Paginator_Adapter_ModelCollection.
 * 
 */
class MaitreCorbeaux_Paginator_Adapter_ModelCollectionTest
extends PHPUnit_Framework_TestCase
{
    /**
     * Paginator adapter under test.
     * 
     * @var MaitreCorbeaux_Paginator_Adapter_ModelCollection
     */
    protected $_adapter;
    
    /**
     * Mocked Zend_Db_Select object.
     * 
     * @var Zend_Db_Select
     */
    protected $_select;
    
    /**
     * Mocked mapper.
     * 
     * @var MaitreCorbeaux_Model_Mapper_AbstractMapper
     */
    protected $_mapper;
    
    /**
     * Initialize the TestCase
     *
     * @return void
     */
    public function setUp()
    {
        $this->_select = $this->getMock(
            'Zend_Db_Select', array(), array(), '', false
        );
        
        $this->_mapper = 
            $this->getMock('MaitreCorbeaux_Model_Mapper_AbstractMapper');
            
        $this->_adapter = new MaitreCorbeaux_Paginator_Adapter_ModelCollection(
            $this->_select, $this->_mapper
        );
    }
    
    public function testMapperConstructSetMapper()
    {
        $this->assertSame($this->_mapper, $this->_adapter->getMapper());
    }
    
    public function testNewMapperCanBeGetAndSet()
    {
        $mapper = $this->getMock('MaitreCorbeaux_Model_Mapper_AbstractMapper');
        $this->_adapter->setMapper($mapper);
        $this->assertSame($mapper, $this->_adapter->getMapper());
    }
    
    public function testGetItems()
    {
        $offset = 123;
        $count = 456;
        $data = array(1, 2, 3);
        
        $expected = $this->getMock(
            'Maitrecorbeaux_Model_Collection_AbstractCollection'
        );
        
        $statement = $this->getMock(
            'Zend_Db_Statement', array(), array(), '', false
        );
        
        $statement->expects($this->once())
                  ->method('fetchAll')
                  ->will($this->returnValue($data));
        
        $this->_select->expects($this->once())
                      ->method('limit')
                      ->with($this->equalTo($count), $this->equalTo($offset));
                      
        $this->_select->expects($this->once())
                      ->method('query')
                      ->will($this->returnValue($statement));
                      
        $this->_mapper->expects($this->once())
                      ->method('createCollection')
                      ->with($this->equalTo($data))
                      ->will($this->returnValue($expected));
                      
        $actual = $this->_adapter->getItems($offset, $count);
        $this->assertSame($expected, $actual);
    }

    /**
     * TestCase tear down
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->_adapter);
    }
}