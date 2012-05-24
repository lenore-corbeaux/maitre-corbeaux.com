<?php
/**
 * Test class for MaitreCorbeaux_Service_Activity_Search
 * 
 */
class MaitreCorbeaux_Service_Activity_SearchTest
extends PHPUnit_Framework_TestCase
{
    /**
     * Activity Search service
     * 
     * @var MaitreCorbeaux_Service_Activity_Search
     */
    protected $_service;
    
    /**
     * Provide activity item and source
     * 
     * @return array
     */
    static public function itemProvider()
    {     
        $source = new MaitreCorbeaux_Model_Activity_Source(array(
            'id' => 789,
            'name' => 'Source test',
            'link' => 'http://www.maitre-corbeaux.com/',
            'slug' => 'source-test'
        ));

        $item = new MaitreCorbeaux_Model_Activity_Item(array(
            'id' => 123,
            'title' => 'Test',
            'description' => 'This is a test',
            'link' => 'http://www.maitre-corbeaux.com/',
            'publicationDate' => Zend_Date::now(),
            'externalId' => 456,
            'source' => $source
        ));
        
        return array(array($item));
    }
    
    /**
     * Initialize the TestCase
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $index = $this->_getMockedIndex();
        $this->_service = new MaitreCorbeaux_Service_Activity_Search();
        $this->_service->setIndex($index);
    }
    
    /**
     * Return a mocked Lucene Index
     * 
     * @return Zend_Search_Lucene
     */
    protected function _getMockedIndex()
    {
        return $this->getMock(
        	'Zend_Search_Lucene', array(), array(), '', false
        );
    }

    public function testIndexCanBeGetAndSet()
    {
        $newIndex = $this->_getMockedIndex();
        $this->_service->setIndex($newIndex);
        $this->assertSame($newIndex, $this->_service->getIndex());
    }
    
    /**
     * @dataProvider itemProvider
     */
    public function testIndexItemAddADocumentToTheIndex($item)
    {
        $this->_service
             ->getIndex()
             ->expects($this->once())
             ->method('addDocument');
        
        $this->_service->indexItem($item);
    }
    
    /**
     * @dataProvider itemProvider
     */
    public function testIndexItemsAddManyDocumentsToTheIndex($item)
    {
        $items = new MaitreCorbeaux_Model_Collection_Activity_Item();
        $items->add($item)
              ->add($item)
              ->add($item);
                   
        $this->_service
             ->getIndex()
             ->expects($this->exactly(count($items)))
             ->method('addDocument');
        
        $this->_service->indexItems($items);
    }
    
    /**
     * @dataProvider itemProvider
     */
    public function testCreateDocumentFromItemReturnsLuceneDocument($item)
    {
        $document = $this->_service
                         ->createDocumentFromItem($item);
                         
        $this->assertInstanceOf('Zend_Search_Lucene_Document',$document);
    }
    
    /**
     * @dataProvider itemProvider
     */
    public function testCreateDocumentFromItemWithoutValidLinkReturnsNull($item)
    {
        $item->setLink('http://not-a-link/');
        $document = $this->_service
                         ->createDocumentFromItem($item);
                         
        $this->assertNull($document);
    }
    
    /**
     * @dataProvider itemProvider
     */
    public function testSearchItemsReturnsACollectionFromLuceneIndex($item)
    {
        $itemId = $item->getId();
        $ids = array($itemId, $itemId, $itemId);
        $page = 4;
        $items = new MaitreCorbeaux_Model_Collection_Activity_Item();
                              
        $document = $this->_service
                         ->createDocumentFromItem($item);
                         
        $query = 'foo';
        $documents = array($document, $document, $document);
        
        $class = 'MaitreCorbeaux_Service_Activity_Item';
        
        $mockedService = $this->getMock($class);
        $mockedService->expects($this->once())
                      ->method('paginateAllIn')
                      ->with(
                          $this->equalTo($ids),
                          $this->equalTo($page)
                      )
                      ->will($this->returnValue($items));

       $this->_service
            ->setServiceItem($mockedService)
            ->getIndex()
            ->expects($this->once())
            ->method('find')
            ->with($this->equalTo($query))
            ->will($this->returnValue($documents));
             
        $newItems = $this->_service
                         ->searchItems($query, $page);

        $this->assertSame($items, $newItems);
    }

    /**
     * TestCase tear down
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->_service);
    }
}