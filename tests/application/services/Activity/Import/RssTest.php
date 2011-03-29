<?php
/**
 * Test class for MaitreCorbeaux_Service_Activity_Import_Rss
 * 
 */
class MaitreCorbeaux_Service_Activity_Import_RssTest
extends PHPUnit_Framework_TestCase
{
    /**
     * Atom feed import
     * 
     * @var MaitreCorbeaux_Service_Activity_Import_Rss
     */
    protected $_service;
    
    /**
     * Initialize the TestCase
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->_service = new MaitreCorbeaux_Service_Activity_Import_Rss();
        $testFeed = Zend_Feed::importFile(TEST_PATH . '/_files/feeds/rss.xml');
        $this->_service->setFeed($testFeed);
    }

    public function testImportRssFeed()
    {
        $item = new MaitreCorbeaux_Model_Activity_Item(array(
            'externalId' => 'test-external-id',
            'publicationDate' => new Zend_Date(
                '2011-03-29 16:26:05',
                'yyyy-MM-dd HH:mm:ss'
            ),
            'link' => 'http://www.maitre-corbeaux.com/test',
            'title' => 'Test title',
            'description' => 'Test description'
        ));

        $collection = $this->_service->import();
        $this->assertInstanceOf(
            'MaitreCorbeaux_Model_Collection_Activity_Item',
            $collection
        );

        $importedItem = $collection->current();
        $this->assertEquals($item, $importedItem);
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