<?php
/**
 * Test class for base class MaitreCorbeaux_Model_AbstractModel.
 * 
 */
class MaitreCorbeaux_Model_AbstractModelTest extends PHPUnit_Framework_TestCase
{
    /**
     * Model under test
     * 
     * @var MaitreCorbeaux_Model_AbstractModel
     */
    protected $_model;

    /**
     * Initialize the TestCase
     *
     * @return void
     */
    public function setUp()
    {
        $this->_model = $this->getMock(
            'MaitreCorbeaux_Model_AbstractModel', null
        );
    }
    
    public function testGetUnexistentPropertyThrowsException()
    {
        $this->setExpectedException('MaitreCorbeaux_Model_Exception');
        $this->_model->notExists;
    }
    
    public function testSetUnexistentPropertyThrowsException()
    {
        $this->setExpectedException('MaitreCorbeaux_Model_Exception');
        $this->_model->notExists = 'whatever';
    }

    /**
     * TestCase tear down
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->_model);
    }
}
