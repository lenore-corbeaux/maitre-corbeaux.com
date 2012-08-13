<?php
/**
 * Profile Model
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Model
 * @see MaitreCorbeaux_Model_AbstractModel
 */
class MaitreCorbeaux_Model_Profile
extends MaitreCorbeaux_Model_AbstractModel
{
    /**
     * Current datetime
     *
     * @var Zend_Date
     */
    protected $_date;

    /**
     * Profile birth date
     * 
     * @var Zend_Date
     */
    protected $_birthDate;
    
    /**
     * Profile first work date
     * 
     * @var Zend_Date
     */
    protected $_firstWorkDate;

    /**
     * Profile age
     *
     * @var int
     */
    protected $_age;

    /**
     * Profile experience
     *
     * @var int
     */
    protected $_experience;

    /**
     *
     * @return Zend_Date
     */
    public function getDate()
    {
        if (null === $this->_date) {
            $this->_date = new Zend_Date();
        }

        return $this->_date;
    }

    /**
     *
     * @param Zend_Date $date
     * @return MaitreCorbeaux_Model_Activity_Profile
     */
    public function setDate(Zend_Date $date)
    {
        $this->_date = $date;
        return $this;
    }

    /**
     *
     * @return Zend_Date
     */
    public function getBirthDate()
    {
        return $this->_birthDate;
    }

    /**
     *
     * @param Zend_Date $date
     * @return MaitreCorbeaux_Model_Activity_Profile
     */
    public function setBirthDate(Zend_Date $date)
    {
        $this->_birthDate = $date;
        return $this;
    }

    /**
     *
     * @return Zend_Date
     */
    public function getFirstWorkDate()
    {
        return $this->_firstWorkDate;
    }

    /**
     *
     * @param Zend_Date $date
     * @return MaitreCorbeaux_Model_Activity_Profile
     */
    public function setFirstWorkDate(Zend_Date $date)
    {
        $this->_firstWorkDate = $date;
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getAge()
    {
        $birthDate = $this->getBirthDate();

        if (null === $this->_age && null !== $birthDate) {
            $this->_age = $this->_timespan($birthDate, $this->getDate());
        }

        return $this->_age;
    }

    /**
     *
     * @param int $age
     * @return MaitreCorbeaux_Model_Activity_Profile
     */
    public function setAge($age)
    {
        $this->_age = (int) $age;
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getExperience()
    {
        $workDate = $this->getFirstWorkDate();
        
        if (null === $this->_experience && null != $workDate) {
            $this->_experience = $this->_timespan($workDate, $this->getDate());
        }
        
        return $this->_experience;
    }

    /**
     *
     * @param int $experience
     * @return MaitreCorbeaux_Model_Activity_Profile
     */
    public function setExperience($experience)
    {
        $this->_experience = (int) $experience;
        return $this;
    }
    
    /**
     * Returns the timespan (in year) between start date and end date.
     * 
     * Used to process age and experience calculation.
     * 
     * @param Zend_Date $startDate
     * @param Zend_Date $endDate
     * @return int
     */
    protected function _timespan(Zend_Date $startDate, Zend_Date $endDate)
    {
        $date = clone $endDate;
        $date->addDay(1)
             ->addMonth(1);
             
        $date->subDay($startDate->getDay())
             ->subMonth($startDate->getMonth())
             ->subYear($startDate->getYear());
            
        return (int) $date->toString('yyyy');
    }
}
