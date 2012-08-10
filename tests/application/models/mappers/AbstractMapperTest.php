<?php
/**
 * Test class for base class MaitreCorbeaux_Model_Mapper_AbstractMapper.
 * 
 */
class MaitreCorbeaux_Model_Mapper_AbstractMapperTest
extends PHPUnit_Framework_TestCase
{
    /**
     * Mapper under test.
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
        $this->_mapper = $this->getMock(
            'MaitreCorbeaux_Model_Mapper_AbstractMapper',
            array('createModel', 'createCollection')
        );
    }
    
    public function testDbTableCanBeGetAndSet()
    {
        $dbTable = $this->getMock('Zend_Db_Table');
        $this->_mapper->setDbTable($dbTable);
        $this->assertSame($dbTable, $this->_mapper->getDbTable());
    }

    /**
     * TestCase tear down
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->_mapper);
    }
}
