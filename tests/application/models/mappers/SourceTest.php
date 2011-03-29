<?php
require_once 'DatabaseTestCase.php';

/**
 * Test class for MaitreCorbeaux_Model_Mapper_Activity_Source
 * 
 */
class MaitreCorbeaux_Model_Mapper_Activity_SourceTest extends DatabaseTestCase
{
    /**
     * Mapper under test
     * 
     * @var MaitreCorbeaux_Model_Mapper_Activity_Source
     */
    protected $_mapper;

    /**
     * Initialize the TestCase
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->_mapper = new MaitreCorbeaux_Model_Mapper_Activity_Source();
    }

    public function testFetchAll()
    {
        $collection = $this->_mapper->fetchAll();
        $this->assertEquals(3, count($collection));
    }

    /**
     * TestCase tear down
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->_mapper);
        parent::tearDown();
    }
}