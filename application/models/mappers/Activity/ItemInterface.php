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
}