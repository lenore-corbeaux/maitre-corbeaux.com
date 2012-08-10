<?php
/**
 * Test class for MaitreCorbeaux_Service_Activity_Import_Twitter
 * 
 */
class MaitreCorbeaux_Service_Activity_Import_TwitterTest
extends PHPUnit_Framework_TestCase
{
    /**
     * Import Twitter
     * 
     * @var MaitreCorbeaux_Service_Activity_Import_Twitter
     */
    protected $_service;
    
    public static function tokenProvider()
    {
        return array(
            array('bad.token'),
            array('doesnt-exists.token')
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
        $this->_service = new MaitreCorbeaux_Service_Activity_Import_Twitter();
    }
    
    protected function _getXml()
    {
        $xml = '<status><id>123</id>'
             . '<created_at>Thu Jul 15 23:26:44 +0000 2012</created_at>'
             . '<text>foo</text></status>';

        return $xml;
    }

    public function testImportTwitter()
    {
        $twitter = $this->getMock('Zend_Service_Twitter');
        $user = new stdClass();
        $user->id = 123;
        
        $queryData = array(
            'user_id' => (string) $user->id,
            'count' => 200,
            'trim_user' => 1,
            'include_rts' => 1
        );
        
        $statusXml = $this->_getXml();
        $xml = '<statuses>' . str_repeat($statusXml, 3) . '</statuses>';
        $statuses = new SimpleXmlElement($xml);
        $statusesChildren = current($statuses->children());
        $status = $statusesChildren[0];
        
        $item = new MaitreCorbeaux_Model_Activity_Item();
        
        $service = $this->getMock(
            'MaitreCorbeaux_Service_Activity_Import_Twitter',
            array('createActivityItem', 'getServiceTwitter')
        );
        
        $service->expects($this->once())
                ->method('getServiceTwitter')
                ->will($this->returnValue($twitter));
                
        $twitter->expects($this->once())
                ->method('accountVerifyCredentials')
                ->will($this->returnValue($user));
                
        $twitter->expects($this->once())
                ->method('statusUserTimeline')
                ->with($this->equalTo($queryData))
                ->will($this->returnValue($statuses));
                
        $service->expects($this->exactly(3))
                ->method('createActivityItem')
                ->with($this->equalTo($status))
                ->will($this->returnValue($item));
        
        $actual = $service->import();
        
        $this->assertInstanceOf(
            'MaitreCorbeaux_Model_Collection_Activity_Item', $actual
        );
        
        $this->assertEquals(3, count($actual));
    }
    
    public function testCreateActivityItem()
    {
        $status = new SimpleXmlElement($this->_getXml());
        $item = $this->_service->createActivityItem($status);
        
        $statusId = (string) $status->id;
        $date = '16/07/2012 01:26:44';
        $text = (string) $status->text;
        $pubDate = $item->getPublicationDate();
        
        $this->assertInstanceOf('MaitreCorbeaux_Model_Activity_Item', $item);
        $this->assertStringEndsWith($statusId, $item->getLink());
        $this->assertInstanceOf('Zend_Date', $pubDate);
        $this->assertEquals($date, $pubDate->toString('dd/MM/yyyy HH:mm:ss'));
        $this->assertEquals($text, $item->getTitle());
    }
    
    /**
     * Prepare bootstrap to allow token creation.
     * 
     * @param string $fileName Token file name.
     * @return void
     */
    protected function _prepareBootstrap($fileName = 'access.token')
    {
        $data = array(
            'accessTokenPath' => TEST_PATH . '/_files/twitter/' . $fileName
        );
        
        $bootstrap = $this->getMock(
            'Zend_Application_Bootstrap_BootstrapAbstract',
            array(), array(), '', false
        );
        
        $bootstrap->expects($this->once())
                  ->method('getResource')
                  ->with($this->equalTo('Twitter'))
                  ->will($this->returnValue($data));
                  
        $this->_service->setBootstrap($bootstrap);
    }

    public function testGetAccessToken()
    {
        $this->_prepareBootstrap();
        $token = $this->_service->getAccessToken();
        $this->assertInstanceOf('Zend_Oauth_Token_Access', $token);
    }

    /**
     *
     * @dataProvider tokenProvider 
     */
    public function testGetInvalidAccessTokenThrowsException($fileName)
    {
        $this->setExpectedException(
            'MaitreCorbeaux_Service_Activity_Import_Exception'
        );
        
        $this->_prepareBootstrap($fileName);
        $token = $this->_service->getAccessToken();
        $this->assertInstanceOf('Zend_Oauth_Token_Access', $token);
    }

    public function testSetAccessToken()
    {
        $token = new Zend_Oauth_Token_Access();
        $this->_service->setAccessToken($token);
        $this->assertSame($token, $this->_service->getAccessToken());
    }

    public function testGetServiceTwitter()
    {
        $this->_prepareBootstrap();
        $twitter = $this->_service->getServiceTwitter();
        $this->assertInstanceOf('Zend_Service_Twitter', $twitter);
    }

    public function testSetServiceTwitter()
    {
        $twitter = new Zend_Service_Twitter();
        $this->_service->setServiceTwitter($twitter);
        $this->assertSame($twitter, $this->_service->getServiceTwitter());
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