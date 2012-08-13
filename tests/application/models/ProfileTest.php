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
                    'firstWorkDate' => new Zend_Date(),
                    'age' => 123,
                    'experience' => 7
                )
            )
        );
    }
    
    /**
     * Provides Zend_Date and expected age for age calculation.
     * 
     * @return array
     */
    public static function ageProvider()
    {
        return array(
            array(
                '11-08-2011', 27
            ),
            array(
                '12-08-2011', 28
            ),
            array(
                '11-08-2012', 28
            ),
            array(
                '12-08-2012', 29
            )
        );
    }
    
    /**
     * Provides Zend_Date and expected age for age calculation.
     * 
     * @return array
     */
    public static function experienceProvider()
    {
        return array(
            array(
                '12-06-2011', 5
            ),
            array(
                '13-06-2011', 6
            ),
            array(
                '12-06-2012', 6
            ),
            array(
                '13-06-2012', 7
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

    /**
     * 
     * @dataProvider ageProvider
     */
    public function testGetAgeReturnsTimespanBetweenDateAndBirthDate(
        $date, $expected
    )
    {
        $date = new Zend_Date($date);
        $birthDate = new Zend_Date('12-08-1983');

        $age = $this->_model->setDate($date)
                            ->setBirthDate($birthDate)
                            ->getAge();

        $this->assertEquals($expected, $age);
    }

    public function testGetExperienceReturnsNullIfNoFirstWorkDate()
    {
        $this->assertNull($this->_model->getFirstWorkDate());
        $this->assertNull($this->_model->getExperience());
    }
    
    /**
     * 
     * @dataProvider experienceProvider
     */
    public function testGetExperienceReturnsTimespanBetweenDateAndFirstWork(
        $date, $expected
    )
    {
        $date = new Zend_Date($date);
        $firstWorkDate = new Zend_Date('13-06-2005');
        
        $experience = $this->_model->setDate($date)
                                   ->setFirstWorkDate($firstWorkDate)
                                   ->getExperience();
        
        $this->assertEquals($expected, $experience);
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
