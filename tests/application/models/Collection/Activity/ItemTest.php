<?php
/**
 * Test class for MaitreCorbeaux_Model_Collection_Activity_Item
 * 
 */
class MaitreCorbeaux_Model_Collection_Activity_ItemTest
extends MaitreCorbeaux_Model_Collection_CollectionTestAbstract
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
     * Initialize the TestCase
     *
     * @return void
     */
    public function setUp()
    {
        $this->_collection =
            new MaitreCorbeaux_Model_Collection_Activity_Item();
    }
}