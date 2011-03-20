<?php
/**
 * Test class for MaitreCorbeaux_Service_Contact
 * 
 */
class MaitreCorbeaux_Service_ContactTest
extends PHPUnit_Framework_TestCase
{
    /**
     * Contact service
     * 
     * @var MaitreCorbeaux_Service_Contact
     */
    protected $_service;

    /**
     *
     * @var array
     */
    static protected $_invalidData = array(array(
        /* Empty email address */
        array(
            'email' => '',
            'subject' => 'abcde',
            'body' => 'body',
            'copy' => '0'
        ),
        /* Invalid email address */
        array(
            'email' => 'invalid-email-address',
            'subject' => 'abcde',
            'body' => 'body',
            'copy' => '0'
        ),
        /* Empty subject */
        array(
            'email' => 'contact@maitre-corbeaux.com',
            'subject' => '',
            'body' => 'body',
            'copy' => '0'
        ),
        /* Subject is too short */
        array(
            'email' => 'contact@maitre-corbeaux.com',
            'subject' => 'abcd',
            'body' => 'body',
            'copy' => '0'
        ),
        /* Subject is too long */
        array(
            'email' => 'contact@maitre-corbeaux.com',
            'subject' => 'abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxy',
            'body' => 'body',
            'copy' => '0'
        ),
        /* Body is empty */
        array(
            'email' => 'contact@maitre-corbeaux.com',
            'subject' => 'abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxy',
            'body' => '',
            'copy' => '0'
        )
    ));

    /**
     *
     * @var array
     */
    static protected $_validData = array(array(
        array(
            'email' => 'contact@maitre-corbeaux.com',
            'subject' => 'abcde',
            'body' => 'body',
            'copy' => '0'
        )
    ));
    
    /**
     * Initialize the TestCase
     *
     * @return void
     */
    public function setUp()
    {
        $this->_service = new MaitreCorbeaux_Service_Contact();

        // We remove the ReCaptcha element for testing purpose
        $this->_service
             ->getForm()
             ->removeElement('captcha');
    }

    /**
     * Provider for invalid data
     * 
     * @return array
     */
    public static function invalidDataProvider()
    {
        return self::$_invalidData;
    }

    /**
     * Provider for valid data
     *
     * @return array
     */
    public static function validDataProvider()
    {
        return self::$_validData;
    }

    public function testSendReturnsFalseWithoutData()
    {
        $this->assertFalse($this->_service->send(array()));
    }

    /**
     *
     * @dataProvider invalidDataProvider
     */
    public function testSendReturnsFalseWithInvalidData($data)
    {
        $this->assertFalse($this->_service->send($data));
    }

    /**
     *
     * @dataProvider validDataProvider
     */
    public function testSendReturnsTrueWithValidData($data)
    {
        $this->assertTrue($this->_service->send($data));
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