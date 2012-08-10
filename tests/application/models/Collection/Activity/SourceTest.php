<?php
/**
 * Test class for MaitreCorbeaux_Model_Collection_Activity_Source
 * 
 */
class MaitreCorbeaux_Model_Collection_Activity_SourceTest
extends MaitreCorbeaux_Model_Collection_CollectionTestAbstract
{
    /**
     * Data provider
     *
     * @return array
     */
    static public function provider()
    {
        return array(
            array(
                new MaitreCorbeaux_Model_Activity_Source(),
                new MaitreCorbeaux_Model_Activity_Source(),
                new MaitreCorbeaux_Model_Activity_Source()
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
            new MaitreCorbeaux_Model_Collection_Activity_Source();
    }
}