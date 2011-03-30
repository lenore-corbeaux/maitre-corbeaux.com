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
}