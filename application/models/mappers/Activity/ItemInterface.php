<?php
/**
 * Interface for Activity Item data mapper
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Model
 * @subpackage Mapper
 */
interface MaitreCorbeaux_Model_Mapper_Activity_ItemInterface
{
    /**
     * Return the Activity Item for the given externalId and activity source
     *
     * @param string $externalId
     * @param MaitreCorbeaux_Model_Activity_Source $source
     * @return MaitreCorbeaux_Model_Activity_Item
     */
    public function findByExternalId(
        $externalId, MaitreCorbeaux_Model_Activity_Source $source
    );

    /**
     * Store the given model into the database
     *
     * @param MaitreCorbeaux_Model_Activity_Item
     * @return MaitreCorbeaux_Model_Mapper_Activity_ItemInterface
     */
    public function save(MaitreCorbeaux_Model_Activity_Item $item);

    /**
     * Returns a collection of the $nbItems last items
     *
     * @param int $nbItems
     * @return MaitreCorbeaux_Model_Mapper_Activity_Item
     * @see MaitreCorbeaux_Model_Mapper_Activity_ItemInterface::fetchLatests()
     */
    public function fetchLast($nbItems);

    /**
     * Returns a paginator of all Activity Items, ordered by publication date
     *
     * @param int $offset
     * @param int $itemCountPerPage
     * @return Zend_Paginator
     */
    public function paginateAll($offset, $itemCountPerPage);

    /**
     * Returns a paginator of all desired Activity Items
     *
     * @param array $ids
     * @param int $offset
     * @param int $itemCountPerPage
     * @return Zend_Paginator
     */
    public function paginateAllIn(array $ids, $offset, $itemCountPerPage);
    
    /**
     * Returns every Activity Items
     * 
     * @return MaitreCorbeaux_Model_Collection_Activity_Item
     */
    public function fetchAll();

    /**
     *
     * @return MaitreCorbeaux_Model_Mapper_Activity_SourceInterface
     */
    public function getActivitySourceMapper();

    /**
     *
     * @param MaitreCorbeaux_Model_Mapper_Activity_SourceInterface $value
     * @return MaitreCorbeaux_Model_Mapper_Activity_ItemInterface
     */
    public function setActivitySourceMapper(
        MaitreCorbeaux_Model_Mapper_Activity_SourceInterface $value
    );
}