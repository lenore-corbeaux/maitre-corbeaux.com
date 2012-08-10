<?php
require_once 'DatabaseTestCase.php';

/**
 * Test class for MaitreCorbeaux_Model_Mapper_Activity_Item
 * 
 */
class MaitreCorbeaux_Model_Mapper_Activity_ItemTest extends DatabaseTestCase
{
    /**
     * Mapper under test
     * 
     * @var MaitreCorbeaux_Model_Mapper_Activity_Item
     */
    protected $_mapper;

    /**
     * Data provider for existing activity item
     * 
     * @return array
     */
    static public function existingItemProvider()
    {
        $source1 = new MaitreCorbeaux_Model_Activity_Source(array(
            'id' => 1
        ));

        $source2 = new MaitreCorbeaux_Model_Activity_Source(array(
            'id' => 3
        ));

        return array(
            array(
                'external-id-3',
                $source1
            ),
            array(
                'external-id-1',
                $source2
            )
        );
    }

    /**
     * Data provider for unexistent activity item
     *
     * @return array
     */
    static public function unexistentItemProvider()
    {
        $source1 = new MaitreCorbeaux_Model_Activity_Source(array(
            'id' => 1
        ));

        $source2 = new MaitreCorbeaux_Model_Activity_Source(array(
            'id' => 2
        ));

        $source3 = new MaitreCorbeaux_Model_Activity_Source(array(
            'id' => 3
        ));

        return array(
            array(
                'external-id-4',
                $source1
            ),
            array(
                'external-id-1',
                $source2
            ),
            array(
                'external-id-2',
                $source3
            ),
        );
    }

    /**
     * Data provider for saving
     *
     * @return array
     */
    static public function saveProvider()
    {
        $item1 = new MaitreCorbeaux_Model_Activity_Item(array(
            'id' => 1,
            'title' => 'New title',
            'description' => 'New description',
            'link' => 'http://www.maitre-corbeaux.com/new',
            'externalId' => 'new-external-id-1',
            'publicationDate' => new Zend_Date(),
            'source' => new MaitreCorbeaux_Model_Activity_Source(array(
                'id' => 2
            ))
        ));

        $item2 = new MaitreCorbeaux_Model_Activity_Item(array(
            'title' => 'New title',
            'description' => 'New description',
            'link' => 'http://www.maitre-corbeaux.com/new',
            'externalId' => 'new-external-id-2',
            'publicationDate' => new Zend_Date(),
            'source' => new MaitreCorbeaux_Model_Activity_Source(array(
                'id' => 2
            ))
        ));

        return array(
            array(
                $item1
            ),
            array(
                $item2
            )
        );
    }

    /**
     * Data for ActivitySource joint
     *
     * @return array
     */
    static public function activitySourcesProvider()
    {
        return array(
            array(
                $source1 = new MaitreCorbeaux_Model_Activity_Source(array(
                    'id' => 1,
                    'slug' => 'twitter',
                    'name' => 'Twitter',
                    'link' => 'http://twitter.com/lucascorbeaux'
                )),
                $source3 = new MaitreCorbeaux_Model_Activity_Source(array(
                    'id' => 3,
                    'slug' => 'github',
                    'name' => 'Github',
                    'link' => 'https://github.com/lucascorbeaux'
                ))
            )
        );
    }

    /**
     * Initialize the TestCase
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->_mapper = new MaitreCorbeaux_Model_Mapper_Activity_Item();
    }

    /**
     *
     * @dataProvider existingItemProvider
     */
    public function testFindByExternalIdWithExistingActivityItem(
        $externalId, $source
    )
    {
        $item = $this->_mapper->findByExternalId($externalId, $source);
        $this->assertInstanceOf('MaitreCorbeaux_Model_Activity_Item', $item);
    }

    /**
     *
     * @dataProvider unexistentItemProvider
     */
    public function testFindByExternalIdWithUnexistentActivityItem(
        $externalId, $source
    )
    {
        $item = $this->_mapper->findByExternalId($externalId, $source);
        $this->assertNull($item);
    }

