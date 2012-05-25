<?php
/**
 * Test class for MaitreCorbeaux_Service_Activity_Import_Pocket
 * 
 */
class MaitreCorbeaux_Service_Activity_Import_PocketTest
extends PHPUnit_Framework_TestCase
{   
    /**
     * Import Pocket
     * 
     * @var MaitreCorbeaux_Service_Activity_Import_Pocket
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
        $this->_service = new MaitreCorbeaux_Service_Activity_Import_Pocket();
    }
    
    public function testGetHttpClient()
    {
        $httpClient = $this->_service->getHttpClient();
        $this->assertInstanceOf('Zend_Http_Client', $httpClient);
    }

    public function testSetHttpClient()
    {
        $httpClient = $this->getMock('Zend_Http_Client');
        $this->_service->setHttpClient($httpClient);
        $this->assertSame($httpClient, $this->_service->getHttpClient());
    }

    /**
     * Prepare mocked Bootstrap for import testing
     * 
     * @param array $pocketOptions
     * @return void
     */
    protected function _prepareBootstrap(array $pocketOptions)
    {
        $bootstrap = $this->getMock(
            'Zend_Application_Bootstrap_BootstrapAbstract',
            array(),
            array(),
            '',
            false
        );
        
        $bootstrap->expects($this->once())
                  ->method('getOption')
                  ->with($this->equalTo('pocket'))
                  ->will($this->returnValue($pocketOptions));
        
        $this->_service->setBootstrap($bootstrap);
    }
    
    public function testImportThrowsExceptionIfNoUsername()
    {
        $pocketOptions = array(
            'password' => 'bar',
            'apikey' => 'baz'
        );
        
        $this->_prepareBootstrap($pocketOptions);
        
        $this->setExpectedException(
            'MaitreCorbeaux_Service_Activity_Import_Exception'
        );
        
        $this->_service->import();
    }

    public function testImportThrowsExceptionIfNoPassword()
    {
        $pocketOptions = array(
            'username' => 'foo',
            'apikey' => 'baz'
        );
        
        $this->_prepareBootstrap($pocketOptions);
        
        $this->setExpectedException(
            'MaitreCorbeaux_Service_Activity_Import_Exception'
        );
        
        $this->_service->import();
    }

    public function testImportThrowsExceptionIfNoApiKey()
    {
        $pocketOptions = array(
            'username' => 'foo',
            'password' => 'bar'
        );
        
        $this->_prepareBootstrap($pocketOptions);
        
        $this->setExpectedException(
            'MaitreCorbeaux_Service_Activity_Import_Exception'
        );
        
        $this->_service->import();
    }
    
    /**
     * Prepare Http Client and response for import tests
     * 
     * @param boolean $responseSuccessful
     * @return Zend_Http_Response
     */
    protected function _prepareHttpClient($responseSuccessful)
    {
        $httpResponse = $this->getMock(
            'Zend_Http_Response', array(), array(), '', false
        );
        
        $httpResponse->expects($this->once())
                     ->method('isSuccessful')
                     ->will($this->returnValue($responseSuccessful));
        
        $url = MaitreCorbeaux_Service_Activity_Import_Pocket::POCKET_API_URL;
        $httpClient = $this->getMock('Zend_Http_Client');
        $httpClient->expects($this->once())
                   ->method('setUri')
                   ->with($this->equalTo($url))
                   ->will($this->returnValue($httpClient));
        
        $httpClient->expects($this->exactly(4))
                   ->method('setParameterPost')
                   ->will($this->returnValue($httpClient));
        
        $httpClient->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo('POST'))
                   ->will($this->returnValue($httpResponse));
        
        $this->_service->setHttpClient($httpClient);
        return $httpResponse;
    }
    
    public function testImportPocketThrowsExceptionIfResponseNotSuccessful()
    {
        $pocketOptions = array(
            'username' => 'foo',
            'password' => 'bar',
            'apikey' => 'baz'
        );
    
        $this->_prepareBootstrap($pocketOptions);
        $httpResponse = $this->_prepareHttpClient(false);
        
        $httpResponse->expects($this->never())
                     ->method('getBody');
    
        $this->setExpectedException(
            'MaitreCorbeaux_Service_Activity_Import_Exception'
        );
        
        $this->_service->import();
    }
    
    /**
     * Data provider for import's tests
     * 
     * @return array
     */
    public static function importProvider()
    {
        return array(
            array(
                array(
                    'list' => array(
                        123 => array(
                            'item_id' => 123,
                            'title' => 'Title',
                            'url' => 'http:\/\/www.maitre-corbeaux.com\/1',
                            'time_updated' => 1337951682,
                            'time_added' => 1337943594,
                            'state' => 1
                        ),
                        456 => array(
                            'item_id' => 456,
                            'title' => 'Title 2',
                            'url' => 'http:\/\/www.maitre-corbeaux.com\/2',
                            'time_updated' => 1337951683,
                            'time_added' => 1337943595,
                            'state' => 2
                        ),
                        789 => array(
                            'item_id' => 789,
                            'title' => 'Title 3',
                            'url' => 'http:\/\/www.maitre-corbeaux.com\/3',
                            'time_updated' => 1337951684,
                            'time_added' => 1337943596,
                            'state' => 3
                        ),
                    )
                )
            ),
            array(
                array()
            )
        );
    }
    
    /**
     * 
     * @dataProvider importProvider
     */
    public function testImportPocket(array $data)
    {
        $pocketOptions = array(
            'username' => 'foo',
            'password' => 'bar',
            'apikey' => 'baz'
        );
        
        $responseBody = Zend_Json::encode($data);
        
        $this->_prepareBootstrap($pocketOptions);
        $httpResponse = $this->_prepareHttpClient(true);

        $httpResponse->expects($this->once())
                     ->method('getBody')
                     ->will($this->returnValue($responseBody));
        
        $collection = $this->_service->import();
        $this->assertInstanceOf(
            'MaitreCorbeaux_Model_Collection_Activity_Item', $collection
        );
        
        $expectedCount = isset($data['list']) ? count($data['list']) : 0;
        $this->assertEquals($expectedCount, count($collection));
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