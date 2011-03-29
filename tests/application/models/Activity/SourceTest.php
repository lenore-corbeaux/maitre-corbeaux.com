<?php
/**
 * Test class for MaitreCorbeaux_Model_Activity_Source
 * 
 */
class MaitreCorbeaux_Model_Activity_SourceTest extends PHPUnit_Framework_TestCase
{
    /**
     * Model under test
     * 
     * @var MaitreCorbeaux_Model_Activity_Source
     */
    protected $_model;

    /**
     * Data provider
     * 
     * @return array
     */
    static public function provider()
    {
        return array(
            array(
                array(
                    'id' => 1,
                    'name' => 'A name',
                    'slug' => 'a-slug',
                    'link' => 'http://www.maitre-corbeaux.com/'
                )
            )
        );
    }

    /**
     * Initialize the TestCase
     *
     * @return void
     */
    public function setUp()
    {
        $this->_model = new MaitreCorbeaux_Model_Activity_Source();
    }

    public function testNewModelIsEmpty()
    {
        $this->assertNull($this->_model->getId());
        $this->assertNull($this->_model->getName());
        $this->assertNull($this->_model->getSlug());
        $this->assertNull($this->_model->getLink());
    }

    /**
     *
     * @dataProvider provider
     */
    public function testFillModelWithData($data)
    {
        $this->_model->populate($data);
        $this->assertEquals($data, $this->_model->toArray());
    }

    public function testSetUnexistentProperty()
    {
        $this->setExpectedException('MaitreCorbeaux_Model_Exception');
        $this->_model->unexistentProperty = 'foo';
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