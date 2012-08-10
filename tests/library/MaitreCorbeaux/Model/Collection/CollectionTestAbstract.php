<?php
/**
 * Base class for testing collections.
 * 
 */
abstract class MaitreCorbeaux_Model_Collection_CollectionTestAbstract
extends PHPUnit_Framework_TestCase
{
    /**
     * Collection under test
     * 
     * @var MaitreCorbeaux_Model_Collection_AbstractCollection
     */
    protected $_collection;

    /**
     * Data provider.
     * 
     * Needs to be implemented in child classes, provides model to test.
     *
     * @return array
     */
    abstract static public function provider();

    /**
     * Fill collection with models
     *
     * @param MaitreCorbeaux_Model_AbstractModel $model1
     * @param MaitreCorbeaux_Model_AbstractModel $model2
     * @param MaitreCorbeaux_Model_AbstractModel $model3
     * @return void
     */
    protected function _fillCollection(
        MaitreCorbeaux_Model_AbstractModel $model1,
        MaitreCorbeaux_Model_AbstractModel $model2,
        MaitreCorbeaux_Model_AbstractModel $model3
    )
    {
        $this->_collection[] = $model1;
        $this->_collection['model2'] = $model2;
        $this->_collection[3] = $model3;
    }

    public function testNewCollectionIsEmpty()
    {
        $this->assertEquals(0, count($this->_collection));
    }

    /**
     *
     * @dataProvider provider
     */
    public function testClearedCollectionIsEmpty(
        MaitreCorbeaux_Model_AbstractModel $model1,
        MaitreCorbeaux_Model_AbstractModel $model2,
        MaitreCorbeaux_Model_AbstractModel $model3
    )
    {
        $this->_fillCollection($model1, $model2, $model3);
        $this->_collection->clear();
        $this->assertEquals(0, count($this->_collection));
    }

    /**
     * 
     * @dataProvider provider
     */
    public function testAddElementToCollection(
        MaitreCorbeaux_Model_AbstractModel $model1,
        MaitreCorbeaux_Model_AbstractModel $model2,
        MaitreCorbeaux_Model_AbstractModel $model3
    )
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
    public function testRemoveElementFromCollection(
        MaitreCorbeaux_Model_AbstractModel $model1,
        MaitreCorbeaux_Model_AbstractModel $model2,
        MaitreCorbeaux_Model_AbstractModel $model3
    )
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
    public function testRemoveUnexistentElementFromCollection(
        MaitreCorbeaux_Model_AbstractModel $model1,
        MaitreCorbeaux_Model_AbstractModel $model2,
        MaitreCorbeaux_Model_AbstractModel $model3
    )
    {
        $this->setExpectedException(
            'MaitreCorbeaux_Model_Collection_Exception'
        );
        
        $this->_collection->remove($model1);
    }

    /**
     *
     * @dataProvider provider
     */
    public function testUnsetElementFromCollection(
        MaitreCorbeaux_Model_AbstractModel $model1,
        MaitreCorbeaux_Model_AbstractModel $model2,
        MaitreCorbeaux_Model_AbstractModel $model3
    )
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
    public function testMergeTwoCollections(
        MaitreCorbeaux_Model_AbstractModel $model1,
        MaitreCorbeaux_Model_AbstractModel $model2,
        MaitreCorbeaux_Model_AbstractModel $model3
    )
    {
        $otherCollection = clone $this->_collection;
        $this->_fillCollection($model1, $model2, $model3);

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
    public function testCollectionIsTraversable(
        MaitreCorbeaux_Model_AbstractModel $model1,
        MaitreCorbeaux_Model_AbstractModel $model2,
        MaitreCorbeaux_Model_AbstractModel $model3
    )
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
    public function testCollectionIsSeekable(
        MaitreCorbeaux_Model_AbstractModel $model1,
        MaitreCorbeaux_Model_AbstractModel $model2,
        MaitreCorbeaux_Model_AbstractModel $model3
    )
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