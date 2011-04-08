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

    public function testImportTwitter()
    {
        $this->markTestIncomplete('Not yet implemented');
    }

    public function testGetAccessToken()
    {
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