<?php
/**
 * Common interface for importing Activity Item
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Service
 */
interface MaitreCorbeaux_Service_Activity_Import_ImportInterface
{
    /**
     * Import Activity Items
     *
     * @return MaitreCorbeaux_Model_Collection_Activity_Item
     */
    public function import();
}