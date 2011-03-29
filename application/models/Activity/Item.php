<?php
/**
 * Activity Item Model
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Model
 * @see MaitreCorbeaux_Model_AbstractModel
 */
class MaitreCorbeaux_Model_Activity_Item
extends MaitreCorbeaux_Model_AbstractModel
{
    /**
     *
     * @var int
     */
    protected $_id;

    /**
     *
     * @var string
     */
    protected $_title;

    /**
     *
     * @var string
     */
    protected $_description;

    /**
     *
     * @var string
     */
    protected $_link;

    /**
     *
     * @var Zend_Date
     */
    protected $_publicationDate;

    /**
     *
     * @var string
     */
    protected $_externalId;

    /**
     *
     * @var MaitreCorbeaux_Model_Activity_Source
     */
    protected $_source;

    /**
     *
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     *
     * @param int $value
     * @return MaitreCorbeaux_Model_Activity_Item
     */
    public function setId($value)
    {
        $this->_id = (int) $value;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     *
     * @param string $value
     * @return MaitreCorbeaux_Model_Activity_Item
     */
    public function setTitle($value)
    {
        $this->_title = (string) $value;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     *
     * @param string $value
     * @return MaitreCorbeaux_Model_Activity_Item
     */
    public function setDescription($value)
    {
        $this->_description = (string) $value;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getLink()
    {
        return $this->_link;
    }

    /**
     *
     * @param string $value
     * @return MaitreCorbeaux_Model_Activity_Item
     */
    public function setLink($value)
    {
        $this->_link = (string) $value;
        return $this;
    }

    /**
     *
     * @return Zend_Date
     */
    public function getPublicationDate()
    {
        return $this->_publicationDate;
    }

    /**
     *
     * @param Zend_Date $value
     * @return MaitreCorbeaux_Model_Activity_Item
     */
    public function setPublicationDate(Zend_Date $value)
    {
        $this->_publicationDate = $value;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getExternalId()
    {
        return $this->_externalId;
    }

    /**
     *
     * @param string $value
     * @return MaitreCorbeaux_Model_Activity_Item
     */
    public function setExternalId($value)
    {
        $this->_externalId = (string) $value;
        return $this;
    }

    /**
     *
     * @return MaitreCorbeaux_Model_Activity_Source
     */
    public function getSource()
    {
        return $this->_source;
    }

    /**
     *
     * @param MaitreCorbeaux_Model_Activity_Source $value
     * @return MaitreCorbeaux_Model_Activity_Item
     */
    public function setSource(MaitreCorbeaux_Model_Activity_Source $value)
    {
        $this->_source = $value;
        return $this;
    }
}