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
    public function cleanImportData(
        MaitreCorbeaux_Model_Activity_Item $item
    )
    {
        $title = $this->_cleanData($item->getTitle());        
        $description = $this->_cleanData($item->getDescription());

        $item->populate(array(
            'title' => $title,
            'description' => $description
        ));
    }
    
    /**
     * Sanitize data.
     * 
     * Decode HTML entities, then strip tags and trim data.
     * 
     * @param string $data
     * @return string
     */
    protected function _cleanData($data)
    {
        return trim(strip_tags(html_entity_decode($data, ENT_QUOTES)));
    }

    /**
     * Import an ActivityItem
     * 
     * Checks first if the externalId exists for this Activity Source
     *
     * @param MaitreCorbeaux_Model_Activity_Item $value
     * @return MaitreCorbeaux_Service_Activity_Item
     */
    public function import(MaitreCorbeaux_Model_Activity_Item $item)
    {
        $this->cleanImportData($item);
        
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
     * 
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
     * Returns number of items by page for paginated elements
     * 
     * @return int
     */
    protected function _getPaginatorNbItems()
    {
        $bootstrap = $this->getBootstrap();
        $config = $bootstrap->getOption('activityItem');
        return $config['nbPaginator'];
    }

    /**
     * Returns a paginator of Activity Items
     *
     * @param int $page
     * @return Zend_Paginator
     */
    public function paginateAll($page)
    {
        $nbItems = $this->_getPaginatorNbItems();
        $mapper = $this->getMapper();

        return $mapper->paginateAll($page, $nbItems);
    }
    
    /**
     * Returns a paginator of selected Activity Items
     *
     * @param array $ids
     * @param int $page
     * @return Zend_Paginator
     */
    public function paginateAllIn(array $ids, $page)
    {
        $nbItems = $this->_getPaginatorNbItems();
        $mapper = $this->getMapper();

        return $mapper->paginateAllIn($ids, $page, $nbItems);
    }
    
    /**
     * Returns every of Activity Items
     *
     * @return MaitreCorbeaux_Model_Collection_Activity_Item
     */
    public function fetchAll()
    {
        $mapper = $this->getMapper();
        return $mapper->fetchAll();
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
     * @param MaitreCorbeaux_Model_Mapper_AbstractMapper $value
     * @return MaitreCorbeaux_Service_Activity_Item
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
