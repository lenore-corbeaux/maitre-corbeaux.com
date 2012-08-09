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
    
    static public function exceptionProvider()
    {
        return array(
            array(new MaitreCorbeaux_Service_Activity_Import_Exception()),
            array(new Zend_Exception())
        );
    }

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
    
    /**
     * Prepare for calling import() method.
     * 
     * @param int $nbLogCall Number of times _log() is called.
     * @param Exception $exceptionImport Exception thrown during import.
     * @return MaitreCorbeaux_Service_Activity_Import_Facade Mocked service.
     */
    protected function _prepareImport($nbLogCall, $exceptionImport = null)
    {
        $source = $this->getMock('MaitreCorbeaux_Model_Activity_Source');
        $source->expects($this->once())
               ->method('getSlug');

        $sources = new MaitreCorbeaux_Model_Collection_Activity_Source();
        $sources->add($source);
        
        $servSearch = $this->getMock('MaitreCorbeaux_Service_Activity_Search');
        $servItem = $this->getMock('MaitreCorbeaux_Service_Activity_Item');
        
        if (null === $exceptionImport) {
            $item = $this->getMock('MaitreCorbeaux_Model_Activity_Item');
            $item->expects($this->once())
                 ->method('setSource')
                 ->with($this->equalTo($source));
                   
            $items = new MaitreCorbeaux_Model_Collection_Activity_Item();
            $items->add($item);
            
            $servItem->expects($this->once())
                     ->method('import')
                     ->with($this->equalTo($item));
            
            $servSearch->expects($this->once())
                       ->method('indexItem')
                       ->with($this->equalTo($item));
        }
        
        $importer = $this->getMock(
            'MaitreCorbeaux_Service_Activity_Import_ImportInterface'
        );
        
        $methodImport = $importer->expects($this->once())
                                 ->method('import');
                 
        if (null === $exceptionImport) {
            $methodImport->will($this->returnValue($items));
        } else {
            $methodImport->will($this->throwException($exceptionImport));
        }
        
        $service = $this->getMock(
            'MaitreCorbeaux_Service_Activity_Import_Facade',
            array('_log', 'factory')
        );
        
        $service->expects($this->exactly($nbLogCall))
                ->method('_log');
                
        $service->expects($this->once())
                ->method('factory')
                ->with($this->equalTo($source))
                ->will($this->returnValue($importer));

        $tag = array('activity');
        $cache = $this->getMock('Zend_Cache_Core');
        $cache->expects($this->once())
              ->method('clean')
              ->with($this->equalTo('matchingTag'), $this->equalTo($tag));

        return $service->setCache($cache)
                       ->setSources($sources)
                       ->setServiceItem($servItem)
                       ->setServiceSearch($servSearch);
    }

    public function testImportFacade()
    {
        $service = $this->_prepareImport(7);
        $service->import();
    }

    /**
     * 
     * @dataProvider exceptionProvider 
     */
    public function testImportFacadeImportException(Exception $exception)
    {
        $service = $this->_prepareImport(6, $exception);
        $service->import();
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