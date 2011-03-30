<?php
/**
 * Paginator adapter that internally use a MaitreCorbeaux_Model_Collection_AbstractCollection
 * created from the Zend_Db_Select provided
 *
 * @see Zend_Paginator_Adapter_DbSelect
 */
class MaitreCorbeaux_Paginator_Adapter_ModelCollection
extends Zend_Paginator_Adapter_DbSelect
{
    /**
     *
     * @var MaitreCorbeaux_Model_Mapper_AbstractMapper
     */
    protected $_mapper;

    public function __construct(
        Zend_Db_Select $select,
        MaitreCorbeaux_Model_Mapper_AbstractMapper $mapper
    )
    {
        parent::__construct($select);
        $this->setMapper($mapper);
    }

    /**
     *
     * @param int $offset
     * @param int $itemCountPerPage
     * @see Zend_Paginator_Adapter_DbSelect::getItems()
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $items = parent::getItems($offset, $itemCountPerPage);
        return $this->_mapper->createCollection($items);
    }

    public function getMapper()
    {
        return $this->_mapper;
    }

    public function setMapper(MaitreCorbeaux_Model_Mapper_AbstractMapper $value)
    {
        $this->_mapper = $value;
    }
}