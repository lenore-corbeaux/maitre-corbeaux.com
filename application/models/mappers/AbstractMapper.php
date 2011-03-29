<?php
/**
 * Base class for Data Mappers
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Model
 * @subpackage Mapper
 */
abstract class MaitreCorbeaux_Model_Mapper_AbstractMapper
{
    /**
     *
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;

    /**
     *
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable()
    {
        return $this->_dbTable;
    }

    /**
     *
     * @param Zend_Db_Table_Abstract $value
     * @return MaitreCorbeaux_Model_Mapper_AbstractMapper
     */
    public function setDbTable(Zend_Db_Table_Abstract $value)
    {
        $this->_dbTable = $value;
        return $this;
    }
}