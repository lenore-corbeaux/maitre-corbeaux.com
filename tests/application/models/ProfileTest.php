<?php
/**
 * Test class for MaitreCorbeaux_Model_Profile
 * 
 */
class MaitreCorbeaux_Model_ProfileTest extends PHPUnit_Framework_TestCase
{
    /**
     * Model under test
     * 
     * @var MaitreCorbeaux_Model_Profile
     */
    protected $_model;
    
    /**
     * Data provider
     *
     * @return array
     */
    public static function provider()
    {
        return array(
            array(
                array(
                    'date' => new Zend_Date(),
                    'birthDate' => new Zend_Date(),
                    'age' => 123
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
        $this->_model = new MaitreCorbeaux_Model_Profile();
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

    public function testGetDateReturnsCurrentDateIfNoneProvided()
    {
        $date = $this->_model->getDate();
        $this->assertInstanceOf('Zend_Date', $date);
    }

    public function testGetAgeReturnsNullIfNoBirthDate()
    {
        $this->assertNull($this->_model->getBirthDate());
        $this->assertNull($this->_model->getAge());
    }

    public function testGetAgeReturnsTimespanBetweenDateAndBirthDate()
    {
        $date = new Zend_Date('11-08-2011');
        $birthDate = new Zend_Date('12-08-1983');

        $age = $this->_model->setDate($date)
                            ->setBirthDate($birthDate)
                            ->getAge();

        $this->assertEquals(27, $age);
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
