<?php
/**
 * 
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Service
 * @see MaitreCorbeaux_Service_AbstractService
 */
class MaitreCorbeaux_Service_Activity_Item
extends MaitreCorbeaux_Service_AbstractService
{
    /**
     * Sanitize data from import before storing them
     *
     * @param MaitreCorbeaux_Model_Activity_Item
     * @return void
     */
    protected function _cleanImportData(MaitreCorbeaux_Model_Activity_Item $item)
    {
        $title = $item->getTitle();
        $description = $item->getDescription();

        // Item title may contains HTML entities
        $title = html_entity_decode($title, ENT_QUOTES);
        // Item description may contains HTML tags and entities
        $description = strip_tags($description);
        $description = html_entity_decode($description, ENT_QUOTES);
        $description = trim($description);

        $item->populate(array(
            'title' => $title,
            'description' => $description
        ));
    }

    /**
     * Import an ActivityItem
     * Checks first if the externalId exists for this Activity Source
     *
     * @param MaitreCorbeaux_Model_Activity_Item $value
     * @return MaitreCorbeaux_Service_Activity_Item
     */
    public function import(MaitreCorbeaux_Model_Activity_Item $item)
    {
        $this->_cleanImportData($item);
        
        $mapper = $this->getMapper();
        $existingItem = $mapper->findByExternalId(
            $item->getExternalId(),
            $item->getSource()
        );

        if (null !== $existingItem) {
            $item->setId($existingItem->getId());
        }

        $mapper->save($item);
        return $this;
    }

    /**
     * Returns the n last Activity Items
     * We use bootstrap to get the number of items to return
     *
     * @return MaitreCorbeaux_Model_Collection_Activity_Item
     */
    public function fetchLast()
    {
        $bootstrap = $this->getBootstrap();
        $config = $bootstrap->getOption('activityItem');
        $nbItems = $config['nbLast'];
        $mapper = $this->getMapper();

        return $mapper->fetchLast($nbItems);
    }

    /**
     *
     * @return MaitreCorbeaux_Model_Mapper_Activity_ItemInterface
     * @see MaitreCorbeaux_Service_AbstractService::getMapper()
     */
    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->_mapper = new MaitreCorbeaux_Model_Mapper_Activity_Item();
        }

        return $this->_mapper;
    }

    /**
     *
     * @param MaitreCorbeaux_Model_Mapper_Activity_ItemInterface $value
     * @return MaitreCorbeaux_Service_Activity_Item
     * @see MaitreCorbeaux_Service_AbstractService::setMapper()
     */
    public function setMapper(
        MaitreCorbeaux_Model_Mapper_Activity_ItemInterface $value
    )
    {
        $this->_mapper = $value;
        return $this;
    }
}