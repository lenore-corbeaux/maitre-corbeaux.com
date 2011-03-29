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