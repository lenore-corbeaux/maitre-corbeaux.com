<?php
/**
 * Interface for Activity Source data mapper
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Model
 * @subpackage Mapper
 */
interface MaitreCorbeaux_Model_Mapper_Activity_SourceInterface
{
    /**
     * Returns all Activity Sources
     *
     * @return MaitreCorbeaux_Model_Collection_Activity_Source
     */
    public function fetchAll();
}