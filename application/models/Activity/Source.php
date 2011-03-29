<?php
/**
 * Activity Source Model
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Model
 * @see MaitreCorbeaux_Model_AbstractModel
 */
class MaitreCorbeaux_Model_Activity_Source
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
    protected $_name;

    /**
     *
     * @var string
     */
    protected $_slug;

    /**
     *
     * @var string
     */
    protected $_link;

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
     * @return MaitreCorbeaux_Model_Activity_Source
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
    public function getName()
    {
        return $this->_name;
    }

    /**
     *
     * @param string $value
     * @return MaitreCorbeaux_Model_Activity_Source
     */
    public function setName($value)
    {
        $this->_name = (string) $value;
        return $this;
    }

    /**
     *
     * @return string
     */
    public final function getSlug()
    {
        return $this->_slug;
    }

    /**
     *
     * @param string $value
     * @return MaitreCorbeaux_Model_Activity_Source
     */
    public final function setSlug($value)
    {
        $this->_slug = (string) $value;
        return $this;
    }

    /**
     *
     * @return string
     */
    public final function getLink()
    {
        return $this->_link;
    }

    /**
     *
     * @param string $value
     * @return MaitreCorbeaux_Model_Activity_Source
     */
    public final function setLink($value)
    {
        $this->_link = (string) $value;
        return $this;
    }
}