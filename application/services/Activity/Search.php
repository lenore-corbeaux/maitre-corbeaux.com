<?php
/**
 * Service Layer for activity Search
 * 
 * Based on Zend_Search_Lucene
 * 
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Service
 * @see MaitreCorbeaux_Service_AbstractService
 */
class MaitreCorbeaux_Service_Activity_Search
extends MaitreCorbeaux_Service_AbstractService
{
    /**
     * @var Zend_Search_Lucene_Interface
     */
    protected $_index;
    
    /**
     * @var MaitreCorbeaux_Service_Activity_Item
     */
    protected $_serviceItem;
    
    /**
     * @return Zend_Search_Lucene_Interface
     */
    public function getIndex()
    {
        if (null === $this->_index) {
            $this->_index = $this->getBootstrap()
                                 ->getResource('LuceneIndex');
        }
        
        return $this->_index;
    }

    /**
     * @param Zend_Search_Lucene_Interface $index
     * @return MaitreCorbeaux_Service_Activity_Search
     */
    public function setIndex(Zend_Search_Lucene_Interface $index)
    {
        $this->_index = $index;
        return $this;
    }
    
    /**
     * @return MaitreCorbeaux_Service_Activity_Item
     */
    public function getServiceItem()
    {
        if (null === $this->_serviceItem) {
            $this->_serviceItem = new MaitreCorbeaux_Service_Activity_Item();
        }
        
        return $this->_serviceItem;
    }

    /**
     * @param MaitreCorbeaux_Service_Activity_Item $serviceItem
     */
    public function setServiceItem(
        MaitreCorbeaux_Service_Activity_Item $serviceItem
    )
    {
        $this->_serviceItem = $serviceItem;
        return $this;
    }

    /**
     * Add an activity item in the lucene index
     * 
     * @param MaitreCorbeaux_Model_Activity_Item $item
     * @return MaitreCorbeaux_Service_Activity_Search
     */
    public function indexItem(MaitreCorbeaux_Model_Activity_Item $item)
    {
        $index = $this->getIndex(); 
        $hits = $index->find('itemId:' . $item->getId());

        if (count($hits)) {
            return $this;
        }

        $document = $this->createDocumentFromItem($item);
        
        if (null !== $document) {
            $index->addDocument($document);
        }

        return $this;
    }
    
    /**
     * Create a lucene document from an Item
     * 
     * Returns null if the item link is not reachable
     * 
     * @param MaitreCorbeaux_Model_Activity_Item $item
     * @return Zend_Search_Lucene_Document|null
     */
    public function createDocumentFromItem(
        MaitreCorbeaux_Model_Activity_Item $item
    )
    {
        $html = @file_get_contents($item->getLink());
        
        if (false === $html) {
            return null;
        }
        
        $document = Zend_Search_Lucene_Document_Html::loadHTML($html);
        $source = $item->getSource();
        
        $itemId = Zend_Search_Lucene_Field::keyword(
            'itemId', $item->getId()
        );
        
        $sourceName = Zend_Search_Lucene_Field::unStored(
            'sourceName', $source->getName()
        );
        
        $document->addField($itemId)
                 ->addField($sourceName);
        
        return $document;
    }
        
    /**
     * Add activity items in the lucene index
     * 
     * @param MaitreCorbeaux_Model_Collection_Activity_Item $items
     * @return MaitreCorbeaux_Service_Activity_Search
     */
    public function indexItems(
        MaitreCorbeaux_Model_Collection_Activity_Item $items
    )
    {
        foreach ($items as $item) {
            $this->indexItem($item);
        }
        
        return $this;
    }
    
    /**
     * Search into the Lucene Index an return an items collection
     * 
     * @param string $query
     * @param int $page
     * @return MaitreCorbeaux_Model_Collection_Activity_Item
     */
    public function searchItems($query, $page)
    {
        $query = (string) $query;
        $hits = $this->getIndex()
                     ->find($query);
        
        $ids = array();
        
        foreach ($hits as $hit) {
            $ids[] = $hit->itemId;
        }
        
        $service = $this->getServiceItem();
        return $service->paginateAllIn($ids, $page);
    }
}