    /**
     *
     * @dataProvider saveProvider
     */
    public function testSaveValidActivityItem($item)
    {
        $this->_mapper->save($item);

        $dbTable = $this->_mapper->getDbTable();
        $row = $dbTable->find($item->getId());

        $this->assertInstanceOf('Zend_Db_Table_Rowset_Abstract', $row);
        $this->assertEquals(1, count($row));
    }

    public function testFetchLastItems()
    {
        $collection = $this->_mapper->fetchLast(3);
        $this->assertInstanceOf(
            'MaitreCorbeaux_Model_Collection_Activity_Item', $collection
        );

        $this->assertEquals(3, count($collection));
        $this->assertEquals(4, $collection[0]->getId());
        $this->assertEquals(3, $collection[1]->getId());
        $this->assertEquals(2, $collection[2]->getId());
    }

    /**
     *
     * @dataProvider activitySourcesProvider
     */
    public function testFetchLastItemsJoinActivitySources($source1, $source3)
    {
        $collection = $this->_mapper->fetchLast(2);

        $this->assertEquals($source1, $collection[0]->getSource());
        $this->assertEquals($source3, $collection[1]->getSource());
    }

    public function testFetchAllItemsReturnsEveryItems()
    {
        $collection = $this->_mapper->fetchAll();
        $this->assertInstanceOf(
            'MaitreCorbeaux_Model_Collection_Activity_Item', $collection
        );

        $this->assertEquals(4, count($collection));
    }

    /**
     *
     * @dataProvider activitySourcesProvider
     */
    public function testFetchAllItemsJoinActivitySources($source1, $source3)
    {
        $collection = $this->_mapper->fetchLast(2);
        $source = $collection->current()->getSource();
        $class = 'MaitreCorbeaux_Model_Activity_Source';
        
        $this->assertInstanceOf($class, $source);
        $this->assertNotNull($source->getId());
    }

    public function testPaginateAllItems()
    {
        $paginator = $this->_mapper->paginateAll(1, 2);
        $collection = $paginator->getCurrentItems();

        $this->assertInstanceOf('Zend_Paginator', $paginator);
        $this->assertInstanceOf(
            'MaitreCorbeaux_Model_Collection_Activity_Item', $collection
        );
        $this->assertEquals(2, count($collection));
        $this->assertEquals(2, count($paginator));
    }

    /**
     *
     * @dataProvider activitySourcesProvider
     */
    public function testPaginateAllJoinActivitySources($source1, $source3)
    {
        $paginator = $this->_mapper->paginateAll(1, 2);
        $collection = $paginator->getCurrentItems();

        $this->assertEquals($source1, $collection[0]->getSource());
        $this->assertEquals($source3, $collection[1]->getSource());
    }
    
    public function testPaginateAllInItemsReturnsItemsInDesiredOrder()
    {
        $paginator = $this->_mapper->paginateAllIn(array(3, 1), 0, 2);
        $collection = $paginator->getCurrentItems();
        
        $this->assertEquals(3, $collection[0]->getId());
        $this->assertEquals(1, $collection[1]->getId());
    }

    /**
     *
     * @dataProvider activitySourcesProvider
     */
    public function testPaginateAllInJoinActivitySources($source1, $source3)
    {
        $paginator = $this->_mapper->paginateAllIn(array(2, 3), 0, 2);
        $collection = $paginator->getCurrentItems();

        $this->assertEquals($source1, $collection[0]->getSource());
        $this->assertEquals($source3, $collection[1]->getSource());
    }
    
    public function testPaginateAllInReturnsAllItemsIfNoId()
    {
        $paginator = $this->_mapper->paginateAllIn(array(), 0, 2);
        $collection = $paginator->getCurrentItems();

        $this->assertEquals(0, count($collection));
    }
    
    public function testActivitySourceMapperCanBeGetAndSet()
    {
        $mapper = $this->getMock(
            'MaitreCorbeaux_Model_Mapper_Activity_Source'
        );
        
        $this->_mapper->setActivitySourceMapper($mapper);
        $this->assertSame($mapper, $this->_mapper->getActivitySourceMapper());
    }

    /**
     * TestCase tear down
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->_mapper);
        parent::tearDown();
    }
}