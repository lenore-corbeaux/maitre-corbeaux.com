<?php
/**
 * Test class for MaitreCorbeaux_Model_Activity_Item
 * 
 */
class MaitreCorbeaux_Model_Activity_ItemTest extends PHPUnit_Framework_TestCase
{
    /**
     * Model under test
     * 
     * @var MaitreCorbeaux_Model_Activity_Item
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
                    'title' => 'A title',
                    'description' => 'A description',
                    'link' => 'http://www.maitre-corbeaux.com/',
                    'publicationDate' => new Zend_Date(),
                    'externalId' => 'an-external-id',
                    'source' => new MaitreCorbeaux_Model_Activity_Source()
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
        $this->_model = new MaitreCorbeaux_Model_Activity_Item();
    }

    public function testNewModelIsEmpty()
    {
        $this->assertNull($this->_model->getId());
        $this->assertNull($this->_model->getTitle());
        $this->assertNull($this->_model->getDescription());
        $this->assertNull($this->_model->getLink());
        $this->assertNull($this->_model->getPublicationDate());
        $this->assertNull($this->_model->getExternalId());
        $this->assertNull($this->_model->getSource());
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