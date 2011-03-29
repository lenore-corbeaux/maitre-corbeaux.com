<?php
/**
 * Test class for MaitreCorbeaux_Model_Collection_Activity_Item
 * 
 */
class MaitreCorbeaux_Model_Collection_Activity_ItemTest
extends PHPUnit_Framework_TestCase
{
    /**
     * Activity items collection
     * 
     * @var MaitreCorbeaux_Model_Collection_Activity_Item
     */
    protected $_collection;

    /**
     * Data provider
     *
     * @return array
     */
    static public function provider()
    {
        return array(
            array(
                new MaitreCorbeaux_Model_Activity_Item(),
                new MaitreCorbeaux_Model_Activity_Item(),
                new MaitreCorbeaux_Model_Activity_Item()
            )
        );
    }

    /**
     * Fill collection with models
     *
     * @param MaitreCorbeaux_Model_Activity_Item $model1
     * @param MaitreCorbeaux_Model_Activity_Item $model2
     * @param MaitreCorbeaux_Model_Activity_Item $model3
     * @return void
     */
    protected function _fillCollection($model1, $model2, $model3)
    {
        $this->_collection[] = $model1;
        $this->_collection['model2'] = $model2;
        $this->_collection[3] = $model3;
    }

    /**
     * Initialize the TestCase
     *
     * @return void
     */
    public function setUp()
    {
        $this->_collection =
            new MaitreCorbeaux_Model_Collection_Activity_Item();
    }

    public function testNewCollectionIsEmpty()
    {
        $this->assertEquals(0, count($this->_collection));
    }

    /**
     *
     * @dataProvider provider
     */
    public function testClearedCollectionIsEmpty($model1, $model2, $model3)
    {
        $this->_fillCollection($model1, $model2, $model3);
        $this->_collection->clear();
        $this->assertEquals(0, count($this->_collection));
    }

    /**
     * 
     * @dataProvider provider
     */
    public function testAddElementToCollection($model1, $model2, $model3)
    {
        $this->_fillCollection($model1, $model2, $model3);

        $this->assertEquals(3, count($this->_collection));
        $this->assertSame($model1, $this->_collection[0]);
        $this->assertSame($model2, $this->_collection['model2']);
        $this->assertSame($model3, $this->_collection[3]);
    }

    public function testAddInvalidElementToCollection()
    {
        $this->setExpectedException(
            'MaitreCorbeaux_Model_Collection_Exception'
        );
        
        $this->_collection[] = new stdClass();
    }

    /**
     *
     * @dataProvider provider
     */
    public function testRemoveElementFromCollection($model1, $model2, $model3)
    {
        $this->_fillCollection($model1, $model2, $model3);

        $this->_collection->remove($model2);
        $this->assertNotContains($model2, $this->_collection);
        $this->assertEquals(2, count($this->_collection));
    }

    /**
     *
     * @dataProvider provider
     */
    public function testRemoveUnexistentElementFromCollection()
    {
        $this->setExpectedException(
            'MaitreCorbeaux_Model_Collection_Exception'
        );
        
        $model = new MaitreCorbeaux_Model_Activity_Item();
        $this->_collection->remove($model);
    }

    /**
     *
     * @dataProvider provider
     */
    public function testUnsetElementFromCollection($model1, $model2, $model3)
    {
        $this->_fillCollection($model1, $model2, $model3);

        unset($this->_collection['model2']);
        $this->assertFalse($this->_collection->offsetExists('model2'));
        $this->assertEquals(2, count($this->_collection));
    }

    /**
     *
     * @dataProvider provider
     */
    public function testMergeTwoCollections($model1, $model2, $model3)
    {
        $this->_fillCollection($model1, $model2, $model3);

        $otherCollection = new MaitreCorbeaux_Model_Collection_Activity_Item();
        $otherCollection[] = $model2;
        $this->_collection->merge($otherCollection);
        
        $this->assertEquals(4, count($this->_collection));
        $this->assertSame($model1, $this->_collection[0]);
        $this->assertSame($model2, $this->_collection['model2']);
        $this->assertSame($model3, $this->_collection[3]);
        $this->assertSame($model2, $this->_collection[4]);
    }

    /**
     *
     * @dataProvider provider
     */
    public function testCollectionIsTraversable($model1, $model2, $model3)
    {
        $this->_fillCollection($model1, $model2, $model3);

        $array = array();
        $array[] = $model1;
        $array['model2'] = $model2;
        $array[3] = $model3;

        foreach ($this->_collection as $key => $value) {
            $this->assertSame($array[$key], $value);
        }
    }

    /**
     *
     * @dataProvider provider
     */
    public function testCollectionIsSeekable($model1, $model2, $model3)
    {
        $this->_fillCollection($model1, $model2, $model3);
        $this->assertSame($model1, $this->_collection->current());

        $this->_collection->seek(2);
        $this->assertSame($model3, $this->_collection->current());
        
        $this->_collection->seek(1);
        $this->assertSame($model2, $this->_collection->current());
    }

    public function testCollectionSeekUnexistentPosition()
    {
        $this->setExpectedException(
            'MaitreCorbeaux_Model_Collection_Exception'
        );

        $this->_collection->seek(1);
    }

    /**
     * TestCase tear down
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->_collection);
    }
}