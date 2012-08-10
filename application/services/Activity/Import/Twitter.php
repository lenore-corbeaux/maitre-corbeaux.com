<?php
/**
 * Import Activity Items from Twitter REST API
 *
 * @author Lucas CORBEAUX
 * @category MaitreCorbeaux
 * @package Default
 * @subpackage Service
 * @see MaitreCorbeaux_Service_AbstractService
 * @see MaitreCorbeaux_Service_Activity_Import_ImportInterface
 */
class MaitreCorbeaux_Service_Activity_Import_Twitter
extends MaitreCorbeaux_Service_AbstractService
implements MaitreCorbeaux_Service_Activity_Import_ImportInterface
{
    /**
     *
     * @var Zend_Oauth_Token_Access
     */
    protected $_accessToken;

    /**
     *
     * @var Zend_Service_Twitter
     */
    protected $_serviceTwitter;

    /**
     * Import Activity Items
     *
     * @return MaitreCorbeaux_Model_Collection_Activity_Item
     * @see MaitreCorbeaux_Service_Activity_Import_ImportInterface::import()
     * @throws MaitreCorbeaux_Service_Activity_Import_Exception
     */
    public function import()
    {
        $collection = new MaitreCorbeaux_Model_Collection_Activity_Item();
        $twitter = $this->getServiceTwitter();
        $user = $twitter->accountVerifyCredentials();

        if (null === $user) {
            throw new MaitreCorbeaux_Service_Activity_Import_Exception(
                'Unable to connect to Twitter REST API'
            );
        }

        $options = array(
            'user_id' => (string) $user->id,
            'count' => 200,
            'trim_user' => 1,
            'include_rts' => 1
        );

        $statuses = $twitter->statusUserTimeline($options);

        foreach ($statuses as $status) {
            $model = $this->createActivityItem($status);
            $collection->add($model);
        }

        return $collection;
    }

    /**
     * Create an Activity Item model from a SimpleXmlElement
     *
     * @param SimpleXmlElement $status
     * @return MaitreCorbeaux_Model_Activity_Item
     */
    public function createActivityItem(SimpleXmlElement $status)
    {
        $link = 'http://twitter.com/lucascorbeaux/statuses/' . $status->id;

        $publicationDate = new Zend_Date($status->created_at,
                                         'EEE MMM dd HH:mm:ss zzz yyyy',
                                         'en_US');

        /*
         *  Here is a quick fix, because Zend_Date doesn't seem to
         *  recognize the Year after the timezone offset
         */
        $publicationDate->setYear(substr($status->created_at, -4))
                        ->setTimezone();

        $model = new MaitreCorbeaux_Model_Activity_Item(array(
            'title' => $status->text,
            'description' => $status->text,
            'link' => $link,
            'externalId' => $link,
            'publicationDate' => $publicationDate
        ));

        return $model;
    }

    /**
     * Use configuration to load and unserialize OAuth Access Token
     *
     * @return Zend_Oauth_Token_Access
     * @throws MaitreCorbeaux_Service_Activity_Import_Exception
     */
    protected function _createAccessToken()
    {
        $bootstrap = $this->getBootstrap();
        $twitterConfig = $bootstrap->getResource('Twitter');

        if (!file_exists($twitterConfig['accessTokenPath'])) {
            throw new MaitreCorbeaux_Service_Activity_Import_Exception(
                'Unable to find access token file'
            );
        }

        $accessToken = unserialize(
            file_get_contents($twitterConfig['accessTokenPath'])
        );
        
        if (false === $accessToken
            || !$accessToken instanceof Zend_Oauth_Token_Access) {
            throw new MaitreCorbeaux_Service_Activity_Import_Exception(
                'Invalid data in access token file'
            );
        }

        return $accessToken;
    }

    /**
     *
     * @return Zend_Oauth_Token_Access
     */
    public function getAccessToken()
    {
        if (null === $this->_accessToken) {
            $this->_accessToken = $this->_createAccessToken();
        }

        return $this->_accessToken;
    }

    /**
     *
     * @param Zend_Oauth_Token_Access $value
     * @return MaitreCorbeaux_Service_Activity_Import_Twitter
     */
    public function setAccessToken(Zend_Oauth_Token_Access $value)
    {
        $this->_accessToken = $value;
        return $this;
    }

    /**
     *
     * @return Zend_Service_Twitter
     */
    public function getServiceTwitter()
    {
        if (null === $this->_serviceTwitter) {
            $accessToken = $this->getAccessToken();
            
            $this->_serviceTwitter = new Zend_Service_Twitter(array(
                'username' => $accessToken->getParam('screen_name'),
                'accessToken' => $accessToken
            ));
        }

        return $this->_serviceTwitter;
    }

    /**
     *
     * @param Zend_Service_Twitter $value
     * @return MaitreCorbeaux_Service_Activity_Import_Twitter
     */
    public function setServiceTwitter(Zend_Service_Twitter $value)
    {
        $this->_serviceTwitter = $value;
        return $this;
    }
}
