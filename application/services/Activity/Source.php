<?php
/**
 * Activity Item data mapper
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Service
 * @see MaitreCorbeaux_Service_AbstractService
 */
class MaitreCorbeaux_Service_Activity_Source
extends MaitreCorbeaux_Service_AbstractService
{
    /**
     * Returns a collection of all the Activity Sources
     *
     * @return MaitreCorbeaux_Model_Collection_Activity_Source
     */
    public function fetchAll()
    {
        $mapper = $this->getMapper();
        return $mapper->fetchAll();
    }

    /**
     *
     * @return MaitreCorbeaux_Model_Mapper_Activity_SourceInterface
     * @see MaitreCorbeaux_Service_AbstractService::getMapper()
     */
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->_mapper = new MaitreCorbeaux_Model_Mapper_Activity_Source();
        }

        return $this->_mapper;
    }

    /**
     *
     * @param MaitreCorbeaux_Model_Mapper_AbstractMapper $value
     * @return MaitreCorbeaux_Service_Activity_Source
     * @see MaitreCorbeaux_Service_AbstractService::setMapper()
     */
    public function setMapper(
        MaitreCorbeaux_Model_Mapper_AbstractMapper $value
    )
    {
        $this->_mapper = $value;
        return $this;
    }
}
