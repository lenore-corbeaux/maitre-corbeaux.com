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
     * Create a model from an array of data
     *
     * @param array $data
     * @return MaitreCorbeaux_Model_AbstractModel
     */
    abstract public function createModel(array $data);

    /**
     * Create a collection of models from an array of data
     *
     * @param array $data
     * @return MaitreCorbeaux_Model_Collection_AbstractCollection
     */
    abstract public function createCollection(array $data);

    /**
     * Create an empty paginator
     *
     * @param Zend_Db_Select $select
     * @param int $offset
     * @param int $itemCountPerPage 
     */
    protected function _createPaginator(
        Zend_Db_Select $select, $offset, $itemCountPerPage
    )
    {
        $adapter = new MaitreCorbeaux_Paginator_Adapter_ModelCollection(
            $select,
            $this
        );

        $paginator = new Zend_Paginator($adapter);

        $paginator->setCurrentPageNumber($offset)
                  ->setItemCountPerPage($itemCountPerPage);

        return $paginator;
    }

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