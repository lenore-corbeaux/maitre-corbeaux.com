<?php
/**
 * Test class for MaitreCorbeaux_Service_Activity_Import_Facade
 * 
 */
class MaitreCorbeaux_Service_Activity_Import_FacadeTest
extends PHPUnit_Framework_TestCase
{
    /**
     * Import facade
     * 
     * @var MaitreCorbeaux_Service_Activity_Import_Facade
     */
    protected $_service;

    static public function provider()
    {
        $source1 = new MaitreCorbeaux_Model_Activity_Source(array(
            'slug' => 'twitter'
        ));

        $source2 = new MaitreCorbeaux_Model_Activity_Source(array(
            'slug' => 'developpezCom'
        ));

        $source3 = new MaitreCorbeaux_Model_Activity_Source(array(
            'slug' => 'github'
        ));

        $source4 = new MaitreCorbeaux_Model_Activity_Source(array(
            'slug' => 'atom'
        ));

        $source5 = new MaitreCorbeaux_Model_Activity_Source(array(
            'slug' => 'rss'
        ));

        return array(
            array(
                $source1
            ),
            array(
                $source2
            ),
            array(
                $source2
            ),
            array(
                $source4
            ),
            array(
                $source5
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
        $this->_service = new MaitreCorbeaux_Service_Activity_Import_Facade();
    }

    public function testImportFacade()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    /**
     *
     * @dataProvider provider
     */
    public function testImportFactoryReturnsAnImportInterface($source)
    {
        $import = $this->_service->factory($source);
        $this->assertInstanceOf(
            'MaitreCorbeaux_Service_Activity_Import_ImportInterface', $import
        );
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